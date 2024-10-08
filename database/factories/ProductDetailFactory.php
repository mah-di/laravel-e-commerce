<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ProductDetail>
 */
class ProductDetailFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'img1' => $this->faker->imageUrl(640, 480),
            'img2' => $this->faker->imageUrl(640, 480),
            'img3' => $this->faker->imageUrl(640, 480),
            'img4' => $this->faker->imageUrl(640, 480),
            'des' => $this->faker->text(800),
            'color' => "{$this->faker->colorName()},{$this->faker->colorName()},{$this->faker->colorName()}",
            'size' => 'S,M,L,XL,XXL'
        ];
    }
}
