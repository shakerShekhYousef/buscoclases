<?php

namespace App\Repositories\api;

use App\Exceptions\GeneralException;
use App\Models\Application;
use App\Models\Customer;
use App\Models\Group;
use App\Models\GroupMessage;
use App\Models\Notification;
use App\Models\Teacher;
use App\Models\UserGroup;
use App\Repositories\BaseRepository;
use App\Trait\FileTrait;
use Illuminate\Support\Facades\DB;

class GroupRepository extends BaseRepository
{
    use FileTrait;

    public function model()
    {
        return Group::class;
    }

    public function create(array $data)
    {
        return DB::transaction(function () use ($data) {
            $group = parent::create([
                'name' => $data['name'],
                'image' => $this->upload($data['image'], 'images/groups'),
                'created_by_id' => auth()->id(),
            ]);
            UserGroup::create([
                'user_id' => auth()->id(),
                'group_id' => $group->id,
                'is_group_admin' => 1,
            ]);
            UserGroup::create([
                'user_id' => 1,
                'group_id' => $group->id,
                'is_group_admin' => 1,
            ]);

            return $group;
        });
        throw new GeneralException('error');
    }

    public function update(Group $group, array $data)
    {
        return DB::transaction(function () use ($group, $data) {
            if ($group->update([
                'name' => isset($data['name']) ? $data['name'] : $group->name,
                'image' => isset($data['image']) ? $this->upload($data['image'], 'images/groups') : $group->image,
            ])) {
                return $group;
            }
            throw new GeneralException('error');
        });
    }

    public function addUsers(array $data)
    {
        return DB::transaction(function () use ($data) {
            foreach ($data['user_id'] as $key => $value) {
                $users = UserGroup::create([
                    'user_id' => $value,
                    'group_id' => $data['group_id'],
                ]);
            }
            if ($users) {
                return true;
            }
            throw new GeneralException('error');
        });
    }

    public function deleteUsers(array $data)
    {
        return DB::transaction(function () use ($data) {
            //Check if user is the admin
            $authUser = UserGroup::query()->where([
                ['group_id', $data['group_id']],
                ['user_id', auth()->id()],
            ])->first();
            if (! $authUser->is_group_admin) {
                throw new GeneralException('No eres administradora en esta grupo.');
            }
            $users = UserGroup::query()->where('group_id', $data['group_id'])
           ->whereIn('user_id', $data['user_id'])
           ->delete();

            return true;
        });
        throw new GeneralException('error');
    }

    public function sendMessage(array $data)
    {
        return DB::transaction(function () use ($data) {
            //Get group
            $group = Group::query()->where('id',$data['group_id'])->first();
            //check if user in group
            $user = UserGroup::query()->where([
                ['group_id', $data['group_id']],
                ['user_id', auth()->id()],
            ])->first();
            if (! $user) {
                throw new GeneralException('No eres un miembro de este grupo.');
            }
            if ($data['message_type'] !== 'text') {
                $message = $this->upload($data['message'], 'group_messages/'.$data['group_id']);
            } else {
                $message = $data['message'];
            }
            $group_message = GroupMessage::create([
                'message' => $message,
                'message_type' => $data['message_type'],
                'sender_id' => auth()->id(),
                'group_id' => $data['group_id'],
            ]);
            $users = $group->users;
            foreach ($users as $user){
                if ($user->id === auth()->id()){
                    continue;
                }
                if ($user->setting->chat_notification){
                    if (auth()->user()->account_type == "teacher"){
                        $auth_user = Teacher::query()->where('user_id',auth()->id())->first();
                        $title = "Nuevo mensaje de ".$auth_user->name." ".$auth_user->surname." un grupo ".$group->name;
                    }elseif (auth()->user()->account_type == "customer"){
                        $auth_user = Customer::query()->where('user_id',auth()->id())->first();
                        $title = "Nuevo mensaje de ".$auth_user->trade_name." un grupo ".$group->name;
                    }elseif (auth()->user()->account_type == "admin"){
                        $title = "Nuevo mensaje de admin un grupo ".$group->name;
                    }
                    $link = "/api/groups/show/get_messages?group_id=".$group->id;
                    send_message_notification($user, $title, $message);
                    Notification::create([
                        'user_id' => $user->id,
                        'content' =>  $data['message'],
                        'title' => $title,
                        'link' => $link
                    ]);
                }
            }

            return $group_message;
        });
        throw new GeneralException('error');
    }

    public function getMyContact()
    {
        //Get Customer id
        $customer_id = auth()->id();
        //Get teachers approved
        $teachers = Application::query()->where('status', 'approved')
            ->whereHas('offer', function ($query) use ($customer_id) {
                $query->where('customer_id', $customer_id);
            })->with('teacher')->get();
        //Response
        return $teachers;
    }

    public function getMyGroups()
    {
        //Get auth user
        $user = auth()->user();
        //Get my groups
        $my_groups = $user->groups()->get();
        //Response
        return $my_groups;
    }
}
