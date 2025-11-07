<?php

namespace Database\Seeders;

use App\Models\Booking;
use App\Models\Car;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BookingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::first();
        $car = Car::first();

        Booking::create([
            'car_id' => $car->id,
            'user_id' => $user->id,
            'starts_at' => Carbon::now()->addHours(1),
            'ends_at' => Carbon::now()->addHours(4),
            'status' => 'confirmed',
        ]);
    }
}
