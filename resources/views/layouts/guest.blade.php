<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Acceso') — CANOA Nautical Sport</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600|outfit:600,700" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="relative flex min-h-screen items-center justify-center px-4 overflow-hidden" style="background-color: #060f1a;">

    {{-- Onda de luz principal — esquina superior izquierda --}}
    <div class="pointer-events-none absolute -top-40 -left-40 h-[500px] w-[500px] rounded-full blur-[120px]" style="background: radial-gradient(circle, rgba(114,213,248,0.45) 0%, rgba(8,126,139,0.2) 60%, transparent 100%);"></div>

    {{-- Onda secundaria — esquina inferior derecha --}}
    <div class="pointer-events-none absolute -bottom-40 -right-40 h-[500px] w-[500px] rounded-full blur-[120px]" style="background: radial-gradient(circle, rgba(8,126,139,0.5) 0%, rgba(11,57,84,0.3) 60%, transparent 100%);"></div>

    {{-- Onda central sutil --}}
    <div class="pointer-events-none absolute top-1/2 left-1/2 h-[300px] w-[300px] -translate-x-1/2 -translate-y-1/2 rounded-full blur-[100px]" style="background: radial-gradient(circle, rgba(114,213,248,0.08) 0%, transparent 70%);"></div>

    <div class="relative w-full max-w-sm">

        {{-- Logo --}}
        <div class="mb-8 flex items-center justify-center gap-3">
            <span class="h-3 w-3 rounded-full bg-brand"></span>
            <span class="font-display text-2xl font-bold tracking-tight text-white">CANOA</span>
        </div>

        {{-- Tarjeta con glassmorphism --}}
        <div class="rounded-2xl border border-white/10 p-8 shadow-2xl backdrop-blur-md" style="background: rgba(255,255,255,0.06);">
            @if (session('status'))
                <x-canoa.alert variant="success" class="mb-5">{{ session('status') }}</x-canoa.alert>
            @endif
            @if (session('error'))
                <x-canoa.alert variant="danger" class="mb-5">{{ session('error') }}</x-canoa.alert>
            @endif

            @yield('content')
        </div>

        <p class="mt-6 text-center text-xs text-white/30">Sistema interno · Acceso restringido</p>
    </div>
</body>
</html>