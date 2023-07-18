<?php

use App\Models\Device;
use GuzzleHttp\Client;

if (! function_exists('send_message_notification')) {
    function send_message_notification($user, $title, $message)
    {
        $reciever = Device::query()->where('user_id', $user->id)->first();
        if ($reciever === null) {
            return not_found_response('Not Found');
        }
        $client = new Client();
        $response = $client->post('https://fcm.googleapis.com/fcm/send', [
            'headers' => [
                'Authorization' => 'key=AAAA7zD6LEs:APA91bFOPmJfGco3PovoqxoZnoa8P0n9minhEufXnCGCPr7eXgbydLwHF5Qf7SeZ1DwObgXiMviFoXOGSKLHBiZD7jB6Br2nXDb7CdYpGz0VMyS2bJgluQR4BGONHlXconjcNfw-fARt',
                'Content-Type' => 'application/json',
            ],
            'json' => [
                'to' => $reciever->firebase_token,
                'notification' => [
                    'title' => $title,
                    'body' => $message,
                ],
                'data' => [
                    'type' => 'message',
                    'sender' => $user->id,
                ],
            ],
        ]);

        return $response;
    }
}
if (! function_exists('send_file_notification')) {
    function send_file_notification($user, $title, $file)
    {
        if ($user->firebase_token == null) {
            return;
        }
        $client = new Client();
        $response = $client->post('https://fcm.googleapis.com/fcm/send', [
            'headers' => [
                'Authorization' => 'key=AAAA7zD6LEs:APA91bFOPmJfGco3PovoqxoZnoa8P0n9minhEufXnCGCPr7eXgbydLwHF5Qf7SeZ1DwObgXiMviFoXOGSKLHBiZD7jB6Br2nXDb7CdYpGz0VMyS2bJgluQR4BGONHlXconjcNfw-fARt',
                'Content-Type' => 'application/json',
            ],
            'json' => [
                'to' => $user->firebase_token,
                'notification' => [
                    'title' => $title,
                    'body' => 'file',
                ],
                'data' => [
                    'type' => 'file',
                    'path' => $file,
                    'sender' => $user->id,
                ],
            ],
        ]);

        return $response;
    }
}

if (! function_exists('send_message_read_notification')) {
    function send_message_read_notification($user)
    {
        if ($user->firebase_token == null) {
            return;
        }
        $client = new Client();
        $response = $client->post('https://fcm.googleapis.com/fcm/send', [
            'headers' => [
                'Authorization' => 'key=AAAA7zD6LEs:APA91bFOPmJfGco3PovoqxoZnoa8P0n9minhEufXnCGCPr7eXgbydLwHF5Qf7SeZ1DwObgXiMviFoXOGSKLHBiZD7jB6Br2nXDb7CdYpGz0VMyS2bJgluQR4BGONHlXconjcNfw-fARt',
                'Content-Type' => 'application/json',
            ],
            'json' => [
                'to' => $user->firebase_token,
                'notification' => [
                    'title' => 'read',
                ],
                'data' => [
                    'type' => 'read',
                    'user_id' => $user->id,
                ],
            ],
        ]);

        return $response;
    }
}
