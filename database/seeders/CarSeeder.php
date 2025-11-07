<?php

namespace Database\Seeders;

use App\Models\Car;
use App\Models\CarModel;
use App\Models\Driver;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CarSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $drivers = Driver::all();
        $models = CarModel::all();

        Car::insert([
            ['car_model_id' => $models[0]->id, 'reg_number' => 'A111AA', 'driver_id' => $drivers[0]->id],
            ['car_model_id' => $models[1]->id, 'reg_number' => 'B222BB', 'driver_id' => $drivers[1]->id],
            ['car_model_id' => $models[2]->id, 'reg_number' => 'C333CC', 'driver_id' => $drivers[2]->id],
        ]);
    }
}
