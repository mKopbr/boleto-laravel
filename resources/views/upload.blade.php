<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upload CSV</title>
</head>
<body>
    <h1>Processar CSV</h1>

    <!-- Formulário para upload do CSV -->
    <form action="/process-csv" method="POST" enctype="multipart/form-data">
        @csrf
        <input type="file" name="csv" required>
        <button type="submit">Enviar CSV</button>
    </form>

    <hr>

    <h2>Retomar Processamento</h2>
    <!-- Formulário para retomar o processamento -->
    <form action="/resume-processing" method="POST">
        @csrf
        <label for="jobId">ID do Job:</label>
        <input type="text" name="jobId" required>
        <button type="submit">Retomar</button>
    </form>
</body>
</html>
