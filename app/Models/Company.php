<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    protected $fillable = [
        'name_ar',
        'name_en',
        'logo',
    ];

    protected $appends = ['name'];

    public function getLogoUrlAttribute()
    {
        return $this->logo
            ? route('files', ['folder' => 'companies', 'filename' => $this->logo])
            : null;
    }

    public function getNameAttribute()
    {
        return app()->getLocale() === 'ar' ? $this->name_ar : $this->name_en;
    }


    public function orders()
    {
        return $this->hasMany(Order::class);
    }
}