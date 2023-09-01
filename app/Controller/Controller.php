<?php
function createConnection()
{
  $pg = new PgConnection;
  $connection = $pg->Connection();
  return $connection;
}

function GetUsersData()
{

  $connection = createConnection();
  $sql =  "   SELECT	*
              FROM		bp_gratuidade_usuarios			    a
              LEFT JOIN	bp_gratuidade_cartoes			    b on a.codigo_cartao	= b.codigo_cartao
              LEFT JOIN	bp_gratuidade_cartoes_status	c on b.status			    = c.codigo_status
          ";
  $stmt = $connection->prepare($sql);
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
}


function GetCardsInfo()
{
  $connection = createConnection();


  $sql =  "     SELECT	*
                FROM		bp_gratuidade_usuarios			    a
                LEFT JOIN	bp_gratuidade_cartoes			    b on a.codigo_cartao	= b.codigo_cartao
                LEFT JOIN	bp_gratuidade_cartoes_status	c on b.status			    = c.codigo_status
                LIMIT 10
            ";

  $stmt = $connection->prepare($sql);
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
}

function getTotalCards()
{
  $connection = createConnection();

  $sql = "SELECT COUNT(*) AS quantidade_total
  FROM bp_gratuidade_cartoes
  WHERE status = 1;";


  $stmt = $connection->prepare($sql);
  $stmt->execute();
  $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
  $data = [];

  foreach ($results as $row) {
    $data[] = array(
      "cartoes_ativos" => $row['quantidade_total']
    );
  }

  return $data;
}
function editCard()
{
  $connection = createConnection();
  $sql = "";

  $stmt = $connection->prepare($sql);
  $stmt->execute();
  $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
}
