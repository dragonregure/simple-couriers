<?php

namespace App\Modules\Couriers\Contracts;

use App\Modules\Couriers\Data\CourierIndexData;
use App\Modules\Couriers\Models\Courier;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

interface CourierRepositoryInterface
{
    /**
     * @return LengthAwarePaginator<int, Courier>
     */
    public function paginate(CourierIndexData $data): LengthAwarePaginator;

    public function find(int $id): ?Courier;

    /**
     * @param  array<string, mixed>  $attributes
     */
    public function create(array $attributes): Courier;

    /**
     * @param  array<string, mixed>  $attributes
     */
    public function update(Courier $courier, array $attributes): Courier;

    public function delete(Courier $courier): void;
}
