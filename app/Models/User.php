<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use App\Enums\UserStatus;
use App\Enums\UserType;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Str;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasFactory, Notifiable, HasApiTokens, HasRoles, SoftDeletes;

    protected $table = 'users';


    protected $fillable = [
        'full_name',
        'phone',
        'password',
        'email',
        'role',
        'status',
    ];


    protected $hidden = ['password', 'remember_token'];

    protected $casts = [
        'subscription_expires_at' => 'datetime',
    ];


    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }


    public function branchManager()
    {
        return $this->hasOne(BranchManager::class);
    }
    public function branch()
    {
        return $this->hasOne(Branch::class);
    }
    public function subscriptions()
    {
        return $this->hasMany(Subscription::class);
    }
    // public function activeSubscription()
    // {
    //     return $this->hasOne(Subscription::class)->where('status', 'active')->latestOfMany();
    // }
    public function createdOrders()
    {
        return $this->hasMany(Order::class, 'created_by');
    }


    public function activeSubscription()
    {
        return $this->hasOne(Subscription::class)
            ->where('status', 'active')
            ->whereDate('start_date', '<=', now())
            ->whereDate('end_date', '>=', now());
    }

    public function expiredSubscriptions()
    {
        return $this->hasMany(Subscription::class)
            ->where('status', 'expired')
            ->orWhere(function ($query) {
                $query->where('status', 'active')
                    ->whereDate('end_date', '<', now());
            });
    }
}