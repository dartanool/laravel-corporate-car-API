<?php

namespace App\Services;

use App\Models\Car;
use Carbon\Carbon;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

class CarService
{
    /**
     * Возвращает список автомобилей, доступных пользователю по фильтрам.
     *
     * Поддерживаемые фильтры:
     *  - filter[start_time] — время начала бронирования
     *  - filter[end_time] — время окончания бронирования
     *  - filter[car_model_id] — ID модели автомобиля
     *  - filter[carModel.comfort_category_id] — ID категории комфорта
     *
     * @param array $filters Параметры фильтрации.
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getAvailableCars(array $filters)
    {
        $start = isset($filters['start_time']) ? Carbon::parse($filters['start_time']) : null;
        $end = isset($filters['end_time']) ? Carbon::parse($filters['end_time']) : null;

        return QueryBuilder::for(Car::class)
            ->with(['carModel.comfortCategory', 'driver'])
            ->allowedFilters([
                AllowedFilter::exact('car_model_id'),
                AllowedFilter::exact('carModel.comfort_category_id'),
                AllowedFilter::callback('start_time', function ($query, $value) use ($end) {
                    $start = Carbon::parse($value);
                    if ($end) {
                        $query->whereDoesntHave('bookings', function ($q) use ($start, $end) {
                            $q->where(function ($q2) use ($start, $end) {
                                $q2->whereBetween('starts_at', [$start, $end])
                                    ->orWhereBetween('ends_at', [$start, $end])
                                    ->orWhere(fn($q3) => $q3->where('starts_at', '<', $start)
                                        ->where('ends_at', '>', $end));
                            });
                        });
                    }
                }),
                AllowedFilter::callback('end_time', function ($query, $value) use ($start) {
                    $end = Carbon::parse($value);
                    if ($start) {
                        $query->whereDoesntHave('bookings', function ($q) use ($start, $end) {
                            $q->where(function ($q2) use ($start, $end) {
                                $q2->whereBetween('starts_at', [$start, $end])
                                    ->orWhereBetween('ends_at', [$start, $end])
                                    ->orWhere(fn($q3) => $q3->where('starts_at', '<', $start)
                                        ->where('ends_at', '>', $end));
                            });
                        });
                    }
                }),
            ])
            ->defaultSort('id')
            ->get();
    }
}
