$(document).ready(function () {
  const ac_id = document.getElementById('ac_id2');
  const item = document.getElementsByName('id');
  const info = document.querySelectorAll('input');
  let counter = 0;
  /* Funcion para Cargar Select de los proveedores */
  const loadDataSelectSupliers = async (id) => {
    try {
      const response = await fetch(URI + 'proveedores/proveedores_controller.php?op=get_list_suppliers');
      const data = await response.json();
      const container = document.getElementById('e_id');
      container.innerHTML = '';
      data.forEach((opt, idx) => {
        const option = document.createElement('option');
        if (id == opt.id) {
          option.setAttribute('value', opt.id);
          option.innerHTML = `${opt.name}`;
          option.setAttribute('selected', 'selected');
          container.appendChild(option);
        } else {
          option.setAttribute('value', opt.id);
          option.innerHTML = `${opt.name}`;
          container.appendChild(option);
        }
      })
    } catch (error) {
      console.log('Error', error);
    }
  }
  /* Funcion para Cargar Select de los proveedores */
  const loadDataSelectClients = async (id) => {
    try {
      const response = await fetch(URI + 'clientes/clientes_controller.php?op=get_list_clients');
      const data = await response.json();
      const container = document.getElementById('e_id');
      container.innerHTML = '';
      data.forEach((opt, idx) => {
        const option = document.createElement('option');
        if (id == opt.id) {
          option.setAttribute('value', opt.id);
          option.innerHTML = `${opt.name}`;
          option.setAttribute('selected', 'selected');
          container.appendChild(option);
        } else {
          option.setAttribute('value', opt.id);
          option.innerHTML = `${opt.name}`;
          container.appendChild(option);
        }
      })
    } catch (error) {
      console.log('Error', error);
    }
  }
  /* Funcion para Cargar Select de las cuentas de gastos */
  const loadDataSelectAccounts = async (id, ac_id) => {
    try {
      const response = await fetch(URI + 'cuentas/cuentagasto_controller.php?op=get_list_accounts_by_category&cate=' + ac_id, {
        method: 'GET',
        headers: {
          'Content-Type': 'application/json'
        },
      });
      const data = await response.json();
      const container = document.getElementById('a_id2');
      container.innerHTML = '';
      data.forEach((opt, idx) => {
        const option = document.createElement('option');
        if (id == opt.id) {
          option.setAttribute('value', opt.id);
          option.innerHTML = `${opt.name}`;
          option.setAttribute('selected', 'selected');
          container.appendChild(option);
        } else {
          option.setAttribute('value', opt.id);
          option.innerHTML = `${opt.name}`;
          container.appendChild(option);
        }
      })
    } catch (error) {
      console.log('Error', error);
    }
  }
  /* Funcion para listar todos los unidades departamentales existentes en la base de datos */
  const LoadDataTableAccountMovements = async () => {
    const table = $('#expense_table').DataTable({
      responsive: true,
      scrollX: true,
      autoWidth: false,
      paging: true,
      lengthChange: true,
      searching: true,
      ordering: false,
      displayLength: 10,
      lengthMenu: [10, 25, 50, 100],
      pageLength: 10,
      info: true,
      language: {
        lengthMenu: "Mostrar _MENU_ registros por pagina",
        zeroRecords: "No se encontraron registros",
        info: "Mostrando pagina _PAGE_ de _PAGES_",
        infoEmpty: "No hay registros disponibles",
        infoFiltered: "(filtrado de _MAX_ registros totales)",
        search: "Buscar:",
        paginate: {
          first: "Primero",
          last: "Ultimo",
          next: "Siguiente",
          previous: "Anterior"
        },
        loadingRecords: "Cargando...",
        processing: "Procesando..."
      },
      ajax: {
        url: "registrogasto_controller.php?op=get_list_account_movements",
        type: "GET",
        dataType: "json",
        dataSrc: "",
      },
      columns: [
        { data: "cate" },
        { data: "date" },
        { data: "account" },
        { data: "entity" },
        { data: "movement" },
        { data: "amount" },
        {
          data: "id", render: (data, _, __, meta) =>
            `<button id="b_update" class="btn btn-outline-primary btn-sm" data-value="${data}" data-toggle="tooltip" data-placement="top" title="Editar Cuenta"><i class="fa fa-edit"></i></button>
            <button id="b_delete" class="btn btn-outline-danger btn-sm" data-value="${data}" data-toggle="tooltip" data-placement="top" title="Eliminar Cuenta"><i class="bi bi-trash3"></i></button>`, className: "text-center"
        }
      ]
    });
  }
  /* Funcion Para Cargar El Contenido del Selectores del Modal "newAccountMovementModal" */
  $('#newExpense').click(function (e) {
    e.preventDefault();
    $('#e_content').hide();
    $('#a_content').hide();
    $('.modal-title').text('Nuevo Movimiento de Cuenta');
    $('#ac_id2').attr('disabled', false);
    $('#e_id').attr('disabled', false);
    $('#a_id2').attr('disabled', false);
    $('#formmovementaccount')[0].reset();
  });
  /* Accion para cargar y visualizar el select de proveedores o clientes */
  $("#ac_id2").change(function () {
    if ($(this).val() == 1) {
      loadDataSelectSupliers();
    } else {
      loadDataSelectClients();
    }
    $('#e_content').show();
    $('#a_content').hide();
    $('#content_item').empty();
  });
  /* Accion para cargar y visualizar el select de proveedores o clientes */
  $("#e_id").change(function () {
    var acid = ac_id.value;
    loadDataSelectAccounts('', acid);
    $('#a_content').show();
  });
  /* Accion para contar los caracteres de la descripcion */
  $('#am_name').keyup(function (e) {
    letters = $(this).val().length;
    $('#count').removeClass('bg-success bg-warning bg-danger text-muted text-white');
    $('#count').addClass('badge');
    $('#count').addClass('font-weight-bold');
    if (letters > 0 && letters <= 80) {
      $('#count').addClass('bg-success');
      $('#count').addClass('text-white');
      $('#count').text(letters + ' / 150');
    }
    if (letters >= 81 && letters <= 130) {
      $('#count').addClass('bg-warning');
      $('#count').addClass('text-muted');
      $('#count').text(letters + ' / 150');
    }
    if (letters >= 131) {
      $('#count').addClass('bg-danger');
      $('#count').addClass('text-white');
      $('#count').text('Le queda pocos caracteres ' + letters + ' / 150');
    }
  });

  $('#p_search').keyup(function (e) {
    e.preventDefault();
    name = $(this).val();
    $.ajax({
      url: URI + 'productos/productos_controller.php?op=get_list_products_by_name',
      method: 'POST',
      dataType: 'json',
      data: { name: name },
      success: function (response) {
        $("#listproducts").empty();
        $.each(response, function (idx, opt) {
          $("#listproducts").append(`<option value="${opt.name} - ${opt.id}">`);
        });
      }
    });
  });
  /* Funcion Para Cargar El Contenido del Selectores del Modal "newAccountMovementModal" */
  $('#b_add_p').click(function (e) {
    e.preventDefault();
    id = $('#p_search').val().split(' - ')[1];
    if (id == undefined) {
      $(".mr-auto").text("Procesos Fallido");
      $(".toast").css("background-color", "rgb(36 113 163 / 85%)");
      $(".toast").css("color", "dark");
      $("#toastText").text("Debe de Seleccionar Producto para continuar");
      $('.toast').toast('show');
      return false;
    }
    $.ajax({
      url: URI + 'productos/productos_controller.php?op=get_data_product',
      method: 'POST',
      dataType: 'json',
      data: { id: id },
      success: function (response) {
        item.forEach(input => {
          console.log(input.value);
          
          if (input.value == response.id) {
            $(".mr-auto").text("Procesos Fallido");
            $(".toast").css("background-color", "rgba(16, 113, 224, 0.43)");
            $(".toast").css("color", "rgba(255, 255, 255, 1)");
            $("#toastText").text("Producto Seleccionado ya se Encuentra en el Listado");
            $('.toast').toast('show');
            return false;
          }
        })
        $("#content_item").append(`<div name="item" id="cont_${counter}" class="row d-flex justify-content-between">
            <input type="hidden" name="id" id="pi_id_${counter}" value="${response.id}">
            <input type="hidden" id="pci_id_${counter}" value="${response.cate}">
            <button id="b_trash" type="button" class="col-md-1 btn btn-outline-danger btn-group-sm" data-value="${counter}" title="Eliminar Item"><i class="bi bi-dash"></i></button>
            <input id="pi_code_${counter}" type="text" class="form-control col-md-2" value="${response.code}" disabled>
            <input id="pi_name_${counter}" type="text" class="form-control col-md-3" value="${response.name}" disabled>
            <input id="pi_amount_${counter}" type="text" class="form-control col-md-2" value="${ac_id.value == 1 ? response.aumonts : response.aumontp}" disabled>
            <input id="pi_quantity_${counter}" type="number" class="form-control col-md-2" step="0.1">
            <input id="pi_total_${counter}" type="text" class="form-control col-md-2" value="" disabled></div>`
        );
        counter++;
        for (let i = 0; i < counter; i++) {
          const element = document.getElementById('pi_quantity_' + i);
          if (element) {
            element.addEventListener('keyup', function () {
              quantity = $(element).val();
              price = $(`#pi_amount_${i}`).val();
              total = Number.parseFloat(quantity) * Number.parseFloat(price);
              $(`#pi_total_${i}`).val(total.toFixed(2));
              getTotalMovement();
            })
          }

        }
      }
    });
  });
  /* Accion para Guardar o Actualizar Informacion de los Gastos en la Base de Datos */
  $('#formmovementaccount').submit(function (e) {
    e.preventDefault();
    id = $('#am_id').val();
    cate = $('#ac_id2').val();
    date = $('#am_date').val();
    entity = $('#e_id').val();
    account = $('#a_id2').val();
    name = $('#am_name').val().toUpperCase();
    amount = $('#am_amount').val();
    dato = new FormData();
    dato.append('id', id);
    dato.append('cate', cate);
    dato.append('date', date);
    dato.append('entity', entity);
    dato.append('account', account);
    dato.append('name', name);
    dato.append('amount', amount);
    $.ajax({
      url: 'registrogasto_controller.php?op=new_account_movement',
      method: 'POST',
      dataType: "json",
      data: dato,
      contentType: false,
      processData: false,
      success: function (response) {
        if (response.status == true) {
          Swal.fire({
            icon: "success",
            title: response.message,
            showConfirmButton: false,
            timer: 1500
          });
          $('#expense_table').DataTable().ajax.reload();
          $('#formmovementaccount')[0].reset();
          $('#newAccountMovementModal').modal('hide');
        } else {
          if (response.error === '400') {
            console.log(response);
            $('#messegecont').removeClass('d-none');
            $('#messegetext').text(response.message);
            setTimeout(function () {
              $('#messegecont').addClass('d-none');
            }, 3000);
          } else {
            Swal.fire({
              icon: "error",
              title: response.message,
              showConfirmButton: false,
              timer: 1500
            });

          }
        }
      }
    });
  });
  /* Accion Para Editar el Gasto Existente En La Lista de Gastos*/
  $(document).on('click', '#b_update', function (e) {
    e.preventDefault();
    var id = $(this).data('value');
    $.ajax({
      url: 'registrogasto_controller.php?op=get_data_account_movement',
      method: 'POST',
      dataType: 'json',
      data: { id: id },
      success: function (response) {
        if (response.cate == 1) {
          loadDataSelectSupliers(response.entity);
        };
        if (response.cate == 2) {
          loadDataSelectClients(response.entity);
        };
        loadDataSelectAccounts(response.account, response.cate);
        $('.modal-title').text('Editar Movemento de Cuenta');
        $('#am_id').val(response.id);
        $('#ac_id2').val(response.cate);
        $('#e_id').val(response.entity);
        $('#am_name').val(response.movement);
        $('#am_date').val(response.date);
        $('#am_amount').val(response.amount);
        $('#ac_id2').attr('disabled', true);
        $('#e_id').attr('disabled', true);
        $('#a_id2').attr('disabled', true);
        $('#newAccountMovementModal').modal('show');
      }
    });
  })
  /* Accion para cambiar el estado de la disponibilidad de unidad departamental */
  $(document).on('click', '#b_delete', function (e) {
    e.preventDefault();
    var id = $(this).data('value');
    Swal.fire({
      title: 'Estas seguro de eliminar el gasto?',
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Si, Eliminar!'
    }).then((result) => {
      if (result.isConfirmed) {
        $.ajax({
          url: 'registrogasto_controller.php?op=delete_account_movement',
          method: 'POST',
          dataType: 'json',
          data: { id: id },
          success: function (response) {
            if (response.status == true) {
              Swal.fire({
                icon: "success",
                title: response.message,
                showConfirmButton: false,
                timer: 1500
              });
              $('#expense_table').DataTable().ajax.reload();
            } else {
              Swal.fire({
                icon: "error",
                title: response.message,
                showConfirmButton: false,
                timer: 1500
              });
            }
          }
        });
      }
    })
  })

  $(document).on('click', '#b_trash', function () {
    const id = $(this).data('value');
    const container = document.getElementById('cont_' + id)
    container.remove();
    const del_container = document.getElementById('cont_' + id);
    if (del_container == null) {
      $(".mr-auto").text("Procesos Exitoso");
      $(".toast").css("z-index", "1000");
      $(".toast").css("background-color", "rgb(29 255 34 / 85%)");
      $(".toast").css("color", "white");
      $(".toast").attr("background-color", "");
      $("#toastText").text("item Eliminado con exito");
      $('.toast').toast('show');
    } else {
      $(".mr-auto").text("Procesos Fallido");
      $(".toast").css("z-index", "1000");
      $(".toast").css("background-color", "rgb(255 80 80 / 85%)");
      $(".toast").css("color", "white");
      $(".toast").attr("background-color", "");
      $("#toastText").text("Error al Eliminar item");
      $('.toast').toast('show');
    }
    getTotalMovement();
  })

  function getTotalMovement() {
    let sum = 0;
    for (let i = 0; i <= counter; i++) {
      total = $(`#pi_total_${i}`).val();
      total = Number.parseFloat(total);
      if (!isNaN(total)) {
        sum += Number.parseFloat(total);
      }
      $('#am_amount').val(sum.toFixed(2));
    }
  }
  LoadDataTableAccountMovements();
});


/* 
  ac_id.value == 1 ? 
          $("#content_item").append(`<input id="pi_amount_${nitem}" type="text" class="form-control col-md-2" value="${response.aumonts}" disabled>
            <input id="pi_quantity_${nitem}" type="number" class="form-control col-md-2" step="0.1">
            <input id="pi_total_${nitem}" type="text" class="form-control col-md-2" value="" disabled>`) :
          $("#content_item").append(`<input id="pi_amount_${nitem}" type="text" class="form-control col-md-2" value="${response.aumontp}" disabled>
            <input id="pi_quantity_${nitem}" type="number" class="form-control col-md-2" step="0.1">
            <input id="pi_total_${nitem}" type="text" class="form-control col-md-2" value="" disabled>`);` */