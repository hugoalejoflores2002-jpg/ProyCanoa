<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'CANOA Nautical Sport')</title>
    <meta name="description" content="@yield('meta_description', '')">
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600|outfit:600,700" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-surface text-ink" x-data="{ menu: false }">

    <header class="sticky top-0 z-30 border-b border-edge/15 bg-surface/95 backdrop-blur">
        <div class="mx-auto flex h-16 max-w-6xl items-center justify-between px-4">
            <a href="/" class="font-display text-xl font-bold tracking-tight text-deep">CANOA</a>

            <nav class="hidden gap-6 text-sm font-medium text-muted md:flex">
                <a href="#" class="transition hover:text-deep">Actividades</a>
                <a href="#" class="transition hover:text-deep">Paquetes</a>
                <a href="#" class="transition hover:text-deep">Nosotros</a>
                <a href="#" class="transition hover:text-deep">Contacto</a>
            </nav>

            <x-canoa.button href="#" class="hidden md:inline-flex">Reservar</x-canoa.button>

            <button @click="menu = ! menu" class="p-2 text-deep md:hidden" aria-label="Menú">
                <svg class="h-6 w-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" d="M4 6h16M4 12h16M4 18h16" />
                </svg>
            </button>
        </div>

        <div x-show="menu" x-cloak class="border-t border-edge/15 px-4 py-4 md:hidden">
            <nav class="flex flex-col gap-3 text-sm font-medium text-muted">
                <a href="#">Actividades</a>
                <a href="#">Paquetes</a>
                <a href="#">Nosotros</a>
                <a href="#">Contacto</a>
            </nav>
            <x-canoa.button href="#" class="mt-4 w-full">Reservar</x-canoa.button>
        </div>
    </header>

    <main>
        @yield('content')
    </main>

    <footer class="mt-20 bg-deep px-4 py-12 text-white/70">
        <div class="mx-auto max-w-6xl">
            <p class="font-display text-lg font-semibold text-white">CANOA Nautical Sport</p>
            <p class="mt-2 text-sm">Turismo de aventura · Pucallpa, Ucayali</p>
        </div>
    </footer>
</body>
</html>