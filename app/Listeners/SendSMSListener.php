<?php

namespace App\Listeners;

use App\Events\SendSMSEvent;
use Illuminate\Support\Facades\Http;

class SendSMSListener
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
     * @param  object  $event
     * @return void
     */
    public function handle(SendSMSEvent $event)
    {
        $code = '999999';
        $headers = [
            'content-type' => 'application/json',
            'Authorization' => 'Basic Z2hhZGVlci45NS5haEBnbWFpbC5jb246dGhlcHJpbmNlLjEyMw==',
            'X-RapidAPI-Key' => env('SMS_APP_KEY'),
            'X-RapidAPI-Host' => env('SMS_API_HOST'),
        ];
        $data = [
            'data' => ['content' => $code, 'from' => 'BUSCO CLASES', 'to' => $event->phone],
        ];
        $response = Http::withHeaders($headers)->post('https://d7sms.p.rapidapi.com/secure/send', $data);

        return $response;
    }
}
