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
        return $this->model->all();
    }

    public function store(array $data)
    {
        return $this->model->create($data);
    }

    public function find(int $id)
    {
        return $this->model->find($id);
    }

    public function update(int $id, array $data)
    {
        $user = $this->find($id);

        return  $user->update($data);
    }

    public function delete(int $id)
    {
        $user = $this->find($id);

        return $user->delete();
    }
}