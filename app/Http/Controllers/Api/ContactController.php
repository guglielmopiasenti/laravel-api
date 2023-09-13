<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Mail\ContactMessageMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class ContactController extends Controller
{
    // This method handles the incoming contact message request
    public function message(Request $request){
        // Retrieve all data from the request
        $data = $request->all();

        // Validate the incoming data using Laravel's Validator
        $validator = Validator::make($data, [
            'email' =>'required|email',  
            'subject' =>'required|string', 
            'content' =>'required|string', 
        ],[
            // Custom error messages for validation failures
            'email.required' => 'Email is mandatory',
            'email.email' => 'Email address is invalid',
            'subject.required' => 'Email subject is mandatory',
            'content.required' => 'Email content is mandatory',
        ]);

        // Check if validation fails, and return validation errors if it does
        if($validator->fails()){
            return response()->json(['errors' => $validator->errors()], 400);
        }

        // Create a new ContactMessageMail instance with the provided data
        $mail = new ContactMessageMail(
            sender: $data['email'],
            subject: $data['subject'],
            content: $data['content'],
        );

        // Send the email using Laravel's Mail facade to the specified address
        Mail::to(env('MAIL_TO_ADDRESS'))->send($mail);

        // Return a successful response with a status code 204 (No Content)
        return response(null, 204);
    }
}