<?php

namespace App\Services;

use App\DTOs\CarDTO;
use App\Models\Car;
use Carbon\Carbon;

class CarService
{
    /**
     * Возвращает список автомобилей, доступных для конкретного пользователя
     * в заданный временной диапазон.
     *
     * @param CarDTO $dto DTO с параметрами запроса.
     * @return \Illuminate\Database\Eloquent\Collection Коллекция автомобилей или JSON-ответ с ошибкой.
     */
    public function getAvailableCars(CarDTO $dto): \Illuminate\Database\Eloquent\Collection|\Illuminate\Http\JsonResponse
    {
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

        return $cars;
    }
}
