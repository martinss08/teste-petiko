<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Models\Tarefa;
use Illuminate\Http\Request;
use App\Http\Requests\TarefaRequest;

class TarefaController extends Controller
{
    protected $model;

    public function __construct(Tarefa $model)
    {
        $this->model = $model;
    }

    public function index()
    {
        $tarefas = $this->model->all();

        return Inertia::render('Home', [
            'tarefas' => $tarefas
        ]);
    }

    public function create()
    {
        return Inertia::render('FormTarefa');
    }

    public function store(TarefaRequest $request)
    {
        $tarefa = $request->validated();
     
        $this->model->create($tarefa);

        return redirect()->route('tarefa.index');
    }

    public function edit($id)
    {
        $tarefa = $this->model->findOrFail($id);

        return Inertia::render('FormTarefa', [
            'tarefa' => $tarefa
        ]);
    }
    public function update($id, TarefaRequest $request)
    {
        $tarefa = $this->model->findOrFail($id);

        $dados = $request->validated();

        $tarefa->update($dados);
    
        return redirect()->route('tarefa.index');
    }

    public function destroy($id)
    {
        $tarefa = $this->model->findOrFail($id);

        $tarefa->delete();

        return redirect()->route('tarefa.index');
    }

}
