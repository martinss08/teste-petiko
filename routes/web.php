<?php

use Inertia\Inertia;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\TarefaController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;

Route::get('/', [TarefaController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('tarefa.index');

Route::middleware(['auth'])->group(function () {
    Route::get('/tarefa', [TarefaController::class, 'index'])->name('tarefa.index');
    Route::get('/tarefa/create', [TarefaController::class, 'create'])->name('tarefa.create');
    Route::post('/tarefa', [TarefaController::class, 'store'])->name('tarefa.store');
    Route::get('/tarefa/{id}/edit', [TarefaController::class, 'edit'])->name('tarefa.edit');
    Route::put('/tarefa/{id}', [TarefaController::class, 'update'])->name('tarefa.update');
    Route::delete('/tarefa/{id}', [TarefaController::class, 'destroy'])->name('tarefa.destroy');
});

Route::get('/login', [AuthenticatedSessionController::class, 'create'])->name('login');
Route::post('/login', [AuthenticatedSessionController::class, 'store']);
Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');

// Rotas de perfil
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::get('/register', [UserController::class, 'create'])->name('register');
Route::post('/register', [UserController::class, 'store'])->name('register');



