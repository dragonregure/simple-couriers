<?php

namespace App\Modules\Couriers\Services;

use App\Modules\Couriers\Contracts\CourierRepositoryInterface;
use App\Modules\Couriers\Data\CourierIndexData;
use App\Modules\Couriers\Models\Courier;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;

class CourierService
{
    public function __construct(
        private readonly CourierRepositoryInterface $couriers,
    ) {
    }

    /**
     * @return LengthAwarePaginator<int, Courier>
     */
    public function paginate(CourierIndexData $data): LengthAwarePaginator
    {
        return $this->couriers->paginate($data);
    }

    public function find(int $id): ?Courier
    {
        return $this->couriers->find($id);
    }

    /**
     * @param  array<string, mixed>  $attributes
     */
    public function create(array $attributes): Courier
    {
        return DB::transaction(fn (): Courier => $this->couriers->create($attributes));
    }

    /**
     * @param  array<string, mixed>  $attributes
     */
    public function update(Courier $courier, array $attributes): Courier
    {
        return DB::transaction(fn (): Courier => $this->couriers->update($courier, $attributes));
    }

    public function delete(Courier $courier): void
    {
        DB::transaction(function () use ($courier): void {
            $this->couriers->delete($courier);
        });
    }
}
