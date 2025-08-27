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
                ->orWhereHas('status', function ($q2) use ($busca) {
                    $q2->where('nome', 'like', "%{$busca}%");
                });
            });
        }

        return $query->orderBy('id')
                     ->paginate(10)
                     ->withQueryString();
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

        $authUser = auth()->user();

        if ($user->id === $authUser->id && $user->tipo_user_id == 2) {
            $otherAdminsCount = $this->model
                ->where('tipo_user_id', 2)
                ->where('id', '!=', $user->id)
                ->count();

            if ($otherAdminsCount === 0) {
                return redirect()->route('user.index')->with('error', 'Você não pode se deletar, pois é o último administrador.');
            }
        }

        return $user->delete();
    }
    
}