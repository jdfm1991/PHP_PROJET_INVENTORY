$(document).ready(function () {
  const ac_id = document.getElementById('ac_id2');
  const item = document.getElementsByName('item');

  const i_id = document.getElementsByName('pi_id');
  const ci_id = document.getElementsByName('pci_id');
  const i_code = document.getElementsByName('pi_code');
  const i_name = document.getElementsByName('pi_name');
  const i_amount = document.getElementsByName('pi_amount');
  const i_quantity = document.getElementsByName('pi_quantity');
  const i_total = document.getElementsByName('pi_total');

  let items = [];
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
          data: null, render: (data, type, row, meta) =>
            (data.a_id == 1 || data.a_id == 2 ) && data.status == 1 ? `<button id="b_view" class="btn btn-outline-primary btn-sm" data-value="${data.id}" title="Ver Movimento"><i class="fa fa-eye"></i></button>
            <button id="b_delete" class="btn btn-outline-danger btn-sm" data-value="${data}" title="Eliminar Movimento"><i class="bi bi-trash3"></i></button>` : `<button id="b_view" class="btn btn-outline-primary btn-sm" data-value="${data.id}" title="Ver Movimento"><i class="fa fa-eye"></i></button>`
        }
      ]
    });
  }
  /* Funcion Para Cargar El Contenido del Selectores del Modal "newAccountMovementModal" */
  $('#newExpense').click(function (e) {
    e.preventDefault();
    $('#e_content').hide();
    $('#a_content').hide();
    loadDataRateTypes();
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
        i_id.forEach(input => {
          items.push(input.value);
        })
        if (items.includes(response.id)) {
          $(".mr-auto").text("Procesos Fallido");
          $(".toast").css("background-color", "rgba(16, 113, 224, 0.43)");
          $(".toast").css("color", "rgba(255, 255, 255, 1)");
          $("#toastText").text("Producto Seleccionado ya se Encuentra en el Listado");
          $('.toast').toast('show');
          return false;
        }
        $("#content_item").append(`<div name="item" id="cont_${counter}" class="row d-flex justify-content-between">
            <input type="hidden" name="pi_id" id="pi_id_${counter}" value="${response.id}">
            <input type="hidden" name="pci_id" id="pci_id_${counter}" value="${response.cate}">
            <button id="b_trash" type="button" class="col-md-1 btn btn-outline-danger btn-group-sm" data-value="${counter}" title="Eliminar Item"><i class="bi bi-dash"></i></button>
            <input name="pi_code" id="pi_code_${counter}" type="text" class="form-control col-md-2" value="${response.code}" disabled>
            <input name="pi_name" id="pi_name_${counter}" type="text" class="form-control col-md-3" value="${response.name}" disabled>
            <input name="pi_amount" id="pi_amount_${counter}" type="text" class="form-control col-md-2" value="${ac_id.value == 1 ? response.aumonts : response.aumontp}" disabled>
            <input name="pi_quantity" id="pi_quantity_${counter}" type="number" class="form-control col-md-2" step="0.1">
            <input name="pi_total" id="pi_total_${counter}" type="text" class="form-control col-md-2" value="" disabled></div>`
        );
        counter++;
        $('#p_search').val('');
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
    let infoitems = [];
    id = $('#am_id').val();
    cate = $('#ac_id2').val();
    date = $('#am_date').val();
    entity = $('#e_id').val();
    account = $('#a_id2').val();
    name = $('#am_name').val().toUpperCase();
    amount = $('#am_amount').val();
    rate = $('#am_rate').val();
    change = $('#am_change').val();
    for (let i = 0; i < item.length; i++) {
      const id = i_id[i].value;
      const cate = ci_id[i].value;
      const code = i_code[i].value;
      const name = i_name[i].value;
      const amount = i_amount[i].value;
      const quantity = i_quantity[i].value;
      const total = i_total[i].value;
      infoitems.push({ id: id, cate: cate, code: code, name: name, amount: amount, quantity: quantity, total: total });
    }
    dato = new FormData();
    dato.append('id', id);
    dato.append('cate', cate);
    dato.append('date', date);
    dato.append('entity', entity);
    dato.append('account', account);
    dato.append('name', name);
    dato.append('amount', amount);
    dato.append('rate', rate);
    dato.append('change', change);
    dato.append('items', JSON.stringify(infoitems));
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
          $('#content_item').empty();
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
  $(document).on('click', '#b_view', function (e) {
    e.preventDefault();
    var id = $(this).data('value');
    $.ajax({
      url: 'registrogasto_controller.php?op=get_data_account_movement',
      method: 'POST',
      dataType: 'json',
      data: { id: id },
      success: function (response) {
        alert('Se generara el reporte PDF');
      }
    });
  })
  /* Accion para cambiar el estado de la disponibilidad de unidad departamental */
  $(document).on('click', '#b_delete', function (e) {
    e.preventDefault();
    var id = $(this).data('value');
    console.log(id);
    
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
      $(".toast").css("background-color", "rgba(23, 224, 16, 0.43)");
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
  $(document).on('click', 'input[name="opcion"]', function () {
    const id = $(this).attr('value');
    loadDataRateToday(id);
  })
  function getTotalMovement() {
    let sum = 0;
    let total = 0;
    let rate = $('#am_rate').val();
    for (let i = 0; i <= counter; i++) {
      total = $(`#pi_total_${i}`).val();
      total = Number.parseFloat(total);
      if (!isNaN(total)) {
        sum += Number.parseFloat(total);
      }
      $('#am_amount').val(sum.toFixed(2));
      total = Number.parseFloat(sum) * Number.parseFloat(rate);
      $('#am_change').val(total.toFixed(2));
    }
  }

  function loadDataRateTypes() {
    $.ajax({
      url: URI + 'tasacambiaria/tasacambiaria_controller.php?op=get_exchange_rate_types',
      method: 'POST',
      dataType: 'json',
      success: function (response) {
        $('#cont_opcion').empty();
        $.each(response, function (idx, opt) {
          $('#cont_opcion').append(`
            <div class="form-check form-check-inline">
              <input class="form-check-input" type="radio" name="opcion" id="${opt.id}" value="${opt.id}">
              <label class="form-check-label" for="${opt.id}">${opt.acr}</label>
            </div>`
          );
          if (opt.id == 1) {
            loadDataRateToday(opt.id);
            document.getElementById(opt.id).checked = true;
          }
        })
      }
    });
  }
  function loadDataRateToday(id) {
    $.ajax({
      url: URI + 'tasacambiaria/tasacambiaria_controller.php?op=get_data_rate',
      method: 'POST',
      dataType: 'json',
      success: function (response) {
        if (id == 1) {
          $('#am_rate').val(response.dollar);
        }
        if (id == 2) {
          $('#am_rate').val(response.euro);
        }
        if (id == 3) {
          $('#am_rate').val(response.pref);
        }
        getTotalMovement();
      }
    });
  }
  LoadDataTableAccountMovements();
});