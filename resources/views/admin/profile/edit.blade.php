@extends('layouts.admin')

@section('title', 'Mi perfil')

@section('content')
    <div class="mx-auto max-w-lg space-y-6">

        <x-canoa.card title="Datos personales">
            <form method="POST" action="{{ route('admin.profile.update') }}" class="mt-4 space-y-4">
                @csrf
                @method('PATCH')

                <x-canoa.input name="name" label="Nombre completo" :value="auth()->user()->name" required />
                <x-canoa.input name="email" type="email" label="Correo electronico" :value="auth()->user()->email" required />
                <x-canoa.input name="phone" label="Telefono" :value="auth()->user()->phone" />

                <x-canoa.button type="submit">Guardar cambios</x-canoa.button>
            </form>
        </x-canoa.card>

        <x-canoa.card title="Cambiar contrasena">
            <form method="POST" action="{{ route('admin.password.update') }}" class="mt-4 space-y-4">
                @csrf
                @method('PUT')

                <x-canoa.input name="current_password" type="password" label="Contrasena actual" required />
                <x-canoa.input name="password" type="password" label="Nueva contrasena" hint="Minimo 10 caracteres con letras y numeros." required />
                <x-canoa.input name="password_confirmation" type="password" label="Confirmar nueva contrasena" required />

                <x-canoa.button type="submit">Actualizar contrasena</x-canoa.button>
            </form>
        </x-canoa.card>

    </div>
@endsection