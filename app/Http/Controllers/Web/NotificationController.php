<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Notification;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function getNotifications()
    {
        $notifications = Notification::latest()->get()
        ->map(fn($n) => [
            'id'      => $n->id,
            'type'    => $n->type,
            'message' => $n->message,
            'is_read' => $n->is_read,
            'time'    => $n->created_at->diffForHumans(),
        ]);
        return response()->json([
            'count' => $notifications->where('is_read', false)->count(),
            'data' => $notifications
        ]);
    }

    public function markAsRead(Request $request)
    {
        Notification::where('id', $request->id)->update([
            'is_read' => true
        ]);
        return response()->json(['success' => true]);
    }
}
