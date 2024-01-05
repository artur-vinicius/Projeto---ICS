<?php
include 'conexao.php';

// Função para obter o nome da sala
function obterNomeSala($conn, $id_sala) {
    $sql = "SELECT Nome FROM Sala WHERE Número = $id_sala";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $nome_sala = $row["Nome"];
    } else {
        $nome_sala = "Sala não encontrada";
    }

    return $nome_sala;
}

// Função para obter dados da reserva
function obterDadosReserva($conn, $id_reserva) {
    $sql = "SELECT ID, Dt_Hr FROM Reserva WHERE ID = $id_reserva";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        return $result->fetch_assoc();
    } else {
        return false;
    }
}

// Ação de editar reserva
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['editar_reserva'])) {
    $id_reserva_editar = $_POST['id_reserva_editar'];
    $id_sala_editar = $_POST['id_sala_editar'];
    $data_reserva_editar = $_POST['data_reserva_editar'];
    $hora_reserva_editar = $_POST['hora_reserva_editar'];

    $data_hora_reserva_editar = date("Y-m-d H:i:s", strtotime("$data_reserva_editar $hora_reserva_editar"));

    // Atualizar os dados da reserva no banco de dados
    $sql = "UPDATE Reserva SET Dt_Hr = '$data_hora_reserva_editar', ID = '$id_sala_editar' WHERE ID = $id_reserva_editar";
    $conn->query($sql);

    header("Location: reserva.php");
    exit();
}

// Ação de excluir reserva
if (isset($_GET['acao']) && $_GET['acao'] == 'excluir' && isset($_GET['id_reserva'])) {
    $id_reserva_excluir = $_GET['id_reserva'];

    // Excluir a reserva do banco de dados
    $sql = "DELETE FROM Reserva WHERE ID = $id_reserva_excluir";
    $conn->query($sql);

    header("Location: reserva.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CRUD de Reservas</title>
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

<h2>LOCUS - RESERVAS</h2>


<!-- Formulário de Reserva -->
<form action="reserva.php" method="post">
    <label for="id_sala">Sala:</label>
    <select name="id_sala" required>
        <?php
        // Consulta para obter a lista de salas
        $result = $conn->query("SELECT Número, Nome FROM Sala");

        while ($row = $result->fetch_assoc()) {
            echo "<option value='{$row["Número"]}'>{$row["Nome"]}</option>";
        }
        ?>
    </select>

    <label for="data_reserva">Data da Reserva:</label>
    <input type="date" name="data_reserva" required>

    <label for="hora_reserva">Hora da Reserva:</label>
    <input type="time" name="hora_reserva" required>

    <button type="submit" name="submit_reserva">Reservar Sala</button>
</form>

<h3 style='text-align: center'>Lista de Reservas</h3>
<table border="1">
    <tr>
        <th>ID</th>
        <th>Sala</th>
        <th>Data e Hora da Reserva</th>
        <th>Ações</th>
    </tr>

    <?php
    // Consulta para obter a lista de reservas
    $result = $conn->query("SELECT ID, Dt_Hr FROM Reserva");

    while ($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>{$row["ID"]}</td>";
        echo "<td>" . obterNomeSala($conn, $row["ID"]) . "</td>";
        echo "<td>{$row["Dt_Hr"]}</td>";
        echo "<td><a href='reserva.php?acao=excluir&id_reserva={$row["ID"]}'>Excluir</a> | <a href='reserva.php?acao=editar&id_reserva={$row["ID"]}'>Editar</a></td>";
        echo "</tr>";
    }
    ?>
</table>

<a href='../projeto.backend.biz/salas.php'>Cadastrar salas</a>




<?php
if (isset($_GET['acao']) && $_GET['acao'] == 'editar' && isset($_GET['id_reserva'])) {
    $id_reserva_editar = $_GET['id_reserva'];
    $dados_reserva = obterDadosReserva($conn, $id_reserva_editar);

    if ($dados_reserva) {
        ?>
        <h3>Editar Reserva</h3>
        <form action="reserva.php" method="post">
            <input type="hidden" name="id_reserva_editar" value="<?= $dados_reserva['ID'] ?>">

            <label for="id_sala_editar">Sala:</label>
            <select name="id_sala_editar" required>
                <?php
                // Consulta para obter a lista de salas
                $result = $conn->query("SELECT Número, Nome FROM Sala");

                while ($row = $result->fetch_assoc()) {
                    $selected = ($row["Número"] == $dados_reserva['ID']) ? 'selected' : '';
                    echo "<option value='{$row["Número"]}' $selected>{$row["Nome"]}</option>";
                }
                ?>
            </select>

            <label for="data_reserva_editar">Data da Reserva:</label>
            <input type="date" name="data_reserva_editar" value="<?= date('Y-m-d', strtotime($dados_reserva['Dt_Hr'])) ?>" required>

            <label for="hora_reserva_editar">Hora da Reserva:</label>
            <input type="time" name="hora_reserva_editar" value="<?= date('H:i', strtotime($dados_reserva['Dt_Hr'])) ?>" required>

            <button type="submit" name="editar_reserva">Salvar Edição</button>
        </form>
        <?php
    }
}
?>

</body>
</html>
