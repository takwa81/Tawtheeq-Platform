<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Branch extends Model
{
    protected $fillable = [
        'user_id',
        'manager_id',
        'creator_user_id'
    ];


    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function manager()
    {
        return $this->belongsTo(BranchManager::class, 'manager_id');
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }
}
