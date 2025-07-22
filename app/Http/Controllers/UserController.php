<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use App\Models\User;
use Illuminate\Http\Request;

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

    public function create(UserRequest $request)
    {
        dd('criou');
        
        $dados = $request->validated();

        $this->model->create($dados);

        dd('criou');
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
