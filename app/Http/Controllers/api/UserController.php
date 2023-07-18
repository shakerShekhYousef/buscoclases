<?php

namespace App\Http\Controllers\api;

use App\Events\SendSMSEvent;
use App\Http\Controllers\Controller;
use App\Http\Requests\api\Auth\PhoneLoginRequest;
use App\Http\Requests\api\User\UpdateImageRequest;
use App\Repositories\api\UserRepository;
use App\Trait\FileTrait;
use Illuminate\Http\Request;

class UserController extends Controller
{
    use FileTrait;

    protected $userRepo;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepo = $userRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateImageRequest $request)
    {
        if ($request->hasFile('image')) {
            $path = $this->upload($request->file('image'), 'users');
            $this->userRepo->updateImage($path);

            return success_response(['image' => $path]);
        }

        return error_response('Por favor elige una imagen');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    /**
     * phone login
     *
     * @param  PhonLoginRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function phoneLogin(PhoneLoginRequest $request)
    {
        $response = event(new SendSMSEvent($request['phone']));

        return $response;
    }
}
