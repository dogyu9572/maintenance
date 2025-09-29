<?php

namespace App\Services;

use App\Models\MaintenanceRequest;
use App\Models\RequestStatus;
use App\Models\MaintenanceType;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class MaintenanceRequestService
{
    const PER_PAGE = 20;

    /**
     * 필터링된 유지보수 요청 목록 조회
     */
    public function getFilteredRequests(array $filters = []): LengthAwarePaginator
    {
        $query = MaintenanceRequest::with(['status', 'maintenanceType', 'user', 'manager', 'worker'])->select('*');

        // 검색 조건 처리
        if (isset($filters['search'])) {
            $search = $filters['search'];
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhereHas('user', function($userQuery) use ($search) {
                      $userQuery->where('name', 'like', "%{$search}%");
                  });
            });
        }

        // 상태별 필터링
        if (isset($filters['status'])) {
            $statusMap = [
                'received' => 1,        // 접수
                'manpower_request' => 2, // 공수확인요청
                'manpower_completed' => 3, // 공수확인완료
                'in_progress' => 4,     // 진행중
                're_request' => 5,      // 재요청
            ];
            
            if (isset($statusMap[$filters['status']])) {
                $query->where('status_id', $statusMap[$filters['status']]);
            }
        }

        // 유지보수 유형별 필터링
        if (isset($filters['type_id'])) {
            $query->where('maintenance_type_id', $filters['type_id']);
        }

        // 날짜 필터
        if (isset($filters['start_date'])) {
            $query->whereDate('created_at', '>=', $filters['start_date']);
        }
        if (isset($filters['end_date'])) {
            $query->whereDate('created_at', '<=', $filters['end_date']);
        }

        return $query->orderBy('idx', 'desc')->paginate($filters['per_page'] ?? self::PER_PAGE);
    }

    /**
     * 유지보수 요청 통계 조회
     */
    public function getRequestStatistics(): array
    {
        $totalCount = MaintenanceRequest::count();
        $receivedCount = MaintenanceRequest::where('status_id', 1)->count();
        $manpowerRequestCount = MaintenanceRequest::where('status_id', 2)->count();
        $manpowerCompletedCount = MaintenanceRequest::where('status_id', 3)->count();
        $inProgressCount = MaintenanceRequest::where('status_id', 4)->count();
        $reRequestCount = $totalCount - $receivedCount - $manpowerRequestCount - $manpowerCompletedCount - $inProgressCount;

        return [
            'totalCount' => $totalCount,
            'receivedCount' => $receivedCount,
            'manpowerRequestCount' => $manpowerRequestCount,
            'manpowerCompletedCount' => $manpowerCompletedCount,
            'inProgressCount' => $inProgressCount,
            'reRequestCount' => $reRequestCount,
        ];
    }

    /**
     * 필터 옵션 조회
     */
    public function getFilterOptions(): array
    {
        return [
            'statuses' => RequestStatus::orderBy('order')->get(),
            'types' => MaintenanceType::orderBy('name')->get(),
        ];
    }

    /**
     * 유지보수 요청 완료 처리
     */
    public function completeRequest(MaintenanceRequest $request): bool
    {
        $completedStatus = RequestStatus::where('name', '완료')->first();
        
        return $request->update([
            'completed_at' => now(),
            'status_id' => $completedStatus->idx ?? 1
        ]);
    }

    /**
     * 첨부파일 삭제 및 요청 삭제
     */
    public function deleteRequestWithAttachments(MaintenanceRequest $request): bool
    {
        // 첨부파일 삭제
        foreach ($request->attachments as $attachment) {
            if (Storage::disk('public')->exists($attachment->file_path)) {
                Storage::disk('public')->delete($attachment->file_path);
            }
        }

        return $request->delete();
    }

    /**
     * 작업공수 업데이트
     */
    public function updateWorkHours(MaintenanceRequest $request, array $data): bool
    {
        $updateData = [
            'expected_pm_hours' => $data['expected_pm_hours'] ?? 0,
            'expected_design_hours' => $data['expected_design_hours'] ?? 0,
            'expected_pub_hours' => $data['expected_pub_hours'] ?? 0,
            'expected_dev_hours' => $data['expected_dev_hours'] ?? 0,
            'actual_pm_hours' => $data['actual_pm_hours'] ?? 0,
            'actual_design_hours' => $data['actual_design_hours'] ?? 0,
            'actual_pub_hours' => $data['actual_pub_hours'] ?? 0,
            'actual_dev_hours' => $data['actual_dev_hours'] ?? 0,
        ];

        return $request->update($updateData);
    }

    /**
     * 관리자 설정 업데이트
     */
    public function updateAdminSettings(MaintenanceRequest $request, array $data): bool
    {
        $updateData = [
            'is_urgent' => $data['is_urgent'] ?? false,
            'worker_id' => $data['worker_id'] ?: null,
            'expected_date' => $data['expected_date'] ?: null,
            'notes' => $data['notes'],
            'issues' => $data['issues'],
            'report_title' => $data['report_title'],
            'progress_rate' => $data['progress_rate'] ?: 0,
            'progress_status' => $data['progress_status'],
        ];

        return $request->update($updateData);
    }

    /**
     * 상태별 노트 생성
     */
    public function generateStatusNotes(MaintenanceRequest $request): array
    {
        $statusNotes = [
            1 => [ // 접수
                '요청이 ' . ($request->request_date ? $request->request_date->format('n/j') : '') . ' 접수되었습니다.',
                '요청내용 확인 및 공수파악 후 담당자가 배정됩니다.',
                '담당자 : ' . ($request->manager->name ?? '') . '님',
                '예상 처리일 : ' . ($request->expected_date ? $request->expected_date->format('n/j') : '') . '일'
            ],
            2 => [ // 공수확인요청
                '공수확인 요청이 ' . ($request->request_date ? $request->request_date->format('n/j') : '') . ' 접수되었습니다.',
                '담당자가 요청내용을 바탕으로 작업 공수를 파악했습니다.',
                '작업공수 확인 후 공수확인완료 처리가 필요합니다.',
                '담당자 : ' . ($request->manager->name ?? '') . '님'
            ],
            3 => [ // 공수확인완료
                '공수확인을 완료했습니다.',
                '담당자가 작업자에게 작업을 요청합니다.',
                '작업자 : ' . ($request->worker->name ?? '') . '님',
                '예상 완료일 : ' . ($request->expected_date ? $request->expected_date->format('n/j') : '') . '일'
            ],
            4 => [ // 진행중
                '작업이 진행중입니다.',
                '작업 진행 중 상태에서는 요청내용 수정이 불가능합니다.',
                '요청한 작업에 추가사항이 있을 경우, 댓글로 요청 부탁드립니다.',
                '작업자 : ' . ($request->worker->name ?? '') . '님'
            ],
            5 => [ // 재요청
                '재요청이 접수되었습니다.',
                '이전 작업 완료 후 추가 요청사항이 있습니다.',
                '담당자 : ' . ($request->manager->name ?? '') . '님',
                '작업자 : ' . ($request->worker->name ?? '') . '님'
            ]
        ];

        return [
            'title' => $request->title,
            'notes' => $statusNotes[$request->status_id] ?? [
                '상태 정보가 없습니다.',
                '담당자 : ' . ($request->manager->name ?? '') . '님'
            ]
        ];
    }

    /**
     * 통계 데이터 조회
     */
    public function getStatistics(): array
    {
        $totalRequests = MaintenanceRequest::count();
        $completedRequests = MaintenanceRequest::whereNotNull('completed_at')->count();
        $pendingRequests = $totalRequests - $completedRequests;

        // 클라이언트별 통계
        $clientStats = User::where('is_admin', false)->withCount(['maintenanceRequests' => function($query) {
            $query->whereNotNull('completed_at');
        }])->get();

        // 월별 통계
        $monthlyStats = MaintenanceRequest::selectRaw('
            YEAR(created_at) as year,
            MONTH(created_at) as month,
            COUNT(*) as total,
            COUNT(CASE WHEN completed_at IS NOT NULL THEN 1 END) as completed
        ')
        ->groupBy('year', 'month')
        ->orderBy('year', 'desc')
        ->orderBy('month', 'desc')
        ->limit(12)
        ->get();

        return [
            'totalRequests' => $totalRequests,
            'completedRequests' => $completedRequests,
            'pendingRequests' => $pendingRequests,
            'clientStats' => $clientStats,
            'monthlyStats' => $monthlyStats,
        ];
    }
}
