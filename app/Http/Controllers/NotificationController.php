<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    public function index(Request $request)
    {
        $query = Notification::where('user_id', Auth::id());

        // 읽음 상태 필터링
        if ($request->filled('read')) {
            if ($request->read === 'true') {
                $query->read();
            } else {
                $query->unread();
            }
        }

        // 타입별 필터링
        if ($request->filled('type')) {
            $query->byType($request->type);
        }

        $notifications = $query->orderBy('created_at', 'desc')
                              ->paginate(20);

        // 읽지 않은 알림 수
        $unreadCount = Notification::where('user_id', Auth::id())
                                 ->unread()
                                 ->count();

        $gNum = "04";
        return view('notifications.index', compact('notifications', 'unreadCount', 'gNum'));
    }

    public function show($id)
    {
        $notification = Notification::where('user_id', Auth::id())
            ->findOrFail($id);

        // 읽음 처리
        if (!$notification->isRead()) {
            $notification->markAsRead();
        }

        $gNum = "04";
        return view('notifications.show', compact('notification', 'gNum'));
    }

    public function markAsRead($id)
    {
        $notification = Notification::where('user_id', Auth::id())
            ->findOrFail($id);

        $notification->markAsRead();

        return back()->with('success', '알림을 읽음 처리했습니다.');
    }

    public function markAllAsRead()
    {
        Notification::where('user_id', Auth::id())
            ->unread()
            ->update([
                'is_read' => true,
                'read_at' => now()
            ]);

        return back()->with('success', '모든 알림을 읽음 처리했습니다.');
    }

    public function destroy($id)
    {
        $notification = Notification::where('user_id', Auth::id())
            ->findOrFail($id);

        $notification->delete();

        return back()->with('success', '알림이 삭제되었습니다.');
    }

    public function destroyAll()
    {
        Notification::where('user_id', Auth::id())->delete();

        return back()->with('success', '모든 알림이 삭제되었습니다.');
    }

    public function getUnreadCount()
    {
        $count = Notification::where('user_id', Auth::id())
            ->unread()
            ->count();

        return response()->json(['count' => $count]);
    }

    public function getRecentNotifications()
    {
        $notifications = Notification::where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        return response()->json($notifications);
    }
}
