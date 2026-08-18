@extends('layouts.admin')

@section('title', 'Guía de estilos')

@section('content')
<div class="max-w-4xl">
    <h2 class="text-2xl font-display font-semibold text-deep">Guía de estilos</h2>
    <p class="mt-1 text-muted">Catálogo visual del sistema de diseño</p>

    {{-- Paleta de colores --}}
    <div class="mt-8">
        <h3 class="text-lg font-display font-semibold text-deep">Paleta de colores</h3>
        <div class="mt-4 grid grid-cols-2 gap-4 sm:grid-cols-3 md:grid-cols-4">
            @php
                $colors = [
                    ['name' => 'brand', 'hex' => '#72D5F8', 'class' => 'bg-brand'],
                    ['name' => 'brand-soft', 'hex' => '#E8F7FE', 'class' => 'bg-brand-soft'],
                    ['name' => 'deep', 'hex' => '#0B3954', 'class' => 'bg-deep'],
                    ['name' => 'deep-hover', 'hex' => '#092E43', 'class' => 'bg-deep-hover'],
                    ['name' => 'teal', 'hex' => '#087E8B', 'class' => 'bg-teal'],
                    ['name' => 'ink', 'hex' => '#17212B', 'class' => 'bg-ink'],
                    ['name' => 'muted', 'hex' => '#5A6B75', 'class' => 'bg-muted'],
                    ['name' => 'edge', 'hex' => '#6B7C86', 'class' => 'bg-edge'],
                    ['name' => 'surface', 'hex' => '#FFFFFF', 'class' => 'bg-surface border border-edge/20'],
                    ['name' => 'base', 'hex' => '#F4F9FB', 'class' => 'bg-base border border-edge/20'],
                    ['name' => 'success', 'hex' => '#0B7A50', 'class' => 'bg-success'],
                    ['name' => 'warning', 'hex' => '#9A5B00', 'class' => 'bg-warning'],
                    ['name' => 'danger', 'hex' => '#B3261E', 'class' => 'bg-danger'],
                    ['name' => 'info', 'hex' => '#087E8B', 'class' => 'bg-info'],
                ];
            @endphp

            @foreach ($colors as $color)
                <div class="rounded-lg border border-edge/10 overflow-hidden shadow-sm">
                    <div class="h-12 {{ $color['class'] }}"></div>
                    <div class="p-2 text-xs">
                        <p class="font-mono font-medium">{{ $color['name'] }}</p>
                        <p class="text-muted">{{ $color['hex'] }}</p>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    {{-- Botones --}}
    <div class="mt-10">
        <h3 class="text-lg font-display font-semibold text-deep">Botones</h3>
        <div class="mt-4 flex flex-wrap gap-3">
            <x-canoa.button variant="primary">Primario</x-canoa.button>
            <x-canoa.button variant="secondary">Secundario</x-canoa.button>
            <x-canoa.button variant="ghost">Ghost</x-canoa.button>
            <x-canoa.button variant="danger">Peligro</x-canoa.button>
            <x-canoa.button href="#" variant="primary">Como enlace</x-canoa.button>
        </div>
        <div class="mt-3 flex flex-wrap gap-3">
            <x-canoa.button variant="primary" disabled>Deshabilitado</x-canoa.button>
            <x-canoa.button variant="secondary" disabled>Deshabilitado</x-canoa.button>
        </div>
    </div>

    {{-- Tarjetas --}}
    <div class="mt-10">
        <h3 class="text-lg font-display font-semibold text-deep">Tarjetas</h3>
        <div class="mt-4 grid gap-4 sm:grid-cols-2">
            <x-canoa.card title="Título de la tarjeta">
                <p class="text-sm text-muted">Contenido de la tarjeta. Puede tener texto, listas o cualquier otro elemento.</p>
            </x-canoa.card>
            <x-canoa.card>
                <p class="text-sm text-muted">Tarjeta sin título, solo contenido.</p>
            </x-canoa.card>
        </div>
    </div>

    {{-- Badges --}}
    <div class="mt-10">
        <h3 class="text-lg font-display font-semibold text-deep">Badges</h3>
        <div class="mt-4 flex flex-wrap gap-2">
            <x-canoa.badge variant="neutral">Neutral</x-canoa.badge>
            <x-canoa.badge variant="success">Éxito</x-canoa.badge>
            <x-canoa.badge variant="warning">Advertencia</x-canoa.badge>
            <x-canoa.badge variant="danger">Peligro</x-canoa.badge>
            <x-canoa.badge variant="info">Info</x-canoa.badge>
            <x-canoa.badge variant="brand">Marca</x-canoa.badge>
        </div>
    </div>

    {{-- Alertas --}}
    <div class="mt-10">
        <h3 class="text-lg font-display font-semibold text-deep">Alertas</h3>
        <div class="mt-4 space-y-3">
            <x-canoa.alert variant="success">Operación realizada con éxito.</x-canoa.alert>
            <x-canoa.alert variant="warning">Ten cuidado con esta acción.</x-canoa.alert>
            <x-canoa.alert variant="danger">Ocurrió un error inesperado.</x-canoa.alert>
            <x-canoa.alert variant="info">Información importante para ti.</x-canoa.alert>
        </div>
    </div>

    {{-- Inputs --}}
    <div class="mt-10">
        <h3 class="text-lg font-display font-semibold text-deep">Inputs</h3>
        <div class="mt-4 space-y-4 max-w-sm">
            <x-canoa.input name="nombre" label="Nombre completo" placeholder="Ej: Juan Pérez" />
            <x-canoa.input name="email" label="Correo electrónico" type="email" placeholder="ejemplo@correo.com" hint="Te enviaremos un correo de confirmación." />
            <x-canoa.input name="telefono" label="Teléfono" type="tel" placeholder="999 888 777" />
            {{-- Input con error simulado --}}
            <x-canoa.input name="campo_error" label="Campo con error" value="Valor incorrecto" />
            @error('campo_error')
                <p class="text-sm text-danger">{{ $message }}</p>
            @enderror
        </div>
    </div>
</div>
@endsection