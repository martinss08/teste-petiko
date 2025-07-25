<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Status;
use App\Models\Tarefa;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TarefaControllerTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     */
    public function test_example(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get('/');

        $response->assertStatus(200);
    }

    public function test_listar_tarefas()
    {
        $user = User::factory()->create();
        $status = Status::factory()->create();

        Tarefa::factory()->count(3)->create([
            'status_id' => $status->id,
            'user_id' => $user->id
        ]);

        $response = $this->actingAs($user)->get('/tarefa');

        $response->assertStatus(200);
        $response->assertInertia(fn ($page) =>
            $page->component('Home')
                 ->has('tarefas.data', 3)
        );
    }

    public function test_criar_tarefa()
    {
        $user = User::factory()->create();
        $status = Status::factory()->create(['nome' => 'pendente']);

        $response = $this->actingAs($user)->post(route('tarefa.store'), [
            'titulo' => 'Nova tarefa',
            'descricao' => 'Descricao',
            'status_id' => $status->id,
            'data_tarefa' => now()->toDateString(),
            'user_id' => $user->id
        ]);

        $response->assertRedirect(route('tarefa.index'));
        $this->assertDatabaseHas('tarefas', [
            'titulo' => 'Nova tarefa',
            'descricao' => 'Descricao',
            'status_id' => $status->id,
            'user_id' => $user->id
        ]);
    }

    public function test_atualizar_tarefa()
    {
        $user = User::factory()->create(); 
        $status = Status::factory()->create();

         $tarefa = Tarefa::factory()->create([
            'user_id' => $user->id,
            'status_id' => $status->id,
            'data_tarefa' => now()->toDateString()
        ]);

        $response = $this->actingAs($user)->put(route('tarefa.update', $tarefa->id), [
            'titulo' => 'Atualizado',
            'descricao' => $tarefa->descricao,
            'status_id' => $tarefa->status_id,
            'data_tarefa' => now()->toDateString(),
            'user_id' => $user->id,
        ]);

        $this->assertDatabaseHas('tarefas', [
            'id' => $tarefa->id,
            'titulo' => 'Atualizado',
        ]);
    }

    public function test_deletar_tarefa()
    {
        $user = User::factory()->create();
        $tarefa = Tarefa::factory()->create(['user_id' => $user->id]);

        $response = $this->actingAs($user)->delete(route('tarefa.destroy', $tarefa->id));

        $response->assertRedirect(route('tarefa.index'));
        $this->assertDatabaseMissing('tarefas', ['id' => $tarefa->id]);
    }
}
