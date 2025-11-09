<?php

namespace App\DTOs;

class CarDTO
{
    /**
     * @param string $startTime Дата и время начала поездки.
     * @param string $endTime Дата и время окончания поездки.
     * @param int|null $modelId Идентификатор модели автомобиля.
     * @param int|null $categoryId Идентификатор категории комфорта.
     * @param int|null $userId Идентификатор пользователя.
     */
    public function __construct(
        public string $startTime,
        public string $endTime,
        public ?int   $modelId = null,
        public ?int   $categoryId = null,
        public ?int   $userId = null,
    )
    {
    }

    /**
     * Создаёт DTO из массива данных.
     *
     * @param array $data Входные данные (из валидации).
     * @return self
     */
    public static function fromArray(array $data): self
    {
        return new self(
            startTime: $data['start_time'],
            endTime: $data['end_time'],
            modelId: $data['model_id'] ?? null,
            categoryId: $data['category_id'] ?? null,
            userId: $data['user_id'] ?? null,
        );
    }
}
