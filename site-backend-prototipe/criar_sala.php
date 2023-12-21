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
    $numero_sala = $_POST['numero_sala'];
    $reservado = isset($_POST['reservado']) ? 1 : 0;
    $nome_sala = $_POST['nome_sala'];

    $sqlInsert = "INSERT INTO Sala (Número, `Reservado?`, Nome) VALUES ('$numero_sala', '$reservado', '$nome_sala')";

    if ($conn->query($sqlInsert) === TRUE) {
        echo "Sala adicionada com sucesso.";
    } else {
        echo "Erro ao adicionar sala: " . $conn->error;
    }
}

$conn->close();
?>
