<?php

namespace App\Repository\Eloquent;

use App\Models\Tarefa;
use App\Repository\Eloquent\BaseRepository;
use App\Repository\Interfaces\TarefaRepositoryInterface;

class TarefaRepository extends BaseRepository implements TarefaRepositoryInterface
{
    public function __construct(Tarefa $model)
    {
        $this->model = $model;
    }

    public function searchBar($query)
    {
        return $query->orderBy('id')
            ->paginate(10)
            ->withQueryString();
    }

    public function create($data)
    {
        return $this->model->create($data);
    }

    public function find($id)
    {
        return $this->model->findOrFail($id);
    }

    public function findWithStatus($id)
    {
        return $this->model->with('status')->findOrFail($id);
    }

    public function withUserAndStatus()
    {
        return $this->model->with(['user', 'status']);
    }

    public function update(int $id, array $data)
    {
        $tareafa = $this->model->findOrFail($id);

        return $tareafa->update($data);
    }

    public function exportarCSV()
    {
        // Carrega todas as tarefas com status e usuário
        $tarefas = $this->model->with(['status', 'user'])->get();

        // Cabeçalho do CSV
        $csvHeader = [
            'ID',
            'Título',
            'Descrição',
            'Data',
            'Status',
            'Responsável'
        ];

        // Monta os dados do CSV
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

        return [
            'header' => $csvHeader,
            'data' => $csvData,
            'filename' => 'tarefas_' . now()->format('Ymd_His') . '.csv'
        ];
    }


    public function delete($id)
    {
        $tareafa = $this->model->findOrFail($id);

        return $tareafa->delete();
    }
}