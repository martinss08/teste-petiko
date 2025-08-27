<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Http\Requests\UserRequest;
use App\Repository\Interfaces\UserRepositoryInterface;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;

class UserController extends Controller
{
    protected $userRepository;

    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function index(Request $request)
    {
        $busca = $request->input('busca');

        $users = $this->userRepository->searchBar($busca);

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
                
        $this->userRepository->store($dados);

        return Auth::check() 
            ? redirect()->route('user.index')
            : Inertia::render('Auth/Login');
    }

    public function show($id)
    {
        $user = $this->userRepository->find($id);

        return Inertia::render('Auth/Register', [
            'user' => $user,
            'authUser' => Auth::user(),
        ]);
    }

    public function edit($id)
    {
        $user = $this->userRepository->find($id);

        return Inertia::render('Auth/Register', [
            'user' => $user,
            'authUser' => Auth::user(),
        ]);
    }

    public function update($id, UserRequest $request)
    {
        $dados = $request->validated();
        
        if ($request->filled('password')) {
            $dados['password'] = Hash::make($request->password);
        } else {
            unset($dados['password']);
        }

        $this->userRepository->update($id, $dados);

        if (Auth::user()->tipo_user_id === 2) {
            return redirect()->route('user.index');
        }
        
        return redirect()->route('tarefa.index');
    }

    public function destroy($id)
    {   
        $this->userRepository->delete($id);

        return redirect()->route('user.index');
    }

}
