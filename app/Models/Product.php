<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'short_des',
        'price',
        'discount',
        'discount_price',
        'image',
        'stock',
        'star',
        'remark',
        'brand_id',
        'category_id',
    ];

    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function productSlider()
    {
        return $this->hasOne(ProductSlider::class);
    }

    public function productDetail()
    {
        return $this->hasOne(ProductDetail::class);
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    public function wishes()
    {
        return $this->hasMany(ProductWish::class);
    }

    public function carts()
    {
        return $this->hasMany(Cart::class);
    }

    public function invoiceProducts()
    {
        return $this->hasMany(InvoiceProduct::class);
    }
}
