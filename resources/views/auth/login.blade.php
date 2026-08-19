@extends('layouts.guest')

@section('title', 'Iniciar sesión')

@section('content')
    <h1 class="font-display text-xl font-semibold text-white">Iniciar sesión</h1>
    <p class="mt-1 text-sm text-white/50">Ingresa tus credenciales para acceder al panel.</p>

    <form method="POST" action="{{ route('admin.login') }}" class="mt-6 space-y-4">
        @csrf

        {{-- Campo correo --}}
        <div>
            <label for="email" class="mb-1.5 block text-sm font-medium text-white/70">
                Correo electrónico
            </label>
            <div class="relative">
                <span class="pointer-events-none absolute inset-y-0 left-3.5 flex items-center text-white/30">
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                        <path stroke-linecap="round" d="M3 8l9 6 9-6M5 6h14v12H5z"/>
                    </svg>
                </span>
                <input
                    id="email" name="email" type="email"
                    value="{{ old('email') }}"
                    required autofocus autocomplete="email"
                    placeholder="admin@canoa.test"
                    class="w-full rounded-xl border py-3 pl-10 pr-4 text-sm text-white placeholder:text-white/25 focus:outline-none focus:ring-2 {{ $errors->has('email') ? 'border-danger/50 focus:ring-danger/30' : 'border-white/10 focus:border-brand/50 focus:ring-brand/20' }}"
                    style="background: rgba(255,255,255,0.06);"
                >
            </div>
            @error('email')
                <p class="mt-1.5 text-xs text-danger">{{ $message }}</p>
            @enderror
        </div>

        {{-- Campo contraseña --}}
        <div>
            <label for="password" class="mb-1.5 block text-sm font-medium text-white/70">
                Contraseña
            </label>
            <div class="relative">
                <span class="pointer-events-none absolute inset-y-0 left-3.5 flex items-center text-white/30">
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                        <path stroke-linecap="round" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                    </svg>
                </span>
                <input
                    id="password" name="password" type="password"
                    required autocomplete="current-password"
                    placeholder="••••••••••"
                    class="w-full rounded-xl border py-3 pl-10 pr-4 text-sm text-white placeholder:text-white/25 focus:outline-none focus:ring-2 {{ $errors->has('password') ? 'border-danger/50 focus:ring-danger/30' : 'border-white/10 focus:border-brand/50 focus:ring-brand/20' }}"
                    style="background: rgba(255,255,255,0.06);"
                >
            </div>
            @error('password')
                <p class="mt-1.5 text-xs text-danger">{{ $message }}</p>
            @enderror
        </div>

        {{-- Recordar sesión --}}
        <label class="flex items-center gap-2.5 text-sm text-white/50 cursor-pointer">
            <input type="checkbox" name="remember"
                class="rounded border-white/20 focus:ring-brand/30"
                style="background: rgba(255,255,255,0.06);">
            Mantener sesión iniciada
        </label>

        {{-- Botón --}}
        <button
            type="submit"
            class="w-full rounded-xl py-3 text-sm font-semibold text-white transition hover:opacity-90 focus:outline-none focus:ring-2 focus:ring-brand/40"
            style="background: linear-gradient(135deg, #0B3954 0%, #087E8B 100%);"
        >
            Entrar
        </button>
    </form>

    <a href="{{ route('admin.password.request') }}"
        class="mt-5 block text-center text-sm transition"
        style="color: #72D5F8;">
        ¿Olvidaste tu contraseña?
    </a>
@endsection