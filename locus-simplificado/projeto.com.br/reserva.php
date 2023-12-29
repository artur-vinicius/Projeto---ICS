<?php
// Verifica se há um parâmetro na URL indicando para recarregar a página
$reload = isset($_GET['reload']) ? $_GET['reload'] : false;

// Variáveis para armazenar os dados de reserva
$nome_sala = $data_reserva = $hora_reserva = $nome_responsavel = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Receber os dados do formulário
    $nome_sala = $_POST["nome_sala"];
    $data_reserva = $_POST["data_reserva"];
    $hora_reserva = $_POST["hora_reserva"];
    $nome_responsavel = $_POST["nome_responsavel"];

    // Aqui você pode realizar operações de reserva, como armazenar no banco de dados.
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reserva de Salas</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
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
        select, input {
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
        /* Adicionando estilo para o título "Locus" */
        h1 {
            text-align: center;
            color: #8B4513; /* Cor marrom */
            margin-top: 30px;
        }
        /* Adicionando estilo para a mensagem de confirmação de reserva */
        .confirmacao {
            margin-top: 20px;
            border: 1px solid #4caf50;
            background-color: #e7f3e1;
            padding: 10px;
            border-radius: 4px;
        }
    </style>
</head>
<body>

<!-- Título "Locus" -->
<h1>Locus</h1>

<div class="container">
    <h2>Reserva de Salas</h2>
    <form action="reserva.php" method="post">
        <label for="nome_sala">Selecione a Sala:</label>
        <select id="nome_sala" name="nome_sala" required>
            <!-- Substitua os valores abaixo pelos nomes reais das salas cadastradas -->
            <option value="sala1">Sala 1</option>
            <option value="sala2">Sala 2</option>
            <option value="sala3">Sala 3</option>
        </select>

        <label for="data_reserva">Data da Reserva:</label>
        <input type="date" id="data_reserva" name="data_reserva" required>

        <label for="hora_reserva">Hora da Reserva:</label>
        <input type="time" id="hora_reserva" name="hora_reserva" required>

        <label for="nome_responsavel">Seu Nome:</label>
        <input type="text" id="nome_responsavel" name="nome_responsavel" required>

        <button type="submit">Reservar Sala</button>
    </form>

    <?php
    // Exibição da sala reservada com sucesso abaixo do formulário
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        echo '<div class="confirmacao">';
        echo "<h2>Reserva realizada com sucesso!</h2>";
        echo "<p><strong>Sala:</strong> $nome_sala</p>";
        echo "<p><strong>Data da Reserva:</strong> $data_reserva</p>";
        echo "<p><strong>Hora da Reserva:</strong> $hora_reserva</p>";
        echo "<p><strong>Responsável pela Reserva:</strong> $nome_responsavel</p>";
        echo '</div>';
    }
    ?>

    <!-- Adicionando um link para reiniciar a página -->
    <p><a href="?reload=true">Voltar ao Começo</a></p>
</div>

</body>
</html>
