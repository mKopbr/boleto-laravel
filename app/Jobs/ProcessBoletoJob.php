<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class ProcessBoletoJob implements ShouldQueue
{
    use InteractsWithQueue, Queueable, SerializesModels;

    protected $lines;
    protected $index;
    protected $jobId;

    public function __construct($lines, $index, $jobId)
    {
        $this->lines = $lines;
        $this->index = $index;
        $this->jobId = $jobId;
    }

    public function handle()
    {
        foreach ($this->lines as $line) {
            $data = str_getcsv($line);

            if (count($data) < 6) {
                Log::warning("Linha inválida: " . json_encode($data));
                continue;
            }

            [$name, $governmentId, $email, $debtAmount, $debtDueDate, $debtID] = $data;

            // Simula a geração do boleto e envio de email
            Log::info("Boleto gerado para: {$name}, valor: R$ {$debtAmount}");
            Log::info("Email enviado para: {$email}");
        }

        // Incrementar o progresso no cache
        Cache::increment($this->jobId . '_progress');
        Log::info("Progresso atualizado para: " . Cache::get($this->jobId . '_progress'));
    }
}