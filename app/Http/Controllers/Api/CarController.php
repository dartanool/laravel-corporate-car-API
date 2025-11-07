<?php

namespace App\Http\Controllers\Api;

use App\DTOs\CarDTO;
use App\Http\Controllers\Controller;
use App\Http\Requests\AvailableCarsRequest;
use App\Models\Car;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

//use App\Http\Requests\StoreRequest;

class CarController extends Controller
{

    public function available(AvailableCarsRequest $request)
    {
        $dto = CarDto::fromArray($request->validated());

        $user = \App\Models\User::where('email', $dto->email)->first();
        if (!$user) {
            return response()->json(['message' => 'Пользователь с таким email не найден'], 404);
        }

        $start = Carbon::parse($dto->startTime);
        $end = Carbon::parse($dto->endTime);

        $allowedCategories = $user->position
            ->comfortCategories()
            ->pluck('comfort_categories.id')
            ->toArray();

        $query = Car::query()
            ->whereHas('carModel', function ($q) use ($allowedCategories) {
                $q->whereIn('comfort_category_id', $allowedCategories);
            });

        if (!empty($dto->modelId)) {
            $query->where('car_model_id', $dto->modelId);
        }

        if (!empty($dto->categoryId)) {
            $query->whereHas('model', function ($q) use ($dto) {
                $q->where('comfort_category_id', $dto->categoryId);
            });
        }

        $query->whereDoesntHave('bookings', function ($q) use ($start, $end) {
            $q->where(function ($q2) use ($start, $end) {
                $q2->whereBetween('starts_at', [$start, $end])
                    ->orWhereBetween('ends_at', [$start, $end])
                    ->orWhere(function ($q3) use ($start, $end) {
                        $q3->where('starts_at', '<', $start)
                            ->where('ends_at', '>', $end);
                    });
            });
        });

        $cars = $query
            ->with(['carModel.comfortCategory', 'driver'])
            ->get();

        return response()->json([
            'available_cars' => $cars,
            'count' => $cars->count(),
        ]);
    }
}
