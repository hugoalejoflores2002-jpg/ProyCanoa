@props(['variant' => 'primary', 'href' => null])

@php
    $base = 'inline-flex items-center justify-center gap-2 rounded-lg px-4 py-2.5 text-sm font-medium transition focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 disabled:pointer-events-none disabled:opacity-50';

    $variants = [
        'primary'   => 'bg-deep text-white hover:bg-deep-hover focus-visible:outline-deep',
        'secondary' => 'bg-teal text-white hover:bg-teal/90 focus-visible:outline-teal',
        'ghost'     => 'text-deep hover:bg-brand-soft focus-visible:outline-deep',
        'danger'    => 'bg-danger text-white hover:bg-danger/90 focus-visible:outline-danger',
    ];

    $classes = $base.' '.($variants[$variant] ?? $variants['primary']);
@endphp

@if ($href)
    <a href="{{ $href }}" {{ $attributes->class($classes) }}>{{ $slot }}</a>
@else
    <button {{ $attributes->class($classes)->merge(['type' => 'button']) }}>{{ $slot }}</button>
@endif