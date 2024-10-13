<?php
namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
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
            [$name, $governmentId, $email, $debtAmount, $debtDueDate, $debtID] = $line;

            // Mocando a geração do boleto
            $boleto = $this->generateBoleto($name, $governmentId, $debtAmount, $debtDueDate, $debtID);

            // Simulando envio de email e registrando no log
            $this->sendEmail($email, $boleto);

            // Log de cada boleto processado
            Log::info("Boleto gerado para: {$name} (ID: {$debtID}), valor: R$ {$debtAmount}");
        }

        // Log do progresso
        Log::info("Job {$this->jobId} - Bloco {$this->index} processado com sucesso.");
    }

    protected function generateBoleto($name, $governmentId, $debtAmount, $debtDueDate, $debtID)
    {
        // Simulando a geração do boleto
        return [
            'name' => $name,
            'governmentId' => $governmentId,
            'debtAmount' => $debtAmount,
            'debtDueDate' => $debtDueDate,
            'debtID' => $debtID,
            'boletoURL' => "http://boleto.api/fake/{$debtID}",
        ];
    }

    protected function sendEmail($email, $boleto)
    {
        // Simulando envio de email e registrando no log
        Log::info("Email enviado para: {$email} com link do boleto: {$boleto['boletoURL']}");
    }
}