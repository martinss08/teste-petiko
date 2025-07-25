<?php

namespace App\Http\Controllers;

use App\Models\User;
use Inertia\Inertia;
use App\Http\Requests\UserRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;

class UserController extends Controller
{
    protected $model;

    public function __construct(User $model)
    {
        $this->model = $model;
    }

    public function index(Request $request)
    {
        $busca = $request->input('busca');

        $query = $this->model->with('tipoUsuario');

        if ($busca) {
            $query->where(function ($q) use ($busca) {
                $q->where('name', 'like', "%{$busca}%")
                ->orWhereHas('tipoUsuario', function ($q2) use ($busca) {
                    $q2->where('nome', 'like', "%{$busca}%");
                });
            });
        }

        $users = $query->orderBy('id')->paginate(10)->withQueryString();

        return Inertia::render('ListUser', [
            'users' => $users,
            'busca' => $busca
        ]);
    }

    public function create()
    {
        return Inertia::render('Auth/Register', [
            'authUser' => auth()->user()
        ]);
    }

    public function store(UserRequest $request)
    {
        $dados = $request->validated();
                
        $this->model->create($dados);

        if (Auth::check()) {
           return redirect()->route('user.index');
        }

        return Inertia::render('Auth/Login');
    }

    public function show($id)
    {
        $user = $this->model->findOrFail($id);

        return Inertia::render('Auth/Register', [
            'user' => $user,
            'authUser' => Auth::user(),
        ]);
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

        if (Auth::user()->tipo_user_id === 2) {
            return redirect()->route('user.index');
        }
        
        return redirect()->route('tarefa.index');
    }

    public function destroy($id)
    {
        $user = $this->model->findOrFail($id);
        $authUser = auth()->user();

        if ($user->id === $authUser->id && $user->tipo_user_id == 2) {
            $otherAdminsCount = $this->model
                ->where('tipo_user_id', 2)
                ->where('id', '!=', $user->id)
                ->count();

            if ($otherAdminsCount === 0) {
                return redirect()->route('user.index')->with('error', 'Você não pode se deletar, pois é o último administrador.');
            }
        }

        $user->delete();

        return redirect()->route('user.index');
    }

}
