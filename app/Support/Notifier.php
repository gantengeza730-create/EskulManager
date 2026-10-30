<?php

namespace App\Support;

use App\Models\AppNotification;

/** Pembuat notifikasi dalam aplikasi. */
class Notifier
{
    public static function send($users, string $title, ?string $message = null, ?string $url = null): void
    {
        $users = $users instanceof \App\Models\User ? [$users] : $users;
        foreach ($users as $u) {
            AppNotification::create(['user_id' => $u->id, 'title' => $title, 'message' => $message, 'url' => $url]);
        }
    }
}
