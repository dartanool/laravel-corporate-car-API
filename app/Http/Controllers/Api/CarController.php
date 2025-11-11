<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\AvailableCarsRequest;
use App\Services\CarService;

class CarController extends Controller
{
    /**
     * Конструктор контроллера.
     *
     * @param CarService $carService Сервис для работы с автомобилями.
     */
    public function __construct(public CarService $carService)
    {
    }

    /**
     * Возвращает список доступных автомобилей для указанного пользователя.
     *
     * @param AvailableCarsRequest $request Валидационный запрос с параметрами фильтрации.
     * @return \Illuminate\Http\JsonResponse JSON-ответ со списком машин или сообщением об ошибке.
     */
    public function available(AvailableCarsRequest $request)
    {
        $cars = $this->carService->getAvailableCars($request->validated()['filter'] ?? []);

        if ($cars->isEmpty()) {
            return response()->json([
                'message' => 'Нет доступных автомобилей по заданным фильтрам.',
                'data' => []
            ], 404, [], JSON_UNESCAPED_UNICODE);
        }

        return response()->json($cars, 200, [], JSON_UNESCAPED_UNICODE);
    }
}
