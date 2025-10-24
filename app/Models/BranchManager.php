<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BranchManager extends Model
{
    protected $fillable = [
        'user_id',
    ];


    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function branches()
    {
        return $this->hasMany(Branch::class, 'manager_id');
    }
}
