<?php

namespace App\Services;

use App\DTOs\CarDTO;
use App\Filters\CarFilters;
use App\Models\Car;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class CarService
{
    /**
     * Возвращает список автомобилей, доступных авторизованному пользователю.
     *
     * @param CarDTO $dto DTO с параметрами фильтрации.
     * @param User $user Текущий авторизованный пользователь.
     * @return Collection<\App\Models\Car>
     *
     * @throws ModelNotFoundException Если у пользователя не указана должность.
     */
    public function getAvailableCars(CarDTO $dto): \Illuminate\Database\Eloquent\Collection|\Illuminate\Http\JsonResponse
    {
        $user = auth()->user();
        if (!$user->position) {
            throw new ModelNotFoundException('У пользователя не указана должность (position).');
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

        if ($dto->modelId) {
            $query->where('car_model_id', $dto->modelId);
        }

        if ($dto->categoryId) {
            $query->whereHas('carModel', function ($q) use ($dto) {
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

        return $query->with(['carModel.comfortCategory', 'driver'])->get();
    }
}
