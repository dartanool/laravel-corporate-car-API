<?php

namespace App\Services;

use App\DTOs\CarDTO;
use App\Filters\CarFilters;
use App\Models\Car;
use Carbon\Carbon;

class CarService
{
    /**
     * Возвращает список автомобилей, доступных авторизованному пользователю.
     *
     * @param CarDTO $dto DTO с параметрами запроса.
     * @return \Illuminate\Database\Eloquent\Collection Коллекция автомобилей
     * или \Illuminate\Http\JsonResponse при ошибке.
     */
    public function getAvailableCars(CarDTO $dto): \Illuminate\Database\Eloquent\Collection|\Illuminate\Http\JsonResponse
    {
        $user = auth()->user();
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
                if (!empty($allowedCategories)) {
                    $q->whereIn('comfort_category_id', $allowedCategories);
                }
            })
            ->with(['carModel.comfortCategory', 'driver']);

        $filters = new CarFilters(request());
        $query = $filters->apply($query);

        return $query->get();
    }
}
