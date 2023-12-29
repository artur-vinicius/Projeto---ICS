<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Receber os dados do formulário
    $nome_sala = $_POST["nome_sala"];
    $capacidade = $_POST["capacidade"];
    $tipo_sala = $_POST["tipo_sala"];

    // Aqui você pode realizar operações de inserção no banco de dados ou armazenamento dos dados.

    // Exemplo de exibição dos dados cadastrados
    echo "<h2>Sala cadastrada com sucesso!</h2>";
    echo "<p><strong>Nome da Sala:</strong> $nome_sala</p>";
    echo "<p><strong>Capacidade:</strong> $capacidade</p>";
    echo "<p><strong>Tipo de Sala:</strong> $tipo_sala</p>";

    // Adicionando um link para http://projeto.com.br/reserva.php
    echo '<p><a href="http://projeto.com.br/reserva.php">Clique aqui para reservar esta sala</a></p>';

    exit();
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro de Salas</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }
        /* Adicionando estilo para o título no topo fora do contêiner */
        h1 {
            text-align: center;
            color: #8B4513; /* Cor marrom */
            margin: 20px 0; /* Espaçamento */
        }
        .container {
            max-width: 600px;
            margin: 50px auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        label {
            display: block;
            margin-bottom: 8px;
        }
        input, select {
            width: 100%;
            padding: 8px;
            margin-bottom: 16px;
            box-sizing: border-box;
        }
        button {
            background-color: #4caf50;
            color: #fff;
            padding: 10px 15px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
        }
    </style>
</head>
<body>

<!-- Título no topo fora do contêiner -->
<h1>Locus</h1>

<div class="container">
    <h2>Cadastro de Salas</h2>
    <form action="index.php" method="post">
        <label for="nome_sala">Nome da Sala:</label>
        <input type="text" id="nome_sala" name="nome_sala" required>

        <label for="capacidade">Capacidade:</label>
        <input type="number" id="capacidade" name="capacidade" required>

        <label for="tipo_sala">Tipo de Sala:</label>
        <select id="tipo_sala" name="tipo_sala" required>
            <option value="auditorio">Auditório</option>
            <option value="sala_reuniao">Sala de Reunião</option>
            <option value="sala_aula">Sala de Aula</option>
        </select>

        <button type="submit">Cadastrar Sala</button>
    </form>
</div>

</body>
</html>
