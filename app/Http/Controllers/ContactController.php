<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class ContactController extends Controller
{
    public function index(): View
    {
        return view('contact.contact');
    }

    public function send(Request $request)
    {
        $request->validate([
            'service' => ['required', 'max:25', Rule::in(['administration', 'logistique'])],
            'name' => ['required', 'max:50', 'regex:/^[\p{L} -]+$/u'],
            'email' => ['required', 'max:70', 'regex:/^[a-zA-Z0-9.-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,3}$/'],
            'tel' => ['nullable', 'max:14', 'regex:/^(\d{10}|\d{2}( \d{2}){4})$/'],
            'object' => ['required', 'max:150'],
            'corps' => ['required', 'max:1500'],
        ]);

        Contact::create($request->all());

        return view('contact.valid-contact-send');
    }
}
