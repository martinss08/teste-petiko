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

    public function index(Request $request)
    {
         $busca = $request->input('busca');

        $tarefas = $this->model
            ->with('status')
            ->where('user_id', auth()->id())
            ->when($busca, function ($query, $busca) {
                $query->where('titulo', 'like', "%{$busca}%")
                    ->orWhereHas('status', function ($q) use ($busca) {
                        $q->where('nome', 'like', "%{$busca}%");
                    });
            })
            ->orderBy('id')
            ->paginate(10)
            ->withQueryString();

        return Inertia::render('Home', [
            'tarefas' => $tarefas,
            'busca' => $busca
        ]);
    }

    public function create()
    {
        $status = Status::select('id', 'nome')->get();

        return Inertia::render('FormTarefa', [
            'statusOptions' => $status
        ]);
    }

    public function store(TarefaRequest $request)
    {
        $data = $request->validated();

        $data['user_id'] = auth()->id();
     
        $this->model->create($data);

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
