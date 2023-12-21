<?php
$servername = "localhost";
$username = "seu_usuario";
$password = "sua_senha";
$database = "Locus";

// Conexão com o banco de dados
$conn = new mysqli($servername, $username, $password, $database);

// Verificação da conexão
if ($conn->connect_error) {
    die("Falha na conexão: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id_sala = $_POST['id_sala'];
    $novo_numero_sala = $_POST['novo_numero_sala'];
    $novo_reservado = isset($_POST['novo_reservado']) ? 1 : 0;
    $novo_nome_sala = $_POST['novo_nome_sala'];

    $sqlUpdate = "UPDATE Sala SET Número='$novo_numero_sala', `Reservado?`='$novo_reservado', Nome='$novo_nome_sala' WHERE Número='$id_sala'";

    if ($conn->query($sqlUpdate) === TRUE) {
        echo "Sala atualizada com sucesso.";
    } else {
        echo "Erro ao atualizar sala: " . $conn->error;
    }
}

$conn->close();
?>
