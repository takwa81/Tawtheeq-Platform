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


    public function getLogoUrlAttribute()
    {
        return $this->logo
            ? route('files', ['folder' => 'companies', 'filename' => $this->logo])
            : null;
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }
}