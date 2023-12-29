<?php
$servername = "localhost";
$username = "locus";
$password = "locus";
$dbname = "Locus";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Falha na conexão com o banco de dados: " . $conn->connect_error);
}

function adicionarSala($num, $reservado, $nome) {
    global $conn;
    $stmt = $conn->prepare("INSERT INTO Sala (Num, Reservado, Nome) VALUES (?, ?, ?)");
    $stmt->bind_param("iss", $num, $reservado, $nome);
    $stmt->execute();
    $stmt->close();
}

function obterSalas() {
    global $conn;
    $result = $conn->query("SELECT * FROM Sala");
    return $result->fetch_all(MYSQLI_ASSOC);
}

function obterSalaPorNumero($num) {
    global $conn;
    $stmt = $conn->prepare("SELECT * FROM Sala WHERE Num = ?");
    $stmt->bind_param("i", $num);
    $stmt->execute();
    $result = $stmt->get_result();
    $stmt->close();
    return $result->fetch_assoc();
}

function atualizarSala($num, $reservado, $nome) {
    global $conn;
    $stmt = $conn->prepare("UPDATE Sala SET Reservado=?, Nome=? WHERE Num=?");
    $stmt->bind_param("ssi", $reservado, $nome, $num);
    $stmt->execute();
    $stmt->close();
}
function excluirSala($num) {
    global $conn;
    $stmt = $conn->prepare("DELETE FROM Sala WHERE Num = ?");
    $stmt->bind_param("i", $num);
    $stmt->execute();
    $stmt->close();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["adicionar"])) {
        adicionarSala($_POST["num"], $_POST["reservado"], $_POST["nome"]);
    } elseif (isset($_POST["atualizar"])) {
        atualizarSala($_POST["num"], $_POST["reservado"], $_POST["nome"]);
    } elseif (isset($_POST["excluir"])) {
        excluirSala($_POST["num"]);
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CRUD de Salas</title>
</head>

<body>

    <h2>Cadastro de Salas</h2>

    <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
        Número da Sala: <input type="text" name="num" required><br>
        Reservado (0 ou 1): <input type="text" name="reservado" required><br>
        Nome da Sala: <input type="text" name="nome" required><br>
        <input type="submit" name="adicionar" value="Adicionar">
        <input type="submit" name="atualizar" value="Atualizar">
    </form>

    <br>

    <h3>Lista de Salas</h3>
    <table border="1">
        <tr>
            <th>Número</th>
            <th>Reservado</th>
            <th>Nome</th>
            <th>Ações</th>
        </tr>
        <?php
        $salas = obterSalas();
        foreach ($salas as $sala) {
            echo "<tr>";
            echo "<td>{$sala['Num']}</td>";
            echo "<td>{$sala['Reservado']}</td>";
            echo "<td>{$sala['Nome']}</td>";
            echo "<td><a href=\"{$_SERVER['PHP_SELF']}?edit={$sala['Num']}\">Editar</a> | <a href=\"{$_SERVER['PHP_SELF']}?delete={$sala['Num']}\">Excluir</a></td>";
            echo "</tr>";
        }
        ?>
    </table>

    <?php
    if (isset($_GET['edit'])) {
        $numEdicao = $_GET['edit'];
        $salaEdicao = obterSalaPorNumero($numEdicao);
    ?>
        <br>
        <h3>Editar Sala</h3>
        <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
            Número da Sala: <input type="text" name="num" value="<?php echo $salaEdicao['Num']; ?>" readonly><br>
            Reservado (0 ou 1): <input type="text" name="reservado" value="<?php echo $salaEdicao['Reservado']; ?>" required><br>
            Nome da Sala: <input type="text" name="nome" value="<?php echo $salaEdicao['Nome']; ?>" required><br>
            <input type="submit" name="atualizar" value="Atualizar">
        </form>
    <?php
    }
    ?>

</body>

</html>
