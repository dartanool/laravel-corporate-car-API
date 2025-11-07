<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AvailableCarsRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
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

    public function messages(): array
    {
        return [
            'start_time.required' => 'Нужно указать дату начала поездки',
            'end_time.required' => 'Нужно указать дату окончания поездки',
            'end_time.after' => 'Дата окончания должна быть позже начала',
        ];
    }
}
