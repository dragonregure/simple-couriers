<?php

namespace App\Http\Requests\Api\V1\Couriers;

use App\Modules\Couriers\Enums\CourierStatus;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Enum;

class StoreCourierRequest extends FormRequest
{
    /**
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:120'],
            'phone' => [
                'required',
                'string',
                'max:30',
                'regex:/^[0-9+\-\s()]+$/',
                Rule::unique('couriers', 'phone'),
            ],
            'email' => ['nullable', 'email:rfc', 'max:120', Rule::unique('couriers', 'email')],
            'level' => ['required', 'integer', 'min:1', 'max:5'],
            'status' => ['required', new Enum(CourierStatus::class)],
            'vehicle_type' => ['nullable', 'string', Rule::in(['motorcycle', 'car', 'van', 'bicycle'])],
            'vehicle_plate_number' => [
                'nullable',
                'string',
                'max:20',
                Rule::unique('couriers', 'vehicle_plate_number'),
            ],
            'service_area' => ['nullable', 'string', 'max:120'],
            'registered_at' => ['nullable', 'date'],
            'notes' => ['nullable', 'string', 'max:1000'],
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
