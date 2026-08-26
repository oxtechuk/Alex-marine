<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Branch extends Model
{
    protected $fillable = [
        'name_ar',
        'name_en',
        'code',
        'city',
        'phone',
        'email',
        'address',
        'manager_name',
        'is_active',
    ];

    public function products()
    {
        return $this->hasMany(Product::class);
    }

    public function quoteRequests()
    {
        return $this->hasMany(QuoteRequest::class);
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }
}
