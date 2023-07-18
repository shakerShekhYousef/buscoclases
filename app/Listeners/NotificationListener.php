<?php

namespace App\Listeners;

use App\Events\NotificationEvent;
use App\Exceptions\GeneralException;
use App\Models\Device;
use App\Models\Notification;

class NotificationListener
{
    public function onCreate($event)
    {
        $tokens = Device::where('user_id', $event->receiver_id)->pluck('firebase_token')->toArray();

        if (count($tokens) != 0) {
            try {
                Notification::create([
                    'user_id' => $event->user_id,
                    'content' => $event->notification,
                ]);
            } catch (GeneralException $e) {
                return error_response($e);
            }
        }

        return 0;
    }

    public function subscribe($events)
    {
        $events->listen(
            NotificationEvent::class,
            'App\Listeners\NotificationListener@onCreate'
        );
    }
}
