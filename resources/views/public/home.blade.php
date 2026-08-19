@extends('layouts.public')

@section('title', 'CANOA Nautical Sport — Turismo de aventura en Pucallpa')

@section('content')
    <section class="mx-auto max-w-6xl px-4 py-12">
        <h1 class="font-display text-3xl font-bold text-deep md:text-5xl">
            Aventura en el corazón de Ucayali
        </h1>
        <p class="mt-4 max-w-xl text-muted">
            Contenido provisional para verificar el layout público. Las páginas reales se construyen en la Etapa 16.
        </p>

        <div class="mt-8 space-y-4">
            @foreach (['Rafting', 'Tubing', 'Kayaking', 'Espeleología'] as $actividad)
                <x-canoa.card :title="$actividad">
                    <p class="text-sm text-muted">Descripción de ejemplo para comprobar el espaciado vertical.</p>
                </x-canoa.card>
            @endforeach
        </div>
    </section>
@endsection