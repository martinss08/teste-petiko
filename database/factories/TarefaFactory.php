<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Status;
use App\Models\Tarefa;
use Illuminate\Database\Eloquent\Factories\Factory;

class TarefaFactory extends Factory
{
    protected $model = Tarefa::class;

    public function definition()
    {
        return [
            'titulo' => $this->faker->sentence(),
            'descricao' => $this->faker->paragraph(),
            'status_id' => Status::factory(),
            'user_id' => User::factory(),
            'data_tarefa' => $this->faker->date()
        ];
    }
}
