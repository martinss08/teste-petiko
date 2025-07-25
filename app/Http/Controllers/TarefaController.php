<?php

namespace App\Http\Controllers;

use App\Models\User;
use Inertia\Inertia;
use App\Models\Status;
use App\Models\Tarefa;
use Illuminate\Http\Request;
use App\Http\Requests\TarefaRequest;
use Illuminate\Support\Facades\Response;

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

        $query = $this->model->with(['status', 'user']);

        if (auth()->user()->tipo_user_id !== 2) {
            $query->where('user_id', auth()->id());
        }

        if ($busca) {
            $query->where(function ($q) use ($busca) {
                $q->where('titulo', 'like', "%{$busca}%")
                ->orWhereHas('status', function ($q2) use ($busca) {
                    $q2->where('nome', 'like', "%{$busca}%");
                });
            });
        }

        $tarefas = $query->orderBy('id')
            ->paginate(10)
            ->withQueryString();


        return Inertia::render('Home', [
            'tarefas' => $tarefas,
            'busca' => $busca,
            'authUser' => auth()->user()
        ]);
    }

    public function create()
    {
        $status = Status::select('id', 'nome')->get();
        $usuarios = User::select('id', 'name')->get();

        return Inertia::render('FormTarefa', [
            'status' => $status,
            'users' => $usuarios, 
            'authUser' => auth()->user(),
        ]);
    }

    public function store(TarefaRequest $request)
    {
        $data = $request->validated();

        if (auth()->user()->tipo_user_id != 2) {
            $data['user_id'] = auth()->id();
        }
        
        $this->model->create($data);

        return redirect()->route('tarefa.index');
    }

    public function edit($id)
    {
        $tarefa = $this->model->with('status')->findOrFail($id);
        
        $status = Status::select('id', 'nome')->get();

        return Inertia::render('FormTarefa', [
            'tarefa' => $tarefa,
            'status' => $status,
            
        ]);
    }
    public function update($id, TarefaRequest $request)
    {
        $tarefa = $this->model->findOrFail($id);

        $dados = $request->validated();

        $tarefa->update($dados);
    
        return redirect()->route('tarefa.index');
    }

        
    public function toggleStatus($id)
    {
        $tarefa = Tarefa::findOrFail($id);

        $tarefa->status_id = $tarefa->status_id === 2 ? 1 : 2;
        $tarefa->save();

        return back(); 
    }

    public function exportarCSV()
    {
        $tarefas = $this->model->with(['status', 'user'])->get();

        $csvHeader = [
            'ID', 'Título', 'Descrição', 'Data', 'Status', 'Responsável'
        ];

        $csvData = $tarefas->map(function ($tarefa) {
            return [
                $tarefa->id,
                $tarefa->titulo,
                $tarefa->descricao,
                $tarefa->data_tarefa,
                $tarefa->status->nome ?? 'sem status',
                $tarefa->user->name ?? 'sem responsável',
            ];
        });

        $filename = 'tarefas_' . now()->format('Ymd_His') . '.csv';

        $handle = fopen('php://temp', 'r+');
        fputcsv($handle, $csvHeader);

        foreach ($csvData as $row) {
            fputcsv($handle, $row);
        }

        rewind($handle);
        $contents = stream_get_contents($handle);
        fclose($handle);

        return Response::make($contents, 200, [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"$filename\"",
        ]);
    }


    public function destroy($id)
    {
        $tarefa = $this->model->findOrFail($id);

        $tarefa->delete();

        return redirect()->route('tarefa.index');
    }

}
