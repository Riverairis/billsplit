<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invitation extends Model
{
    use HasFactory;

    protected $fillable = [
        'bill_id',
        'email',
        'user_type',
        'nickname',
        'token',
        'expires_at'
    ];

    public function bill()
    {
        return $this->belongsTo(Bill::class);
    }
}
