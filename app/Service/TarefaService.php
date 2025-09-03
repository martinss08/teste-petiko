<?php

namespace App\Service;

use App\Repository\Eloquent\TarefaRepository;

class TarefaService
{
    public function __construct(protected TarefaRepository $tarefaRepository){}

    public function getAllTarefa($busca)
    {
       $query = $this->tarefaRepository->withUserAndStatus();
            
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

        return $this->tarefaRepository->searchBar($query);
    }

    public function createTarefa($request)
    {
        $data = $request->validated();
        
        if (auth()->user()->tipo_user_id != 2) {
            $data['user_id'] = auth()->id();
        }

        return $this->tarefaRepository->create($data);
    }

    public function updateTarefa($id, $request)
    {
        $dados = $request->validated();

        return $this->tarefaRepository->update($id, $dados);
    }


}