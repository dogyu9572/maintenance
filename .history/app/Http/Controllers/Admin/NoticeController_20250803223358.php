<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Notice;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NoticeController extends Controller
{
    public function index(Request $request)
    {
        $query = Notice::with(['user']);

        // 검색 조건 처리
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('content', 'like', "%{$search}%");
            });
        }

        // 중요 공지 필터링
        if ($request->filled('important')) {
            $query->important();
        }

        // 게시 상태 필터링
        if ($request->filled('published')) {
            if ($request->published === 'true') {
                $query->published();
            } else {
                $query->where('is_published', false);
            }
        }

        // 작성자별 필터링
        if ($request->filled('user_id')) {
            $query->byUser($request->user_id);
        }

        $notices = $query->orderBy('is_important', 'desc')
                        ->orderBy('created_at', 'desc')
                        ->paginate(20);

        // 필터 옵션들
        $users = User::orderBy('name')->get();

        $gNum = "03";
        return view('admin.notices.index', compact('notices', 'users', 'gNum'));
    }

    public function show($id)
    {
        $notice = Notice::with(['user'])
            ->findOrFail($id);

        $gNum = "03";
        return view('admin.notices.show', compact('notice', 'gNum'));
    }

    public function create()
    {
        return view('admin.notices.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'is_important' => 'boolean',
            'is_published' => 'boolean',
        ]);

        $notice = Notice::create([
            'user_id' => Auth::id(),
            'title' => $validated['title'],
            'content' => $validated['content'],
            'is_important' => $validated['is_important'] ?? false,
            'is_published' => $validated['is_published'] ?? false,
        ]);

        return redirect()->route('admin.notices.show', $notice)
            ->with('success', '공지사항이 생성되었습니다.');
    }

    public function edit($id)
    {
        $notice = Notice::findOrFail($id);

        return view('admin.notices.edit', compact('notice'));
    }

    public function update(Request $request, $id)
    {
        $notice = Notice::findOrFail($id);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'is_important' => 'boolean',
            'is_published' => 'boolean',
        ]);

        $notice->update($validated);

        return redirect()->route('admin.notices.show', $notice)
            ->with('success', '공지사항이 수정되었습니다.');
    }

    public function destroy($id)
    {
        $notice = Notice::findOrFail($id);

        $notice->delete();

        return redirect()->route('admin.notices.index')
            ->with('success', '공지사항이 삭제되었습니다.');
    }

    public function publish($id)
    {
        $notice = Notice::findOrFail($id);

        $notice->publish();

        return back()->with('success', '공지사항이 게시되었습니다.');
    }

    public function unpublish($id)
    {
        $notice = Notice::findOrFail($id);

        $notice->unpublish();

        return back()->with('success', '공지사항 게시가 취소되었습니다.');
    }

    public function markAsImportant($id)
    {
        $notice = Notice::findOrFail($id);

        $notice->markAsImportant();

        return back()->with('success', '공지사항이 중요 표시되었습니다.');
    }

    public function markAsNormal($id)
    {
        $notice = Notice::findOrFail($id);

        $notice->markAsNormal();

        return back()->with('success', '공지사항 중요 표시가 해제되었습니다.');
    }

    public function statistics()
    {
        // 전체 통계
        $totalNotices = Notice::count();
        $publishedNotices = Notice::published()->count();
        $importantNotices = Notice::important()->count();
        $draftNotices = Notice::where('is_published', false)->count();

        // 작성자별 통계
        $userStats = User::withCount(['notices' => function($query) {
            $query->published();
        }])->get();

        // 월별 통계
        $monthlyStats = Notice::selectRaw('
            YEAR(created_at) as year,
            MONTH(created_at) as month,
            COUNT(*) as total,
            COUNT(CASE WHEN is_published = 1 THEN 1 END) as published,
            COUNT(CASE WHEN is_important = 1 THEN 1 END) as important
        ')
        ->groupBy('year', 'month')
        ->orderBy('year', 'desc')
        ->orderBy('month', 'desc')
        ->limit(12)
        ->get();

        return view('admin.notices.statistics', compact(
            'totalNotices',
            'publishedNotices',
            'importantNotices',
            'draftNotices',
            'userStats',
            'monthlyStats'
        ));
    }

    public function bulkPublish(Request $request)
    {
        $validated = $request->validate([
            'notice_ids' => 'required|array',
            'notice_ids.*' => 'exists:notices,idx',
        ]);

        Notice::whereIn('idx', $validated['notice_ids'])
            ->update([
                'is_published' => true,
                'published_at' => now()
            ]);

        return back()->with('success', '선택된 공지사항들이 게시되었습니다.');
    }

    public function bulkUnpublish(Request $request)
    {
        $validated = $request->validate([
            'notice_ids' => 'required|array',
            'notice_ids.*' => 'exists:notices,idx',
        ]);

        Notice::whereIn('idx', $validated['notice_ids'])
            ->update([
                'is_published' => false,
                'published_at' => null
            ]);

        return back()->with('success', '선택된 공지사항들의 게시가 취소되었습니다.');
    }

    public function bulkMarkAsImportant(Request $request)
    {
        $validated = $request->validate([
            'notice_ids' => 'required|array',
            'notice_ids.*' => 'exists:notices,idx',
        ]);

        Notice::whereIn('idx', $validated['notice_ids'])
            ->update(['is_important' => true]);

        return back()->with('success', '선택된 공지사항들이 중요 표시되었습니다.');
    }

    public function bulkMarkAsNormal(Request $request)
    {
        $validated = $request->validate([
            'notice_ids' => 'required|array',
            'notice_ids.*' => 'exists:notices,idx',
        ]);

        Notice::whereIn('idx', $validated['notice_ids'])
            ->update(['is_important' => false]);

        return back()->with('success', '선택된 공지사항들의 중요 표시가 해제되었습니다.');
    }
}
