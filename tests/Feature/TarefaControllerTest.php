<?php

namespace Tests\Feature;

use App\Models\Status;
use App\Models\Tarefa;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class TarefaControllerTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     */
    public function test_example(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    public function test_listar_tarefas()
    {
        $status = Status::factory()->create();
        Tarefa::factory()->count(3)->create([
            'status_id' => $status->id
        ]);

        $response = $this->get('/tarefa');

        $response->assertStatus(200);
        $response->assertInertia(fn ($page) =>
            $page->component('Home')
                 ->has('tarefas.data', 3)
        );
    }

    public function test_criar_tarefa()
    {
        $status = Status::factory()->create();

        $response = $this->post(route('tarefa.store'), [
            'titulo' => 'Nova tarefa',
            'descircao' => 'Descricao',
            'status_id' => $status->id
        ]);

        $response->assertRedirect(route('tarefa.index'));
        $this->assertDatabaseHas('tarefas', ['titulo' => 'Nova Tarefa']);
    }

    public function test_atualizar_tarefa()
    {
        $status = Status::factory()->create();
        $tarefa = Tarefa::factory()->create([
            'status_id' => $status->id
        ]);

        $response = $this->put(route('tarefa.update', $tarefa->id), [
            'titulo' => 'Atualizado',
            'descricao' => $tarefa->descricao,
            'status_id' => $tarefa->status_id,
        ]);

        $response->assertRedirect(route('tarefa.index'));
        $this->assertDatabaseHas('tarefas', ['titulo' => 'Atualizado']);
    }

    public function test_deletar_tarefa()
    {
        $tarefa = Tarefa::factory()->create();

        $response = $this->delete(route('tarefa.destroy', $tarefa->id));

        $response->assertRedirect(route('tarefa.index'));
        $this->assertDatabaseMissing('tarefas', ['id' => $tarefa->id]);
    }
}
