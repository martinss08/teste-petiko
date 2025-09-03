<?php

namespace App\Repository\Eloquent;

use App\Models\User;
use App\Repository\Eloquent\BaseRepository;
use App\Repository\Interfaces\UserRepositoryInterface;

class UserRepository extends BaseRepository implements UserRepositoryInterface
{
    protected $model;

    public function __construct(User $model) 
    {
        $this->model = $model;
    }

    public function searchBar($busca)
    {
        $query = $this->model->with('tipoUsuario');

        if ($busca) {
            $query->where(function ($q) use ($busca) {
                $q->where('name', 'like', "%{$busca}%")
                ->orWhereHas('tipoUsuario', function ($q2) use ($busca) {
                    $q2->where('nome', 'like', "%{$busca}%");
                });
            });
        }

        return $query;
    }

    public function getForSelect()
    {
        return $this->model->select('id', 'name')->get();
    }

    public function store($data)
    {
        return $this->model->create($data);
    }

    public function find($id)
    {
        return $this->model->findOrFail($id);
    }

    public function update($id, $data)
    {
        $user = $this->model->findOrFail($id);
    
        return $user->update($data);
    }

    public function delete($id)
    {   
        $user = $this->model->findOrFail($id);

        return $user->delete();
    }
    
}