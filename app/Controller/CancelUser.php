<?php
require('../../../acesso_bd.php');

$connection = conectaPDOAnalytics();
$pg = $connection[1];

$id = intval($_POST['id']);


if (isset($_POST['function']) && isset($_POST['id']) && isset($_POST['cancellationDate'])) {
  $id = intval($_POST['id']);
  $function = $_POST['function'];
  $cancellationDate = $_POST['cancellationDate'];
} else {
  die('Error');
}

function cancelUser($id, $pg, $cancellationDate)
{
  try {
    $sql = "SELECT codigo_cartao FROM bp_gratuidade_usuarios WHERE codigo_usuario = :id";
    $stmt = $pg->prepare($sql);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->execute();

    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $totalUpdatedRows = 0;
    $totalRowsUpdate = 0;

    foreach ($result as $row) {
      $codigo_cartao = $row['codigo_cartao'];

      $query = "UPDATE bp_gratuidade_cartoes SET status = 2 WHERE codigo_cartao = $codigo_cartao";


      $stmt2 = $pg->prepare($query);


      $stmt2->execute();

      // Obter o número de linhas afetadas após a execução do UPDATE
      $updatedRowCount = $stmt2->rowCount();

      if ($updatedRowCount > 0) {
        $totalUpdatedRows += $updatedRowCount;
        $sqlQuery = "UPDATE bp_gratuidade_cartoes SET data_cancelamento = :cancellationDate WHERE codigo_cartao = :codigo_cartao";
        $stmt3 = $pg->prepare($sqlQuery);
        $stmt3->bindParam(':cancellationDate', $cancellationDate, PDO::PARAM_STR);
        $stmt3->bindParam(':codigo_cartao', $codigo_cartao, PDO::PARAM_INT);
        $stmt3->execute();
        $updatedCount = $stmt3->rowCount();

        if ($updatedCount > 0) {
          $totalRowsUpdate += $updatedCount;
        }
      }
    }

    if ($totalUpdatedRows > 0 && $totalRowsUpdate > 0) {
      return ["response" => true, "rowsUpdated" => $totalUpdatedRows . "cancellation-date" . $totalRowsUpdate];
    } else {
      return ["response" => false, "rowsUpdated" => 0];
    }
  } catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
    return ["success" => false, "error" => $e->getMessage()];
  }
}

switch ($function) {
  case "cancelUser":
    if (isset($id) && isset($pg)) {
      echo json_encode(['response' => true, 'data' => cancelUser($id, $pg, $cancellationDate)]);
    } else {
      echo json_encode(['response' => false, 'data' => 'error']);
    }
    break;
}
