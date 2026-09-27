<?php

namespace App\Http\Requests\Api\V1\Couriers;

use App\Modules\Couriers\Data\CourierIndexData;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class IndexCourierRequest extends FormRequest
{
    private const DEFAULT_SORT = 'name';

    /**
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'search' => ['sometimes', 'string', 'max:255'],
            'level' => ['sometimes', 'string', 'max:9', 'regex:/^[1-5](,[1-5])*$/'],
            'sort' => ['sometimes', 'string', Rule::in(['name', 'registered_at'])],
            'direction' => ['sometimes', 'string', Rule::in(['asc', 'desc'])],
            'per_page' => ['sometimes', 'integer', 'min:1', 'max:100'],
        ];
    }

    public function authorize(): bool
    {
        return true;
    }

    public function toData(): CourierIndexData
    {
        $validated = $this->validated();
        $levels = [];

        if (isset($validated['level'])) {
            $levels = array_map('intval', explode(',', (string) $validated['level']));
        }

        return new CourierIndexData(
            search: isset($validated['search']) ? trim((string) $validated['search']) : null,
            levels: $levels,
            sort: (string) ($validated['sort'] ?? self::DEFAULT_SORT),
            direction: (string) ($validated['direction'] ?? 'asc'),
            perPage: (int) ($validated['per_page'] ?? 15),
        );
    }
}
