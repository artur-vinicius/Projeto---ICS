<?php
include 'conexao.php';

// Função para obter dados da sala
function obterDadosSala($conn, $numero_sala) {
    $sql = "SELECT * FROM Sala WHERE Número = $numero_sala";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        return $result->fetch_assoc();
    } else {
        return false;
    }
}

// Ação de editar sala
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['editar_sala'])) {
        $numero_sala_editar = $_POST['numero_sala_editar'];
        $reservado_editar = isset($_POST['reservado_editar']) ? 1 : 0;
        $nome_sala_editar = $_POST['nome_sala_editar'];

        // Atualizar os dados da sala no banco de dados
        $sql = "UPDATE Sala SET Reservado = ?, Nome = ? WHERE Número = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("isi", $reservado_editar, $nome_sala_editar, $numero_sala_editar);
        $stmt->execute();
        $stmt->close();

        header("Location: salas.php");
        exit();
    } elseif (isset($_POST['submit_cadastro'])) {
        $numero_sala = $_POST['numero_sala'];
        $reservado = isset($_POST['reservado']) ? 1 : 0;
        $nome_sala = $_POST['nome_sala'];

        // Inserir a sala no banco de dados
        $sql = "INSERT INTO Sala (Número, Reservado, Nome) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("iis", $numero_sala, $reservado, $nome_sala);
        $stmt->execute();
        $stmt->close();

        header("Location: salas.php");
        exit();
    }
}

// Verificar ação de exclusão
if (isset($_GET['acao']) && $_GET['acao'] == 'excluir' && isset($_GET['numero'])) {
    $numero_sala_excluir = $_GET['numero'];

    // Excluir a sala do banco de dados
    $sql = "DELETE FROM Sala WHERE Número=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $numero_sala_excluir);
    $stmt->execute();
    $stmt->close();

    header("Location: salas.php");
    exit();
}

// Ação de edição (carregar dados)
if (isset($_GET['acao']) && $_GET['acao'] == 'editar' && isset($_GET['numero'])) {
    $numero_sala_editar = $_GET['numero'];
    $dados_sala_editar = obterDadosSala($conn, $numero_sala_editar);

    if ($dados_sala_editar) {
        $reservado_checked = $dados_sala_editar['Reservado'] ? 'checked' : '';
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CRUD de Salas</title>
    <style>
        /* Estilo CSS aqui */
        body {
            background-color: #f2f2f2;
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }

        h2 {
            background-color: #800080;
            color: #fff;
            text-align: center;
            padding: 20px;
            margin: 0;
        }

        form {
            width: 50%;
            margin: 20px auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        table {
            width: 80%;
            margin: 20px auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        th, td {
            padding: 10px;
            text-align: left;
        }

        th {
            background-color: #800080;
            color: #fff;
        }

        tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        tr:hover {
            background-color: #f1f1f1;
        }

        button {
            background-color: #800080;
            color: #fff;
            padding: 10px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
    </style>
</head>
<body>

<h2>LOCUS - SALA</h2>

<!-- Formulário de Cadastro -->
<form action="salas.php" method="post">
    <label for="numero_sala">Número da Sala:</label>
    <input type="text" name="numero_sala" required>

    <label for="reservado">Reservado:</label>
    <input type="checkbox" name="reservado">

    <label for="nome_sala">Nome da Sala:</label>
    <input type="text" name="nome_sala" required>

    <button type="submit" name="submit_cadastro">Cadastrar Sala</button>
</form>

<!-- Formulário de Edição -->
<?php if (isset($dados_sala_editar)) { ?>
    <h3>Editar Sala</h3>
    <form action="salas.php" method="post">
        <input type="hidden" name="numero_sala_editar" value="<?= $dados_sala_editar['Número'] ?>">

        <label for="reservado_editar">Reservado:</label>
        <input type="checkbox" name="reservado_editar" <?= $reservado_checked ?>>

        <label for="nome_sala_editar">Nome da Sala:</label>
        <input type="text" name="nome_sala_editar" value="<?= $dados_sala_editar['Nome'] ?>" required>

        <button type="submit" name="editar_sala">Salvar Edição</button>
    </form>
<?php } ?>

<h3 style='text-align: center; margin: 2em'>Lista de Salas</h3>
<table border="1">
    <tr>
        <th>Número</th>
        <th>Reservado</th>
        <th>Nome da Sala</th>
        <th>Ações</th>
    </tr>

    <?php
    // Consulta para obter a lista de salas
    $result = $conn->query("SELECT * FROM Sala");

    while ($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . $row["Número"] . "</td>";
        echo "<td>" . ($row["Reservado"] ? 'Sim' : 'Não') . "</td>";
        echo "<td>" . $row["Nome"] . "</td>";
        echo "<td><a href='salas.php?acao=excluir&numero=" . $row["Número"] . "'>Excluir</a> | <a href='salas.php?acao=editar&numero=" . $row["Número"] . "'>Editar</a></td>";
        echo "</tr>";
    }
    ?>
</table>

<a href='../projeto.com.br/reserva.php'>Fazer reserva</a>

</body>
</html>
