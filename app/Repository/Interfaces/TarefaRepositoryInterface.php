<?php

namespace App\Repository\Interfaces;

use App\Repository\Interfaces\EloquentRepositoryInterface;

interface TarefaRepositoryInterface extends EloquentRepositoryInterface
{
    public function all();
    public function searchBar(string $busca);
    public function store(array $dados);
    public function find(int $id);
    public function update(int $id, array $data);
    public function delete(int $id);
}