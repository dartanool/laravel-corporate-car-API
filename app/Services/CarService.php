<?php

namespace App\Services;

use App\DTOs\CarDTO;
use App\Filters\CarFilters;
use App\Models\Car;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class CarService
{
    /**
     * Возвращает список автомобилей, доступных авторизованному пользователю.
     *
     * @param CarDTO $dto DTO с параметрами запроса.
     * @return \Illuminate\Database\Eloquent\Collection Коллекция автомобилей
     * или \Illuminate\Http\JsonResponse при ошибке.
     */
    public function __construct(private CarFilters $filters)
    {
    }

    /**
     * Возвращает список автомобилей, доступных пользователю.
     */
    public function getAvailableCars(CarDTO $dto)
    {
        $user = Auth::user();

        if (!$user || !$user->position) {
            throw new \Exception('У пользователя не указана должность.');
        }

        $start = Carbon::parse($dto->startTime);
        $end = Carbon::parse($dto->endTime);

        $allowedCategories = $user->position
            ->comfortCategories()
            ->pluck('comfort_categories.id')
            ->toArray();

        $query = Car::query()
            ->whereHas('carModel', fn($q) => $q->whereIn('comfort_category_id', $allowedCategories)
            );

        $this->filters->apply($query);

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
