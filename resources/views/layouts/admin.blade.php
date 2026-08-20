<!DOCTYPE html>
<html lang="es" class="h-full">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Panel') — CANOA Nautical Sport</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600|outfit:500,600,700" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
</head>
<body class="h-full bg-base text-ink" x-data="{ open: false }">

    <div class="flex h-full">

        <aside
            class="fixed inset-y-0 left-0 z-40 flex w-64 flex-col bg-deep text-white transition-transform lg:static lg:translate-x-0"
            :class="open ? 'translate-x-0' : '-translate-x-full'"
        >
            <div class="flex h-16 items-center gap-3 px-6">
                <span class="h-2.5 w-2.5 rounded-full bg-brand"></span>
                <span class="font-display text-lg font-semibold tracking-tight">CANOA</span>
            </div>

            <nav class="mt-4 flex-1 space-y-1 px-3 text-sm">
                @php
                    $items = [
                        ['label' => 'Dashboard',       'route' => 'admin.dashboard'],
                        ['label' => 'Perfil',          'route' => 'admin.profile.edit'],
                        ['label' => 'Guia de estilos', 'route' => 'admin.styleguide'],
                        ['label' => 'Actividades', 'route' => 'admin.activities.index'],
                    ];
                @endphp

                @foreach ($items as $item)
                    <a href="{{ route($item['route']) }}" class="{{ request()->routeIs($item['route']) ? 'block rounded-lg px-3 py-2 transition bg-white/10 text-white font-medium' : 'block rounded-lg px-3 py-2 transition text-white/70 hover:bg-white/5 hover:text-white' }}">
                        {{ $item['label'] }}
                    </a>
                @endforeach
            </nav>

            <div class="border-t border-white/10 px-3 py-4">
                @auth
                    <p class="px-3 text-xs text-white/50 truncate">{{ auth()->user()->email }}</p>
                @endauth

                <form method="POST" action="{{ route('admin.logout') }}" class="mt-2">
                    @csrf
                    <button type="submit" class="w-full rounded-lg px-3 py-2 text-left text-sm text-white/70 transition hover:bg-white/5 hover:text-white">
                        Cerrar sesion
                    </button>
                </form>
            </div>
        </aside>

        <div x-show="open" x-cloak @click="open = false" class="fixed inset-0 z-30 bg-ink/40 lg:hidden"></div>

        <div class="flex min-w-0 flex-1 flex-col">

            <header class="flex h-16 items-center gap-4 border-b border-edge/20 bg-surface px-4 lg:px-8">
                <button @click="open = ! open" class="rounded-lg p-2 text-muted hover:bg-base lg:hidden" aria-label="Abrir menu">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                </button>
                <h1 class="font-display text-lg font-semibold text-deep">@yield('title', 'Panel')</h1>
            </header>

            <main class="flex-1 overflow-y-auto p-4 lg:p-8">
                @if (session('error'))
                    <x-canoa.alert variant="danger" class="mb-6">{{ session('error') }}</x-canoa.alert>
                @endif
                @if (session('status'))
                    <x-canoa.alert variant="success" class="mb-6">{{ session('status') }}</x-canoa.alert>
                @endif
                @yield('content')
            </main>
        </div>
    </div>

    @livewireScripts
</body>
</html>