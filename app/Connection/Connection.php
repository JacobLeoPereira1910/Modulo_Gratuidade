<?php

class PgConnection
{

  public function Connection()
  {

    $ip = $_SERVER['SERVER_ADDR'];

    if ($ip == "172.32.101.22") {
      $acesso = "172.32.101.24";
    } elseif ($ip == "172.32.100.22") {
      $acesso = "172.32.100.24";
    } else {
      $acesso = "127.0.0.1";
    }

    try {
      $pgconnection = new PDO("pgsql:dbname=bomprato;host=172.32.100.25;", "postgres", "");
      $pgconnection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      return $pgconnection;
    } catch (PDOException $e) {
      throw new Exception('Erro ao conectar ao banco de dados: ' . $e->getMessage());
    }
  }
}
