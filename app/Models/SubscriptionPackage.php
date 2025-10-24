<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SubscriptionPackage extends Model
{
    protected $fillable = [
        'name_en',
        'name_ar',
        'description',
        'branches_limit',
        'price',
        'duration_days',
        'features',
    ];

    protected $casts = [
        'features' => 'array',
    ];

       public function subscriptions()
    {
        return $this->hasMany(Subscription::class, 'package_id');
    }
}
