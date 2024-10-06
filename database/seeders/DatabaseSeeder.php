<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        $user = \App\Models\User::factory()->create(['email' => 'jon@doe.com']);
        \App\Models\CustomerProfile::factory()->create(['user_id' => $user->id]);

        $user = \App\Models\User::factory()->create(['email' => 'jane@doe.com']);
        \App\Models\CustomerProfile::factory()->create(['user_id' => $user->id]);

        $user = \App\Models\User::factory()->create(['email' => 'jerry@doe.com']);
        \App\Models\CustomerProfile::factory()->create(['user_id' => $user->id]);

        $this->call([
            CategorySeeder::class,
            BrandSeeder::class,
        ]);
    }
}
