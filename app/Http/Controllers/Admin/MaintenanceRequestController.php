<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\MaintenanceRequest;
use App\Models\RequestStatus;
use App\Models\MaintenanceType;
use App\Models\User;
use App\Http\Requests\MaintenanceRequestRequest;
use App\Services\MaintenanceRequestService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MaintenanceRequestController extends Controller
{
    const G_NUM = '01';

    protected $maintenanceRequestService;

    public function __construct(MaintenanceRequestService $maintenanceRequestService)
    {
        $this->maintenanceRequestService = $maintenanceRequestService;
    }

    public function index(Request $request)
    {
        $filters = $request->only(['search', 'status', 'type_id', 'start_date', 'end_date', 'per_page']);
        
        $requests = $this->maintenanceRequestService->getFilteredRequests($filters);
        $statistics = $this->maintenanceRequestService->getRequestStatistics();
        $filterOptions = $this->maintenanceRequestService->getFilterOptions();

        return view('admin.maintenance-requests.index', compact(
            'requests',
            'statistics',
            'filterOptions'
        ));
    }

    public function create()
    {
        $filterOptions = $this->maintenanceRequestService->getFilterOptions();
        $users = User::orderBy('name')->get();

        return view('admin.maintenance-requests.create', compact('filterOptions', 'users'));
    }

    public function show($id)
    {
        $request = MaintenanceRequest::with([
            'status',
            'maintenanceType',
            'user',
            'manager',
            'worker',
            'attachments',
            'comments.user'
        ])->findOrFail($id);

        $filterOptions = $this->maintenanceRequestService->getFilterOptions();
        $users = User::orderBy('name')->get();

        return view('admin.maintenance-requests.show', compact('request', 'filterOptions', 'users'));
    }

    public function edit($id)
    {
        $request = MaintenanceRequest::with(['user'])->findOrFail($id);
        $filterOptions = $this->maintenanceRequestService->getFilterOptions();
        $users = User::orderBy('name')->get();

        return view('admin.maintenance-requests.edit', compact('request', 'filterOptions', 'users'));
    }

    public function update(MaintenanceRequestRequest $request, $id)
    {
        $maintenanceRequest = MaintenanceRequest::findOrFail($id);
        $validated = $request->validated();

        $maintenanceRequest->update($validated);

        return redirect()->route('admin.maintenance-requests.show', $maintenanceRequest)
            ->with('success', '유지보수 요청이 수정되었습니다.');
    }

    public function destroy($id)
    {
        $request = MaintenanceRequest::findOrFail($id);
        
        $this->maintenanceRequestService->deleteRequestWithAttachments($request);

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
        
        $this->maintenanceRequestService->completeRequest($maintenanceRequest);

        return back()->with('success', '유지보수가 완료 처리되었습니다.');
    }

    public function statistics()
    {
        $statistics = $this->maintenanceRequestService->getStatistics();

        return view('admin.maintenance-requests.statistics', $statistics);
    }

    public function notes($id)
    {
        $request = MaintenanceRequest::with(['user', 'manager', 'worker', 'maintenanceType', 'status'])->findOrFail($id);
        
        $notes = $this->maintenanceRequestService->generateStatusNotes($request);
        
        return response()->json($notes);
    }

    public function updateWorkHours(Request $request, $id)
    {
        $maintenanceRequest = MaintenanceRequest::findOrFail($id);
        
        $validated = $request->validate([
            'expected_pm_hours' => 'nullable|numeric|min:0',
            'expected_design_hours' => 'nullable|numeric|min:0',
            'expected_pub_hours' => 'nullable|numeric|min:0',
            'expected_dev_hours' => 'nullable|numeric|min:0',
            'actual_pm_hours' => 'nullable|numeric|min:0',
            'actual_design_hours' => 'nullable|numeric|min:0',
            'actual_pub_hours' => 'nullable|numeric|min:0',
            'actual_dev_hours' => 'nullable|numeric|min:0',
        ]);

        $this->maintenanceRequestService->updateWorkHours($maintenanceRequest, $validated);

        return response()->json([
            'success' => true,
            'message' => '작업공수가 저장되었습니다.'
        ]);
    }

    public function updateAdminSettings(Request $request, $id)
    {
        try {
            $maintenanceRequest = MaintenanceRequest::findOrFail($id);
            
            $validated = $request->validate([
                'is_urgent' => 'boolean',
                'worker_id' => 'nullable|exists:users,idx',
                'expected_date' => 'nullable|date',
                'notes' => 'nullable|string|max:1000',
                'issues' => 'nullable|string|max:1000',
                'report_title' => 'nullable|string|max:255',
                'progress_rate' => 'nullable|integer|min:0|max:100',
                'progress_status' => 'nullable|string|max:50',
            ]);

            $this->maintenanceRequestService->updateAdminSettings($maintenanceRequest, $validated);
            
            return response()->json([
                'success' => true,
                'message' => '관리자 설정이 저장되었습니다.'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => '관리자 설정 저장 중 오류가 발생했습니다: ' . $e->getMessage()
            ], 500);
        }
    }
}
