<?php

namespace App\Filters;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CarFilters
{
    protected Request $request;
    protected Builder $query;

    /**
     * @param Request $request HTTP-запрос с параметрами filter[...]
     */
    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    /**
     * Применяет все фильтры к запросу.
     *
     * @param Builder $query
     * @return Builder
     */
    public function apply(Builder $query): Builder
    {
        $this->query = $query;

        $filters = $this->request->input('filter', []);

        foreach ($filters as $filter => $value) {
            $method = 'filter' . ucfirst(Str::camel($filter));

            if (method_exists($this, $method) && $value !== null && $value !== '') {
                $this->{$method}($value);
            }
        }

        return $this->query;
    }

    /**
     * Фильтр по ID модели автомобиля.
     *
     * @param int|string $modelId
     * @return void
     */
    protected function filterModelId($modelId): void
    {
        $this->query->where('car_model_id', $modelId);
    }

    /**
     * Фильтр по категории автомобиля.
     *
     * @param int|string $categoryId
     * @return void
     */
    protected function filterCategoryId($categoryId): void
    {
        $this->query->whereHas('carModel', function ($q) use ($categoryId) {
            $q->where('comfort_category_id', $categoryId);
        });
    }

    /**
     * Фильтр по дате начала поездки.
     *
     * @param string $startTime
     * @return void
     */
    protected function filterStartTime($startTime): void
    {
        $this->query->whereDoesntHave('bookings', function ($q) use ($startTime) {
            $q->where('starts_at', '<=', $startTime);
        });
    }

    /**
     * Фильтр по дате окончания поездки.
     *
     * @param string $endTime
     * @return void
     */
    protected function filterEndTime($endTime): void
    {
        $this->query->whereDoesntHave('bookings', function ($q) use ($endTime) {
            $q->where('ends_at', '>=', $endTime);
        });
    }
}
