<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Bill;
use App\Models\Category;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $user = auth()->user();
        
        // Get bills data
        $activeBills = $user->bills()
            ->where('is_archived', false)
            ->with(['participants', 'expenses.category'])
            ->get();
            
        $sharedBills = $user->sharedBills()
            ->where('is_archived', false)
            ->with(['user', 'participants', 'expenses.category'])
            ->get();
            
        $archivedBills = $user->bills()
            ->where('is_archived', true)
            ->with(['user', 'participants'])
            ->get();

        // Get unique categories from all bills' expenses
        $categories = Category::whereHas('expenses', function($query) use ($user) {
                $query->whereIn('bill_id', $user->bills()->pluck('id'));
            })
            ->withCount(['expenses' => function($query) use ($user) {
                $query->whereIn('bill_id', $user->bills()->pluck('id'));
            }])
            ->get();

        return view('dashboard', compact('activeBills', 'sharedBills', 'archivedBills', 'categories'));
    }
}