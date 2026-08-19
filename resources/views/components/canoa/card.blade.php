@props(['title' => null])

<div {{ $attributes->class('rounded-xl border border-edge/15 bg-surface p-5 shadow-sm') }}>
    @if ($title)
        <h3 class="font-display text-base font-semibold text-deep">{{ $title }}</h3>
        <div class="mt-3">{{ $slot }}</div>
    @else
        {{ $slot }}
    @endif
</div>