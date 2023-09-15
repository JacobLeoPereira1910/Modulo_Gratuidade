function getDataCards() {
  $('.body-table').empty();
  $.ajax({
    method: 'POST',
    url: 'app/Controller/Controller.php',
    data: {
      func: 'getDataCards',
    },
    beforeSend: function () {

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
          const statusCard = info.status_cartao;
          const row = $(`
                  <tr>
                    <td id="codigo-cartao" class="content-text-table">${info.codigo_cartao}</td>
                    <td id="data-criacao" class="content-text-table">${info.data_criacao}</td>
                    <td id="status" class="content-text-table status-card">${info.status_cartao}</td>
                    <td>
                      <i class="fa-solid fa-pen-to-square btn-edit-user" id="${info.id_usuario}"></i>
                    </td>
                    <td>
                      <i class="fa-solid fa-list btn-show-card-user" id="btn-show-card-user-id-${info.id_usuario}" data-bs-toggle="modal"
                        data-bs-target="#myModal"></i>
                    </td>
                    <td>
                      <i class="fa-solid fa-ban btn-cancel-user" id="${info.id_usuario}" style="color: #ff0202;"></i>
                      <i class="fa-solid fa-rotate-right btn-active-user" id="${info.id_usuario}" style="color: #388e49;"></i>
                      <i class="fa-duotone fa-plus fa-2xl btn-reactivate-user" id="${info.id_usuario} style="color: #414bb2;"></i>
                    </td>
                  </tr>
          `);

          $('.body-table').append(row);
          $('#btn-cancel-user').attr('id', `id-btn-cancel-user-${info.id_usuario}`);
          $('#btn-active-user').attr('id', `id-btn-active-user-${info.id_usuario}`);
          $('#btn-reactivate-user').attr('id', `id-btn-reactivate-user-${info.id_usuario}`);

          $('#btn-modal-cancel-user').attr('id', `${info.id_usuario}`);
          $('#btn-modal-active-user').attr('id', `${info.id_usuario}`);

          $('#btn-confirm-active').attr('id', `${info.id_usuario}`);
          $('#btn-confirm-cancel').attr('id', `${info.id_usuario}`);
          $('#btn-confirm-reactivate').attr('id', `${info.id_usuario}`);

          const statusElement = row.find('.status-card'); // Selecione o elemento .status-card dentro da linha atual

          statusElement.css('color',
            statusCard === 'ATIVO' ? '#008000' :
              statusCard === 'CANCELADO' ? '#ff0000' :
                statusCard === 'INATIVO' ? '#000000' :
                  '#000000' // Cor padrão caso o valor não corresponda a nenhum dos três
          );

          statusElement.css('font-weight', '700');

          const status = info.status_cartao;

          console.log(`STATUS: ${status}`);


          const btnActiveUser = row.find('.btn-active-user');
          const btnCancelUser = row.find('.btn-cancel-user');
          const btnreactivateUser = row.find('.btn-reactivate-user');

          // Definir a exibição com base no status
          btnActiveUser.css('display', status === 'CANCELADO' ? 'inline-block' : 'none');
          btnCancelUser.css('display', status === 'ATIVO' ? 'inline-block' : 'none');
          btnreactivateUser.css('display', status === 'INATIVO' ? 'inline-block' : 'none');

        });


        obj = responseData.data;



        getStatusCard = (id) => {
          let cardStatus = '';
          for (const key in obj) {
            if (obj[key].id_usuario == id) {
              cardStatus = obj[key].status;
            }
          }
          return cardStatus;
        }

        $('.btn-edit-user').unbind().click(function () {
          const id = $(this).attr('id');
          $('.btn-close-modal').attr('id', `${id}`)
          getModalUser(id);
        })

        $('.btn-show-card-user').click(function () {
          let id = $(this).attr('id');
          id = id.split('-').pop();
          alert(`click: ${id}`);
          $('.modal-use-card').modal('show');

        })

        $('.btn-reactivate-user').click(function () {
          let id = $(this).attr('id');
          alert(`click: ${id}`);
        });

        $('.btn-cancel-user').unbind().click(function () {
          const id = $(this).attr('id');

          $('.modal-cancel-user').attr('id', `modal-cancel-user-id-${id}`)

          $('.btn-confirm-cancel').attr('id', `${id}`);

          $('.btn-close-confirm-modal-cancel').attr('id', `${id}`);

          showModalCancelCard(id);

        });
        $('.btn-modal-cancel-user').unbind().click(function () {
          const id = $(this).attr('id');

          $('.modal-cancel-user').attr('id', `modal-cancel-user-id-${id}`)

          $('.btn-confirm-cancel').attr('id', `${id}`);

          $('.btn-close-confirm-modal-cancel').attr('id', `${id}`);

          showModalCancelCard(id);

        });

        $('.btn-active-user').unbind().click(function () {
          const id = $(this).attr('id');

          $('.modal-active-user').attr('id', `modal-active-user-id-${id}`)

          $('.btn-confirm-active').attr('id', `${id}`);

          $('.btn-close-confirm-modal-active').attr('id', `${id}`);
          showModalActiveCard(id);

        });


        $('.btn-reactivate-user').unbind().click(function () {
          const id = $(this).attr('id');

          $('.modal-active-user').attr('id', `modal-active-user-id-${id}`)

          $('.btn-confirm-active').attr('id', `${id}`);

          $('.btn-close-confirm-modal-active').attr('id', `${id}`);
          showModalActiveCard(id);

        });




        $('.btn-modal-active-user').unbind().click(function () {
          const id = $(this).attr('id');

          $('.modal-active-user').attr('id', `modal-active-user-id-${id}`)

          $('.btn-confirm-active').attr('id', `${id}`);

          $('.btn-close-confirm-modal-active').attr('id', `${id}`);
          showModalActiveCard(id);

        });


        $('.btn-confirm-cancel').unbind().click(function () {
          const id = $(this).attr('id');
          console.log(`Confirma: ${id}`)
          cancelCardUser(id);
        });

        $('.btn-confirm-active').unbind().click(function () {
          const id = $(this).attr('id');
          console.log(`Confirma: ${id}`)
          activeCardUser(id);
        });

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

          $('.btn-modal-active-user').css('display', status === 'CANCELADO' ? 'inline-block' : 'none');
          $('.btn-modal-cancel-user').css('display', status === 'ATIVO' ? 'inline-block' : 'none');


          $('#name').text('');
          $('#name').val(info.nome);
          $('#nascimento').text('');
          $('#nascimento').val(info.nascimento);
          $('#nome-mae').text('');
          $('#nome-mae').val(info.nome_mae);
          $('#local').text('');
          $('#local').val(info.local);
          $('#data').text('');
          $('#data').val(info.data_abordagem);
          $('#cartao').text('');
          $('#cartao').text(info.cod_cartao);
          $('#situacao').text('');
          $('#situacao').text(info.status);


          $('#btn-close-confirm-modal-cancel').attr('id', `${info.id_usuario}`);
          $('#btn-close-active-modal-cancel').attr('id', `${info.id_usuario}`);
          $('.modal-cancel-user').attr('id', `id-cancel-user-${info.id_usuario}`);
          $('.modal-active-user').attr('id', `id-active-user-${info.id_usuario}`);


          $('#btn-save-user').attr('id', `${info.id_usuario}`);
          $('#btn-edit-user').attr('id', `${info.id_usuario}`);

          $('#form-data').attr('id', `form-data-user-id-${info.id_usuario}`)

          $('.content-text-modal-situacao').css('color', status === 'ATIVO' ? '#008000' : '#ff0000')


        });


        $('.btn-save-user').unbind().click(function () {
          const id = $(this).attr('id');

          let formData = $(`#form-data-user-id-${id}`).serializeArray();
          const formDataSerialized = JSON.stringify(formData);

          editDataUser(id, formDataSerialized);
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
  let myModal = new bootstrap.Modal(document.getElementById(`id-btn-cancel-user-${id}`), {
    keyboard: false
  })
  myModal.toggle();
  $(`#confirm-cancel-id-${id}`);
  console.log(`Usuário cancelado: ${response.response}`)

}

function showConfirmModalActive(id) {
  let myModal = new bootstrap.Modal(document.getElementById(`id-btn-active-user-5580${id}`), {
    keyboard: false
  })
  myModal.toggle();
  $(`#confirm-active-id-${id}`);
  console.log(`Cartão Ativado: ${response.response}`)

}

function showModalCancelCard(id) {
  let myModal = new bootstrap.Modal($(`#modal-cancel-user-id-${id}`), {
    keyboard: false
  })
  myModal.toggle();
}

function showModalActiveCard(id) {
  let myModal = new bootstrap.Modal($(`#modal-active-user-id-${id}`), {
    keyboard: false
  })
  myModal.toggle();
}

function showModalReactivateCard(id) {
  let myModal = new bootstrap.Modal($(`#modal-reactivate-user-id-${id}`), {
    keyboard: false
  })
  myModal.toggle();
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

      const obj = JSON.parse(response.response);

      console.log(`RESPONSE: ${obj}`)

      if (obj == true) {
        const currentPageUrl = window.location.href; // Obtém a URL completa da página
        const parts = currentPageUrl.split('/'); // Divide a URL em partes usando a barra como separador
        const endpoint = parts[parts.length - 1]; // Obtém a última parte, que é o endpoint

        switch (endpoint) {
          case 'cartoes.php':
            getDataCards();
            break;
          case 'index.php':
            getAllCards();
            break;
          default:
            console.log('Endpoint desconhecido:', endpoint);
            break;
        }

        console.log(endpoint);
        $(`#modal-cancel-user-id-${id}`).modal('hide');
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
    url: "app/Controller/ActiveCard.php",
    data: {
      function: 'activeUser',
      id: id
    },
    beforeSend: function () {
    },
    success: function (r) {
      response = JSON.parse(r);

      const obj = JSON.parse(response.response);

      console.log(`RESPONSE: ${obj}`)

      if (obj == true) {
        const currentPageUrl = window.location.href; // Obtém a URL completa da página
        const parts = currentPageUrl.split('/'); // Divide a URL em partes usando a barra como separador
        const endpoint = parts[parts.length - 1]; // Obtém a última parte, que é o endpoint

        switch (endpoint) {
          case 'cartoes.php':
            getDataCards();
            break;
          case 'index.php':
            getAllCards();
            break;
          default:
            console.log('Endpoint desconhecido:', endpoint);
            break;
        }

        console.log(`ENDPOINT: ${endpoint}`);



        $(`#modal-active-user-id-${id}`).modal('hide');
      }


    },
    complete: function () {


    },
    error: function (e) {
      console.error(e);
    },
  })
}

function reactivateCardUser(id) {
  $.ajax({
    method: "POST",
    url: "app/Controller/RactivateCard.php",
    data: {
      function: 'reactivateCard',
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
        $(`#modal-active-user-id-${id}`).modal('hide');
      }


    },
    complete: function () {


    },
    error: function (e) {
      console.error(e);
    },
  })
}

function editDataUser(id, formDataSerialized) {
  $.ajax({
    method: "POST",
    url: "app/Controller/EditUser.php",
    data: {
      'func': 'editUser',
      id: id,
      formData: formDataSerialized
    },
    // processData: false,
    // contentType: false,
    beforeSend: function () {
      // Adicione aqui qualquer código a ser executado antes da requisição AJAX.
    },
    success: function (r) {
      try {
        const responseData = JSON.parse(r);

        if (!responseData.response) {
          throw responseData.data;
        }

        if (!responseData.data.length > 0) {
          throw responseData.data;
        }
        console.log(responseData.response);

        console.log('Sucesso ao editar usuário:', responseData.response);
        getAllCards();
      } catch (error) {
        console.error('Erro ao analisar a resposta JSON:', error);
      }
    },
    complete: function () {
      // Adicione aqui qualquer código a ser executado após a requisição AJAX ser concluída.
    },
    error: function (e) {
      console.error('Erro ao tentar editar usuário:', e);
    }
  });
}
