<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bill extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'invitation_code',
        'user_id',
        'is_archived',
        'category_id'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function participants()
    {
        return $this->belongsToMany(User::class, 'bill_users');
    }

    public function category()
{
    return $this->belongsTo(Category::class);
}

    public function expenses()
    {
        return $this->hasMany(Expense::class);
    }

    public function invitations()
    {
        return $this->hasMany(Invitation::class);
    }

    public function canAddMoreParticipants()
    {
        if ($this->user->isPremium()) {
            return true;
        }

        return $this->participants()->count() < 3;
    }

    public static function generateInvitationCode()
{
    do {
        $code = strtoupper(substr(md5(uniqid()), 0, 8));
    } while (self::where('invitation_code', $code)->exists());
    
    return $code;
}
public function isAccessibleBy($user)
{
    return $user && ($this->user_id === $user->id || 
           $this->participants->contains($user));
}
public function scopeActive($query)
    {
        return $query->where('is_archived', false);
    }

    public function scopeArchived($query)
    {
        return $query->where('is_archived', true);
    }
}
