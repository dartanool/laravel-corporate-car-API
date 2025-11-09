<?php

namespace App\DTOs;

class CarDTO
{
    /**
     * @param string $startTime Дата и время начала поездки.
     * @param string $endTime Дата и время окончания поездки.
     * @param int|null $modelId Идентификатор модели автомобиля.
     * @param int|null $categoryId Идентификатор категории комфорта.
     */
    public function __construct(
        public string $startTime,
        public string $endTime,
        public ?int   $modelId = null,
        public ?int   $categoryId = null,
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
        $filters = $data['filter'] ?? [];

        return new self(
            startTime: $filters['start_time'] ?? throw new \InvalidArgumentException('start_time required'),
            endTime: $filters['end_time'] ?? throw new \InvalidArgumentException('end_time required'),
            modelId: isset($filters['model_id']) ? (int)$filters['model_id'] : null,
            categoryId: isset($filters['category_id']) ? (int)$filters['category_id'] : null,
        );
    }
}
