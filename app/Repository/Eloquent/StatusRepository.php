<?php

namespace App\Repository\Eloquent;

use App\Models\Status;
use App\Repository\Interfaces\StatusRepositoryInterface;

class StatusRepository implements StatusRepositoryInterface
{
    protected $model;

    public function __construct(Status $model)
    {
        $this->model = $model;
    }

    public function all()
    {
        return $this->model->all();
    }

    public function getForSelect()
    {
        return $this->model->select('id', 'nome')->get();
    }

    public function store(array $data)
    {
        return $this->model->create($data);
    }

    public function find($id)
    {
        return $this->model->findOrFail($id);
    }

    public function update(int $id, array $data)
    {
        $status = $this->model->findOrFail($id);
        
        return $status->update($data);
    }
    
    public function delete($id)
    {
        $status = $this->model->findOrFail($id);

        return  $status->delete();
    }
}