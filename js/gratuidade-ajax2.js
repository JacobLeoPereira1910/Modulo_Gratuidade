function getAllCards() {
  $('.body-table').empty();
  $.ajax({
    method: 'POST',
    url: 'app/Controller/Controller.php',
    data: {
      func: 'getAllCards',
    },
    beforeSend: function () {
      // Você pode adicionar alguma ação antes de enviar a solicitação, se necessário.
    },
    success: function (response) {
      try {
        const responseData = JSON.parse(response);

        if (!responseData.response) {
          throw (responseData.data)
        }

        if (!responseData.data.length > 0) {
          throw (responseData.data)
        }

        var html = '';

        console.table(responseData.data);

        $.each(responseData.data, function (index, info) {

          html += `<tr>
        <td id="nome" class="content-text-table">${info.nome}</td>
        <td id="data-nasci" class="content-text-table">${info.nascimento}</td>
        <td id="nome-mae" class="content-text-table">${info.nome_mae}</td>
        <td id="local" class="content-text-table">${info.local}</td>
        <td id="data-abordagem" class="content-text-table">${info.data_abordagem}</td>
        <td id="cartao" class="content-text-table">${info.cartao}</td>
        <td id="situacao" class="content-text-table">${info.status}</td>
        <td>
          <button id="${info.id_usuario}" type="button" class="btn btn-primary btn-preview-user" data-bs-toggle="modal" data-bs-target="">
            Editar
          </button>
        </td>
      </tr>`

          $('.body-table').html(html);

        });


        $('.btn-preview-user').unbind().click(function () {
          const id = $(this).attr('id');
          getModalUser(id);


        })




      } catch (error) {
        console.error('Erro ao analisar a resposta JSON:', error);
      }
    },
    complete: function (xhr, status) {
      // O evento complete não contém a resposta JSON, apenas informações sobre a solicitação
      console.log(`Solicitação concluída com status: ${status}`);
    },
    error: function (xhr, status, error) {
      console.error(`Erro na solicitação: ${status} - ${error}`);
    }
  });
}

function getModalUser(id) {
  $.ajax({
    method: 'POST',
    url: 'app/Controller/UpdateUser.php',
    data: {
      function: 'viewModalUser',
      id: id
    },
    beforeSend: function () {

    },
    success: function (r) {
      try {
        const responseData = JSON.parse(r);

        if (!responseData.response) {
          throw (responseData.data)
        }

        if (!responseData.data.length > 0) {
          throw (responseData.data)
        }

        $('.view-modal').attr('id', `id-edit-user-${id}`)
        $(this).attr('data-bs-target', `#id-edit-user-${id}`)


        let myModal = new bootstrap.Modal(document.getElementById(`id-edit-user-${id}`), {
          keyboard: false
        })

        myModal.toggle()

        $.each(responseData.data, function (index, info) {
          const status = info.status;

          $('.btn-active-user').css('display', status === 'CANCELADO' ? 'inline-block' : 'none');
          $('.btn-cancel-user').css('display', status === 'ATIVO' ? 'inline-block' : 'none');

          console.log(`${status}`);

          $('#name').text('');
          $('#name').text(info.nome);
          $('#nascimento').text('');
          $('#nascimento').text(info.nascimento);
          $('#nome-mae').text('');
          $('#nome-mae').text(info.nome_mae);
          $('#local').text('');
          $('#local').text(info.local);
          $('#data').text('');
          $('#data').text(info.data_abordagem);
          $('#cartao').text('');
          $('#cartao').text(info.local);
          $('#situacao').text('');
          $('#situacao').text(info.status);

          $('#btn-cancel-user').attr('id', `${info.id_usuario}`);
          $('.modal-cancel-user').attr('id', `id-cancel-user-${info.id_usuario}`);

        });

        $('.btn-cancel-user').unbind().click(function () {
          const id = $(this).attr('id');
          console.log(`meu id é: ${id}`)
          $('.btn-confirm-cancel').attr('id', `confirm-cancel-id-${id}`);
          showConfirmModal(id);

        });

        $('.btn-confirm-cancel').unbind().click(function () {
          const id = $(this).attr('id');
          alert(`Funcionando id: ${id}`);
          cancelCardUser(id);
        });

      } catch (error) {
        console.error('Erro ao analisar a resposta JSON:', error);
      }
    },
    complete: function () {

    },
    error: function (e) {

    }

  })
}

function showConfirmModal(id) {
  let myModal = new bootstrap.Modal(document.getElementById(`id-cancel-user-${id}`), {
    keyboard: false
  })
  myModal.toggle()
  console.table(response)
  $(`#confirm-cancel-id-${id}`);
  console.log(`Usuário cancelado: ${response.response}`)

}

function cancelCardUser(id) {
  $.ajax({
    method: "POST",
    url: "app/Controller/CancelUser.php",
    data: {
      function: 'cancelUser',
      id: id
    },
    beforeSend: function () {
    },
    success: function (r) {
      response = JSON.parse(r);
      if (response.response == true) {
        //$(`#${id}`).attr('class', 'btn btn-success');
        console.log(id);
        getAllCards();

      }


    },
    complete: function () {

    },
    error: function (e) {
      console.error(e);
    },
  })


}

function activeCardUser(id) {
  $.ajax({
    method: "POST",
    url: "app/Controller/activeUser.php",
    data: {
      function: 'activeUser',
      id: id
    },
    beforeSend: function () {
    },
    success: function (r) {
      response = JSON.parse(r);
      if (response.response == true) {
        //$(`#${id}`).attr('class', 'btn btn-success');
        console.log(id);
        getAllCards();

      }


    },
    complete: function () {

    },
    error: function (e) {
      console.error(e);
    },
  })


}