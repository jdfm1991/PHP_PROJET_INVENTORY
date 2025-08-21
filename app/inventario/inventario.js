$(document).ready(function () {
  const ac_id = document.getElementById('ac_id3');
  const item = document.getElementsByName('item');

  const i_id = document.getElementsByName('pi_id');
  const ci_id = document.getElementsByName('pci_id');
  const i_code = document.getElementsByName('pi_code');
  const i_name = document.getElementsByName('pi_name');
  const i_amount = document.getElementsByName('pi_amount');
  const i_quantity = document.getElementsByName('pi_quantity');
  const i_quant = document.getElementsByName('pi_quant');
  const i_balance = document.getElementsByName('pi_balance');
  const i_total = document.getElementsByName('pi_total');

  let items = [];
  let counter = 0;

  /* Funcion para listar todos los unidades departamentales existentes en la base de datos */
  const LoadDataTableInventoryMovements = async () => {
    const table = $('#inventory_table').DataTable({
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
        url: "inventario_controller.php?op=get_list_inventory_movements",
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
      ]
    });
  }
  /* Funcion Para Cargar El Contenido del Selectores del Modal "newInventoryMovementModal" */
  $('#newmovement').click(function (e) {
    e.preventDefault();
    loadDataRateTypes();
    $('.modal-title').text('Nuevo Movimiento de Cuenta');
    $('#ac_id3').attr('disabled', false);
    $('#formmovementinventory')[0].reset();
  });
  /* Accion para cargar y visualizar el select de proveedores o clientes */
  $("#ac_id3").change(function () {
    $('#content_item2').empty();
    items = []
  });
  /* Accion para contar los caracteres de la descripcion */
  $('#im_name').keyup(function (e) {
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

  $('#p_search2').keyup(function (e) {
    e.preventDefault();
    name = $(this).val();
    $.ajax({
      url: URI + 'productos/productos_controller.php?op=get_list_products_by_name',
      method: 'POST',
      dataType: 'json',
      data: { name: name },
      success: function (response) {
        $("#listproducts2").empty();
        $.each(response, function (idx, opt) {
          $("#listproducts2").append(`<option value="${opt.name} - ${opt.id}">`);
        });
      }
    });
  });
  /* Funcion Para Cargar El Contenido del Selectores del Modal "newInventoryMovementModal" */
  $('#b_add_p2').click(function (e) {
    e.preventDefault();
    id = $('#p_search2').val().split(' - ')[1];
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
        $("#content_item2").append(
          `<div name="item" id="cont_${counter}" class="row justify-content-between">
            <input type="hidden" name="pi_id" id="pi_id_${counter}" value="${response.id}">
            <input type="hidden" name="pci_id" id="pci_id_${counter}" value="${response.cate}">
            <button id="b_trash" type="button" class="col-md-1 btn btn-outline-danger btn-group-sm" data-value="${counter}" title="Eliminar Item"><i class="bi bi-dash"></i></button>
            <input name="pi_code" id="pi_code_${counter}" type="text" class="form-control col-md-2" value="${response.code}" disabled>
            <input name="pi_name" id="pi_name_${counter}" type="text" class="form-control col-md-2" value="${response.name}" disabled>
            <input name="pi_amount" id="pi_amount_${counter}" type="text" class="form-control col-md-1" value="${response.aumonts}" disabled>
            <input name="pi_quantity" id="pi_quantity_${counter}" type="number" class="form-control col-md-1" step="0.1">
            <input name="pi_quant" id="pi_quant_${counter}" type="text" class="form-control col-md-1" value="${response.quan}" disabled>
            <input name="pi_balance" id="pi_balance_${counter}" type="text" class="form-control col-md-1" disabled>
            <input name="pi_total" id="pi_total_${counter}" type="text" class="form-control col-md-1" disabled>
          </div>`
        );
        counter++;
        $('#p_search2').val('');
        for (let i = 0; i < counter; i++) {
          let balance = 0;
          let quantity = 0;
          let total = 0;
          const element = document.getElementById('pi_quantity_' + i);
          if (element) {
            element.addEventListener('keyup', function () {
              quantity = $(element).val();
              price = $(`#pi_amount_${i}`).val();
              quant = $(`#pi_quant_${i}`).val();
              console.log(quant);


              if (ac_id.value == 3) {
                balance = Number.parseFloat(quant) + Number.parseFloat(quantity);
                total = Number.parseFloat(quantity) * Number.parseFloat(price);
              }
              if (ac_id.value == 4) {
                balance = Number.parseFloat(quant) - Number.parseFloat(quantity);
                total = Number.parseFloat(quantity) * Number.parseFloat(price);
              }
              if (ac_id.value == 5) {
                balance = Number.parseFloat(quantity) - Number.parseFloat(quant);
                total = Number.parseFloat(balance) * Number.parseFloat(price);
              }

              $(`#pi_total_${i}`).val(total.toFixed(2));
              $(`#pi_balance_${i}`).val(balance.toFixed(2));
              getTotalMovement();
            })
          }

        }
      }
    });
  });
  /* Accion para Guardar o Actualizar Informacion de los Gastos en la Base de Datos */
  $('#formmovementinventory').submit(function (e) {
    e.preventDefault();
    let infoitems = [];
    id = $('#im_id').val();
    cate = $('#ac_id3').val();
    date = $('#im_date').val();
    name = $('#im_name').val().toUpperCase();
    amount = $('#im_amount').val();
    rate = $('#im_rate').val();
    change = $('#im_change').val();
    for (let i = 0; i < item.length; i++) {
      const id = i_id[i].value;
      const cate = ci_id[i].value;
      const code = i_code[i].value;
      const name = i_name[i].value;
      const amount = i_amount[i].value;
      const quantity = i_quantity[i].value;
      const quant = i_quant[i].value;
      const balance = i_balance[i].value;
      const total = i_total[i].value;
      infoitems.push({ id: id, cate: cate, code: code, name: name, amount: amount, quantity: quantity, quant: quant, balance: balance, total: total });
    }
    dato = new FormData();
    dato.append('id', id);
    dato.append('cate', cate);
    dato.append('date', date);
    dato.append('name', name);
    dato.append('amount', amount);
    dato.append('rate', rate);
    dato.append('change', change);
    dato.append('items', JSON.stringify(infoitems));
    $.ajax({
      url: 'inventario_controller.php?op=new_inventory_movement',
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
          $('#inventory_table').DataTable().ajax.reload();
          $('#formmovementinventory')[0].reset();
          $('#newInventoryMovementModal').modal('hide');
          $('#content_item2').empty();
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
      url: 'inventario_controller.php?op=get_data_inventory_movement',
      method: 'POST',
      dataType: 'json',
      data: { id: id },
      success: function (response) {
        $('.modal-title').text('Editar Movemento de Cuenta');
        $('#im_id').val(response.id);
        $('#ac_id3').val(response.cate);
        $('#e_id').val(response.entity);
        $('#im_name').val(response.movement);
        $('#im_date').val(response.date);
        $('#im_amount').val(response.amount);
        $('#ac_id3').attr('disabled', true);
        $('#e_id').attr('disabled', true);
        $('#a_id2').attr('disabled', true);
        $('#newInventoryMovementModal').modal('show');
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
          url: 'inventario_controller.php?op=delete_inventory_movement',
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
              $('#inventory_table').DataTable().ajax.reload();
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
    let rate = $('#im_rate').val();
    for (let i = 0; i <= counter; i++) {
      total = $(`#pi_total_${i}`).val();
      total = Number.parseFloat(total);
      if (!isNaN(total)) {
        sum += Number.parseFloat(total);
      }
      $('#im_amount').val(sum.toFixed(2));
      total = Number.parseFloat(sum) * Number.parseFloat(rate);
      $('#im_change').val(total.toFixed(2));
    }
  }

  function loadDataRateTypes() {
    $.ajax({
      url: URI + 'tasacambiaria/tasacambiaria_controller.php?op=get_exchange_rate_types',
      method: 'POST',
      dataType: 'json',
      success: function (response) {
        $('#cont_opcion2').empty();
        $.each(response, function (idx, opt) {
          if (opt.id == 1) {
            $('#cont_opcion2').append(`
              <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="opcion" id="${opt.id}" value="${opt.id}">
                <label class="form-check-label" for="${opt.id}">${opt.acr}</label>
              </div>`
            );
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
          $('#im_rate').val(response.dollar);
        }
        if (id == 2) {
          $('#im_rate').val(response.euro);
        }
        if (id == 3) {
          $('#im_rate').val(response.pref);
        }
        getTotalMovement();
      }
    });
  }
  LoadDataTableInventoryMovements();
});