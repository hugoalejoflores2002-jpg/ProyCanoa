<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">
    <title>@yield('title', 'CANOA Nautical Sport')</title>
    <meta name="description" content="@yield('meta_description', '')">
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600|outfit:600,700" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-surface text-ink">

    {{-- Cabecera mínima --}}
    <header class="sticky top-0 z-30 border-b border-edge/15 bg-surface/95 backdrop-blur">
        <div class="mx-auto flex h-14 max-w-6xl items-center justify-between px-4 md:h-16">
            <a href="/" class="font-display text-xl font-bold tracking-tight text-deep">CANOA</a>

            {{-- Navegación de escritorio --}}
            <nav class="hidden items-center gap-6 text-sm font-medium text-muted md:flex">
                <a href="#" class="transition hover:text-deep">Actividades</a>
                <a href="#" class="transition hover:text-deep">Paquetes</a>
                <a href="#" class="transition hover:text-deep">Nosotros</a>
                <a href="#" class="transition hover:text-deep">Contacto</a>
                <x-canoa.button href="#">Reservar</x-canoa.button>
            </nav>
        </div>
    </header>

    {{-- Contenido. El padding inferior evita que la barra tape el final --}}
    <main class="pb-24 md:pb-0">
        @yield('content')
    </main>

    {{-- Footer: navegación secundaria completa --}}
    <footer class="bg-deep px-4 pt-12 pb-28 text-white/70 md:pb-12">
        <div class="mx-auto max-w-6xl">
            <p class="font-display text-lg font-semibold text-white">CANOA Nautical Sport</p>
            <p class="mt-1 text-sm">Turismo de aventura · Pucallpa, Ucayali</p>

            <div class="mt-8 grid grid-cols-2 gap-8 text-sm sm:grid-cols-3">
                <div>
                    <p class="mb-3 font-medium text-white">Explorar</p>
                    <ul class="space-y-2">
                        <li><a href="#" class="transition hover:text-brand">Actividades</a></li>
                        <li><a href="#" class="transition hover:text-brand">Paquetes</a></li>
                        <li><a href="#" class="transition hover:text-brand">Promociones</a></li>
                        <li><a href="#" class="transition hover:text-brand">Galería</a></li>
                    </ul>
                </div>
                <div>
                    <p class="mb-3 font-medium text-white">Información</p>
                    <ul class="space-y-2">
                        <li><a href="#" class="transition hover:text-brand">Nosotros</a></li>
                        <li><a href="#" class="transition hover:text-brand">Hospedajes</a></li>
                        <li><a href="#" class="transition hover:text-brand">Preguntas frecuentes</a></li>
                        <li><a href="#" class="transition hover:text-brand">Contacto</a></li>
                    </ul>
                </div>
                <div class="col-span-2 sm:col-span-1">
                    <p class="mb-3 font-medium text-white">Síguenos</p>
                    <ul class="space-y-2">
                        <li><a href="#" class="transition hover:text-brand">Facebook</a></li>
                        <li><a href="#" class="transition hover:text-brand">Instagram</a></li>
                        <li><a href="#" class="transition hover:text-brand">TikTok</a></li>
                    </ul>
                </div>
            </div>

            <p class="mt-10 border-t border-white/10 pt-6 text-xs text-white/50">
                © {{ date('Y') }} CANOA Nautical Sport
            </p>
        </div>
    </footer>

    {{-- Barra inferior: solo móvil --}}
    <x-canoa.bottom-nav />

</body>
</html>