@props(['label' => null, 'name', 'type' => 'text', 'hint' => null, 'value' => null])

<div>
    @if ($label)
        <label for="{{ $name }}" class="mb-1.5 block text-sm font-medium text-ink">{{ $label }}</label>
    @endif

    <input
        type="{{ $type }}"
        name="{{ $name }}"
        id="{{ $name }}"
        value="{{ old($name, $value) }}"
        {{ $attributes->class([
            'w-full rounded-lg border bg-surface px-3.5 py-2.5 text-sm text-ink placeholder:text-muted/60 focus:outline-none focus:ring-2',
            'border-edge/30 focus:border-teal focus:ring-teal/20' => ! $errors->has($name),
            'border-danger focus:border-danger focus:ring-danger/20' => $errors->has($name),
        ]) }}
    >

    @error($name)
        <p class="mt-1.5 text-sm text-danger">{{ $message }}</p>
    @enderror

    @if ($hint && ! $errors->has($name))
        <p class="mt-1.5 text-sm text-muted">{{ $hint }}</p>
    @endif
</div>