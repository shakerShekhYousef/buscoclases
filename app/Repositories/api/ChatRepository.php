<?php

namespace App\Repositories\api;

use App\Models\Chat;
use App\Models\Message;
use App\Models\User;
use App\Repositories\BaseRepository;
use App\Trait\UserTrait;

class ChatRepository extends BaseRepository
{
    use UserTrait;

    public function model()
    {
        return Chat::class;
    }

    public function create($reciever_id)
    {
        $user = auth()->user();
        $chat = null;
        //check receiver
        $receiver = User::query()->where('id', $reciever_id)->first();
        if ($user->account_type == 'teacher') {
            $chat = Chat::where('teacher_id', $user->id)
                ->where('customer_id', $reciever_id)->first();
        } elseif ($user->account_type == 'customer') {
            $chat = Chat::where('customer_id', $user->id)
                ->where('teacher_id', $reciever_id)->first();
        } elseif ($user->account_type == 'admin') {
            //check role
            if ($receiver->account_type == 'customer') {
                $chat = Chat::where('admin', $user->id)
                    ->where('teacher_id', $reciever_id)->first();
            } elseif ($receiver->account_type == 'teacher') {
                $chat = Chat::where('admin', $user->id)
                    ->where('customer_id', $reciever_id)->first();
            }
        }
        if ($chat == null) {
            $data = [];
            if ($user->account_type == 'teacher') {
                $data['teacher_id'] = $user->id;
                if ($receiver->id == 1){
                    $data['admin'] = $reciever_id;
                }else{
                    $data['customer_id'] = $reciever_id;
                }

            } elseif ($user->account_type == 'customer') {
                $data['customer_id'] = $user->id;
                if ($receiver->id == 1){
                    $data['admin'] = $reciever_id;
                }else{
                    $data['teacher_id'] = $reciever_id;
                }
            } elseif ($user->account_type == 'admin') {
                if ($receiver->account_type == 'teacher') {
                    $data['admin'] = $user->id;
                    $data['teacher_id'] = $reciever_id;
                } elseif ($receiver->account_type == 'customer') {
                    $data['admin'] = $user->id;
                    $data['customer_id'] = $reciever_id;
                }
            }
            $chat = Chat::create($data);
            if ($chat) {
                return $chat;
            }

            return null;
        }

        return $chat;
    }

    public function chats()
    {
        $user = auth()->user();
        $chats = Chat::with(['admin', 'teacher', 'customer'])->where('teacher_id', $user->id)
            ->orWhere('customer_id', $user->id)
            ->orWhere('admin', $user->id)
            ->get();
        $data = [];
        foreach ($chats as $chat) {
            $message = Message::where('chat_id', $chat->id)->orderBy('created_at', 'desc')->first();
            if ($message != null) {
                $array = $chat->toArray();
                $user = User::find($message->sender_id);
                $sender = $this->profile($user);
                $messageData = $message->toArray();
                if ($sender != null) {
                    $messageData['sender'] = $sender;
                }
                $array['last_message'] = $messageData;
                array_push($data, $array);
            }
        }

        return $data;
    }

    public function chat($id)
    {
        $user = auth()->user();
        $chat = Chat::with(['teacher', 'customer'])->where('id', $id)
            ->where('teacher_id', $user->id)
            ->orWhere('customer_id', $user->id)
            ->first();
        if ($chat != null) {
            $data = $chat->toArray();
            $messages = Message::with(['sender'])
                ->where('chat_id', $id)->paginate(20);
            $data['messages'] = $messages;

            return $data;
        }

        return null;
    }

    /**
     * get chat messages
     *
     * @param  int  $id
     */
    public function messages($chat_id)
    {
        $messages = Message::where('chat_id', $chat_id)->get();

        return $messages;
    }
}
