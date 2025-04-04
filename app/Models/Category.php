<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'color'];
    public function expenses()
    {
        return $this->hasMany(Expense::class);
    }

    // Helper method to get total expenses amount
    public function getTotalAmountAttribute()
    {
        return $this->expenses->sum('amount');
    }
}