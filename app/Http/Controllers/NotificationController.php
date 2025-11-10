<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function partial()
    {
        $notifications = Notification::where('is_read', 0)
        ->latest()->take(10)->get();

        if(auth()->user()->role->id == '3')
        {
            $notifications = Notification::where('is_read', 0)
            ->where('user_id', auth()->user()->id)
            ->latest()->take(10)->get();
        }

        return view('partials.dashboard.cards._notifikasi-list', compact('notifications'));
    }

    public function markAllRead()
    {
        Notification::where('is_read', 0)
        ->where('user_id', auth()->user()->id)
        ->update(['is_read' => 1]);

        return back()->with('success', 'Semua notifikasi telah ditandai sebagai dibaca.');
    }

    public function markRead($id)
    {
        $notif = Notification::where('id', $id)
            ->firstOrFail();

        $notif->update(['is_read' => 1]);


        return back()->with('success', 'Notifikasi telah ditandai sebagai dibaca.');
    }

    public function destroy($id)
    {
        $notif = Notification::where('id', $id)
            ->firstOrFail();

        $notif->delete();

        return back()->with('success', 'Notifikasi berhasil dihapus.');
    }
}
