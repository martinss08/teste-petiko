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

    public function searchBar($busca)
    {
        $query = $this->model->query();
            
        if(auth()->user()->tipo_user_id !== 2) {
            $query->where('user_id', auth()->id());
        }

        if ($busca) {
            $query->where(function ($q) use ($busca) {
                $q->where('name', 'like', "%{$busca}%")
                ->orWhereHas('tipoUsuario', function ($q2) use ($busca) {
                    $q2->where('nome', 'like', "%{$busca}%");
                });
            });
        }

        $tarefas = $query->orderBy('id')
            ->paginate(10)
            ->withQueryString();

        return $tarefas;
    }
}