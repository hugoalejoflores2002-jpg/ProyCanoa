@props(['variant' => 'info'])

@php
    $variants = [
        'success' => 'bg-success/10 text-success border-success/20',
        'warning' => 'bg-warning/10 text-warning border-warning/20',
        'danger'  => 'bg-danger/10 text-danger border-danger/20',
        'info'    => 'bg-info/10 text-info border-info/20',
    ];
@endphp

<div role="alert" {{ $attributes->class('rounded-lg border px-4 py-3 text-sm '.($variants[$variant] ?? $variants['info'])) }}>
    {{ $slot }}
</div>