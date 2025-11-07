<?php

namespace Database\Seeders;

use App\Models\ComfortCategory;
use App\Models\Position;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            PositionSeeder::class,
            ComfortCategorySeeder::class,
            CarModelSeeder::class,
            DriverSeeder::class,
            CarSeeder::class,
            UserSeeder::class,
            BookingSeeder::class,
        ]);

        // Настраиваем доступные категории по должностям
        $manager = Position::where('name', 'Менеджер')->first();
        $director = Position::where('name', 'Директор')->first();
        $intern = Position::where('name', 'Стажёр')->first();

        $category1 = ComfortCategory::where('level', 1)->first();
        $category2 = ComfortCategory::where('level', 2)->first();
        $category3 = ComfortCategory::where('level', 3)->first();

        // Менеджер может брать 2-ю и 3-ю
        $manager->comfortCategories()->sync([$category2->id, $category3->id]);

        // Директор — 1-ю
        $director->comfortCategories()->sync([$category1->id]);

        // Стажёр — только 3-ю
        $intern->comfortCategories()->sync([$category3->id]);

    }
}
