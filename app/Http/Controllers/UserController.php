<?php

namespace App\Http\Controllers;

use App\Models\User;
use Inertia\Inertia;
use Illuminate\Http\Request;
use App\Http\Requests\UserRequest;

class UserController extends Controller
{
    protected $model;

    public function __construct(User $model)
    {
        $this->model = $model;
    }

    public function index()
    {
        $user = $this->model->all();

        dd($user);
    }

    public function create()
    {
        return Inertia::render('Auth/Register'); // nome do seu componente Vue de registro
    }

    public function store(UserRequest $request)
    {
        
        $dados = $request->validated();
        
        // dd('criou');
        $this->model->create($dados);

        return Inertia::render('Auth/Login');
    }

    public function update($id, UserRequest $request)
    {
        $user = $this->model->findOrFail($id);

        $dados = $request->validated();

        $user->update($dados);
        
        dd('atualizou');
    }

    public function destroy($id)
    {
        $user = $this->model->findOrFail($id);

        $user->delete();

        dd('deletou');
    }
}
