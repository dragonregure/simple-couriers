<?php

namespace Database\Factories;

use App\Modules\Couriers\Enums\CourierStatus;
use App\Modules\Couriers\Models\Courier;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Courier>
 */
class CourierFactory extends Factory
{
    protected $model = Courier::class;

    /**
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'phone' => fake()->unique()->phoneNumber(),
            'email' => fake()->unique()->safeEmail(),
            'level' => fake()->numberBetween(1, 5),
            'status' => fake()->randomElement(CourierStatus::cases())->value,
            'vehicle_type' => fake()->randomElement(['motorcycle', 'car', 'van', 'bicycle']),
            'vehicle_plate_number' => strtoupper(fake()->unique()->bothify('?? #### ??')),
            'service_area' => fake()->city(),
            'registered_at' => fake()->dateTimeBetween('-2 years'),
            'notes' => fake()->optional()->sentence(),
        ];
    }
}
