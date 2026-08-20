@props(['id', 'title', 'size' => 'md'])

@php
    $sizes = [
        'sm' => 'max-w-md',
        'md' => 'max-w-lg',
        'lg' => 'max-w-2xl',
        'xl' => 'max-w-4xl',
    ];
    $maxWidth = $sizes[$size] ?? $sizes['md'];
@endphp

<div
    x-data="{ open: false }"
    x-on:open-modal-{{ $id }}.window="open = true"
    x-on:close-modal-{{ $id }}.window="open = false"
    x-show="open"
    x-cloak
    class="fixed inset-0 z-50 flex items-center justify-center px-4"
>
    {{-- Fondo oscuro --}}
    <div
        x-show="open"
        x-transition:enter="transition ease-out duration-200"
        x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100"
        x-transition:leave="transition ease-in duration-150"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0"
        @click="open = false"
        class="absolute inset-0 bg-ink/50 backdrop-blur-sm"
    ></div>

    {{-- Panel del modal --}}
    <div
        x-show="open"
        x-transition:enter="transition ease-out duration-200"
        x-transition:enter-start="opacity-0 scale-95 translate-y-2"
        x-transition:enter-end="opacity-100 scale-100 translate-y-0"
        x-transition:leave="transition ease-in duration-150"
        x-transition:leave-start="opacity-100 scale-100"
        x-transition:leave-end="opacity-0 scale-95"
        class="relative w-full {{ $maxWidth }} rounded-2xl border border-edge/15 bg-surface shadow-2xl"
    >
        {{-- Cabecera --}}
        <div class="flex items-center justify-between border-b border-edge/15 px-6 py-4">
            <h3 class="font-display text-base font-semibold text-deep">{{ $title }}</h3>
            <button
                @click="open = false"
                class="rounded-lg p-1.5 text-muted transition hover:bg-base hover:text-ink"
                aria-label="Cerrar"
            >
                <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>

        {{-- Contenido --}}
        <div class="max-h-[80vh] overflow-y-auto px-6 py-5">
            {{ $slot }}
        </div>
    </div>
</div>