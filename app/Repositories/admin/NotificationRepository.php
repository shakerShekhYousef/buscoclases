<?php

namespace App\Repositories\admin;

use App\Models\Notification;
use App\Repositories\BaseRepository;

class NotificationRepository extends BaseRepository
{
    public function model()
    {
        return Notification::class;
    }
}
