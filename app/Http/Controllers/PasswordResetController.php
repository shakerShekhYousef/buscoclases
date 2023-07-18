<?php

namespace App\Http\Controllers;

use App\Events\GenerateResetCodeEvent;
use App\Mail\ResetPassword;
use App\Models\Customer;
use App\Models\PasswordResetCode;
use App\Models\Teacher;
use App\Models\User;
use App\Trait\ResponseTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class PasswordResetController extends Controller
{
    use ResponseTrait;

    /**
     * request reset password code
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        $request->validate(['email' => 'required|exists:users,email']);
        event(new GenerateResetCodeEvent($request['email']));

        $code = PasswordResetCode::with(['user'])->orderBy('created_at', 'desc')->first();
        $name = $code->user->email;
        if ($code->user->account_type == 'teacher') {
            $teacher = Teacher::find($code->user_id);
            if ($teacher) {
                $name = $teacher->name.' '.$teacher->surname;
            }
        } elseif ($code->user->account_type) {
            $customer = Customer::find($code->user_id);
            if ($customer) {
                $name = $customer->trade_name;
            }
        }
        $result = Mail::to($request['email'])->send(new ResetPassword($code->code, $name));

        return $this->success();
    }

    /**
     * check reset code
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function check(Request $request)
    {
        $request->validate([
            'code' => 'required',
            'email' => 'required',
        ]);

        if ($this->checkCode($request['code'], $request['email'])) {
            return $this->success();
        }

        return $this->unauthorized('El código de reinicio no es válido');
    }

    /**
     * reset password
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function reset(Request $request)
    {
        $request->validate([
            'email' => 'required',
            'code' => 'required',
            'password' => 'required',
        ]);
        if ($this->checkCode($request['code'], $request['email'])) {
            $user = User::where('email', $request['email'])->first();
            $user->password = Hash::make($request['password']);
            $user->save();

            return $this->success();
        }

        return $this->unauthorized('El código de reinicio no es válido');
    }

    public function checkCode($code, $email)
    {
        $user = User::where('email', $email)->first();
        $code = PasswordResetCode::where('user_id', $user->id)
            ->where('code', $code)->first();
        if ($code) {
            return true;
        }

        return false;
    }
}
