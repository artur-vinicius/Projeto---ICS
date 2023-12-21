<?php
$servername = "localhost";
$username = "seu_usuario";
$password = "sua_senha";
$database = "Locus";

$conn = new mysqli($servername, $username, $password, $database);

if ($conn->connect_error) {
    die("Falha na conexão: " . $conn->connect_error);
}

$sqlSelect = "SELECT * FROM Sala";
$result = $conn->query($sqlSelect);

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        echo "Número: " . $row["Número"]. " - Reservado: " . $row["Reservado?"]. " - Nome: " . $row["Nome"]. "<br>";
    }
} else {
    echo "Nenhum resultado encontrado na tabela Sala.";
}

$conn->close();
?>
