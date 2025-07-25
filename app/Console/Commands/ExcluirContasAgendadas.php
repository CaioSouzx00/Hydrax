<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use Illuminate\Support\Carbon;

class ExcluirContasAgendadas extends Command
{
    protected $signature = 'usuarios:limpar-exclusoes';
    protected $description = 'Exclui automaticamente contas agendadas para deleção';

    public function handle(): void
    {
        $excluidos = User::whereNotNull('data_exclusao_agendada')
            ->where('data_exclusao_agendada', '<=', now())
            ->delete();

        $this->info("{$excluidos} contas excluídas.");
    }
}