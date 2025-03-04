<?php

namespace App\Enums;

enum ApplicationEnum: string
{
    case USER_SERVICE = 'user_service';
    case ECOMMERCE_SERVICE = 'ecommerce_service';
    case PROJECT_MANAGEMENT_SERVICE = 'project_management_service';

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }
}