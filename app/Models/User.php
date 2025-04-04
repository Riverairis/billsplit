<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'last_name',
        'first_name',
        'nickname',
        'email',
        'username',
        'password',
        'account_type',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'last_guest_access' => 'datetime',
    ];

    public function bills()
    {
        return $this->hasMany(Bill::class);
    }

    public function participations()
    {
        return $this->belongsToMany(Bill::class, 'bill_users');
    }

    public function sharedBills()
    {
        return $this->belongsToMany(Bill::class, 'bill_users');
    }

    public function expenses()
    {
        return $this->hasMany(Expense::class, 'paid_by');
    }

    public function isStandard()
    {
        return $this->account_type === 'standard';
    }

    public function isPremium()
    {
        return $this->account_type === 'premium';
    }

    public function isGuest()
{
    return $this->account_type === 'guest'; // Adjust based on your user model
}

public function canJoinBill()
{
    // Allow one bill access per day for guests
    return !$this->last_guest_access || 
           $this->last_guest_access->lt(now()->subDay());
}

    public function canCreateBill()
    {
        if ($this->isPremium()) {
            return true;
        }

        if ($this->isStandard()) {
            $currentMonthBills = $this->bills()
                ->whereMonth('created_at', now()->month)
                ->count();
            
            return $currentMonthBills < 5;
        }

        return false;
    }
}