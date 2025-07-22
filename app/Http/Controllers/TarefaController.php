<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Models\Tarefa;
use Illuminate\Http\Request;
use App\Http\Requests\TarefaRequest;
use App\Models\Status;

class TarefaController extends Controller
{
    protected $model;

    public function __construct(Tarefa $model)
    {
        $this->model = $model;
    }

    public function index()
    {
        $tarefas = $this->model->with('status')->get();

        return Inertia::render('Home', [
            'tarefas' => $tarefas
        ]);
    }

    public function create()
    {
        $status = Status::select('id', 'nome')->get();

        // dd($status);

        return Inertia::render('FormTarefa', [
            'statusOptions' => $status
        ]);
        // return Inertia::render('FormTarefa');
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

        $status = Status::select('id', 'nome')->get();

        return Inertia::render('FormTarefa', [
            'tarefa' => $tarefa,
            'statusOptions' => $status
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
