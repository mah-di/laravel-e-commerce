<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Invoice>
 */
class InvoiceFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'total' => 0,
            'vat' => 0,
            'payable' => 0,
            'cus_detail' => 'Demo Customer',
            'ship_detail' => 'Demo Ship',
            'transaction_id' => $this->faker->uuid(),
            'validation_id' => $this->faker->uuid(),
            'delivery_status' => 'DELIVERED',
            'payment_status' => 'success',
        ];
    }
}
