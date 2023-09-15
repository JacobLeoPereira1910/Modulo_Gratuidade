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
function viewModalUser($id, $pg)
{
  $sql =  "     SELECT	*
                FROM		bp_gratuidade_usuarios			    a
                LEFT JOIN	bp_gratuidade_cartoes			    b on a.codigo_cartao	= b.codigo_cartao
                LEFT JOIN	bp_gratuidade_cartoes_status	c on b.status			    = c.codigo_status
                WHERE a.codigo_usuario = :id
            ";

  $stmt = $pg->prepare($sql);
  $stmt->bindParam(':id', $id, PDO::PARAM_INT);
  $stmt->execute();
  $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

  $data = [];

  foreach ($results as $row) {
    $data[] = array(
      "nome" => utf8_encode($row['nome']),
      "nascimento" => utf8_encode($row['data_nasc']),
      "nome_mae" => utf8_encode($row['nome_mae']),
      "local" => utf8_encode($row['localidade']),
      "cartao" => utf8_encode($row['codigo_cartao']),
      "status" => utf8_encode($row['descricao']),
      "data_abordagem" => utf8_encode($row['data_abordagem']),
      "cod_cartao" => utf8_encode($row['qrcode']),
      "id_usuario" => utf8_encode($row['codigo_usuario']),
      "data_cancelamento" => utf8_encode($row['data_cancelamento'])
    );
  }

  return $data;
}

switch ($function) {
  case "viewModalUser":
    if (isset($id) && isset($pg)) {
      $result = viewModalUser($id, $pg);
      echo json_encode(['response' => true, 'data' => $result]);
    } else {
      echo json_encode(['response' => false, 'data' => 'error']);
    }
    break;
}
