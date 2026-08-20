@extends('layouts.admin')
@section('title', 'Nueva actividad')
@section('content')
    <div class="mx-auto max-w-2xl">
        <x-canoa.card title="Nueva actividad">
            <form method="POST" action="{{ route('admin.activities.store') }}" class="mt-4">
                @csrf
                @include('admin.activities._form')
                <div class="mt-6 flex gap-3">
                    <x-canoa.button type="submit">Guardar actividad</x-canoa.button>
                    <x-canoa.button href="{{ route('admin.activities.index') }}" variant="ghost">Cancelar</x-canoa.button>
                </div>
            </form>
        </x-canoa.card>
    </div>
@endsection