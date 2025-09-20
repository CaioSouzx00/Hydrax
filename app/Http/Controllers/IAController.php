<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Symfony\Component\Process\Process;
use Illuminate\Support\Facades\Log;

class IAController extends Controller
{
    public function buscar(Request $request)
    {
        $prompt = $request->input('prompt');
        $python = 'C:\\Users\\caiod\\AppData\\Local\\Programs\\Python\\Python311\\python.exe';
        $caminhoPython = base_path('ia_multimodal/busca.py');

        Log::info("Prompt recebido: $prompt");

        $process = new Process([$python, $caminhoPython, $prompt]);
        $process->setTimeout(300); // aumenta timeout se necessário

        try {
            $process->run();

            if (!$process->isSuccessful()) {
                $error = $process->getErrorOutput() ?: $process->getOutput();
                Log::error("Erro Python: $error");
                return response()->json([
                    'error' => 'Erro ao executar Python',
                    'detalhes' => $error
                ], 500);
            }

            $output = trim($process->getOutput());
            Log::info("Saída Python bruta: [$output]");

            $produtos = json_decode($output, true);
            if (json_last_error() !== JSON_ERROR_NONE) {
                Log::error('JSON inválido: ' . json_last_error_msg());
                return response()->json([
                    'error' => 'JSON inválido',
                    'detalhes' => json_last_error_msg(),
                    'saida' => $output
                ], 500);
            }

            array_walk_recursive($produtos, function (&$item) {
                if (is_string($item)) {
                    $item = mb_convert_encoding($item, 'UTF-8', 'UTF-8');
                }
            });

            return response()->json($produtos);

        } catch (\Exception $e) {
            Log::error('Exceção PHP: ' . $e->getMessage());
            return response()->json([
                'error' => 'Erro interno',
                'detalhes' => $e->getMessage()
            ], 500);
        }
    }
}