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
            'email' => 'required|email',
            'start_time' => 'required|date',
            'end_time' => 'required|date|after:start_time',
            'model_id' => 'nullable|integer|exists:car_models,id',
            'category_id' => 'nullable|integer|exists:comfort_categories,id',
            'user_id' => 'nullable|integer|exists:users,id',
        ];
    }

    /**
     * Сообщения об ошибках валидации.
     */
    public function messages(): array
    {
        return [
            'start_time.required' => 'Нужно указать дату начала поездки',
            'end_time.required' => 'Нужно указать дату окончания поездки',
            'end_time.after' => 'Дата окончания должна быть позже начала',
        ];
    }
}
