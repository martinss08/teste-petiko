<?php

namespace App\Http\Controllers;

use App\Models\User;
use Inertia\Inertia;
use App\Models\Status;
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
        return Inertia::render('Auth/Register');
    }

    public function store(UserRequest $request)
    {
        $dados = $request->validated();
        
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
        $authUser = auth()->user();

        // Verifica se o usuário a ser deletado é o próprio usuário logado
        if ($user->id === $authUser->id && $user->tipo_user_id == 2) {
            // Verifica se existe outro admin no sistema
            $otherAdminsCount = $this->model
                ->where('tipo_user_id', 2)
                ->where('id', '!=', $user->id)
                ->count();

            if ($otherAdminsCount === 0) {
                // Bloqueia exclusão: último admin não pode se deletar
                return redirect()->route('user.index')->with('error', 'Você não pode se deletar pois é o último administrador.');
            }
        }

        // Pode deletar normalmente
        $user->delete();

        return redirect()->route('user.index')->with('success', 'Usuário deletado com sucesso.');
    }

}
