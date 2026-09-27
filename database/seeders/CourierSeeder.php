<?php

namespace Database\Seeders;

use App\Modules\Couriers\Models\Courier;
use Illuminate\Database\Seeder;

class CourierSeeder extends Seeder
{
    public function run(): void
    {
        $remaining = 1000 - Courier::query()->count();

        if ($remaining <= 0) {
            return;
        }

        Courier::factory()
            ->count($remaining)
            ->create();
    }
}
