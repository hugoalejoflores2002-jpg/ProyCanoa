@php
    $items = [
        ['label' => 'Inicio',      'href' => '/',  'icon' => 'M3 10.5 12 3l9 7.5M5 9.5V21h14V9.5'],
        ['label' => 'Actividades', 'href' => '#',  'icon' => 'M4 6h16M4 12h16M4 18h10'],
    ];

    $secondary = [
        ['label' => 'WhatsApp', 'href' => '#', 'icon' => 'M21 12a9 9 0 1 1-4.2-7.6L21 3l-1.4 4.2A9 9 0 0 1 21 12Z'],
        ['label' => 'Contacto', 'href' => '#', 'icon' => 'M3 6.5 12 13l9-6.5M3 6h18v12H3z'],
    ];
@endphp

<nav
    class="fixed inset-x-0 bottom-0 z-40 border-t border-edge/15 bg-surface/95 backdrop-blur md:hidden"
    style="padding-bottom: env(safe-area-inset-bottom);"
    aria-label="Navegación principal"
>
    <div class="mx-auto grid max-w-md grid-cols-5 items-end px-2 pt-2 pb-1">

        @foreach ($items as $item)
            <a href="{{ $item['href'] }}" class="flex flex-col items-center gap-1 py-1 text-muted transition hover:text-deep">
                <svg class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="{{ $item['icon'] }}" />
                </svg>
                <span class="text-[11px] font-medium">{{ $item['label'] }}</span>
            </a>
        @endforeach

        {{-- Acción central destacada --}}
        <a href="#" class="flex flex-col items-center" aria-label="Reservar">
            <span class="-mt-6 flex h-14 w-14 items-center justify-center rounded-full bg-deep text-white shadow-lg ring-4 ring-surface transition hover:bg-deep-hover">
                <svg class="h-6 w-6" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3M3 9h18M5 5h14v16H5z" />
                </svg>
            </span>
            <span class="mt-1 text-[11px] font-semibold text-deep">Reservar</span>
        </a>

        @foreach ($secondary as $item)
            <a href="{{ $item['href'] }}" class="flex flex-col items-center gap-1 py-1 text-muted transition hover:text-deep">
                <svg class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="{{ $item['icon'] }}" />
                </svg>
                <span class="text-[11px] font-medium">{{ $item['label'] }}</span>
            </a>
        @endforeach
    </div>
</nav>