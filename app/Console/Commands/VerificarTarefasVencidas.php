<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use App\Models\Tarefa;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class VerificarTarefasVencidas extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:verificar-tarefas-vencidas';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $hoje = Carbon::today()->toDateString();

        $tarefasVencidas = Tarefa::where('data_tarefa', '<', $hoje)
            ->whereHas('status', function ($q) {
                $q->where('nome', '!=', 'Concluída');
            })
            ->get();

        foreach ($tarefasVencidas as $tarefa) {

            Log::info("Tarefa atrasada: {$tarefa->titulo} (ID {$tarefa->id})");
        }

        $this->info("Verificação concluída. Total atrasadas: " . $tarefasVencidas->count());
    }
}
