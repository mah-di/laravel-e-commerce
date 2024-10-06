<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\CustomerProfile>
 */
class CustomerProfileFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $data = [
            'name' => $this->faker->name(),
            'address' => $this->faker->address(),
            'city' => $this->faker->city(),
            'state' => $this->faker->city(),
            'postcode' => $this->faker->postcode(),
            'country' => $this->faker->country(),
            'phone' => $this->faker->phoneNumber(),
        ];

        return [
            'cus_name' => $data['name'],
            'cus_address' => $data['address'],
            'cus_city' => $data['city'],
            'cus_state' => $data['state'],
            'cus_postcode' => $data['postcode'],
            'cus_country' => $data['country'],
            'cus_phone' => $data['phone'],
            'ship_name' => $data['name'],
            'ship_address' => $data['address'],
            'ship_city' => $data['city'],
            'ship_state' => $data['state'],
            'ship_postcode' => $data['postcode'],
            'ship_country' => $data['country'],
            'ship_phone' => $data['phone']
        ];
    }
}
