<?php

namespace App\Repository\Interfaces;

interface TarefaRepositoryInterface extends EloquentRepositoryInterface
{
    public function all();
    public function store(array $dados);
    public function find(int $id);
    public function update(int $id, array $data);
    public function delete(int $id);
}