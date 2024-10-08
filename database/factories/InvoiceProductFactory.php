<?php

namespace Database\Factories;

use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\InvoiceProduct>
 */
class InvoiceProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $product = Product::select(['id', 'price'])->inRandomOrder()->first();

        return [
            'product_id' => $product->id,
            'qty' => $this->faker->numberBetween(1, 3),
            'sale_price' => $product->price,
        ];
    }
}
