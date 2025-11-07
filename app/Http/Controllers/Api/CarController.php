<?php

namespace App\Http\Controllers\Api;

use App\DTOs\CarDTO;
use App\Http\Controllers\Controller;
use App\Http\Requests\AvailableCarsRequest;
use App\Http\Resources\CarResource;
use App\Models\Car;
use App\Services\CarService;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

//use App\Http\Requests\StoreRequest;

class CarController extends Controller
{

    public function __construct(public CarService $carService)
    {}

    public function available(AvailableCarsRequest $request)
    {
        $dto = CarDto::fromArray($request->validated());
        $cars = $this->carService->getAvailableCars($dto);

        return CarResource::collection($cars)->additional([
            'count' => $cars->count(),
        ]);
    }
}
