<?php

namespace App\Modules\Couriers\Data;

final readonly class CourierIndexData
{
    /**
     * @param  array<int, int>  $levels
     */
    public function __construct(
        public ?string $search,
        public array $levels,
        public string $sort,
        public string $direction,
        public int $perPage,
    ) {
    }
}
