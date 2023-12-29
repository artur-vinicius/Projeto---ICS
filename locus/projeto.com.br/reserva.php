<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <title>Cadastro de reservas</title>
</head>
<body>
  <h1>Cadastro de reservas</h1>

  <?php

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
      $nome = $_POST["nome"];
      $sala = $_POST["sala"];
      $data = $_POST["data"];
      $horario = $_POST["horario"];

      $mysqli = new mysqli("localhost", "root", "", "cadastro_salas");
      if ($mysqli->connect_error) {
        die("Erro ao conectar ao banco de dados: " . $mysqli->connect_error);
      }

      $stmt = $mysqli->prepare("INSERT INTO reservas (nome, sala, data, horario) VALUES (?, ?, ?, ?)");

      $stmt->bind_param("ssss", $nome, $sala, $data, $horario);

      if ($stmt->execute()) {
        echo "Reserva cadastrada com sucesso!";
      } else {
        echo "Erro ao cadastrar reserva: " . $mysqli->error;
      }

      $stmt->close();

      $mysqli->close();
    }

  ?>

  <form action="cadastro-reservas.php" method="post">
    <input type="text" name="nome" placeholder="Nome do responsável pela reserva">
    <select name="sala">
      <?php
        $mysqli = new mysqli("localhost", "root", "", "cadastro_salas");
        $stmt = $mysqli->prepare("SELECT nome FROM salas");
        $stmt->execute();
        $result = $stmt->get_result();
        while ($row = $result->fetch_assoc()) {
          echo "<option value='" . $row["nome"] . "'>" . $row["nome"] . "</option>";
        }
        $mysqli->close();
      ?>
    </select>
    <input type="date" name="data" placeholder="Data da reserva">
    <input type="time" name="horario" placeholder="Horário da reserva">
    <input type="submit" value="Cadastrar">
  </form>
</body>
</html>
