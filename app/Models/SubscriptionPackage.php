<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SubscriptionPackage extends Model
{
    protected $fillable = [
        'name_en',
        'name_ar',
        'description_ar',
        'description_en',
        'branches_limit',
        'price',
        'duration_days',
        'features',
    ];

    protected $casts = [
        'features' => 'array',
    ];

    public function getNameAttribute()
    {
        return app()->getLocale() === 'ar' ? $this->name_ar : $this->name_en;
    }

    public function subscriptions()
    {
        return $this->hasMany(Subscription::class, 'package_id');
    }
}