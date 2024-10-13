<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use App\Jobs\ProcessBoletoJob;

class BoletoController extends Controller
{
    public function processCsv(Request $request)
    {
        $file = $request->file('csv');

        if (!$file->isValid()) {
            return response()->json(['error' => 'Invalid file.'], 400);
        }

        $path = $file->getRealPath();
        $lines = file($path);

        $chunkSize = 1000; // Processar em blocos de 1000 linhas
        $chunks = array_chunk($lines, $chunkSize);
        $jobId = uniqid();

        Cache::put($jobId . '_total', count($chunks));

        foreach ($chunks as $index => $chunk) {
            dispatch(new ProcessBoletoJob($chunk, $index, $jobId));
        }

        return response()->json(['message' => 'Processamento iniciado.', 'jobId' => $jobId]);
    }

    public function resumeProcessing(Request $request)
    {
        $jobId = $request->input('jobId');

        // Recuperar progresso e total de blocos a serem processados
        $progress = Cache::get($jobId . '_progress', 0);
        $total = Cache::get($jobId . '_total', 0);

        if ($progress >= $total) {
            return response()->json(['message' => 'Processamento já foi concluído.']);
        }

        // Retomar o processamento dos blocos restantes
        $file = storage_path("app/public/your_large_file.csv"); // Ajuste o caminho conforme necessário
        $lines = file($file);
        $chunkSize = 1000;
        $chunks = array_chunk($lines, $chunkSize);

        $remainingChunks = array_slice($chunks, $progress);
        foreach ($remainingChunks as $index => $chunk) {
            dispatch(new ProcessBoletoJob($chunk, $progress + $index, $jobId));
        }

        return response()->json(['message' => 'Processamento retomado a partir do bloco ' . $progress]);
    }
}