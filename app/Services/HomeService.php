<?php

namespace App\Services;

use App\Models\MaintenanceRequest;
use App\Models\RequestStatus;
use App\Models\User;
use App\Models\Notice;
use Illuminate\Support\Collection;

class HomeService
{
    // 상태 ID 상수 정의
    const STATUS_RECEIVED = 1;           // 접수
    const STATUS_MANPOWER_REQUEST = 2;   // 공수확인요청
    const STATUS_MANPOWER_COMPLETED = 3; // 공수확인완료
    const STATUS_IN_PROGRESS = 4;        // 진행중
    const STATUS_RE_REQUEST = 5;         // 재요청

    /**
     * 최근 유지보수 요청 조회
     */
    public function getRecentRequests(int $limit = 5): Collection
    {
        return MaintenanceRequest::with(['status', 'maintenanceType', 'user'])
            ->orderBy('created_at', 'desc')
            ->limit($limit)
            ->get();
    }

    /**
     * 유지보수 요청 통계 조회
     */
    public function getMaintenanceStatistics(): array
    {
        $receivedCount = MaintenanceRequest::where('status_id', self::STATUS_RECEIVED)->count();
        $manpowerRequestCount = MaintenanceRequest::where('status_id', self::STATUS_MANPOWER_REQUEST)->count();
        $manpowerCompletedCount = MaintenanceRequest::where('status_id', self::STATUS_MANPOWER_COMPLETED)->count();
        $inProgressCount = MaintenanceRequest::where('status_id', self::STATUS_IN_PROGRESS)->count();
        $reRequestCount = MaintenanceRequest::where('status_id', self::STATUS_RE_REQUEST)->count();

        return [
            'receivedCount' => $receivedCount,
            'manpowerRequestCount' => $manpowerRequestCount,
            'manpowerCompletedCount' => $manpowerCompletedCount,
            'inProgressCount' => $inProgressCount,
            'reRequestCount' => $reRequestCount,
        ];
    }

    /**
     * 필터링된 유지보수 요청 조회
     */
    public function getFilteredRequests(string $status = 'all', int $limit = 20): Collection
    {
        $query = MaintenanceRequest::with(['status', 'maintenanceType', 'user', 'manager', 'worker']);
        
        if ($status !== 'all') {
            $query->where('status_id', $status);
        }
        
        return $query->orderBy('created_at', 'desc')->limit($limit)->get();
    }

    /**
     * 전체 유지보수 요청 수 조회
     */
    public function getTotalRequestsCount(): int
    {
        return MaintenanceRequest::count();
    }

    /**
     * 고객사 목록 조회 (유지보수 요청이 있는 고객사들)
     */
    public function getClientsWithRequestCount(): Collection
    {
        return User::where('is_admin', false)
            ->orderBy('name')
            ->get()
            ->map(function($user) {
                $user->maintenance_requests_count = MaintenanceRequest::where('user_id', $user->idx)->count();
                return $user;
            });
    }

    /**
     * 최근 공지사항 조회
     */
    public function getRecentNotices(int $limit = 3): Collection
    {
        return Notice::where('is_published', true)
            ->orderBy('created_at', 'desc')
            ->limit($limit)
            ->get(['idx', 'title', 'created_at']);
    }

    /**
     * 상태별 요청 수를 배열로 반환
     */
    public function getStatusCountsArray(): array
    {
        $stats = $this->getMaintenanceStatistics();
        
        return [
            'receivedCount' => $stats['receivedCount'],
            'manpowerRequestCount' => $stats['manpowerRequestCount'],
            'manpowerCompletedCount' => $stats['manpowerCompletedCount'],
            'inProgressCount' => $stats['inProgressCount'],
            'reRequestCount' => $stats['reRequestCount'],
        ];
    }
}
