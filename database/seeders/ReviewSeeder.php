<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ReviewSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $invoiceProducts = \App\Models\InvoiceProduct::select(['user_id', 'product_id'])->distinct()->get();

        foreach ($invoiceProducts as $invoiceProduct) {
            \App\Models\Review::factory()->create([
                'customer_profile_id' => $invoiceProduct->user->profile->id,
                'product_id' => $invoiceProduct->product_id
            ]);
        }
    }
}
