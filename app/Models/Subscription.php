<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Subscription extends Model
{
    protected $table = 'subscriptions';
    protected $fillable = [
        'user_id',
        'package_id',
        'start_date',
        'end_date',
        'status',
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
    ];
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function package()
    {
        return $this->belongsTo(SubscriptionPackage::class, 'package_id');
    }

    public function scopeActive($query)
    {
        return $query->where('status', 'active')
            ->whereDate('start_date', '<=', now())
            ->whereDate('end_date', '>=', now());
    }

    public function scopeExpired($query)
    {
        return $query->where('status', 'expired')
            ->orWhere(function ($q) {
                $q->where('status', 'active')
                    ->whereDate('end_date', '<', now());
            });
    }


    public function scopeFilter($query, array $filters)
    {
        if (!empty($filters['user_id'])) {
            $query->where('user_id', $filters['user_id']);
        }

        if (!empty($filters['status'])) {
            $query->where('status', $filters['status']);
        }

        if (!empty($filters['package_id'])) {
            $query->where('package_id', $filters['package_id']);
        }

        if (!empty($filters['sort'])) {
            if ($filters['sort'] === 'latest') {
                $query->latest();
            } elseif ($filters['sort'] === 'oldest') {
                $query->oldest();
            }
        } else {
            $query->latest();
        }

        return $query;
    }

    public function getRemainingDaysAttribute()
    {
        if ($this->end_date) {
            $today = Carbon::today();
            return $today->diffInDays(Carbon::parse($this->end_date), false);
        }
        return null;
    }
}