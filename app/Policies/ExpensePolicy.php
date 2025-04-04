<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Expense;
use Illuminate\Auth\Access\HandlesAuthorization;

class ExpensePolicy
{
    use HandlesAuthorization;

    public function create(User $user, Expense $expense)
    {
        return $expense->bill->user_id === $user->id || $expense->bill->participants->contains($user->id);
    }

    public function update(User $user, Expense $expense)
    {
        return $expense->bill->user_id === $user->id;
    }

    public function delete(User $user, Expense $expense)
    {
        return $expense->bill->user_id === $user->id;
    }
}