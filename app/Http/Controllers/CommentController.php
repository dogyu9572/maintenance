<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\MaintenanceRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    public function store(Request $request, $maintenanceRequestId)
    {
        $validated = $request->validate([
            'content' => 'required|string',
            'comment_type' => 'required|in:comment,reply,rework,complete',
        ]);

        $maintenanceRequest = MaintenanceRequest::findOrFail($maintenanceRequestId);

        $comment = Comment::create([
            'maintenance_request_id' => $maintenanceRequestId,
            'user_id' => Auth::id(),
            'content' => $validated['content'],
            'type' => $validated['comment_type'],
        ]);

        return redirect()->route('maintenance.requests.show', $maintenanceRequestId)
            ->with('success', '댓글이 등록되었습니다.');
    }

    public function update(Request $request, $maintenanceRequestId, $commentId)
    {
        $comment = Comment::where('maintenance_request_id', $maintenanceRequestId)
            ->where('idx', $commentId)
            ->firstOrFail();

        // 권한 확인
        if (Auth::id() != $comment->user_id && !Auth::user()->is_admin) {
            abort(403, '댓글을 수정할 권한이 없습니다.');
        }

        $validated = $request->validate([
            'content' => 'required|string',
            'comment_type' => 'required|in:comment,reply,rework,complete',
        ]);

        $comment->update($validated);

        return redirect()->route('maintenance.requests.show', $maintenanceRequestId)
            ->with('success', '댓글이 수정되었습니다.');
    }

    public function destroy($maintenanceRequestId, $commentId)
    {
        $comment = Comment::where('maintenance_request_id', $maintenanceRequestId)
            ->where('idx', $commentId)
            ->firstOrFail();

        // 권한 확인
        if (Auth::id() != $comment->user_id && !Auth::user()->is_admin) {
            abort(403, '댓글을 삭제할 권한이 없습니다.');
        }

        $comment->delete();

        return redirect()->route('maintenance.requests.show', $maintenanceRequestId)
            ->with('success', '댓글이 삭제되었습니다.');
    }
}
