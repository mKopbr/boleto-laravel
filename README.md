
# Projeto de Processamento de Boletos e Envio de Emails

Este projeto foi desenvolvido em **Laravel** e processa arquivos CSV para gerar boletos e enviar emails simulados. O sistema foi projetado para lidar com arquivos grandes e pode ser retomado em caso de falhas. As operações são simuladas e registradas nos logs para garantir controle e monitoramento.

---

## Requisitos

- PHP 8+
- Composer
- XAMPP ou qualquer servidor com MySQL e Apache
- Redis (opcional para ambiente avançado)

---

## Instalação e Configuração

1. **Clone o projeto:**
   ```bash
   git clone https://github.com/seu-usuario/seu-repositorio.git
   cd seu-repositorio
   ```

2. **Instale as dependências do Laravel:**
   ```bash
   composer install
   ```

3. **Crie o arquivo `.env`:**
   ```bash
   cp .env.example .env
   ```

4. **Configure o banco de dados:**
   - Abra o arquivo `.env` e configure a seção do banco de dados:
     ```env
     DB_CONNECTION=mysql
     DB_HOST=127.0.0.1
     DB_PORT=3306
     DB_DATABASE=seu_banco
     DB_USERNAME=seu_usuario
     DB_PASSWORD=sua_senha
     ```

5. **Execute as migrations:**
   ```bash
   php artisan migrate
   ```

6. **Gere a chave da aplicação:**
   ```bash
   php artisan key:generate
   ```

---

## Como Executar

1. **Inicie o servidor local:**
   ```bash
   php artisan serve
   ```

2. **Execute o worker de filas:**
   ```bash
   php artisan queue:work
   ```

3. **Acesse a interface de upload de CSV:**
   Abra o navegador e vá para:
   ```
   http://127.0.0.1:8000/upload
   ```

4. **Envie um arquivo CSV:**
   - O sistema irá processar o CSV e gerar boletos e emails simulados.
   - Verifique o log em `storage/logs/laravel.log` para confirmar o processamento.

---

## Testes

1. **Configuração para Testes:**
   No arquivo `.env.testing`, configure:
   ```env
   DB_CONNECTION=sqlite
   DB_DATABASE=:memory:
   ```

2. **Executar todos os testes:**
   ```bash
   php artisan test
   ```

3. **Executar um teste específico:**
   ```bash
   php artisan test --filter=BoletoIntegrationTest
   ```

4. **Verificar os logs de testes:**
   - Os testes simulam a geração de boletos e o envio de emails.
   - Verifique os logs para garantir que as operações foram registradas corretamente.

---

## Estrutura do Projeto

- **app/Jobs/ProcessBoletoJob.php**: Contém a lógica de processamento do boleto e envio de email.
- **app/Http/Controllers/BoletoController.php**: Controla o upload do CSV e o processamento em filas.
- **tests/Feature/BoletoIntegrationTest.php**: Teste de integração para garantir o processamento correto.
- **tests/Unit/BoletoUnitTest.php**: Teste unitário para verificar a geração de boletos.

---

## Logs

- As operações de geração de boletos e envio de emails são registradas no log em:
  ```
  storage/logs/laravel.log
  ```
- Exemplo de log:
  ```
  [2024-10-12 15:30:45] local.INFO: Boleto gerado para: João da Silva (ID: debt-123), valor: R$ 1000.50
  [2024-10-12 15:30:45] local.INFO: Email enviado para: joao@example.com com link do boleto: http://boleto.api/fake/debt-123
  ```

---

## Troubleshooting (Solução de Problemas)

- **Erro: "Class Redis not found"**:
  - Solução: Verifique se o driver de filas está definido como `database` no `.env`:
    ```env
    QUEUE_CONNECTION=database
    ```

- **Erro: "SQLSTATE[HY000]: General error: 1 table 'jobs' already exists"**:
  - Solução: Rode as migrations novamente com:
    ```bash
    php artisan migrate:fresh --env=testing
    ```

---

## Licença

Este projeto está licenciado sob a [MIT License](https://opensource.org/licenses/MIT).

---

## Contribuição

Contribuições são bem-vindas! Sinta-se à vontade para abrir **Issues** ou enviar **Pull Requests**.
