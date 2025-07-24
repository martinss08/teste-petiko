<?php

namespace Database\Factories;

use App\Models\TipoUser;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\TipoUser>
 */
class TipoUserFactory extends Factory
{
    protected $model = TipoUser::class;
    
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'nome' => $this->faker->randomElement([
                'administrador',
                'usuario'
            ]),
        ];
    }
}
