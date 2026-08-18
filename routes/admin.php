<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return 'Panel administrativo — Fase 1.1';
})->name('dashboard');