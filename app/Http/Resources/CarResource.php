<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CarResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'reg_number' => $this->reg_number ,

            'model' => [
                'id' => $this->carModel->id,
                'name' => $this->carModel->name,
                'comfort_category' => [
                    'id' => $this->carModel->comfortCategory->id,
                    'name' => $this->carModel->comfortCategory->name,
                ],
            ],

            'driver' => [
                'id' => $this->driver->id,
                'first_name' => $this->driver->first_name,
                'last_name' => $this->driver->last_name,
                'employee_number' => $this->driver->employee_number ?? null,
            ],
        ];
    }
}
