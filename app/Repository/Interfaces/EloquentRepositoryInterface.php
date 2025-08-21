<?php

namespace App\Repository\Interfaces;

interface EloquentRepositoryInterface
{
    public function all();
    public function store(array $data);
    public function find(int $id);
    public function update(int $id, array $data);
    public function delete(int $id);
}