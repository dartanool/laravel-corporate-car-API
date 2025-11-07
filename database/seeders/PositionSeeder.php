<?php

namespace Database\Seeders;

use App\Models\Position;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PositionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Position::insert([
            ['name' => 'Менеджер', 'description' => 'Средний уровень сотрудников'],
            ['name' => 'Директор', 'description' => 'Руководство компании'],
            ['name' => 'Стажёр', 'description' => 'Начальный уровень сотрудников'],
        ]);
    }
}
