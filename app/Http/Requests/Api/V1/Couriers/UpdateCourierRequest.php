<?php

namespace App\Http\Requests\Api\V1\Couriers;

use App\Modules\Couriers\Enums\CourierStatus;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Enum;

class UpdateCourierRequest extends FormRequest
{
    /**
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        $courierId = (int) $this->route('courier');

        return [
            'name' => ['sometimes', 'required', 'string', 'max:120'],
            'phone' => [
                'sometimes',
                'required',
                'string',
                'max:30',
                'regex:/^[0-9+\-\s()]+$/',
                Rule::unique('couriers', 'phone')->ignore($courierId),
            ],
            'email' => [
                'sometimes',
                'nullable',
                'email:rfc',
                'max:120',
                Rule::unique('couriers', 'email')->ignore($courierId),
            ],
            'level' => ['sometimes', 'required', 'integer', 'min:1', 'max:5'],
            'status' => ['sometimes', 'required', new Enum(CourierStatus::class)],
            'vehicle_type' => ['sometimes', 'nullable', 'string', Rule::in(['motorcycle', 'car', 'van', 'bicycle'])],
            'vehicle_plate_number' => [
                'sometimes',
                'nullable',
                'string',
                'max:20',
                Rule::unique('couriers', 'vehicle_plate_number')->ignore($courierId),
            ],
            'service_area' => ['sometimes', 'nullable', 'string', 'max:120'],
            'registered_at' => ['sometimes', 'nullable', 'date'],
            'notes' => ['sometimes', 'nullable', 'string', 'max:1000'],
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
