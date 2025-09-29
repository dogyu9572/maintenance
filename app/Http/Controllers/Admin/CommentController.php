<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use App\Models\MaintenanceRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class CommentController extends Controller
{
    public function store(Request $request, $maintenanceRequestId)
    {
        try {
            Log::info('댓글 등록 시작', [
                'maintenance_request_id' => $maintenanceRequestId,
                'request_data' => $request->all()
            ]);

            $request->validate([
                'content' => 'required|string|max:1000',
                'type' => 'required|in:comment,reply,rework,complete',
                'parent_id' => 'nullable|exists:comments,idx',
            ]);

            $comment = Comment::create([
                'maintenance_request_id' => $maintenanceRequestId,
                'user_id' => Auth::id(),
                'content' => $request->content,
                'type' => $request->type,
                'parent_id' => $request->parent_id,
            ]);

            Log::info('댓글 등록 완료', ['comment_id' => $comment->id]);

            return response()->json([
                'success' => true,
                'comment' => $comment->load('user'),
                'message' => '댓글이 등록되었습니다.'
            ]);
        } catch (\Exception $e) {
            Log::error('댓글 등록 오류', [
                'maintenance_request_id' => $maintenanceRequestId,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json([
                'success' => false,
                'message' => '댓글 등록 중 오류가 발생했습니다: ' . $e->getMessage()
            ], 500);
        }
    }

    public function update(Request $request, $id)
    {
        $comment = Comment::findOrFail($id);
        
        // 권한 확인 (작성자만 수정 가능)
        if ($comment->user_id !== Auth::id()) {
            return response()->json([
                'success' => false,
                'message' => '수정 권한이 없습니다.'
            ], 403);
        }

        $request->validate([
            'content' => 'required|string|max:1000',
        ]);

        $comment->update([
            'content' => $request->content,
        ]);

        return response()->json([
            'success' => true,
            'comment' => $comment->load('user'),
            'message' => '댓글이 수정되었습니다.'
        ]);
    }

    public function destroy($id)
    {
        $comment = Comment::findOrFail($id);
        
        // 권한 확인 (작성자만 삭제 가능)
        if ($comment->user_id !== Auth::id()) {
            return response()->json([
                'success' => false,
                'message' => '삭제 권한이 없습니다.'
            ], 403);
        }

        $comment->delete();

        return response()->json([
            'success' => true,
            'message' => '댓글이 삭제되었습니다.'
        ]);
    }
}
