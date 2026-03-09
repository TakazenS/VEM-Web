<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use Illuminate\Support\Str;
use Illuminate\View\View;

class DmdContactController
{
    public function index(): View
    {
        $contacts = Contact::all();

        return view('dashboard-pages.gestion-contact', ['contacts' => $contacts]);
    }
}
