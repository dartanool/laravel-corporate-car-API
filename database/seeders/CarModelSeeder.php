<?php

namespace Database\Seeders;

use App\Models\CarModel;
use App\Models\ComfortCategory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CarModelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $category1 = ComfortCategory::where('level', 1)->first();
        $category2 = ComfortCategory::where('level', 2)->first();
        $category3 = ComfortCategory::where('level', 3)->first();

        CarModel::insert([
            ['name' => 'Toyota Camry', 'manufacturer' => 'Toyota', 'comfort_category_id' => $category1->id],
            ['name' => 'Skoda Octavia', 'manufacturer' => 'Skoda', 'comfort_category_id' => $category2->id],
            ['name' => 'Kia Rio', 'manufacturer' => 'Kia', 'comfort_category_id' => $category3->id],
        ]);
    }
}
