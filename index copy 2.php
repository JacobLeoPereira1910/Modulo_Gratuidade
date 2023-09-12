<?php
require('./vendor/autoload.php');
require('./app/Connection/Connection.php');
require('./app/Controller/Controller.php');

$dataCard = GetCardsInfo();


$data = GetCardsInfo(); // Supondo que você chama a função para obter os dados

// Transforma o array em um objeto JSON
$jsonData = json_encode($data);


?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Teste</title>
  <script src="../modulo_gratuidade/js/gratuidade-ajax.js"></script>
  <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>

  <style>
    body {
      font-family: Arial, sans-serif;
      background-color: #f5f5f5;
    }

    .container {
      margin-top: 20px;
    }

    .table {
      margin-top: 20px;
    }

    th {
      background-color: #f8f9fa;
    }

    .table-bordered th,
    .table-bordered td {
      border: 1px solid #dee2e6;
    }

    .content-dashboard {
      background-color: #ffffff;
      padding: 20px;
      border-radius: 5px;
      box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    }

    .table th,
    .table td {
      vertical-align: middle;
    }

    .table td:last-child {
      text-align: center;
    }

    .text-table,
    .content-text-table {
      font-weight: 600;
    }

    .modal-dialog-cancel-user {
      background-color: rgba(0, 0, 0, 0.5);
      border-radius: 5px;
      box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
    }

    .modal-cancel-user {
      background-color: rgba(0, 0, 0, 0.5);
      /* Fundo semi-transparente */
    }

    .modal-content-cancel-user {
      background-color: #fff;
      /* Fundo branco */
      border-radius: 10px;
      /* Cantos arredondados */
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
      /* Sombra */
    }

    .modal-title {
      color: #333;
      /* Cor do título */
    }

    .modal-body-cancel-user {
      padding: 20px;
    }

    .modal-footer {
      justify-content: center;
      /* Centralizar botões */
    }

    .btn-secondary {
      background-color: #ccc;
      /* Cor de fundo do botão de fechar */
      color: #333;
      /* Cor do texto do botão de fechar */
    }

    .btn-danger {
      background-color: #f44336;
      /* Cor de fundo do botão "Cancelar Cartão" */
      color: #fff;
      /* Cor do texto do botão "Cancelar Cartão" */
    }

    .btn-secondary:hover,
    .btn-danger:hover {
      opacity: 0.8;
    }

    .btn-cancel-user,
    .btn-active-user {
      display: none;
    }
  </style>
</head>

<body>

  <div class="modal fade view-modal modal-view-user" id="" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content modal-content-view-user">
        <div class="modal-header">
          <h5 class="modal-title" id="staticBackdropLabel">Usuário:
          </h5>
          <button type="button" class="btn-close btn-close-modal" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <div class="container">
            <div class="user">
              <p>Nome</p>
              <p id="name"></p>
            </div>
            <div class="">
              <p>Data de Nascimento</p>
              <p id="nascimento"></p>
            </div>
            <div class="">
              <p>Nome da Mãe</p>
              <p id="nome-mae"></p>
            </div>
            <div>
              <p>Local</p>
              <p id="local"></p>
            </div>
            <div>
              <p>Data Abordagem</p>
              <p id="data"></p>
            </div>
            <div>
              <p>Cartão</p>
              <p id="cartao"></p>
            </div>
            <div>
              <p>Situação</p>
              <p id="situacao"></p>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary btn-close-modal" data-bs-dismiss="modal">Fechar</button>
          <button id="btn-cancel-user" type="button" class="btn btn-danger btn-cancel-user">Cancelar Cartão</button>
          <button id="btn-active-user" type="button" class="btn btn-success btn-active-user">Ativar Cartão</button>
        </div>
      </div>

    </div>
  </div>

  <div class="modal modal-cancel-user show" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-dialog-cancel-user">
      <div class="modal-content modal-content-cancel-user">
        <div class="modal-body modal-body-cancel-user text-center">
          <h5 class="modal-title">Confirmação de Cancelamento</h5>
          <p>Deseja cancelar o cartão do(a) X?</p>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary btn-close-confirm-modal-cancel" id="btn-close-confirm-modal-cancel" data-bs-dismiss="modal-cancel-user">Fechar</button>
          <button type="button" id="btn-confirm-cancel" class="btn btn-danger btn-confirm-cancel" >Cancelar Cartão</button>
        </div>
      </div>
    </div>
  </div>

  <div class="modal modal-active-user" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-dialog-cancel-user">
      <div class="modal-content modal-content-active-user">
        <div class="modal-body modal-body-active-user text-center">
          <h5 class="modal-title">Confirmação para ativar</h5>
          <p>Deseja habilitar o cartão do(a) X?</p>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary btn-close-confirm-modal-active" id="btn-close-confirm-modal-active" data-bs-dismiss="modal-active-user">Fechar</button>
          <button type="button" id="btn-confirm-active" class="btn btn-success btn-confirm-active">Habilitar Cartão</button>
        </div>
      </div>
    </div>
  </div>

  <div class="container">
    <div class="row content-dashboard">
      <div class="table">
        <h2>Tabela</h2>
        <table class="table table-bordered">
          <thead>
            <tr>
              <th class="text-table">Nome</th>
              <th class="text-table">Data de Nascimento</th>
              <th class="text-table">Nome da Mãe</th>
              <th class="text-table">Local</th>
              <th class="text-table">Data Abordagem</th>
              <th class="text-table">Cartão</th>
              <th class="text-table">Situação</th>
              <th class="text-table">Ações</th> <!-- Nova coluna para as ações -->
            </tr>
          </thead>
          <tbody class="body-table">

          </tbody>
        </table>
      </div>
    </div>
  </div>
</body>

</html>

<script>
  $(document).ready(function() {
    getAllCards();

    $('.btn-close-confirm-modal-active').unbind().click(function() {
      const id = $(this).attr('id');
      alert(`O ID É: ${id}`)
      $(`#id-active-user-${id}`).modal('hide');
      
    });

    $('.btn-close-confirm-modal-cancel').unbind().click(function() {
      const id = $(this).attr('id');
      alert(`O ID É: ${id}`)
      $(`#id-cancel-user-${id}`).modal('hide');
    });

    $('.btn-close-modal').unbind().click(function() {
      const id = $(this).attr('id');
      alert(id)
      $(`#id-edit-user-${id}`).modal('hide');
      $('.view-modal').attr('id', ``);
      
    });



  })
</script>