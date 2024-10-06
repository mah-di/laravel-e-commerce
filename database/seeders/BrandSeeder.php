<?php

namespace Database\Seeders;

use App\Models\Brand;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BrandSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Brand::create(['name' => 'APPLE', 'img' => 'https://images.unsplash.com/photo-1516648612766-d5f00245f63e?q=80&w=1926&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D']);
        Brand::create(['name' => 'SAMSUNG', 'img' => 'https://images.unsplash.com/photo-1615512064903-0eb7d620bf45?q=80&w=2070&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D']);
        Brand::create(['name' => 'ASUS', 'img' => 'https://images.unsplash.com/photo-1582203422342-1541a90a0103?q=80&w=2070&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D']);
        Brand::create(['name' => 'DELL', 'img' => 'https://cdn.pixabay.com/photo/2017/08/10/07/32/dell-2619501_1280.jpg']);
        Brand::create(['name' => 'HP', 'img' => 'https://images.unsplash.com/photo-1683128069421-2c1881f70ed7?q=80&w=1974&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D']);
        Brand::create(['name' => 'XIAOMI', 'img' => 'https://images.unsplash.com/photo-1696041761060-5c7c81656978?q=80&w=1931&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D']);
        Brand::create(['name' => 'HUAWEI', 'img' => 'https://cdn.pixabay.com/photo/2017/07/31/13/13/huawei-2557932_1280.jpg']);
        Brand::create(['name' => 'LENOVO', 'img' => 'https://cdn.pixabay.com/photo/2016/09/08/21/52/phone-1655677_1280.jpg']);
    }
}
