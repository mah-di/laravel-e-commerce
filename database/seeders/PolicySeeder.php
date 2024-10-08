<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PolicySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach (['About', 'Contact', 'How To Buy', 'Payment System', 'Privacy Policy', 'User Agreement', 'Terms & Conditions'] as $type) {
            \App\Models\Policy::factory()->create([
                'type' => $type
            ]);
        }
    }
}
