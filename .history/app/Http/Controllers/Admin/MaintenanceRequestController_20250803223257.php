<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\MaintenanceRequest;
use App\Models\RequestStatus;
use App\Models\MaintenanceType;
use App\Models\User;
use App\Models\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MaintenanceRequestController extends Controller
{
    public function index(Request $request)
    {
        $query = MaintenanceRequest::with(['status', 'maintenanceType', 'user', 'assignedUser', 'user.client']);

        // 검색 조건 처리
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhereHas('user', function($userQuery) use ($search) {
                      $userQuery->where('name', 'like', "%{$search}%");
                  })
                  ->orWhereHas('user.client', function($clientQuery) use ($search) {
                      $clientQuery->where('name', 'like', "%{$search}%");
                  });
            });
        }

        // 클라이언트별 필터링
        if ($request->filled('client_id')) {
            $query->whereHas('user', function($q) use ($request) {
                $q->where('client_id', $request->client_id);
            });
        }

        // 상태별 필터링
        if ($request->filled('status_id')) {
            $query->where('status_id', $request->status_id);
        }

        // 유지보수 유형별 필터링
        if ($request->filled('type_id')) {
            $query->where('maintenance_type_id', $request->type_id);
        }

        // 날짜 필터
        if ($request->filled('start_date')) {
            $query->whereDate('created_at', '>=', $request->start_date);
        }
        if ($request->filled('end_date')) {
            $query->whereDate('created_at', '<=', $request->end_date);
        }

        $requests = $query->orderBy('created_at', 'desc')->paginate(20);

        // 필터 옵션들
        $clients = Client::orderBy('name')->get();
        $statuses = RequestStatus::orderBy('order')->get();
        $types = MaintenanceType::orderBy('name')->get();

        // 전체 요청 수
        $allCount = MaintenanceRequest::count();

        // 상태별 요청 수
        $statusStats = RequestStatus::withCount('maintenanceRequests')->get();

        $gNum = "01";
        return view('admin.maintenance-requests.index', compact(
            'requests',
            'clients',
            'statuses',
            'types',
            'allCount',
            'statusStats',
            'gNum'
        ));
    }

    public function show($id)
    {
        $request = MaintenanceRequest::with([
            'status',
            'maintenanceType',
            'user.client',
            'assignedUser',
            'attachments',
            'comments.user'
        ])->findOrFail($id);

        return view('admin.maintenance-requests.show', compact('request'));
    }

    public function edit($id)
    {
        $request = MaintenanceRequest::with(['user.client'])->findOrFail($id);

        $statuses = RequestStatus::orderBy('order')->get();
        $types = MaintenanceType::orderBy('name')->get();
        $users = User::orderBy('name')->get();

        return view('admin.maintenance-requests.edit', compact('request', 'statuses', 'types', 'users'));
    }

    public function update(Request $request, $id)
    {
        $maintenanceRequest = MaintenanceRequest::findOrFail($id);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'maintenance_type_id' => 'required|exists:maintenance_types,idx',
            'status_id' => 'required|exists:request_statuses,idx',
            'assigned_user_id' => 'nullable|exists:users,idx',
            'priority' => 'required|in:low,medium,high,urgent',
            'estimated_pm_hours' => 'nullable|integer|min:0',
            'estimated_design_hours' => 'nullable|integer|min:0',
            'estimated_publishing_hours' => 'nullable|integer|min:0',
            'estimated_development_hours' => 'nullable|integer|min:0',
            'actual_pm_hours' => 'nullable|integer|min:0',
            'actual_design_hours' => 'nullable|integer|min:0',
            'actual_publishing_hours' => 'nullable|integer|min:0',
            'actual_development_hours' => 'nullable|integer|min:0',
        ]);

        $maintenanceRequest->update($validated);

        return redirect()->route('admin.maintenance-requests.show', $maintenanceRequest)
            ->with('success', '유지보수 요청이 수정되었습니다.');
    }

    public function destroy($id)
    {
        $request = MaintenanceRequest::findOrFail($id);

        // 첨부파일 삭제
        foreach ($request->attachments as $attachment) {
            if (file_exists(storage_path('app/public/' . $attachment->file_path))) {
                unlink(storage_path('app/public/' . $attachment->file_path));
            }
        }

        $request->delete();

        return redirect()->route('admin.maintenance-requests.index')
            ->with('success', '유지보수 요청이 삭제되었습니다.');
    }

    public function assign($id, Request $request)
    {
        $maintenanceRequest = MaintenanceRequest::findOrFail($id);

        $validated = $request->validate([
            'assigned_user_id' => 'required|exists:users,idx',
        ]);

        $maintenanceRequest->update($validated);

        return back()->with('success', '담당자가 지정되었습니다.');
    }

    public function updateStatus($id, Request $request)
    {
        $maintenanceRequest = MaintenanceRequest::findOrFail($id);

        $validated = $request->validate([
            'status_id' => 'required|exists:request_statuses,idx',
        ]);

        $maintenanceRequest->update($validated);

        return back()->with('success', '상태가 변경되었습니다.');
    }

    public function complete($id)
    {
        $maintenanceRequest = MaintenanceRequest::findOrFail($id);

        $maintenanceRequest->update([
            'completed_at' => now(),
            'status_id' => RequestStatus::where('name', '완료')->first()->idx ?? 1
        ]);

        return back()->with('success', '유지보수가 완료 처리되었습니다.');
    }

    public function statistics()
    {
        // 전체 통계
        $totalRequests = MaintenanceRequest::count();
        $completedRequests = MaintenanceRequest::whereNotNull('completed_at')->count();
        $pendingRequests = MaintenanceRequest::whereNull('completed_at')->count();

        // 클라이언트별 통계
        $clientStats = Client::withCount(['maintenanceRequests' => function($query) {
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

        return view('admin.maintenance-requests.statistics', compact(
            'totalRequests',
            'completedRequests',
            'pendingRequests',
            'clientStats',
            'monthlyStats'
        ));
    }
}
