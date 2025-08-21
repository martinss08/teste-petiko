<?php

namespace App\Repository\Eloquent;

use App\Models\User;
use App\Repository\Eloquent\BaseRepository;
use App\Repository\Interfaces\EloquentRepositoryInterface;
use Symfony\Component\HttpFoundation\Request;

class UserRepository extends BaseRepository implements EloquentRepositoryInterface
{
    public function __construct(User $model)
    {
        Parent::__construct($model);
    }

    public function getAll(Request $request)
    {
        $query = $this->model->with('tipoUsuario');

        if($query == auth()->user())
    }
}