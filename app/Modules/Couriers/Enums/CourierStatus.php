<?php

namespace App\Modules\Couriers\Enums;

enum CourierStatus: string
{
    case Active = 'active';
    case Inactive = 'inactive';
    case Suspended = 'suspended';
}
