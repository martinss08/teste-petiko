<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use Illuminate\Http\Request;
use App\Http\Requests\TarefaRequest;
use App\Repository\Eloquent\TarefaRepository;
use App\Repository\Eloquent\StatusRepository;
use App\Repository\Eloquent\UserRepository;
use Illuminate\Support\Facades\Response;

class TarefaController extends Controller
{
    protected $tarefaRepository;
    protected $statusRepository;
    protected $userRepository;

    public function __construct (
        TarefaRepository $tarefaRepository,
        StatusRepository $statusRepository,
        UserRepository $userRepository
    )
    {
        $this->tarefaRepository = $tarefaRepository;
        $this->statusRepository = $statusRepository;
        $this->userRepository = $userRepository;
    }

    public function index(Request $request)
    {
        $busca = $request->input('busca');

        $tarefas = $this->tarefaRepository->searchBar($busca);

        return Inertia::render('Home', [
            'tarefas' => $tarefas,
            'busca' => $busca,
            'authUser' => auth()->user()
        ]);
    }

    public function create()
    {
        $status = $this->statusRepository->getForSelect();
        $usuarios = $this->userRepository->getForSelect();

        return Inertia::render('FormTarefa', [
            'status' => $status,
            'users' => $usuarios, 
            'authUser' => auth()->user(),
        ]);
    }

    public function store(TarefaRequest $request)
    {
        $data = $request->validated();
        
        $this->tarefaRepository->create($data);

        return redirect()->route('tarefa.index');
    }

    public function edit($id)
    {
        $tarefa = $this->tarefaRepository->findWithStatus($id);
        
        $status = $this->statusRepository->getForSelect();

        return Inertia::render('FormTarefa', [
            'tarefa' => $tarefa,
            'status' => $status,
        ]);
    }

    public function update($id, TarefaRequest $request)
    {
        $dados = $request->validated();

        $this->tarefaRepository->update($id, $dados);
    
        return redirect()->route('tarefa.index');
    }

        
    public function toggleStatus($id)
    {
        $tarefa = $this->tarefaRepository->find($id);

        $tarefa->status_id = $tarefa->status_id === 2 ? 1 : 2;
        $tarefa->save();

        return back(); 
    }

   public function exportarCSV()
    {
        $csv = $this->tarefaRepository->exportarCSV();

        $handle = fopen('php://temp', 'r+');
        fputcsv($handle, $csv['header']);

        foreach ($csv['data'] as $row) {
            fputcsv($handle, $row);
        }

        rewind($handle);
        $contents = stream_get_contents($handle);
        fclose($handle);

        return Response::make($contents, 200, [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"{$csv['filename']}\"",
        ]);
    }


    public function destroy($id)
    {
        $this->tarefaRepository->delete($id);

        return redirect()->route('tarefa.index');
    }

}
