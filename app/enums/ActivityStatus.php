<?php

namespace App\Enums;

enum ActivityStatus: string
{
    case Active   = 'active';
    case Inactive = 'inactive';

    public function label(): string
    {
        return match ($this) {
            self::Active   => 'Activa',
            self::Inactive => 'Inactiva',
        };
    }

    public function badgeVariant(): string
    {
        return match ($this) {
            self::Active   => 'success',
            self::Inactive => 'neutral',
        };
    }
}