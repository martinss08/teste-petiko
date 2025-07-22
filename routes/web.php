<?php

use App\Http\Controllers\TarefaController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return 'Página temporária, aguarde o login';
});

Route::get('/login', function () {
    return Inertia::render('Login');
});

Route::get('/tarefa', [TarefaController::class, 'index'])->name('tarefa.index');
Route::get('/tarefa/create', [TarefaController::class, 'create'])->name('tarefa.create');
Route::post('/tarefa', [TarefaController::class, 'store'])->name('tarefa.store');
Route::get('/tarefa/{id}/edit', [TarefaController::class, 'edit'])->name('tarefa.edit');
Route::put('/tarefa/{id}', [TarefaController::class, 'update'])->name('tarefa.update');
Route::delete('/tarefa/{id}', [TarefaController::class, 'destroy'])->name('tarefa.destroy');