<?php

namespace App\Http\Controllers;

use App\Models\MaintenanceRequest;
use App\Models\RequestStatus;
use App\Models\MaintenanceType;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class MaintenanceRequestController extends Controller
{
    public function index(Request $request)
    {
        $query = MaintenanceRequest::with(['status', 'maintenanceType', 'user', 'assignedUser']);

        // 검색 조건 처리
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhereHas('user', function($userQuery) use ($search) {
                      $userQuery->where('name', 'like', "%{$search}%");
                  });
            });
        }

        // 날짜 필터
        if ($request->filled('start_date')) {
            $query->whereDate('created_at', '>=', $request->start_date);
        }
        if ($request->filled('end_date')) {
            $query->whereDate('created_at', '<=', $request->end_date);
        }

        // 상태별 필터
        if ($request->filled('status_id')) {
            $query->where('status_id', $request->status_id);
        }

        $requests = $query->orderBy('created_at', 'desc')->paginate(15);

        // 전체 요청 수
        $allCount = MaintenanceRequest::count();

        // 상태별 요청 수 (실제 카운트)
        $requestStatuses = RequestStatus::withCount(['maintenanceRequests' => function($query) {
            // 검색 조건이 있는 경우 해당 조건을 적용
            if (request('search')) {
                $search = request('search');
                $query->where(function($q) use ($search) {
                    $q->where('title', 'like', "%{$search}%")
                      ->orWhereHas('user', function($userQuery) use ($search) {
                          $userQuery->where('name', 'like', "%{$search}%");
                      });
                });
            }

            // 날짜 필터 적용
            if (request('start_date')) {
                $query->whereDate('created_at', '>=', request('start_date'));
            }
            if (request('end_date')) {
                $query->whereDate('created_at', '<=', request('end_date'));
            }
        }])->orderBy('order')->get();

        $gNum = "01";
        return view('maintenance.requests.index', compact('requests', 'requestStatuses', 'allCount', 'gNum'));
    }

    public function show($id)
    {
        $request = MaintenanceRequest::with(['status', 'maintenanceType', 'user', 'assignedUser', 'attachments', 'comments.user'])
            ->findOrFail($id);

        return view('maintenance.requests.show', compact('request'));
    }

    public function create()
    {
        $maintenanceTypes = MaintenanceType::orderBy('name')->get();
        $users = User::orderBy('name')->get();

        return view('maintenance.requests.create', compact('maintenanceTypes', 'users'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'maintenance_type_id' => 'required|exists:maintenance_types,idx',
            'priority' => 'required|in:low,medium,high,urgent',
            'attachments.*' => 'nullable|file|max:10240', // 10MB
        ]);

        $maintenanceRequest = MaintenanceRequest::create([
            'title' => $validated['title'],
            'content' => $validated['content'],
            'maintenance_type_id' => $validated['maintenance_type_id'],
            'priority' => $validated['priority'],
            'status_id' => 1, // 접수 상태
            'user_id' => Auth::id(),
        ]);

        // 첨부파일 처리
        if ($request->hasFile('attachments')) {
            foreach ($request->file('attachments') as $file) {
                $path = $file->store('attachments', 'public');
                $maintenanceRequest->attachments()->create([
                    'original_name' => $file->getClientOriginalName(),
                    'file_path' => $path,
                    'file_size' => $file->getSize(),
                    'mime_type' => $file->getMimeType(),
                ]);
            }
        }

        return redirect()->route('maintenance.requests.index')
            ->with('success', '유지보수 요청이 등록되었습니다.');
    }

    public function edit($id)
    {
        $request = MaintenanceRequest::findOrFail($id);
        $maintenanceTypes = MaintenanceType::orderBy('name')->get();
        $users = User::orderBy('name')->get();
        $requestStatuses = RequestStatus::orderBy('order')->get();

        return view('maintenance.requests.edit', compact('request', 'maintenanceTypes', 'users', 'requestStatuses'));
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
            'attachments.*' => 'nullable|file|max:10240',
        ]);

        $maintenanceRequest->update($validated);

        // 첨부파일 처리
        if ($request->hasFile('attachments')) {
            foreach ($request->file('attachments') as $file) {
                $path = $file->store('attachments', 'public');
                $maintenanceRequest->attachments()->create([
                    'original_name' => $file->getClientOriginalName(),
                    'file_path' => $path,
                    'file_size' => $file->getSize(),
                    'mime_type' => $file->getMimeType(),
                ]);
            }
        }

        return redirect()->route('maintenance.requests.show', $id)
            ->with('success', '유지보수 요청이 수정되었습니다.');
    }

    public function destroy($id)
    {
        $maintenanceRequest = MaintenanceRequest::findOrFail($id);
        $maintenanceRequest->delete();

        return redirect()->route('maintenance.requests.index')
            ->with('success', '유지보수 요청이 삭제되었습니다.');
    }
}
