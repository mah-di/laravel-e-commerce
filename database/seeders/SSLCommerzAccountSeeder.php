<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SSLCommerzAccountSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \App\Models\SSLCommerzAccount::create([
            'store_id' => env('SSL_STORE_ID'),
            'store_password' => env('SSL_STORE_PASSWORD'),
            'currency' => env('SSL_CURRENCY'),
            'success_url' => env('SSL_SUCCESS_URL'),
            'fail_url' => env('SSL_FAIL_URL'),
            'cancel_url' => env('SSL_CANCEL_URL'),
            'ipn_url' => env('SSL_IPN_URL'),
            'init_url' => env('SSL_INIT_URL'),
        ]);
    }
}
