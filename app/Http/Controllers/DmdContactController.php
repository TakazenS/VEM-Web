<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use Auth;
use Illuminate\Support\Str;
use Illuminate\View\View;

class DmdContactController
{
    public function index(): View
    {
        if (Auth::user()->isAdmin()) {
            $contacts = Contact::where('service', '=', 'administration')
            ->get();
        } else if (Auth::user()->isLogistique()) {
            $contacts = Contact::where('service', '=', 'logistique')
            ->get();
        } else {
            $contacts = Contact::all();
        }

        return view('dashboard-pages.gestion-contact', ['contacts' => $contacts]);
    }
}
