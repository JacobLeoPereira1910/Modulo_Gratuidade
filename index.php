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
  <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
  <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
  <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
  <script src="https://unpkg.com/jspdf@latest/dist/jspdf.umd.min.js"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" integrity="sha512-KfkfwYDsLkIlwQp6LFnl8zNdLGxu9YAA1QvwINks4PhcElQSvqcyVLLD9aMhXd13uQjoXtEKNosOWaZqXgel0g==" crossorigin="anonymous" referrerpolicy="no-referrer" />
  <script src="https://cdnjs.cloudflare.com/ajax/libs/FileSaver.js/2.0.0/FileSaver.min.js" integrity="sha512-csNcFYJniKjJxRWRV1R7fvnXrycHP6qDR21mgz1ZP55xY5d+aHLfo9/FcGDQLfn2IfngbAHd8LdfsagcCqgTcQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
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
  </style>
</head>

<body>

  <div class="modal fade view-modal" id="" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
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
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary btn-close-modal" data-bs-dismiss="modal">Fechar</button>
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
          <tbody>
            <?php
            $items = GetCardsInfo();
            foreach ($items as $item) : ?>
              <tr>
                <td class="content-text-table"><?php echo $item['nome']; ?></td>
                <td class="content-text-table"><?php echo $item['nascimento']; ?></td>
                <td class="content-text-table"><?php echo $item['nome_mae']; ?></td>
                <td class="content-text-table"><?php echo $item['local']; ?></td>
                <td class="content-text-table"><?php echo $item['data_abordagem']; ?></td>
                <td class="content-text-table"><?php echo $item['cod_cartao']; ?></td>
                <td class="content-text-table"><?php echo $item['status']; ?></td>
                <td>

                  <button type="button" class="btn btn-primary btn-preview-user" id="btn-preview-user" data-bs-toggle="modal" data-bs-target="">
                    Editar
                  </button>
                </td>
              </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</body>

</html>

<script>
  $(document).ready(function() {
    const item = JSON.stringify(<?php echo $jsonData ?>);
    data = JSON.parse(item);

    console.log(data);

    function getName(idUsuario) {
      let name = '';
      for (const key in data) {
        if (data[key].id_usuario == idUsuario) {
          name = data[key].nome;
        }
      }
      return name;
    }


    function getLocal(idUsuario) {
      let local = '';
      for (const key in data) {
        if (data[key].id_usuario == idUsuario) {
          local = data[key].local;
        }
      }
      return local;
    }

    function getNameMae(idUsuario) {
      let name = '';
      for (const key in data) {
        if (data[key].id_usuario == idUsuario) {
          name = data[key].nome_mae;
        }
      }
      return name;
    }

    function getNascimento(idUsuario) {
      let nascimento = '';
      for (const key in data) {
        if (data[key].id_usuario == idUsuario) {
          nascimento = data[key].nascimento;
        }
      }
      return nascimento;
    }

    function getCartao(idUsuario) {
      let cartao = '';
      for (const key in data) {
        if (data[key].id_usuario == idUsuario) {
          cartao = data[key].cod_cartao;
        }
      }
      return cartao;
    }


    function getSituacao(idUsuario) {
      let descricao = '';
      for (const key in data) {
        if (data[key].id_usuario == idUsuario) {
          descricao = data[key].status;
        }
      }
      return descricao;
    }

    function getAbordagem(idUsuario) {
      let dataAbordagem = '';
      for (const key in data) {
        if (data[key].id_usuario == idUsuario) {
          dataAbordagem = data[key].data_abordagem;
        }
      }
      return dataAbordagem;
    }

    console.log(getName(5576))

    $.each(data, function(index, info) {
      $('#btn-edit').attr('id', `${info.id_usuario}`);
      $('#btn-preview-user').attr('id', `${info.id_usuario}`)
      getName(info.id_usuario);
      getAbordagem(info.id_usuario);
      getCartao(info.id_usuario);
      getLocal(info.id_usuario);
      getNameMae(info.id_usuario);
      getNascimento(info.id_usuario);
      getSituacao(info.id_usuario);
      getLocal(info.id_usuario);
      getNameMae(info.id_usuario);

    })

    $('.btn-preview-user').on('click', function() {
      const id = $(this).attr('id');
      $('.view-modal').attr('id', `modal-preview-music-${id}`);
      $(this).attr('data-bs-target', `#modal-preview-music-${id}`);
      $('#name').text('');
      $('#name').append(getName(id));
      $('#nome-mae').text('');
      $('#nome-mae').append(getNameMae(id));
      $('#nascimento').text('');
      $('#nascimento').append(getNascimento(id));
      $('#local').text('');
      $('#local').append(getLocal(id));
      $('#cartao').text('');
      $('#cartao').append(getCartao(id));
      $('#situacao').text('');
      $('#situacao').append(getSituacao(id));
      $('#data').text('');
      $('#data').append(getAbordagem(id));

      console.log(id)


      let myModal = new bootstrap.Modal(document.getElementById('modal-preview-music-' + id), {
        keyboard: false
      })

      myModal.toggle()
    })

    $('.btn-close-modal').click(function() {
      let id = $(this).attr('id');
      $('.view-modal').attr('id', ``);
      $(this).attr('data-bs-target', ``);
    })

  })
</script>