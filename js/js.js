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

        const qtdActive = responseData.data[2]['cartoes_ativos'];
        const qtdCancel = responseData.data[2]['cartoes_cancelados'];

        
          
        const inputCardActive = $('#ativos');

        //if (inputCardActive.val())
        
        console.log(inputCardActive.val());

        $('#ativos').append(qtdActive);
        $('#cancelados').append(qtdCancel);

        

        $.each(responseData.data[1], function (index, info) {
          const statusCard = info.status_cartao;
          const row = $(`
                  <tr>
                    <td id="codigo-cartao" class="content-text-table">${info.codigo_cartao}</td>
                    <td id="data-criacao" class="content-text-table">${info.data_criacao}</td>
                    <td id="status" class="content-text-table status-card">${info.status_cartao}</td>
                    <td>
                      
                      <i class="fa-solid fa-magnifying-glass-plus fa-xl btn-view-card" id="${info.id_usuario}"></i>
                    </td>
                    <td>
                      <i class="fa-solid fa-list fa-xl btn-show-card-user" id="btn-show-card-user-id-${info.id_usuario}" data-bs-toggle="modal"
                        data-bs-target="#myModal"></i>
                    </td>
                    <td>
                      <i class="fa-solid fa-ban fa-xl btn-cancel-user" id="${info.id_usuario}" style="color: #ff0202;"></i>
                      <i class="fa-solid fa-rotate-right fa-xl btn-active-user" id="${info.id_usuario}" style="color: #388e49;"></i>
                      <i class="fa-duotone fa-plus fa-xl btn-reactivate-user" id="${info.id_usuario}" style="color: #414bb2;"></i>
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

          statusElement.css('font-weight', '800');

          const status = info.status_cartao;

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

        $('.btn-view-card').unbind().click(function () {
          const id = $(this).attr('id');
          $('.btn-close-modal').attr('id', `${id}`)
          getModalCard(id)
        })

        $('.btn-show-card-user').click(function () {
          let id = $(this).attr('id');
          id = id.split('-').pop();
          alert(`click: ${id}`);
          $('.modal-use-card').modal('show');

        })


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

          $('.modal-reactivate-user').attr('id', `modal-reactivate-user-id-${id}`)

          $('.btn-confirm-reactivate').attr('id', `${id}`);

          $('.btn-close-confirm-modal-reactivate').attr('id', `${id}`);
          showModalReactivateCard(id);

        });

        $('.btn-modal-active-user').unbind().click(function () {
          const id = $(this).attr('id');

          $('.modal-active-user').attr('id', `modal-active-user-id-${id}`)

          $('.btn-confirm-active').attr('id', `${id}`);

          $('.btn-close-confirm-modal-active').attr('id', `${id}`);
          showModalActiveCard(id);

        });

        $('.btn-modal-reactivate-user').unbind().click(function () {
          const id = $(this).attr('id');

          $('.modal-reactivate-user').attr('id', `modal-active-user-id-${id}`)

          $('.btn-confirm-reactivate').attr('id', `${id}`);

          $('.btn-close-confirm-modal-reactivate').attr('id', `${id}`);
          showModalReactivateCard(id);

        });


        $('.btn-confirm-cancel').unbind().click(function () {
          const id = $(this).attr('id');
          const currentDate = new Date();
          const formattedDate = formatDate(currentDate); // Formata a data


          cancelCardUser(id, formattedDate);
        });

        $('.btn-confirm-active').unbind().click(function () {
          const id = $(this).attr('id');

          activeCardUser(id);
        });

        $('.btn-confirm-reactivate').unbind().click(function () {
          const id = $(this).attr('id');

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
          $('.btn-modal-reactivate-user').css('display', status === 'INATIVO' ? 'inline-block' : 'none');


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

          var cor = (status === 'ATIVO') ? '#008000' : (status === 'CANCELADO') ? '#ff0000' : '#000000';
          $('.content-text-modal-situacao').css('color', cor);

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

function getModalCard(id) {
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
      const responseData = JSON.parse(r);



      $('.modal-view-card').attr('id', `id-card-${id}`)
      $(this).attr('data-bs-target', `#id-card-${id}`)


      let myModal = new bootstrap.Modal(document.getElementById(`id-card-${id}`), {
        keyboard: false
      })

      myModal.toggle()

      const data = responseData.data[0]; // Obtenha o primeiro objeto de dados

      const cardStatus = data.status;
      const date = data.data_cancelamento;

      $('#situacao-cartao').css('color',
        cardStatus === 'ATIVO' ? '#008000' :
          cardStatus === 'CANCELADO' ? '#ff0000' :
            cardStatus === 'INATIVO' ? '#000000' :
              '#000000' // Cor padrão caso o valor não corresponda a nenhum dos três
      );
      $('#situacao-cartao').css('font-weight', '800');



      $('#nome').text(data.nome);
      $('#nascimento').text(data.nascimento);
      $('#nome-mae').text(data.nome_mae);
      $('#local').text(data.local);
      $('#data').text(data.data_abordagem);
      $('#cartao').text(data.cod_cartao);
      $('#situacao-cartao').text(data.status);

      if (date) {
        $('#data-cancelamento').text(data.data_cancelamento);
        $('.cancelation-date').css('display', 'inline-block');
      } else {
        $('.cancelation-date').css('display', 'none');
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

function cancelCardUser(id, formattedDate) {
  $.ajax({
    method: "POST",
    url: "app/Controller/CancelUser.php",
    data: {
      function: 'cancelUser',
      id: id,
      cancellationDate: formattedDate
    },
    beforeSend: function () {
    },
    success: function (r) {
      response = JSON.parse(r);

      const obj = JSON.parse(response.response);
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
        $(`#modal-cancel-user-id-${id}`).modal('hide');
        $('.modal-content-cancel-user').modal('hide')
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
        $('.modal-content-active-user').modal('hide')
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



        $(`#modal-reactivate-user-id-${id}`).modal('hide');
        $('.modal-content-reactivate-user').modal('hide')
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
function formatDate(date) {
  const day = String(date.getDate()).padStart(2, '0');
  const month = String(date.getMonth() + 1).padStart(2, '0');
  const year = date.getFullYear();
  return `${day}/${month}/${year}`;
}

