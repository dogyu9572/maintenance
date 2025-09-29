<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreNoticeRequest;
use App\Http\Requests\UpdateNoticeRequest;
use App\Models\Notice;
use App\Models\User;
use App\Models\NoticeFile;
use App\Services\NoticeService;
use Illuminate\Http\Request;

class NoticeController extends Controller
{
    private const GROUP_NUMBER = '03';
    private const DEFAULT_PER_PAGE = 20;

    public function __construct(
        private NoticeService $noticeService
    ) {
    }

    public function index(Request $request)
    {
        $query = $this->getNoticesQuery($request);
        $notices = $query->orderBy('is_important', 'desc')
                        ->orderBy('created_at', 'desc')
                        ->paginate(self::DEFAULT_PER_PAGE);

        $users = User::orderBy('name')->get();

        return view('admin.notices.index', [
            'notices' => $notices,
            'users' => $users,
            'gNum' => self::GROUP_NUMBER,
            'totalCount' => $notices->total()
        ]);
    }


    public function create()
    {
        return view('admin.notices.create', [
            'gNum' => self::GROUP_NUMBER
        ]);
    }

    public function store(StoreNoticeRequest $request)
    {
        try {
            $notice = $this->noticeService->createNotice($request->validated());

            if ($request->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => '공지사항이 생성되었습니다.',
                    'redirect' => route('admin.notices.index')
                ]);
            }

            return redirect()->route('admin.notices.index')
                ->with('success', '공지사항이 생성되었습니다.');

        } catch (\Exception $e) {
            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => '공지사항 저장 중 오류가 발생했습니다.'
                ], 500);
            }

            return back()->withErrors(['message' => '공지사항 저장 중 오류가 발생했습니다.']);
        }
    }

    public function edit($id)
    {
        $notice = Notice::findOrFail($id);
        return view('admin.notices.edit', compact('notice'));
    }

    public function update(UpdateNoticeRequest $request, $id)
    {
        try {
            $notice = Notice::findOrFail($id);
            $this->noticeService->updateNotice($notice, $request->validated());

            return redirect()->route('admin.notices.show', $notice)
                ->with('success', '공지사항이 수정되었습니다.');

        } catch (\Exception $e) {
            return back()->withErrors(['message' => '공지사항 수정 중 오류가 발생했습니다.']);
        }
    }

    public function destroy($id)
    {
        try {
            $notice = Notice::findOrFail($id);
            $this->noticeService->deleteNotice($notice);

            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => '삭제 중 오류가 발생했습니다.'], 500);
        }
    }

    public function bulkDelete(Request $request)
    {
        $request->validate([
            'ids' => 'required|array',
            'ids.*' => 'integer|exists:notices,idx'
        ]);

        try {
            $success = $this->noticeService->bulkDeleteNotices($request->ids);
            return response()->json(['success' => $success]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => '삭제 중 오류가 발생했습니다.'], 500);
        }
    }

    public function publish($id)
    {
        try {
            $notice = Notice::findOrFail($id);
            $this->noticeService->publishNotice($notice);

            return back()->with('success', '공지사항이 게시되었습니다.');
        } catch (\Exception $e) {
            return back()->withErrors(['message' => '게시 중 오류가 발생했습니다.']);
        }
    }

    public function unpublish($id)
    {
        try {
            $notice = Notice::findOrFail($id);
            $this->noticeService->unpublishNotice($notice);

            return back()->with('success', '공지사항 게시가 취소되었습니다.');
        } catch (\Exception $e) {
            return back()->withErrors(['message' => '게시 취소 중 오류가 발생했습니다.']);
        }
    }

    public function markAsImportant($id)
    {
        try {
            $notice = Notice::findOrFail($id);
            $this->noticeService->markAsImportant($notice);

            return back()->with('success', '공지사항이 중요 표시되었습니다.');
        } catch (\Exception $e) {
            return back()->withErrors(['message' => '중요 표시 중 오류가 발생했습니다.']);
        }
    }

    public function markAsNormal($id)
    {
        try {
            $notice = Notice::findOrFail($id);
            $this->noticeService->markAsNormal($notice);

            return back()->with('success', '공지사항 중요 표시가 해제되었습니다.');
        } catch (\Exception $e) {
            return back()->withErrors(['message' => '중요 표시 해제 중 오류가 발생했습니다.']);
        }
    }

    public function statistics()
    {
        $stats = $this->noticeService->getStatistics();

        return view('admin.notices.statistics', array_merge($stats, [
            'gNum' => self::GROUP_NUMBER
        ]));
    }

    public function bulkPublish(Request $request)
    {
        $request->validate([
            'notice_ids' => 'required|array',
            'notice_ids.*' => 'exists:notices,idx',
        ]);

        try {
            $success = $this->noticeService->bulkPublishNotices($request->notice_ids);
            return back()->with('success', '선택된 공지사항들이 게시되었습니다.');
        } catch (\Exception $e) {
            return back()->withErrors(['message' => '대량 게시 중 오류가 발생했습니다.']);
        }
    }

    public function bulkUnpublish(Request $request)
    {
        $request->validate([
            'notice_ids' => 'required|array',
            'notice_ids.*' => 'exists:notices,idx',
        ]);

        try {
            $success = $this->noticeService->bulkUnpublishNotices($request->notice_ids);
            return back()->with('success', '선택된 공지사항들의 게시가 취소되었습니다.');
        } catch (\Exception $e) {
            return back()->withErrors(['message' => '대량 게시 취소 중 오류가 발생했습니다.']);
        }
    }

    public function bulkMarkAsImportant(Request $request)
    {
        $request->validate([
            'notice_ids' => 'required|array',
            'notice_ids.*' => 'exists:notices,idx',
        ]);

        try {
            $success = $this->noticeService->bulkMarkAsImportant($request->notice_ids);
            return back()->with('success', '선택된 공지사항들이 중요 표시되었습니다.');
        } catch (\Exception $e) {
            return back()->withErrors(['message' => '대량 중요 표시 중 오류가 발생했습니다.']);
        }
    }

    public function bulkMarkAsNormal(Request $request)
    {
        $request->validate([
            'notice_ids' => 'required|array',
            'notice_ids.*' => 'exists:notices,idx',
        ]);

        try {
            $success = $this->noticeService->bulkMarkAsNormal($request->notice_ids);
            return back()->with('success', '선택된 공지사항들의 중요 표시가 해제되었습니다.');
        } catch (\Exception $e) {
            return back()->withErrors(['message' => '대량 중요 표시 해제 중 오류가 발생했습니다.']);
        }
    }

    public function downloadFile($fileId)
    {
        $file = NoticeFile::findOrFail($fileId);
        $absolutePath = storage_path('app/public/' . $file->file_path);

        if (!file_exists($absolutePath)) {
            abort(404);
        }

        return response()->download($absolutePath, $file->original_name);
    }

    /**
     * 공지사항 쿼리 생성 (공통 로직)
     */
    private function getNoticesQuery(Request $request): \Illuminate\Database\Eloquent\Builder
    {
        $query = Notice::with(['user']);

        if ($request->filled('search')) {
            $this->applySearchFilter($query, $request->search);
        }

        if ($request->filled('start_date') && $request->filled('end_date')) {
            $this->applyDateFilter($query, $request->start_date, $request->end_date);
        }

        if ($request->filled('important')) {
            $query->important();
        }

        if ($request->filled('published')) {
            $this->applyPublishedFilter($query, $request->published);
        }

        if ($request->filled('user_id')) {
            $query->byUser($request->user_id);
        }

        return $query;
    }

    /**
     * 검색 필터 적용
     */
    private function applySearchFilter($query, string $search): void
    {
        $query->where(function ($q) use ($search) {
            $q->where('title', 'like', "%{$search}%")
                ->orWhere('content', 'like', "%{$search}%");
        });
    }

    /**
     * 날짜 필터 적용
     */
    private function applyDateFilter($query, string $startDate, string $endDate): void
    {
        $query->where('created_at', '>=', $startDate)
            ->where('created_at', '<=', $endDate . ' 23:59:59');
    }

    /**
     * 게시 상태 필터 적용
     */
    private function applyPublishedFilter($query, string $published): void
    {
        if ($published === 'true') {
            $query->published();
        } else {
            $query->where('is_published', false);
        }
    }
}
