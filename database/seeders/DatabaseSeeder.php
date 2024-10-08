<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\ProductSlider;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        $this->call([
            SSLCommerzAccountSeeder::class,
            PolicySeeder::class,
            CategorySeeder::class,
            BrandSeeder::class,
            ProductSeeder::class,
            ProductSliderSeeder::class
        ]);

        $users = [];

        $users[] = \App\Models\User::factory()->create(['email' => 'jon@doe.com']);
        $users[] = \App\Models\User::factory()->create(['email' => 'jane@doe.com']);
        $users[] = \App\Models\User::factory()->create(['email' => 'jerry@doe.com']);

        foreach ($users as $user) {
            \App\Models\CustomerProfile::factory()->create(['user_id' => $user->id]);

            for ($i = 0; $i < random_int(2, 5); $i++)
                \App\Models\ProductWish::factory()->create(['user_id' => $user->id]);
        }

        $this->call([
            InvoiceSeeder::class,
            ReviewSeeder::class
        ]);
    }
}
