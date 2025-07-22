<?php

use App\Http\Controllers\TarefaController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

// Route::get('/tarefa', function () {
//     return Inertia::render('Home');
// });

Route::resource('/tarefa', TarefaController::class);

Route::get('/tarefa', [TarefaController::class, 'index'])->name('tarefa.index');
Route::get('/tarefa/{id}/edit', [TarefaController::class, 'edit']);
Route::post('/tarefa', [TarefaController::class, 'store']);
Route::delete('/tarefa/{id}', [TarefaController::class, 'destroy'])->name('tarefa.destroy');



Route::get('/tarefa/create', function () {
    return Inertia::render('FormTarefa');
});