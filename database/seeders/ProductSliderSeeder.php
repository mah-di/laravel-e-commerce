<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductSliderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Product::inRandomOrder()->limit(5)->get()->each(function ($product) {
            \App\Models\ProductSlider::create([
                'product_id' => $product->id,
                'title' => $product->title,
                'short_des' => $product->short_des,
                'pricing' => $product->price,
                'image' => $product->image,
            ]);
        });

    }
}
