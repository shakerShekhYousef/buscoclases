<?php

namespace App\Http\Controllers;

use App\Http\Requests\api\ContactUs\ContactUsRequest;
use App\Mail\ContactUsMail;
use App\Models\ContactUs;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ContactUsController extends Controller
{
    public function send(ContactUsRequest $request){
        if ($request->accept_privacy == 0){
            return forbidden_response('por favor acepte las condiciones de privacidad');
        }
        $to = 'buscoclasesapp@gmail.com';
        $first_name = $request->first_name;
        $last_name = $request->last_name;
        $phone = $request->phone;
        $email = $request->email;
        $reason = $request->reason;
        $message = $request->message;
        $contact_us = ContactUs::create([
            'first_name'=>$first_name,
            'last_name'=>$last_name,
            'phone'=>$phone,
            'email'=>$email,
            'reason'=>$reason,
            'message'=>$message
        ]);
//        Mail::to($to)->send(new ContactUsMail($first_name,$last_name,$phone,$email,$reason,$message));
        return success_response('mensaje enviado');
    }

    public function index(){
        $messages = ContactUs::all();
        return success_response($messages);
    }

    public function show(ContactUs $contactUs){
        return success_response($contactUs);
    }

}
