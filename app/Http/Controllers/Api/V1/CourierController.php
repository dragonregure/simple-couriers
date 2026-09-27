<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\Couriers\IndexCourierRequest;
use App\Http\Requests\Api\V1\Couriers\StoreCourierRequest;
use App\Http\Requests\Api\V1\Couriers\UpdateCourierRequest;
use App\Http\Resources\Api\V1\CourierResource;
use App\Modules\Couriers\Services\CourierService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class CourierController extends Controller
{
    public function __construct(
        private readonly CourierService $couriers,
    ) {
    }

    public function index(IndexCourierRequest $request): AnonymousResourceCollection
    {
        return CourierResource::collection($this->couriers->paginate($request->toData()));
    }

    public function store(StoreCourierRequest $request): JsonResponse
    {
        return (new CourierResource($this->couriers->create($request->validated())))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(int $courier): CourierResource
    {
        return new CourierResource($this->findCourier($courier));
    }

    public function update(UpdateCourierRequest $request, int $courier): CourierResource
    {
        return new CourierResource(
            $this->couriers->update($this->findCourier($courier), $request->validated()),
        );
    }

    public function destroy(int $courier): JsonResponse
    {
        $this->couriers->delete($this->findCourier($courier));

        return response()->json(status: Response::HTTP_NO_CONTENT);
    }

    private function findCourier(int $id): \App\Modules\Couriers\Models\Courier
    {
        $courier = $this->couriers->find($id);

        if ($courier === null) {
            throw new NotFoundHttpException('Courier not found.');
        }

        return $courier;
    }
}
