@props(['variant' => 'neutral'])

@php
    $variants = [
        'neutral' => 'bg-edge/10 text-muted',
        'success' => 'bg-success/10 text-success',
        'warning' => 'bg-warning/10 text-warning',
        'danger'  => 'bg-danger/10 text-danger',
        'info'    => 'bg-info/10 text-info',
        'brand'   => 'bg-brand-soft text-deep',
    ];
@endphp

<span {{ $attributes->class('inline-flex items-center rounded-full px-2.5 py-1 text-xs font-medium '.($variants[$variant] ?? $variants['neutral'])) }}>
    {{ $slot }}
</span>