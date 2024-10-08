<?php

namespace Database\Factories;

use App\Models\Brand;
use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $remarks = ['New', 'Hot', 'Trending', 'Flash Sale', 'Popular'];

        return [
            'title' => $this->faker->sentence(random_int(5, 20)),
            'short_des' => $this->faker->sentence(random_int(10, 20)),
            'price' => $this->faker->numberBetween(20, 500) * 500,
            'discount' => 0,
            'discount_price' => 0,
            'image' => $this->faker->imageUrl(640, 480),
            'stock' => $this->faker->numberBetween(1, 50),
            'star' => 0,
            'remark' => $remarks[array_rand($remarks)],
            'category_id' => Category::pluck('id')->random(),
            'brand_id' => Brand::pluck('id')->random()
        ];
    }
}
