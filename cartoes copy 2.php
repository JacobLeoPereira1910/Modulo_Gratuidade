<!DOCTYPE html>
<html lang="pt-br">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Teste</title>

  <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
  <link rel="stylesheet" type="text/css" href="../DataTables/datatables.css" />
  <script type="text/javascript" src="../DataTables/datatables.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
  <script src="../modulo_gratuidade/js/js.js"></script>


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
      font-weight: 400;
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
      border-radius: 10px;
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
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

    .modal-button {
      color: #fff;
    }

    .btn-edit-user,
    .btn-cancel-user,
    .btn-active-user,
    .btn-show-card-use,
    .btn-reactivate-user {
      cursor: pointer;
    }

    .content-text-table {
      font-size: 12px;
    }

    .header-text-table {
      font-weight: 700;
    }

    .content-text-header {
      text-align: center;
      color: #ffae4f;
      font-weight: 700;
    }

    .secondary-top-header,
    .primary-top-header {
      padding: 1rem 0rem 1rem;
    }

    hr:not([size]) {
      height: 5px;
      border-radius: 10px;
      color: #f69661;
      border: solid;
    }

    .top-hr-header {
      margin: 1.5rem 0 1rem;
    }

    .dataTables_filter input[type="search"] {
      /* Estilos personalizados aqui */
      width: 200px;
      border: 1px solid #ccc;
      border-radius: 5px;
      padding: 5px;
    }

    .btn-active-user,
    .btn-cancel-user,
    .btn-reactivate-user {
      display: none;
    }

    .dataTables_filter input[type="search"]:focus,
    .dataTables_filter input[type="search"]:focus-within {
      border-color: rgba(255, 102, 0, 0.4);
    }

    .btn-warning {
      background-color: #ffae4f;
    }
    .modal-header {
      border-bottom: 2px solid #f69661 !important;
    }

  </style>
</head>

<body>

  <div class="modal modal-cancel-user show" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-dialog-cancel-user">
      <div class="modal-content modal-content-cancel-user">
        <div class="modal-body modal-body-cancel-user text-center">
          <h5 class="modal-title">Confirmação de Cancelamento</h5>
          <p>Deseja cancelar o cartão do(a) X?</p>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary btn-close-confirm-modal-cancel" id="btn-close-confirm-modal-cancel" data-bs-dismiss="modal-cancel-user">Fechar</button>
          <button type="button" id="btn-confirm-cancel" class="btn btn-danger btn-confirm-cancel">Cancelar</button>
        </div>
      </div>
    </div>
  </div>

  <div class="modal modal-active-user" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-dialog-active-user">
      <div class="modal-content modal-content-active-user">
        <div class="modal-body modal-body-active-user text-center">
          <h5 class="modal-title">Confirmação para ativar</h5>
          <p>Deseja habilitar o cartão do(a) X?</p>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary btn-close-confirm-modal-active" id="btn-close-confirm-modal-active" data-bs-dismiss="modal-active-user">Fechar</button>
          <button type="button" id="btn-confirm-active" class="btn btn-primary btn-confirm-active">Ativar</button>
        </div>
      </div>
    </div>
  </div>


  <div class="modal modal-reactivate-user" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-dialog-reactivate-user">
      <div class="modal-content modal-content-reactivate-user">
        <div class="modal-body modal-body-reactivate-user text-center">
          <h5 class="modal-title">Confirmação para reativar</h5>
          <p>Deseja reativar o cartão do(a) X?</p>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary btn-close-confirm-modal-reactivate" id="btn-close-confirm-modal-reactivate" data-bs-dismiss="modal-reactivate-user">Fechar</button>
          <button type="button" id="btn-confirm-reactivate" class="btn btn-primary btn-confirm-reactivate">Reativar</button>
        </div>
      </div>
    </div>
  </div>

  <!-- Modal -->
  <div class="modal fade modal-use-card" id="myModal">
    <div class="modal-dialog">
      <div class="modal-content">

        <!-- Cabeçalho da modal -->
        <div class="modal-header">
          <h5 class="modal-title">Preencher Dados do Cartão</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
        </div>

        <!-- Corpo da modal -->
        <div class="modal-body">
          <!-- Formulário para preencher os dados -->
          <form>
            <div class="mb-3">
              <label for="data">Data:</label>
              <input type="text" class="form-control" id="data" placeholder="Data">
            </div>
            <div class="mb-3">
              <label for="horario">Horário:</label>
              <input type="text" class="form-control" id="horario" placeholder="Horário">
            </div>
            <div class="mb-3">
              <label for="unidade">Unidade:</label>
              <input type="text" class="form-control" id="unidade" placeholder="Unidade">
            </div>
            <div class="mb-3">
              <label for="refeicao">Refeição:</label>
              <input type="text" class="form-control" id="refeicao" placeholder="Refeição">
            </div>
          </form>
        </div>

        <!-- Rodapé da modal -->
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
          <!-- Botão para salvar os dados (você pode adicionar a função JavaScript desejada aqui) -->
          <button type="button" class="btn btn-primary">Salvar</button>
        </div>

      </div>
    </div>
  </div>



  <div class="modal fade view-modal-card modal-view-card" id="" data-bs-backdrop="static" data-bs-keyboard="false"
  tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content modal-content-view-card">
      <div class="modal-header">
        <h5 class="modal-title" id="staticBackdropLabel">Cartões:</h5>
        <button type="button" class="btn-close btn-close-modal" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="container">
          <div class="row">
            <div class="col-md-6">
              <div class="mb-3">
                <label for="cartao" class="form-label">Cartão (QRCode)</label>
                <p id="cartao"></p>
              </div>
              <div class="mb-3">
                <label for="name" class="form-label">Nome</label>
                <p id="nome"></p>
              </div>
              <div class="mb-3">
                <label for="" class="form-label">Data de Nascimento</label>
                <p id="nascimento"></p>
              </div>
              <div class="mb-3">
                <label for="nome-mae" class="form-label">Nome da Mãe</label>
                <p id="nome-mae"></p>
              </div>
            </div>
            <div class="col-md-6">
              <div class="mb-3 row">
                <div class="col">
                  <label for="situacao" class="form-label">Situação</label>
                  <p id="situacao-cartao" class="content-text-modal-situacao"></p>
                </div>
                <div class="col cancelation-date">
                  <label for="data" class="form-label">Data Cancelamento</label>
                  <p id="data-cancelamento"></p>
                </div>
              </div>
            </div>

          </div>
        </div>
      
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-warning btn-close-modal modal-button"
          data-bs-dismiss="modal">Fechar</button>
      </div>
    </div>
  </div>
</div>



  <div class="container">
    <div class="row content-data-users">

      <div class="container header-container">
        <header class="cabecalho">
          <?php include("../novo_layout/novo_topo.php"); ?>
        </header>
      </div>
      <div class="container primary-top-header">

      </div>
      <div class="secondary-top-header">
        <h1 class="content-text-header">GRATUIDADE</h1>
        <hr class="top-hr-header">
      </div>

      <div class="table table-borderless">
        <h2>Cartões     (Ativos: <span id="ativos"></span> Cancelados: <span id="cancelados"></span>)</h2>
        <table class="table table-borderless table-users" id="id-table-users">
          <thead>
            <tr>
              <th class="text-table header-text-table">Cartão</th>
              <th class="text-table header-text-table">Data Envio</th>
              <th class="text-table header-text-table">Situação</th>
              <th class="text-table header-text-table"></th>
              <th class="text-table header-text-table"></th>
              <th class="text-table header-text-table"></th>


            </tr>
          </thead>
          <tbody class="body-table">

          </tbody>
        </table>
      </div>
      <div class="container footer-container">
        <footer class="rodape container-fluid">
          <?php include("../novo_layout/novo_rodape.php"); ?>
        </footer>
      </div>

    </div>
  </div>

</body>

</html>

<script>
  $(document).ready(function() {
    getDataCards();

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