<?php

namespace App\Support;

use App\Models\AppNotification;
use Illuminate\Support\Collection;

/** Pembuat notifikasi dalam aplikasi (jadwal, pengumuman, status pendaftaran, sertifikat). */
class Notifier
{
    /** @param iterable|Collection|\App\Models\User $users */
    public static function send($users, string $title, ?string $message = null, ?string $url = null): void
    {
        $users = $users instanceof \App\Models\User ? [$users] : $users;
        foreach ($users as $u) {
            AppNotification::create([
                'user_id' => $u->id,
                'title' => $title,
                'message' => $message,
                'url' => $url,
            ]);
        }
    }
}
