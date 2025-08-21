<?php 

namespace App\Repository\Interfaces;

use App\Repository\Interfaces\EloquentRepositoryInterface;

interface UserRepositoryInterface extends EloquentRepositoryInterface
{
    public function getAll();
    // public function store();

}