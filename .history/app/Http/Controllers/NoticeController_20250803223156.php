<?php

namespace App\Http\Controllers;

use App\Models\Notice;
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
            $query->published();
        }

        $notices = $query->orderBy('is_important', 'desc')
                        ->orderBy('created_at', 'desc')
                        ->paginate(15);

        $gNum = "03";
        return view('notices.index', compact('notices', 'gNum'));
    }

    public function show($id)
    {
        $notice = Notice::with(['user'])
            ->findOrFail($id);

        $gNum = "03";
        return view('notices.show', compact('notice', 'gNum'));
    }

    public function create()
    {
        // 관리자만 공지사항 작성 가능
        if (!Auth::user()->isAdmin()) {
            abort(403);
        }

        return view('notices.create');
    }

    public function store(Request $request)
    {
        // 관리자만 공지사항 작성 가능
        if (!Auth::user()->isAdmin()) {
            abort(403);
        }

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

        return redirect()->route('notices.show', $notice)
            ->with('success', '공지사항이 생성되었습니다.');
    }

    public function edit($id)
    {
        $notice = Notice::findOrFail($id);

        // 관리자만 수정 가능
        if (!Auth::user()->isAdmin()) {
            abort(403);
        }

        return view('notices.edit', compact('notice'));
    }

    public function update(Request $request, $id)
    {
        $notice = Notice::findOrFail($id);

        // 관리자만 수정 가능
        if (!Auth::user()->isAdmin()) {
            abort(403);
        }

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'is_important' => 'boolean',
            'is_published' => 'boolean',
        ]);

        $notice->update($validated);

        return redirect()->route('notices.show', $notice)
            ->with('success', '공지사항이 수정되었습니다.');
    }

    public function destroy($id)
    {
        $notice = Notice::findOrFail($id);

        // 관리자만 삭제 가능
        if (!Auth::user()->isAdmin()) {
            abort(403);
        }

        $notice->delete();

        return redirect()->route('notices.index')
            ->with('success', '공지사항이 삭제되었습니다.');
    }

    public function publish($id)
    {
        $notice = Notice::findOrFail($id);

        // 관리자만 게시 가능
        if (!Auth::user()->isAdmin()) {
            abort(403);
        }

        $notice->publish();

        return back()->with('success', '공지사항이 게시되었습니다.');
    }

    public function unpublish($id)
    {
        $notice = Notice::findOrFail($id);

        // 관리자만 게시 취소 가능
        if (!Auth::user()->isAdmin()) {
            abort(403);
        }

        $notice->unpublish();

        return back()->with('success', '공지사항 게시가 취소되었습니다.');
    }

    public function markAsImportant($id)
    {
        $notice = Notice::findOrFail($id);

        // 관리자만 중요 표시 가능
        if (!Auth::user()->isAdmin()) {
            abort(403);
        }

        $notice->markAsImportant();

        return back()->with('success', '공지사항이 중요 표시되었습니다.');
    }

    public function markAsNormal($id)
    {
        $notice = Notice::findOrFail($id);

        // 관리자만 중요 표시 해제 가능
        if (!Auth::user()->isAdmin()) {
            abort(403);
        }

        $notice->markAsNormal();

        return back()->with('success', '공지사항 중요 표시가 해제되었습니다.');
    }
}
