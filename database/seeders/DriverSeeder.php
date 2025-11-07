<?php

namespace Database\Seeders;

use App\Models\Driver;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DriverSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Driver::insert([
            ['first_name' => 'Иван', 'last_name' => 'Иванов', 'employee_number' => 'DRV001'],
            ['first_name' => 'Пётр', 'last_name' => 'Петров', 'employee_number' => 'DRV002'],
            ['first_name' => 'Сергей', 'last_name' => 'Сергеев', 'employee_number' => 'DRV003'],
        ]);
    }
}
