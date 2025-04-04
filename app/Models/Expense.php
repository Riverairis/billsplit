<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Expense extends Model
{
    use HasFactory;

    protected $fillable = [
        'bill_id',
        'category_id',
        'name',
        'amount',
        'paid_by',
        'split_type',
    ];

    public function bill()
    {
        return $this->belongsTo(Bill::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function splits()
    {
        return $this->hasMany(ExpenseSplit::class);
    }

    // In Expense.php
public function payer()
{
    return $this->belongsTo(User::class, 'paid_by');
}
}