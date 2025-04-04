<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckGuestAccess
{
    public function handle(Request $request, Closure $next)
    {
        $bill = $request->route('bill');
        
        // For authenticated users
        if (auth()->check()) {
            if ($bill->user_id !== auth()->id() && !$bill->participants->contains(auth()->id())) {
                abort(403, 'Unauthorized access to this bill');
            }
        } 
        // For non-authenticated users (invitation code access)
        else {
            if (session('guest_bill_id') != $bill->id) {
                abort(403, 'Please use your invitation link to access this bill');
            }
        }

        return $next($request);
    }
}