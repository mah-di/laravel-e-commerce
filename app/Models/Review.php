<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    use HasFactory;

    protected $fillable = [
        'review',
        'rating',
        'customer_profile_id',
        'product_id',
    ];

    public function customer()
    {
        return $this->belongsTo(CustomerProfile::class, 'customer_profile_id');
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
