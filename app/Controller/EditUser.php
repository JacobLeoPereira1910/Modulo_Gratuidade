<?php
// Caminho para o arquivo de conexão
require('../../../acesso_bd.php');

$connection = conectaPDOAnalytics();
$pg = $connection[1];

if (!$connection[0]) {
  echo json_encode(['response' => false, 'data' => 'Não foi possível realizar a conexão com o banco.']);
  exit; // Encerre o script após enviar a resposta JSON
}

$id = intval($_POST['id']);
$function = $_POST['function'];

$formData = json_decode($_POST['formData'], true);

if ($formData === null) {
  echo json_encode(['response' => false, 'data' => 'Erro na decodificação do JSON']);
  exit; // Encerre o script após enviar a resposta JSON
}

$func = '';
if (isset($_POST['func']) && strlen($_POST['func']) > 0) {
  $func = $_POST['func'];
  $result = editUser($id, $pg, $formData);
  if ($result) {
    echo json_encode(['response' => true, 'data' => 'Dados atualizados com sucesso.']);
  } else {
    echo json_encode(['response' => false, 'data' => 'Erro ao atualizar os dados.']);
  }
} else {
  echo json_encode(['response' => false, 'data' => 'Função não especificada.']);
}

function editUser($id, $pg, $formData)
{

  foreach ($formData as $item) {
    $name = $item['name'];
    $value = $item['value'];

    // Use um switch para atribuir o valor à variável apropriada com base no nome do campo
    switch ($name) {
      case 'nome':
        $nome = $value;
        break;
      case 'nascimento':
        $nascimento = $value;
        break;
      case 'nome-mae':
        $nomeMae = $value;
        break;
      case 'local':
        $local = $value;
        break;
      case 'data':
        $data = $value;
        break;
      default:
        break;
    }
  }

  if ($nome || $nascimento || $nomeMae || $local || $data) {
    try {
      $sql = "UPDATE bp_gratuidade_usuarios SET ";
      $params = array(':id' => $id);

      if ($nome) {
        $sql .= "nome = :nome, ";
        $params[':nome'] = $nome;
      }

      if ($nascimento) {
        $sql .= "data_nasc = :nascimento, ";
        $params[':nascimento'] = $nascimento;
      }

      if ($nomeMae) {
        $sql .= "nome_mae = :nomeMae, ";
        $params[':nomeMae'] = $nomeMae;
      }

      if ($local) {
        $sql .= "localidade = :local, ";
        $params[':local'] = $local;
      }

      if ($data) {
        $sql .= "data_abordagem = :data, ";
        $params[':data'] = $data;
      }

      // Remova a vírgula extra no final do SQL
      $sql = rtrim($sql, ', ');

      // Adicione a condição WHERE para atualizar apenas o usuário específico
      $sql .= " WHERE codigo_usuario = :id";

      $stmt = $pg->prepare($sql);
      $stmt->execute($params);

      // Verifique se algum registro foi afetado
      $affectedRows = $stmt->rowCount();

      if ($affectedRows > 0) {
        return true;
      } else {
        echo json_encode(['response' => false, 'data' => 'Erro ao atualizar os dados.']);
        exit; // Encerre o script após enviar a resposta JSON
      }
    } catch (Exception $e) {
      echo json_encode(['response' => false, 'data' => $e->getMessage()]);
      exit; // Encerre o script após enviar a resposta JSON
    }
  } else {
    echo json_encode(['response' => false, 'data' => 'Erro Nenhum dado para atualizar.']);
    exit; // Encerre o script após enviar a resposta JSON
  }
}
