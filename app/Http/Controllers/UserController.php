<?php

namespace App\Http\Controllers;

use App\Models\User;
use Inertia\Inertia;
use Illuminate\Http\Request;
use App\Http\Requests\UserRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    protected $model;

    public function __construct(User $model)
    {
        $this->model = $model;
    }

    public function index()
    {
        $users = $this->model->with('tipoUsuario')->paginate(10);

        return Inertia::render('ListUser', [
            'users' => $users  
        ]);
    }

    public function create()
    {
        return Inertia::render('Auth/Register', [
        'authUser' => Auth::user(), // Passa o usuário logado
    ]);
    }

    public function store(UserRequest $request)
    {
        
        $dados = $request->validated();
        
        // dd('criou');
        $this->model->create($dados);

        return Inertia::render('Auth/Login');
    }

    public function edit($id)
    {
        $user = $this->model->findOrFail($id);

        return Inertia::render('Auth/Register', [
            'user' => $user,
            'authUser' => Auth::user(),
        ]);
    }

    public function update($id, UserRequest $request)
    {
        $user = $this->model->findOrFail($id);
        
        $dados = $request->validated();
        
        if ($request->filled('password')) {
            $dados['password'] = Hash::make($request->password);
        } else {
            
            unset($dados['password']);
        }
        
        $user->update($dados);
        
        return redirect()->route('user.index');
    }

    public function destroy($id)
    {
        $user = $this->model->findOrFail($id);

        $user->delete();

        return Inertia::render('ListUser');
    }
}
