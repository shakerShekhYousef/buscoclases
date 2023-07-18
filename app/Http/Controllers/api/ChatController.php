<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Requests\api\Chat\OpenChatRequest;
use App\Http\Requests\api\Chat\SendMessageRequest;
use App\Models\Chat;
use App\Models\Customer;
use App\Models\Message;
use App\Models\Notification;
use App\Models\Teacher;
use App\Models\User;
use App\Repositories\api\ChatRepository;
use App\Trait\FileTrait;
use App\Trait\ResponseTrait;

class ChatController extends Controller
{
    use ResponseTrait;
    use FileTrait;

    protected $chatRepo;

    public function __construct(ChatRepository $chatRepository)
    {
        $this->chatRepo = $chatRepository;
    }

    /**
     * get chats
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $chats = $this->chatRepo->chats();

        return $this->success($chats);
    }

    /**
     * get chat details
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $chat = $this->chatRepo->chat($id);

        return $this->success($chat);
    }

    /**
     * get chat messages
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function messages($id)
    {
        $messages = $this->chatRepo->messages($id);

        return $this->success($messages);
    }

    /**
     * open chat between teacher and customer
     *
     * @param  OpenChatRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function createChat(OpenChatRequest $request)
    {
        $chat = $this->chatRepo->create($request['reciever_id']);
        if ($chat) {
            return $this->success($chat);
        }

        return $this->error();
    }

    /**
     * send message to chat
     *
     * @param  SendMessageRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function sendMessage(SendMessageRequest $request)
    {
        $user = auth()->user();
        if ($request['message_type'] !== 'text') {
            $message = $this->upload($request['message'], 'messages/'.$request['chat_id']);
        } else {
            $message = $request['message'];
        }
        $message = Message::create([
            'sender_id' => $user->id,
            'chat_id' => $request['chat_id'],
            'message' => $message,
            'message_type' => $request['message_type'],
        ]);
        //Get chat
        $chat = Chat::query()->where('id',$request['chat_id'])->first();
        //Get User
        if ($chat->teacher_id !== auth()->id() && $chat->admin === null){
            $user = User::query()->where('id',$chat->teacher_id)->first();
            if ($user->setting->chat_notification){
                $auth_user = Customer::query()->where('user_id',auth()->id())->first();
                $title = "Nuevo mensaje de ".$auth_user->trade_name;
                $link ="/api/chats/messages/".$chat->id;
                send_message_notification($user, $title, $message);
                Notification::create([
                    'user_id' => $user->id,
                    'content' =>  $request['message'],
                    'title'=>$title,
                    'link'=>$link
                ]);
            }
        }else if ($chat->customer_id !== auth()->id() && $chat->admin === null){
            $user = User::query()->where('id',$chat->customer_id)->first();
            if ($user->setting->chat_notification) {
                $auth_user = Teacher::query()->where('user_id', auth()->id())->first();
                $title = "Nuevo mensaje de " . $auth_user->name . " " . $auth_user->surname;
                $link = "/api/chats/messages/" . $chat->id;
                send_message_notification($user, $title, $message);
                Notification::create([
                    'user_id' => $user->id,
                    'content' => $request['message'],
                    'title' => $title,
                    'link' => $link
                ]);
            }
        }else if($chat->admin !== null) {
            if ($chat->customer_id !== null){
                $user = User::query()->where('id',$chat->customer_id)->first();
            }else if($chat->teacher_id !== null){
                $user = User::query()->where('id',$chat->teacher_id)->first();
            }
            if ($user->setting->chat_notification) {
                $title = "Nuevo mensaje";
                $link = "/api/chats/messages/" . $chat->id;
                send_message_notification($user, $title, $message);
                Notification::create([
                    'user_id' => $user->id,
                    'content' => $request['message'],
                    'title' => $title,
                    'link' => $link
                ]);
            }
        }
        if ($message) {
            return $this->success($message);
        }

        return $this->error();
    }
}
