<?php
// Caminho para o arquivo de conexão
require('../../../acesso_bd.php');


$connection = conectaPDOAnalytics();
$pg = $connection[1];

$id = intval($_POST['id']);


if (isset($_POST['function']) || isset($_POST['id'])) {
  $id = intval($_POST['id']);
  $function = $_POST['function'];
} else {
  die('Error');
}

function activeUser($id, $pg)
{ {
    try {
      $sql = "SELECT codigo_cartao FROM bp_gratuidade_usuarios WHERE codigo_usuario = :id";
      $stmt = $pg->prepare($sql);
      $stmt->bindParam(':id', $id, PDO::PARAM_INT);
      $stmt->execute();

      $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

      $totalUpdatedRows = 0; // Variável para rastrear o número total de linhas atualizadas

      foreach ($result as $row) {
        $codigo_cartao = $row['codigo_cartao'];

        $query = "UPDATE bp_gratuidade_cartoes SET status = 1 WHERE codigo_cartao = $codigo_cartao";


        $stmt2 = $pg->prepare($query);


        $stmt2->execute();

        
        $updatedRowCount = $stmt2->rowCount();

        if ($updatedRowCount > 0) {
          $totalUpdatedRows += $updatedRowCount;
        }
      }

      if ($totalUpdatedRows > 0) {
        return ["response" => true, "rowsUpdated" => $totalUpdatedRows];
      } else {
        return ["response" => false, "rowsUpdated" => 0];
      }
    } catch (PDOException $e) {
      echo "Error: " . $e->getMessage();
      return ["success" => false, "error" => $e->getMessage()];
    }
  }
}


switch ($function) {
  case "activeUser":
    if (isset($id) && isset($pg)) {
      echo json_encode(['response' => true, 'data' => activeUser($id, $pg)]);
    } else {
      echo json_encode(['response' => false, 'data' => 'error']);
    }
    break;
}
