<?php
$servername = "localhost";
$username = "seu_usuario";
$password = "sua_senha";
$database = "Locus";

$conn = new mysqli($servername, $username, $password, $database);

if ($conn->connect_error) {
    die("Falha na conexão: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id_sala = $_POST['id_sala'];

    $sqlDelete = "DELETE FROM Sala WHERE Número='$id_sala'";

    if ($conn->query($sqlDelete) === TRUE) {
        echo "Sala deletada com sucesso.";
    } else {
        echo "Erro ao deletar sala: " . $conn->error;
    }
}

$conn->close();
?>
