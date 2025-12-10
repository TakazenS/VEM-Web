<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureContactFormSubmit
{
    public function handle(Request $request, Closure $next): Response
    {
        if (!session()->has('contact_success')) {
            return redirect()->route('contact');
        }

        return $next($request);
    }
}
