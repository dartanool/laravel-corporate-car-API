<?php

namespace App\DTOs;

use App\Http\Requests\AvailableCarsRequest;
use App\Models\Car;

class CarDTO
{
    public function __construct(
        public string $email,
        public string $startTime,
        public string $endTime,
        public ?int   $modelId = null,
        public ?int   $categoryId = null,
        public ?int   $userId = null,
    )
    {
    }

    public static function fromArray(array $data): self
    {
        return new self(
            email: $data['email'],
            startTime: $data['start_time'],
            endTime: $data['end_time'],
            modelId: $data['model_id'] ?? null,
            categoryId: $data['category_id'] ?? null,
            userId: $data['user_id'] ?? null,
        );
    }
}
