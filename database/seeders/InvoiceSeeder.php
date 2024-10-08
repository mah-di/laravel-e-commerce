<?php

namespace Database\Seeders;

use App\Models\InvoiceProduct;
use App\Models\Review;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class InvoiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $userIds = \App\Models\User::pluck('id');

        for ($i = 0; $i < 12; $i++) {
            $userId = $userIds->random();

            $invoice = \App\Models\Invoice::factory()
                ->has(InvoiceProduct::factory(random_int(1, 3), ['user_id' => $userId]))
                ->create([
                    'user_id' => $userId
                ]);

            $total = $invoice->invoiceProducts()->select(DB::raw('sale_price * qty as total'))->get()->sum('total');

            $invoice->update([
                'total' => $total,
                'vat' => $total * 0.05,
                'payable' => $total + $total * 0.05
            ]);
        }
    }
}
