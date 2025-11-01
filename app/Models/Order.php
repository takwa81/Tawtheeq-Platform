<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'branch_id',
        'company_id',
        'created_by',
        'order_number',
        'customer_name',
        'customer_phone',
        'order_image',
        'total_order',
        'date',
        'time',
        'notes',
        'status',
    ];

    public function getOrderImageUrlAttribute()
    {
        return $this->order_image
            ? route('files', ['folder' => 'orders', 'filename' => $this->order_image])
            : null;
    }

    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }


    public function scopeFilter($query, array $filters)
    {
        if (!empty($filters['order_number'])) {
            $query->where('order_number', 'like', "%{$filters['order_number']}%");
        }

        if (!empty($filters['customer_name'])) {
            $query->where('customer_name', 'like', "%{$filters['customer_name']}%");
        }

        if (!empty($filters['customer_phone'])) {
            $query->where('customer_phone', 'like', "%{$filters['customer_phone']}%");
        }

        if (!empty($filters['company_id'])) {
            $query->where('company_id', $filters['company_id']);
        }

        if (!empty($filters['branch_id'])) {
            $query->where('branch_id', $filters['branch_id']);
        }

        if (!empty($filters['date'])) {
            $query->whereDate('date', $filters['date']);
        }

        if (!empty($filters['sort'])) {
            if ($filters['sort'] === 'latest') {
                $query->latest();
            } elseif ($filters['sort'] === 'oldest') {
                $query->oldest();
            }
        } else {
            $query->latest(); // Default
        }

        return $query;
    }
}
