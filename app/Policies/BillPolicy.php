<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Bill;
use Illuminate\Auth\Access\HandlesAuthorization;

class BillPolicy
{
    use HandlesAuthorization;

    public function view(User $user, Bill $bill)
{
    return $user->id === $bill->user_id || $bill->participants->contains($user);
}

    public function update(User $user, Bill $bill)
    {
        return $bill->user_id === $user->id;
    }

    public function delete(User $user, Bill $bill)
    {
        return $bill->user_id === $user->id;
    }

    public function archive(User $user, Bill $bill)
    {
        return $bill->user_id === $user->id;
    }
}