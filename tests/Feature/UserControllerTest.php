<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\TipoUser;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic feature test example.
     */

    public function test_listar_usuarios()
    {
        $tipoAdmin = TipoUser::create(['nome' => 'administrador']);
        $tipoUsuario = TipoUser::create(['nome' => 'usuario']);
        
        User::factory()->count(5)->create([
            'tipo_user_id' => $tipoUsuario->id
        ]);

        $admin = User::factory()->create([
            'tipo_user_id' => $tipoAdmin->id
        ]);

        $response = $this->actingAs($admin)->get(route('user.index'));

        $response->assertStatus(200);

        $response->assertInertia(fn ($page) =>
            $page->component('ListUser')
                ->has('users.data', 6)
                ->has('users.data.0.tipo_usuario')
        );

    }

    public function test_criar_usuarios()
    {
        $tipo = TipoUser::factory()->create([
            'nome' => 'Administrador' 
        ]);

        $dados = [
            'name' => 'Alef',
            'email' => 'alef@gmail.com',
            'password' => 'senha123',
            'password_confirmation' => 'senha123',
            'tipo_user_id' => $tipo->id
        ];

        $response = $this->post(route('register'), $dados);

        $response->assertStatus(200);
        $this->assertDatabaseHas('users', [
            'name' => 'Alef',
            'email' => 'alef@gmail.com',
            'tipo_user_id' => $tipo->id
        ]);
    }

    

    public function test_deletar_usuario()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->delete(route('user.destroy', $user->id));

        $response->assertRedirect(route('user.index'));

        $this->assertDatabaseMissing('users', ['id' => $user->id]);
    }
}
