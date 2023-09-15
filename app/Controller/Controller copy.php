<?php

require('../../../acesso_bd.php');

$func = '';


if (isset($_POST['func']) && strlen($_POST['func']) > 0) {
  $func = $_POST['func'];
  switch ($func) {
    case 'getAllCards':
      echo json_encode(['response' => true, 'data' => GetCardsInfo()]);
      break;
    case 'getDataCards':
      echo json_encode(['response' => true, 'data' => getDataCards()]);
      break;
    default:
      echo json_encode(['response' => false, 'data' => 'error']);
  }
} else {
  echo json_encode(['response' => false, 'data' => 'error']);
}



function GetUsersData()
{

  try {

    $connection = conectaPDOAnalytics();

    if (!$connection[0]) {
      throw new Exception('Não foi possível realizar a conexão com o banco.');
    }

    $sql =  "   SELECT	*
              FROM		bp_gratuidade_usuarios			    a
              LEFT JOIN	bp_gratuidade_cartoes			    b on a.codigo_cartao	= b.codigo_cartao
              LEFT JOIN	bp_gratuidade_cartoes_status	c on b.status			    = c.codigo_status
          ";
    $stmt = $connection[1]->prepare($sql);
    $stmt->execute();

    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $data = [];

    foreach ($results as $key => $row) {
      $data[] = array(
        "nome" => utf8_encode($row['nome']),
        "nascimento" => utf8_encode($row['data_nasc']),
        "nome_mae" => utf8_encode($row['nome_mae']),
        "local" => utf8_encode($row['localidade']),
        "cartao" => utf8_encode($row['codigo_cartao']),
        "status" => utf8_encode($row['descricao'])
      );
    }
    return $data;
  } catch (Exception $e) {
    return [false, $e->getMessage()];
  }
}


function GetCardsInfo()
{
  try {

    $connection = conectaPDOAnalytics();

    if (!$connection[0]) {
      throw new Exception('Não foi possível realizar a conexão com o banco.');
    }

    $sql =  "     SELECT	*
                  FROM		bp_gratuidade_usuarios			    a
                  LEFT JOIN	bp_gratuidade_cartoes			    b on a.codigo_cartao	= b.codigo_cartao
                  LEFT JOIN	bp_gratuidade_cartoes_status	c on b.status			    = c.codigo_status
                  ORDER BY a.nome
                  LIMIT 100
              ";

    $stmt = $connection[1]->prepare($sql);
    $stmt->execute();
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

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
        "id_usuario" => utf8_encode($row['codigo_usuario'])
      );
    }
    return $data;
  } catch (Exception $e) {
    return [false, $e->getMessage()];
  }
}

function getDataCards()
{

  try {

    $connection = conectaPDOAnalytics();


    if (!$connection[0]) {
      throw new Exception('Não foi possível realizar a conexão com o banco.');
    }

    $sql = "SELECT	    *
            FROM		    bp_gratuidade_cartoes			    a
            INNER JOIN	bp_gratuidade_cartoes_status	b	on a.status	= b.codigo_status
            ORDER BY a.codigo_cartao
            LIMIT 30
            ";

    $stmt = $connection[1]->prepare($sql);
    $stmt->execute();

    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $data = [];
    foreach ($results as $row) {
      $data[] = array(
        "codigo_cartao"     =>  $row['codigo_cartao'],
        "qr_code"           =>  $row['qr_code'],
        "data_criacao"      =>  $row['data_criacao'],
        "status"            =>  $row['status'],
        "data_cancelamento" =>  $row['data_cancelamento'],
        "id_usuario"        =>  $row['codigo_usuario'],
        "status_cartao"     =>  $row['descricao']
      );
    }

    return $data;
  } catch (Exception $e) {
    return [false, $e->getMessage()];
  }
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


    $stmt = $connection[1]->prepare($sql);
    $stmt->execute();
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $data = [];

    foreach ($results as $row) {
      $data[] = array(
        "cartoes_ativos" => $row['quantidade_total']
      );
    }

    return $data;
  } catch (Exception $e) {

    return [false, $e->getMessage()];
  }
}

// function editCard()
// {
//   $connection = createConnection();
//   $sql = "";

//   $stmt = $connection->prepare($sql);
//   $stmt->execute();
//   $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
// }
