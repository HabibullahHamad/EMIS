<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
   public function index(Request $request)
{
    $user = auth()->user();

    $query = \App\Models\Notification::with('user')->latest();

    // Admin can see all notifications
    if (!$user->canAccess('notifications.view_all')) {
        // Normal users see only their own notifications
        $query->where('user_id', $user->id);
    }

    if ($request->filled('type')) {
        $query->where('type', $request->type);
    }

    if ($request->filled('status')) {
        if ($request->status === 'read') {
            $query->where('is_read', true);
        }

        if ($request->status === 'unread') {
            $query->where('is_read', false);
        }
    }

    $notifications = $query->paginate(15)->withQueryString();

    return view('notifications.index', compact('notifications'));
}

    public function unread()
    {
        $notifications = Notification::where('user_id', auth()->id())
            ->where('is_read', false)
            ->latest()
            ->paginate(15);

        $stats = [
            'total' => Notification::where('user_id', auth()->id())->count(),
            'unread' => Notification::where('user_id', auth()->id())->where('is_read', false)->count(),
        ];

        return view('notifications.index', compact('notifications', 'stats'));
    }

    public function markAsRead(Notification $notification)
{
    $user = auth()->user();

    // Normal user can only read own notification
    // Admin / permission user can read all
    if ($notification->user_id !== $user->id && !$user->canAccess('notifications.view_all')) {
        abort(403);
    }

    $oldValues = $notification->getOriginal();

    $notification->update([
        'is_read' => true,
        'read_at' => now(),
    ]);

    if (function_exists('audit_log')) {
        audit_log('notification_read', $notification, $oldValues, $notification->getChanges());
    }

    return back()->with('success', 'Notification marked as read.');
}
    public function markAllAsRead()
    {
        Notification::where('user_id', auth()->id())
            ->where('is_read', false)
            ->update([
                'is_read' => true,
                'read_at' => now(),
            ]);

        if (function_exists('audit_log')) {
            audit_log('all_notifications_read', null, null, [
                'user_id' => auth()->id(),
            ]);
        }

        return back()->with('success', 'All notifications marked as read.');
    }

    public function destroy(Notification $notification)
{
    $user = auth()->user();

    if ($notification->user_id !== $user->id && !$user->canAccess('notifications.view_all')) {
        abort(403);
    }

    $oldValues = $notification->toArray();

    if (function_exists('audit_log')) {
        audit_log('notification_deleted', $notification, $oldValues, null);
    }

    $notification->delete();

    return back()->with('success', 'Notification deleted successfully.');
}
}