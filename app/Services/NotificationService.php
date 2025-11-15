<?php

namespace App\Services;

use App\Models\Notification;
use App\Models\User;
use Illuminate\Support\Facades\Log;

class NotificationService
{
    /**
     * Kirim notifikasi ke user.
     *
     * @param int $userId
     * @param string $title
     * @param string $message
     * @param string $type
     * @return \App\Models\Notification|null
     */
    public static function send(int $userId, string $title, string $message, string $type = 'info')
    {
        try {
            // pastikan user ada
            $user = User::findOrFail($userId);

            return Notification::create([
                'user_id' => $user->id,
                'type' => $type,
                'title' => $title,
                'message' => $message,
                'is_read' => false,
            ]);
        } catch (\Exception $e) {
            Log::error("Gagal mengirim notifikasi: " . $e->getMessage());
            return null;
        }
    }

    /**
     * Kirim notifikasi ke banyak user sekaligus.
     *
     * @param array $userIds
     * @param string $title
     * @param string $message
     * @param string $type
     * @return void
     */
    public static function broadcast(array $userIds, string $title, string $message, string $type = 'info')
    {
        foreach ($userIds as $userId) {
            self::send($userId, $title, $message, $type);
        }
    }
}