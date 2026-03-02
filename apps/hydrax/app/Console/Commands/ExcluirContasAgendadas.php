<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Usuario;
use Illuminate\Support\Carbon;

class ExcluirContasAgendadas extends Command
{
    protected $signature = 'usuarios:limpar-exclusoes';
    protected $description = 'Exclui automaticamente contas agendadas para deleção';

  public function handle(): void
{
    $usuarios = Usuario::whereNotNull('data_exclusao_agendada')
        ->where('data_exclusao_agendada', '<=', now())
        ->get();

    if ($usuarios->isEmpty()) {
        $this->info("Nenhum usuário para excluir no momento.");
        return;
    }

    foreach ($usuarios as $usuario) {
        $this->info("Excluindo usuário ID: {$usuario->id_usuarios}");
        $usuario->delete();
    }

    $this->info("Exclusão concluída.");
}


    
}