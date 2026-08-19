<?php

namespace App\Enums;

enum UserRole: string
{
    case Superadmin = 'superadmin';
    case Admin = 'admin';
    case Reservations = 'reservas';
    case Guide = 'guia';
    case Support = 'soporte';

    public function label(): string
    {
        return match ($this) {
            self::Superadmin => 'Superadministrador',
            self::Admin => 'Administrador',
            self::Reservations => 'Reservas / Recepcion',
            self::Guide => 'Guia',
            self::Support => 'Soporte',
        };
    }
}