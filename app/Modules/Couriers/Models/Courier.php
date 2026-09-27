<?php

namespace App\Modules\Couriers\Models;

use App\Modules\Couriers\Enums\CourierStatus;
use Database\Factories\CourierFactory;
use Illuminate\Database\Eloquent\Attributes\UseFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * @property int $id
 * @property string $name
 * @property string $phone
 * @property string|null $email
 * @property int $level
 * @property CourierStatus|null $status
 * @property string|null $vehicle_type
 * @property string|null $vehicle_plate_number
 * @property string|null $service_area
 * @property Carbon|null $registered_at
 * @property string|null $notes
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 */
#[UseFactory(CourierFactory::class)]
class Courier extends Model
{
    /** @use HasFactory<CourierFactory> */
    use HasFactory;

    /**
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'phone',
        'email',
        'level',
        'status',
        'vehicle_type',
        'vehicle_plate_number',
        'service_area',
        'registered_at',
        'notes',
    ];

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'level' => 'integer',
            'registered_at' => 'datetime',
            'status' => CourierStatus::class,
        ];
    }
}
