<?php

namespace App\Http\Controllers;

use App\Http\Requests\TarefaRequest;
use App\Models\Tarefa;
use Illuminate\Http\Request;

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

        dd($tarefas);
    }

    public function store()
    {
        dd('direcionar');
    }
    public function create(TarefaRequest $request)
    {
        $tarefa = $request->validated();

        $this->model->create($tarefa);

        dd('criou');
    }

    public function edit($id)
    {
        $tarefa = $this->model->findOrFail($id);

        dd('redirecionar');
    }
    public function update($id, TarefaRequest $request)
    {
        $tarefa = $this->model->findOrFail($id);

        $dados = $request->validated();

        $tarefa->update($dados);
    
        // Redireciona
    }

    public function destroy($id)
    {
        $tarefa = $this->model->findOrFail($id);

        $tarefa->destroy();

        // redireciona
    }

}
