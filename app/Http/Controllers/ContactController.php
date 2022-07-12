<?php

namespace App\Http\Controllers;

use App\Mail\ContactMail;
use App\Mail\Test;
use App\Models\Contact;
use Illuminate\Support\Facades\Mail;

class ContactController extends Controller
{
    public function create()
    {
        return view('contact');
    }

    public function store()
    {
        $attributes = request()->validate([
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required',
            'subject' => 'nullable|min:5|max:50',
            'message' => 'required|min:5|max:500',
        ]);

        Contact::create(
            $attributes
        );

        Mail::to("billlelatobur@gmail.com")->send(new ContactMail(
           $attributes['first_name'],
           $attributes['last_name'],
           $attributes['email'],
           $attributes['subject'],
           $attributes['message']
        ));

        return redirect()->route('contact.create')->with('success', 'Your message has been sent!');
    }
}
