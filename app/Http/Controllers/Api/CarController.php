<?php

namespace App\Http\Controllers\Api;

use App\DTOs\CarDTO;
use App\Http\Controllers\Controller;
use App\Http\Requests\AvailableCarsRequest;
use App\Http\Resources\CarResource;
use App\Services\CarService;
use Illuminate\Database\Eloquent\ModelNotFoundException;

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
    public function available(AvailableCarsRequest $request): \Illuminate\Http\JsonResponse
    {
        $dto = CarDTO::fromArray($request->validated());

        try {
            $cars = $this->carService->getAvailableCars($dto);
        } catch (ModelNotFoundException $e) {
            return response()->json(['message' => $e->getMessage()], 404);
        }

        return response()->json([
            'data' => CarResource::collection($cars),
            'count' => $cars->count(),
        ]);
    }
}
