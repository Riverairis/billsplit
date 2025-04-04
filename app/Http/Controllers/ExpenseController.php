<?php

namespace App\Http\Controllers;

use App\Models\Bill;
use App\Models\Category;
use App\Models\Expense; // Add this import
use Illuminate\Http\Request;

class ExpenseController extends Controller
{
    public function create(Bill $bill)
    {
        $categories = Category::orderBy('name')->get();
        return view('expenses.create', compact('bill', 'categories'));
    }

    public function store(Request $request)
{
    $validated = $request->validate([
        'bill_id' => 'required|exists:bills,id',
        'name' => 'required|string|max:255',
        'amount' => 'required|numeric|min:0',
        'paid_by' => 'required|exists:users,id',
        'split_type' => 'required|in:equal,exact,percentage',
        'category' => 'required|string|max:255',
        'category_id' => 'nullable|exists:categories,id',
    ]);

    $bill = Bill::findOrFail($request->bill_id);
    $this->authorize('update', $bill);

    $category = $request->category_id 
        ? Category::findOrFail($request->category_id)
        : Category::firstOrCreate(
            ['name' => $request->category],
            ['color' => '#' . dechex(rand(0x000000, 0xFFFFFF))]
        );

    $expense = Expense::create([
        'bill_id' => $bill->id,
        'category_id' => $category->id,
        'name' => $request->name,
        'amount' => $request->amount,
        'paid_by' => $request->paid_by,
        'split_type' => $request->split_type,
    ]);

    // Handle split logic based on split_type
    $this->handleExpenseSplit($expense, $request);

    return redirect()->route('bills.show', $bill)
        ->with('success', 'Expense added successfully!');
}

private function handleExpenseSplit(Expense $expense, Request $request)
{
    $participants = $expense->bill->participants->pluck('id')->push($expense->bill->user_id);
    $totalParticipants = $participants->count();

    switch ($expense->split_type) {
        case 'equal':
            $amountPerPerson = $expense->amount / $totalParticipants;
            foreach ($participants as $userId) {
                ExpenseSplit::create([
                    'expense_id' => $expense->id,
                    'user_id' => $userId,
                    'amount' => $amountPerPerson,
                ]);
            }
            break;
        // Add cases for 'exact' and 'percentage' as needed
    }
}
}