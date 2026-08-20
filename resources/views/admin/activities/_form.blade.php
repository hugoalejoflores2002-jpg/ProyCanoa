<div class="space-y-4">
    <x-canoa.input name="name" label="Nombre de la actividad" :value="old('name', $activity->name ?? '')" required />
    <x-canoa.input name="slug" label="Slug (URL)" :value="old('slug', $activity->slug ?? '')" hint="Se genera automáticamente si lo dejas vacío." />

    <div>
        <label class="mb-1.5 block text-sm font-medium text-ink">Descripción corta</label>
        <textarea name="short_description" rows="2"
            class="w-full rounded-lg border border-edge/30 bg-surface px-3.5 py-2.5 text-sm text-ink focus:border-teal focus:outline-none focus:ring-2 focus:ring-teal/20"
        >{{ old('short_description', $activity->short_description ?? '') }}</textarea>
    </div>

    <div>
        <label class="mb-1.5 block text-sm font-medium text-ink">Descripción completa</label>
        <textarea name="description" rows="4"
            class="w-full rounded-lg border border-edge/30 bg-surface px-3.5 py-2.5 text-sm text-ink focus:border-teal focus:outline-none focus:ring-2 focus:ring-teal/20"
        >{{ old('description', $activity->description ?? '') }}</textarea>
    </div>

    <div class="grid grid-cols-2 gap-4 sm:grid-cols-3">
        <x-canoa.input name="default_capacity" type="number" label="Capacidad por defecto" :value="old('default_capacity', $activity->default_capacity ?? 20)" required />
        <x-canoa.input name="min_participants" type="number" label="Mínimo participantes" :value="old('min_participants', $activity->min_participants ?? 1)" required />
        <x-canoa.input name="max_participants" type="number" label="Máximo participantes" :value="old('max_participants', $activity->max_participants ?? 50)" required />
        <x-canoa.input name="duration_minutes" type="number" label="Duración (minutos)" :value="old('duration_minutes', $activity->duration_minutes ?? 120)" required />
        <x-canoa.input name="sort_order" type="number" label="Orden" :value="old('sort_order', $activity->sort_order ?? 0)" />
    </div>

    <div>
        <label class="mb-1.5 block text-sm font-medium text-ink">Dificultad</label>
        <select name="difficulty" class="w-full rounded-lg border border-edge/30 bg-surface px-3.5 py-2.5 text-sm text-ink focus:border-teal focus:outline-none focus:ring-2 focus:ring-teal/20">
            @foreach (['easy' => 'Fácil', 'moderate' => 'Moderada', 'hard' => 'Difícil', 'expert' => 'Experto'] as $value => $label)
                <option value="{{ $value }}" {{ old('difficulty', $activity->difficulty ?? 'moderate') === $value ? 'selected' : '' }}>{{ $label }}</option>
            @endforeach
        </select>
    </div>

    <div>
        <label class="mb-1.5 block text-sm font-medium text-ink">Estado</label>
        <select name="status" class="w-full rounded-lg border border-edge/30 bg-surface px-3.5 py-2.5 text-sm text-ink focus:border-teal focus:outline-none focus:ring-2 focus:ring-teal/20">
            @foreach (App\Enums\ActivityStatus::cases() as $status)
                <option value="{{ $status->value }}" {{ old('status', $activity->status->value ?? 'active') === $status->value ? 'selected' : '' }}>{{ $status->label() }}</option>
            @endforeach
        </select>
    </div>
</div>