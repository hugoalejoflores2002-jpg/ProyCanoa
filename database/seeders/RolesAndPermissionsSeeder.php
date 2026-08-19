<?php

namespace Database\Seeders;

use App\Enums\UserRole;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class RolesAndPermissionsSeeder extends Seeder
{
    public function run(): void
    {
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        $permissions = [
            // Usuarios
            'users.view', 'users.create', 'users.edit', 'users.delete',

            // Actividades y paquetes
            'activities.view', 'activities.create', 'activities.edit', 'activities.delete',
            'packages.view', 'packages.create', 'packages.edit', 'packages.delete',

            // Reservas
            'bookings.view', 'bookings.create', 'bookings.edit', 'bookings.delete',
            'bookings.assign_guide', 'bookings.assign_support',

            // Pagos
            'payments.view', 'payments.create', 'payments.refund',

            // Salidas
            'departures.view', 'departures.manage',

            // Guías
            'guides.view', 'guides.create', 'guides.edit', 'guides.delete',

            // Soportes
            'supports.view', 'supports.create', 'supports.edit', 'supports.delete',

            // Equipamiento
            'equipment.view', 'equipment.create', 'equipment.edit', 'equipment.delete',

            // Clientes
            'customers.view', 'customers.create', 'customers.edit',

            // Reportes
            'reports.view',

            // Auditoría
            'audit.view',

            // Configuración
            'settings.view', 'settings.edit',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        // Superadmin — accede a todo vía Gate::before, no necesita permisos explícitos
        Role::firstOrCreate(['name' => UserRole::Superadmin->value]);

        // Admin — todo excepto auditoría y gestión de usuarios del sistema
        $admin = Role::firstOrCreate(['name' => UserRole::Admin->value]);
        $admin->syncPermissions(array_filter($permissions, fn($p) =>
            ! in_array($p, ['audit.view', 'users.delete', 'settings.edit'])
        ));

        // Reservas/Recepción — gestión operativa de reservas, clientes y pagos
        $reservations = Role::firstOrCreate(['name' => UserRole::Reservations->value]);
        $reservations->syncPermissions([
            'bookings.view', 'bookings.create', 'bookings.edit',
            'bookings.assign_guide', 'bookings.assign_support',
            'payments.view', 'payments.create',
            'customers.view', 'customers.create', 'customers.edit',
            'departures.view',
            'guides.view', 'supports.view',
        ]);

        // Guía — solo sus propias salidas
        $guide = Role::firstOrCreate(['name' => UserRole::Guide->value]);
        $guide->syncPermissions([
            'departures.view',
            'bookings.view',
            'customers.view',
        ]);

        // Soporte — sus salidas asignadas
        $support = Role::firstOrCreate(['name' => UserRole::Support->value]);
        $support->syncPermissions([
            'departures.view',
            'bookings.view',
        ]);
    }
}