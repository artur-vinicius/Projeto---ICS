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

// Consulta para obter os dados da tabela Sala
$sqlSelect = "SELECT * FROM Sala";
$result = $conn->query($sqlSelect);

if ($result->num_rows > 0) {
    // Exibição dos dados em uma tabela HTML
    while($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . $row["Número"] . "</td>";
        echo "<td>" . ($row["Reservado?"] ? 'Sim' : 'Não') . "</td>";
        echo "<td>" . $row["Nome"] . "</td>";
        echo "</tr>";
    }
} else {
    echo "<tr><td colspan='3'>Nenhum resultado encontrado na tabela Sala.</td></tr>";
}

// Fechamento da conexão
$conn->close();
?>
