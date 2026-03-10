<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use Auth;
use Illuminate\View\View;

class DashboardController
{
    public function index(): View
    {
        if (Auth::user()->isAdmin()) {
            $contactCount = Contact::where('service', '=', 'administration')
                ->get()
                ->count();
        } else if (Auth::user()->isLogistique()) {
            $contactCount = Contact::where('service', '=', 'logistique')
                ->get()
                ->count();
        } else {
            $contactCount = Contact::all()
                ->count();
        }

        return view('dashboard', ['contactCount' => $contactCount]);
    }
}
