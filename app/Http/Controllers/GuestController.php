<?php

namespace App\Http\Controllers;

use App\Models\Bill;
use Illuminate\Http\Request;

class GuestController extends Controller
{
    public function join(Request $request)
{
    $request->validate(['code' => 'required|string']);
    
    $bill = Bill::where('invitation_code', $request->code)->first();
    
    if (!$bill) {
        return back()->with('error', 'Invalid invitation code');
    }
    
    // For authenticated users
    if (auth()->check()) {
        if (!$bill->participants->contains(auth()->id())) {
            $bill->participants()->attach(auth()->id());
        }
        return redirect()->route('bills.show', $bill);
    }
    
    // For guests
    session(['guest_bill_id' => $bill->id]);
    return redirect()->route('bills.show', $bill);
}
}