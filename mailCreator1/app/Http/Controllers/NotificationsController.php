<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationsController extends Controller
{
    public function index()
    {
        $notifications = Notification::where('user_id', Auth::id())
            ->with(['campaign'])
            ->orderBy('created_at', 'DESC')
            ->paginate(20);

        return view('notifications.index', [
            'title' => 'Notificaciones',
            'notifications' => $notifications
        ]);
    }

    public function markAsRead($id)
    {
        $notification = Notification::findOrFail($id);
        
        if ($notification->user_id === Auth::id()) {
            $notification->update(['read' => true]);
            
            if ($notification->action_url) {
                return redirect($notification->action_url);
            }
        }
        
        return redirect()->route('notifications.index');
    }

    public function markAllAsRead()
    {
        Notification::where('user_id', Auth::id())
            ->where('read', false)
            ->update(['read' => true]);
            
        return redirect()->back()->with('success', 'Todas las notificaciones marcadas como leídas');
    }

    public function getUnreadCount()
    {
        return response()->json([
            'count' => Notification::where('user_id', Auth::id())
                ->where('read', false)
                ->count()
        ]);
    }
}