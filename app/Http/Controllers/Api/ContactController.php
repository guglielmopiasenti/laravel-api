<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Mail\ContactMessageMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class ContactController extends Controller
{
    public function message(Request $request){
        $data = $request->all();

        $validator = Validator::make($data, [
            'email' =>'required|email',
            'subject' =>'required|string',
            'content' =>'required|string',
        ],[
            'email.required' => 'mail is mandatory',
            'email.email' => 'mail address is invalid',
            'subject.required' => 'mail subject is mandatory',
            'content.required' => 'mail content is mandatory',
        ]);
        $mail = new ContactMessageMail(
            sender: $data['email'],
            subject: $data['subject'],
            content: $data['message'],
        );
        Mail::to(env('MAIL_TO_ADDRESS'))->send($mail);

       return response(null, 204);
    }
}
