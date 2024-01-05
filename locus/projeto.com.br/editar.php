<?php
include 'conexao.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id_reserva = $_POST['id_reserva'];
    $id_sala = $_POST['id_sala'];
    $data_reserva = $_POST['data_reserva'];
    $hora_reserva = $_POST['hora_reserva'];

    // Combine a data e a hora em um formato adequado para o banco de dados
    $data_hora_reserva = "$data_reserva $hora_reserva";

    // Atualizar a reserva no banco de dados
    $sql = "UPDATE Reserva SET Dt_Hr='$data_hora_reserva', ID='$id_sala' WHERE IdReserva='$id_reserva'";
    $conn->query($sql);

    header("Location: reserva.php");
    exit();
}

// Obter o ID da reserva da URL
if (isset($_GET['id_reserva'])) {
    $id_reserva = $_GET['id_reserva'];

    // Consulta para obter os detalhes da reserva
    $result = $conn->query("SELECT * FROM Reserva WHERE IdReserva='$id_reserva'");
    $reserva = $result->fetch_assoc();

    // Consulta para obter a lista de salas
    $result = $conn->query("SELECT * FROM Sala");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Reserva</title>
    <style>
        /* Adicione seu CSS conforme necessário */
    </style>
</head>
<body>

<h2>Editar Reserva</h2>

<!-- Formulário de Edição -->
<form action="editar_reserva.php" method="post">
    <input type="hidden" name="id_reserva" value="<?php echo $id_reserva; ?>">
    
    <label for="id_sala">Sala:</label>
    <select name="id_sala" required>
        <?php
        while ($row = $result->fetch_assoc()) {
            $selected = ($row["Número"] == $reserva["ID"]) ? "selected" : "";
            echo "<option value='" . $row["Número"] . "' $selected>" . $row["Nome"] . "</option>";
        }
        ?>
    </select>

    <label for="data_reserva">Data da Reserva:</label>
    <input type="date" name="data_reserva" value="<?php echo date('Y-m-d', strtotime($reserva['Dt_Hr'])); ?>" required>

    <label for="hora_reserva">Hora da Reserva:</label>
    <input type="time" name="hora_reserva" value="<?php echo date('H:i', strtotime($reserva['Dt_Hr'])); ?>" required>

    <button type="submit" name="submit_edicao">Salvar Edição</button>
</form>

</body>
</html>
