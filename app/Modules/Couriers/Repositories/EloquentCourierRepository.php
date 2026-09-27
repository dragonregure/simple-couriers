<?php

namespace App\Modules\Couriers\Repositories;

use App\Modules\Couriers\Contracts\CourierRepositoryInterface;
use App\Modules\Couriers\Data\CourierIndexData;
use App\Modules\Couriers\Models\Courier;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;

class EloquentCourierRepository implements CourierRepositoryInterface
{
    public function paginate(CourierIndexData $data): LengthAwarePaginator
    {
        return Courier::query()
            ->when($data->search !== null, function (Builder $query) use ($data): void {
                foreach ($this->searchTerms($data->search) as $term) {
                    $query->where('name', 'like', '%' . $this->escapeLike($term) . '%');
                }
            })
            ->when($data->levels !== [], function (Builder $query) use ($data): void {
                $query->whereIn('level', $data->levels);
            })
            ->orderBy($data->sort, $data->direction)
            ->orderBy('id')
            ->paginate($data->perPage)
            ->withQueryString();
    }

    public function find(int $id): ?Courier
    {
        return Courier::query()->find($id);
    }

    public function create(array $attributes): Courier
    {
        return Courier::query()->create($attributes);
    }

    public function update(Courier $courier, array $attributes): Courier
    {
        $courier->fill($attributes);
        $courier->save();

        return $courier->refresh();
    }

    public function delete(Courier $courier): void
    {
        $courier->delete();
    }

    /**
     * @return list<string>
     */
    private function searchTerms(string $search): array
    {
        $terms = preg_split('/\s+/', trim($search)) ?: [];

        return array_values(array_filter($terms, static fn (string $term): bool => $term !== ''));
    }

    private function escapeLike(string $value): string
    {
        return addcslashes($value, '\\%_');
    }
}
