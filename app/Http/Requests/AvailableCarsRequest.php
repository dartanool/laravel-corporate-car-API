<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AvailableCarsRequest extends FormRequest
{
    /**
     * Разрешает выполнение запроса.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Правила валидации запроса.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'filter.start_time' => ['required', 'date'],
            'filter.end_time' => ['required', 'date', 'after:filter.start_time'],
            'filter.model_id' => ['nullable', 'integer', 'exists:car_models,id'],
            'filter.category_id' => ['nullable', 'integer', 'exists:comfort_categories,id'],
        ];
    }

    /**
     * Сообщения об ошибках валидации.
     */
    public function messages(): array
    {
        return [
            'filter.start_time.required' => 'Нужно указать дату начала поездки',
            'filter.end_time.required' => 'Нужно указать дату окончания поездки',
            'filter.end_time.after' => 'Дата окончания должна быть позже начала',
        ];
    }
}
