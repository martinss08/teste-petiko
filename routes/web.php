<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\TarefaController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;

Route::get('/', [TarefaController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('tarefa.index');

Route::get('/register', [UserController::class, 'create'])->name('register');
Route::post('/register', [UserController::class, 'store'])->name('register');

Route::middleware(['auth'])->group(function () {
    Route::get('/tarefa', [TarefaController::class, 'index'])->name('tarefa.index');
    Route::get('/tarefa/create', [TarefaController::class, 'create'])->name('tarefa.create');
    Route::post('/tarefa', [TarefaController::class, 'store'])->name('tarefa.store');
    Route::get('/tarefa/{id}/edit', [TarefaController::class, 'edit'])->name('tarefa.edit');
    Route::put('/tarefa/{id}', [TarefaController::class, 'update'])->name('tarefa.update');
    Route::put('/tarefa/{id}/toggle-status', [TarefaController::class, 'toggleStatus'])->name('tarefa.toggleStatus');
    Route::delete('/tarefa/{id}', [TarefaController::class, 'destroy'])->name('tarefa.destroy');

    Route::get('/user', [UserController::class, 'index'])->name('user.index');
    Route::post('/user', [UserController::class, 'store'])->name('user.store');
    Route::get('/user/{id}/edit', [UserController::class, 'edit'])->name('user.edit');
    Route::put('/user/{id}', [UserController::class, 'update'])->name('user.update');
    Route::delete('/user/{id}', [UserController::class, 'destroy'])->name('user.destroy');

    Route::get('/user/{id}/perfil', [UserController::class, 'show'])->name('user.show');

    Route::get('/tarefas/exportar', [TarefaController::class, 'exportarCSV'])->name('tarefas.exportar');

});

Route::get('/login', [AuthenticatedSessionController::class, 'create'])->name('login');
Route::post('/login', [AuthenticatedSessionController::class, 'store']);
Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');