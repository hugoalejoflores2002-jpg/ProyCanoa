@extends('layouts.admin')

@section('title', 'Cambiar contraseña')

@section('content')
    <div class="mx-auto max-w-lg">
        <x-canoa.card title="Cambiar contraseña">
            @if (auth()->user()->must_change_password)
                <x-canoa.alert variant="warning" class="mb-5">
                    Debes cambiar tu contraseña antes de continuar. Es obligatorio en el primer acceso.
                </x-canoa.alert>
            @endif

            <form method="POST" action="{{ route('admin.password.update') }}" class="mt-4 space-y-4">
                @csrf
                @method('PUT')

                @if (! auth()->user()->must_change_password)
                    <x-canoa.input
                        name="current_password"
                        type="password"
                        label="Contraseña actual"
                        required
                    />
                @endif

                <x-canoa.input
                    name="password"
                    type="password"
                    label="Nueva contraseña"
                    hint="Mínimo 10 caracteres, con letras y números."
                    required
                />

                <x-canoa.input
                    name="password_confirmation"
                    type="password"
                    label="Confirmar nueva contraseña"
                    required
                />

                <x-canoa.button type="submit" class="w-full">
                    Actualizar contraseña
                </x-canoa.button>
            </form>
        </x-canoa.card>
    </div>
@endsection