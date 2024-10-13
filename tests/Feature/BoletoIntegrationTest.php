<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Illuminate\Support\Facades\Queue;
use App\Jobs\ProcessBoletoJob;
use Illuminate\Http\UploadedFile;

class BoletoIntegrationTest extends TestCase
{
    // Garante que o banco será resetado antes de cada teste
    use RefreshDatabase;

    /**
     * Teste para verificar se a API processa o CSV e dispara a job corretamente.
     */
    public function test_csv_process_dispatches_jobs()
    {
        // Simula as filas para evitar execução real
        Queue::fake();

        // Cria um arquivo CSV temporário para o teste
        $file = UploadedFile::fake()->create('test.csv', 1, 'text/csv');

        // Faz a chamada para a rota de processamento do CSV
        $response = $this->post('/process-csv', [
            'csv' => $file,
        ]);

        // Verifica se a resposta tem status 200 e contém a estrutura esperada
        $response->assertStatus(200);
        $response->assertJsonStructure(['message', 'jobId']);

        // Verifica se a job foi enfileirada
        Queue::assertPushed(ProcessBoletoJob::class);
    }
}