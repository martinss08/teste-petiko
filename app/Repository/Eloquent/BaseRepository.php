<?php

namespace App\Repository\Eloquent;

use App\Repository\Interfaces\EloquentRepositoryInterface;
use Illuminate\Database\Eloquent\Model;

class BaseRepository implements EloquentRepositoryInterface
{
    protected $model;

    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    public function all()
    {
        $this->model->all();
    }

    public function store(array $data)
    {
        $this->model->create($data);
    }

    public function find(int $id)
    {
        $this->model->find($id);
    }

    public function update(int $id, array $data)
    {
        // $user = $this->find($id);

        // $user->update($data);
        
    }

    public function delete(int $id)
    {
        $user = $this->find($id);

        $this->model->delete($user);
    }
}