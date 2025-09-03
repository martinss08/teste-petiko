<?php

namespace App\Service;

use App\Repository\Eloquent\UserRepository;
use Illuminate\Support\Facades\Hash;

class UserService
{
    public function __construct(protected UserRepository $userRepository) {}

    public function getAllUser($busca)
    {
        return $this->userRepository->searchBar($busca)
                     ->orderBy('id')
                     ->paginate(10)
                     ->withQueryString();
    }

    public function createUser($request)
    {
        $dados = $request->validated();

        return $this->userRepository->store($dados);
    }

    public function updateUser($id, $request)
    {
        $dados = $request->validated();

        if ($request->filled('password')) {
            $dados['password'] = Hash::make($request->password);
        } else {
            unset($dados['password']);
        }

        return $this->userRepository->update($id, $dados);
    }

    public function delete($id)
    {
        $user = $this->userRepository->find($id);
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

        return $this->userRepository->delete($id);
    }
}