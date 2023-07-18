<?php

namespace App\Providers;

use App\Events\GenerateResetCodeEvent;
use App\Events\SendSMSEvent;
use App\Listeners\GenerateResetCodeListener;
use App\Listeners\SendSMSListener;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event to listener mappings for the application.
     *
     * @var array<class-string, array<int, class-string>>
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
        SendSMSEvent::class => [
            SendSMSListener::class,
        ],
        GenerateResetCodeEvent::class => [
            GenerateResetCodeListener::class,
        ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        // Event::listen(
        //     SendSMSEvent::class,
        //     [SendSMSListener::class, 'handle']
        // );
    }

    /**
     * Determine if events and listeners should be automatically discovered.
     *
     * @return bool
     */
    public function shouldDiscoverEvents()
    {
        return false;
    }
}
