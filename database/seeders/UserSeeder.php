<?php

namespace Database\Seeders;

use App\Models\Position;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $positions = Position::pluck('id', 'name');

        User::insert([
            [
                'name' => 'Иван Менеджер',
                'email' => 'manager@test.com',
                'password' => Hash::make('password'),
                'position_id' => $positions['Менеджер'],
            ],
            [
                'name' => 'Ольга Директор',
                'email' => 'director@test.com',
                'password' => Hash::make('password'),
                'position_id' => $positions['Директор'],
            ],
            [
                'name' => 'Анна Стажёр',
                'email' => 'intern@test.com',
                'password' => Hash::make('password'),
                'position_id' => $positions['Стажёр'],
            ],
        ]);
    }
}
