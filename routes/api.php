<?php

use App\Http\Controllers\Api\V1\CourierController;
use Illuminate\Support\Facades\Route;

Route::get('docs', function () {
    return response()->file(public_path('docs/openapi.yaml'), [
        'Content-Type' => 'application/yaml',
    ]);
});

Route::get('documentation', function () {
    return response()->file(public_path('docs/index.html'));
});

Route::prefix('v1')->group(function (): void {
    Route::apiResource('couriers', CourierController::class);
});
