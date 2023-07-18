<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Requests\api\Group\AddUsersToGroupRequest;
use App\Http\Requests\api\Group\CreateGroupRequest;
use App\Http\Requests\api\Group\DeleteUsersFromGroupRequest;
use App\Http\Requests\api\Group\SendMessageToGroup;
use App\Http\Requests\api\Group\UpdateGroupRequest;
use App\Models\Chat;
use App\Models\Customer;
use App\Models\Group;
use App\Models\GroupMessage;
use App\Models\Teacher;
use App\Repositories\api\GroupRepository;

class GroupController extends Controller
{
    public $groupRepository;

    public function __construct(GroupRepository $groupRepository)
    {
        $this->groupRepository = $groupRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $groups = Group::paginate(10);

        return success_response($groups);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  CreateGroupRequest  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(CreateGroupRequest $request)
    {
        $group = $this->groupRepository->create($request->all());

        return success_response($group);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Group  $group
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Group $group)
    {
        return success_response($group);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Group  $group
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(UpdateGroupRequest $request, Group $group)
    {
        $group = $this->groupRepository->update($group, $request->all());

        return success_response($group);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Group  $group
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Group $group)
    {
        $group->delete();

        return success_response('El grupo ha sido eliminado con éxito.');
    }

    //Add users to group
    public function addUsersToGroup(AddUsersToGroupRequest $request)
    {
        $this->groupRepository->addUsers($request->all());

        return success_response('Los usuarios se han agregado con éxito.');
    }

    //Delete users from group
    public function deleteUsersFromGroups(DeleteUsersFromGroupRequest $request)
    {
        $this->groupRepository->deleteUsers($request->all());

        return success_response('Los usuarios han sido eliminados exitosamente.');
    }

    //Get users of group
    public function getUserOfGroup()
    {
        $group_id = $_GET['group_id'];
        $users = Group::query()->where('id', $group_id)
            ->with('users')->paginate(10);

        return success_response($users);
    }

    //Send message to group
    public function sendMessage(SendMessageToGroup $request)
    {
        $message = $this->groupRepository->sendMessage($request->all());

        return success_response($message);
    }

    //Get messages for group
    public function getMessages()
    {
        $group_id = $_GET['group_id'];
        $messages = GroupMessage::query()
            ->where('group_id', $group_id)
            ->with('sender')
            ->get();

        return success_response($messages);
    }

    //Get my contact
    public function getMyContact()
    {
        $my_contact = $this->groupRepository->getMyContact();

        return success_response($my_contact);
    }

    //Get my groups
    public function getMyGroups()
    {
        $my_groups = $this->groupRepository->getMyGroups();

        return success_response($my_groups);
    }

    //Search in my groups or my contact
    public function search()
    {
        //Get search query
        $search = $_GET['search'];
        //Get auth user
        $user = auth()->user();
        //Get my contacts
        if ($user->role_id == 1) {
            $my_contact = [];
            $teachers_id = Chat::query()->where([['admin', 1], ['status', 'open']])
                ->where('teacher_id', '<>', null)->pluck('teacher_id');
            if ($teachers_id->first() !== null) {
                $teachers = Teacher::query()->whereIn('id', $teachers_id)
                    ->where('name', 'like', '%'.$search.'%')->get();
                $my_contact[] = $teachers;
            }
            $customers_id = Chat::query()->where([['admin', 1], ['status', 'open']])
                ->where('customer_id', '<>', null)->pluck('customer_id');
            if ($customers_id->first() !== null) {
                $customers = Customer::query()->whereIn('id', [$customers_id])
                    ->where('trade_name', 'like', '%'.$search.'%')
                    ->orWhere('business_name', 'like', '%'.$search.'%')
                    ->get();
                $my_contact[] = $customers;
            }
        } elseif ($user->role_id == 2) {
            $my_contact = [];
            $teachers_id = Chat::query()->where([['customer_id', $user->id], ['status', 'open']])
                ->where('teacher_id', '<>', null)->pluck('teacher_id');
            if ($teachers_id->first() !== null) {
                $teachers = Teacher::query()->whereIn('id', $teachers_id)
                    ->where('name', 'like', '%'.$search.'%')->get();
                $my_contact[] = $teachers;
            }
        } elseif ($user->role_id == 3) {
            $my_contact = [];
            $customers_id = Chat::query()->where([['teacher_id', $user->id], ['status', 'open']])
                ->where('customer_id', '<>', null)->pluck('customer_id');
            if ($customers_id->first() !== null) {
                $customers = Customer::query()->whereIn('id', $customers_id)
                    ->where('trade_name', 'like', '%'.$search.'%')
                    ->orWhere('business_name', 'like', '%'.$search.'%')
                    ->get();
                $my_contact[] = $customers;
            }
        }
        //Get my groups
        $my_groups = $user->groups()->where('name', 'like', '%'.$search.'%')->get();
        //Response
        $data = [
            'my_contacts' => $my_contact,
            'my_groups' => $my_groups,
        ];

        return success_response($data);
    }
}
