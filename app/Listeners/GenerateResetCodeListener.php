<?php

namespace App\Listeners;

use App\Events\GenerateResetCodeEvent;
use App\Models\PasswordResetCode;
use App\Models\User;
use Nette\Utils\Random;

class GenerateResetCodeListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  GenerateResetCodeEvent  $event
     * @return void
     */
    public function handle(GenerateResetCodeEvent $event)
    {
        $user = User::where('email', $event->email)->first();
        if ($user != null) {
            $check = 1;
            while ($check > 0) {
                $code = Random::generate(6, '0-9');
                $check = PasswordResetCode::where('code', $code)->count();
            }
            $expire = time() + 3600;
            $code = PasswordResetCode::create([
                'user_id' => $user->id,
                'code' => $code,
                'expire_at' => $expire,
            ]);
        }
    }
}
