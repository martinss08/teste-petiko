<?php

namespace App\Repository\Interfaces;

use App\Repository\Interfaces\EloquentRepositoryInterface;

interface StatusRepositoryInterface extends EloquentRepositoryInterface
{
    public function all();
    public function getForSelect();
    public function store(array $dados);
    public function find(int $id);
    public function update(int $id, array $data);
    public function delete(int $id);
}