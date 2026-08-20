@extends('layouts.admin')

@section('title', 'Actividades')

@section('content')
    <div class="mb-6 flex items-center justify-between">
        <div>
            <h2 class="font-display text-xl font-semibold text-deep">Actividades</h2>
            <p class="mt-1 text-sm text-muted">{{ $activities->total() }} actividades registradas</p>
        </div>
        @can('create', App\Models\Activity::class)
            <x-canoa.button @click="$dispatch('open-modal-activity-create')">
                Nueva actividad
            </x-canoa.button>
        @endcan
    </div>

    <x-canoa.card>
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="border-b border-edge/15 text-left text-xs font-medium uppercase tracking-wide text-muted">
                        <th class="pb-3 pr-4">Actividad</th>
                        <th class="pb-3 pr-4">Capacidad</th>
                        <th class="pb-3 pr-4">Duración</th>
                        <th class="pb-3 pr-4">Estado</th>
                        <th class="pb-3 text-right">Acciones</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-edge/10">
                    @forelse ($activities as $activity)
                        <tr>
                            <td class="py-3 pr-4 font-medium text-ink">{{ $activity->name }}</td>
                            <td class="py-3 pr-4 text-muted">{{ $activity->default_capacity }} personas</td>
                            <td class="py-3 pr-4 text-muted">{{ $activity->duration_minutes }} min</td>
                            <td class="py-3 pr-4">
                                <x-canoa.badge :variant="$activity->status->badgeVariant()">
                                    {{ $activity->status->label() }}
                                </x-canoa.badge>
                            </td>
                            <td class="py-3 text-right">
                                <div class="flex items-center justify-end gap-2">
                                    @can('update', $activity)
                                        <x-canoa.button
                                            variant="ghost"
                                            @click="$dispatch('open-modal-activity-edit-{{ $activity->id }}')"
                                        >Editar</x-canoa.button>

                                        <form method="POST" action="{{ route('admin.activities.toggle-status', $activity) }}">
                                            @csrf @method('PATCH')
                                            <x-canoa.button type="submit" variant="ghost">
                                                {{ $activity->status->value === 'active' ? 'Desactivar' : 'Activar' }}
                                            </x-canoa.button>
                                        </form>
                                    @endcan
                                </div>
                            </td>
                        </tr>

                        {{-- Modal de edición por fila --}}
                        <x-canoa.modal :id="'activity-edit-'.$activity->id" title="Editar actividad">
                            <form method="POST" action="{{ route('admin.activities.update', $activity) }}">
                                @csrf @method('PUT')
                                @include('admin.activities._form', ['activity' => $activity])
                                <div class="mt-6 flex gap-3 border-t border-edge/10 pt-4">
                                    <x-canoa.button type="submit">Guardar cambios</x-canoa.button>
                                    <x-canoa.button variant="ghost" @click="$dispatch('close-modal-activity-edit-{{ $activity->id }}')">Cancelar</x-canoa.button>
                                </div>
                            </form>
                        </x-canoa.modal>
                    @empty
                        <tr>
                            <td colspan="5" class="py-8 text-center text-muted">No hay actividades registradas.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if ($activities->hasPages())
            <div class="mt-4 border-t border-edge/10 pt-4">{{ $activities->links() }}</div>
        @endif
    </x-canoa.card>

    {{-- Modal de creación --}}
    <x-canoa.modal id="activity-create" title="Nueva actividad">
        <form method="POST" action="{{ route('admin.activities.store') }}">
            @csrf
            @include('admin.activities._form', ['activity' => null])
            <div class="mt-6 flex gap-3 border-t border-edge/10 pt-4">
                <x-canoa.button type="submit">Crear actividad</x-canoa.button>
                <x-canoa.button variant="ghost" @click="$dispatch('close-modal-activity-create')">Cancelar</x-canoa.button>
            </div>
        </form>
    </x-canoa.modal>
@endsection