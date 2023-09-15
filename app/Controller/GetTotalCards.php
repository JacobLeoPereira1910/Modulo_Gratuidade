<?php
require('../../../acesso_bd.php');

if (isset($_POST['function'])) {
  $function = $_POST['function'];
} else {
  die('Error');
}

function getTotalCards()
{
  try {
    $connection = conectaPDOAnalytics();
    if (!$connection[0]) {
      throw new Exception('Não foi possível realizar a conexão com o banco.');
    }

    $sql = "SELECT COUNT(*) AS quantidade_total
      FROM bp_gratuidade_cartoes
      WHERE status = 1;";

    $query = "SELECT COUNT(*) FROM bp_gratuidade_cartoes WHERE status = 2";
    $stmt2 = $connection[1]->prepare($query);
    $stmt2->execute();

    $result = $stmt2->fetchAll(PDO::FETCH_ASSOC);
    $dataCard = [];
    foreach ($result as $row) {
      $dataCard[] = array(
        "cartoes_cancelados" => $row['count']
      );
    }

    $stmt = $connection[1]->prepare($sql);
    $stmt->execute();
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $data = [];

    foreach ($results as $row) {
      $data[] = array(
        "cartoes_ativos" => $row['quantidade_total']
      );
    }

    // Crie um array associativo para retornar ambos os conjuntos de dados
    $responseData = [
      "cartoes_ativos" => $data[0]['cartoes_ativos'], // Acesso ao valor diretamente
      "cartoes_cancelados" => $dataCard[0]['cartoes_cancelados'] // Acesso ao valor diretamente
    ];
    

    return $responseData;
  } catch (Exception $e) {
    return [false, $e->getMessage()];
  }
}

switch ($function) {
  case "getTotalCards":
    if (isset($function)) {
      echo json_encode(['response' => true, 'data' => getTotalCards()]);
    } else {
      echo json_encode(['response' => false, 'data' => 'error']);
    }
    break;
}
