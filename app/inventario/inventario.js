$(document).ready(function () {
  const ac_id = document.getElementById('ac_id3');
  const item = document.getElementsByName('item');

  const i_id = document.getElementsByName('pi_id');
  const ci_id = document.getElementsByName('pci_id');
  const i_name = document.getElementsByName('pi_name');
  const ui_id = document.getElementsByName('pui_id');
  const i_amount = document.getElementsByName('pi_amount');
  const i_quantity = document.getElementsByName('pi_quantity');
  const i_existence = document.getElementsByName('pi_existence');
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
        { data: "company" },
        { data: "category" },
        { data: "partner" },
        { data: "date" },
        { data: "amount" },
        { data: "change" },
        {
          data: "id", render: (data, _, __, meta) =>
            `<button id="b_view" class="btn btn-outline-primary btn-sm" data-value="${data}" title="Ver Movimento"><i class="fa fa-eye"></i></button>`
        }
      ]
    });
  }
  /* Funcion Para Cargar El Contenido del Selectores del Modal "newInventoryMovementModal" */
  $('#newmovement').click(function (e) {
    e.preventDefault();
    loadDataRateTypes();
    loadDataSelectCompanies();
    $('.modal-title').text('Nuevo Movimiento de Cuenta');
    $('.table').hide();
    $('#newInventoryMovementModal').modal('show');
    $('#ac_id3').attr('disabled', false);
    $('#formmovementinventory')[0].reset();
  });
  /* Accion para cargar y visualizar el select de proveedores o clientes */
  $("#ac_id3").change(function () {
    $('#content_item2').empty();
    items = []
    $('.table').hide();
    counter = 0;
    
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
    if (ac_id.value == "") {
      $(".mr-auto").text("Procesos Fallido");
      $(".toast").css("background-color", "rgba(148, 16, 224, 0.59)");
      $(".toast").css("color", "rgba(255, 255, 255, 1)");
      $("#toastText").text("Debe de Seleccionar Una Categoria Para Continuar");
      $('.toast').toast('show');
      return false;
    }
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
        if (items.includes(response.id)) {
          $(".mr-auto").text("Procesos Fallido");
          $(".toast").css("background-color", "rgba(16, 113, 224, 0.43)");
          $(".toast").css("color", "rgba(255, 255, 255, 1)");
          $("#toastText").text("Producto Seleccionado ya se Encuentra en el Listado");
          $('.toast').toast('show');
          return false;
        }        
        $("#content_item2").append(
          `<tr name="item" id="cont_${counter}">
            <td>
            <input type="hidden" name="pi_id" id="pi_id_${counter}" value="${response.id}">
            <input type="hidden" name="pci_id" id="pci_id_${counter}" value="${response.cate}">
            <input type="hidden" name="pui_id" id="pui_id_${counter}" value="${response.unit}">
            <button id="b_trash" type="button" class="btn btn-outline-danger" data-value="${counter}" data-product="${response.id}"><i class="bi bi-dash"></i></button>
            </td>
            <td>${response.name}
            <input type="hidden" name="pi_name" id="pi_name_${counter}" value="${response.name}">
            </td>
            <td>${response.aumonts}
            <input type="hidden" name="pi_amount" id="pi_amount_${counter}" value="${response.aumonts}">
            </td>
            <td><input name="pi_quantity" id="pi_quantity_${counter}" type="text" class="form-control"></td>
            <td>${response.existence}
            <input  type="hidden" name="pi_existence" id="pi_existence_${counter}" value="${response.existence}">
            </td>
            <td>${response.acronym}</td>
            <td><input name="pi_balance" id="pi_balance_${counter}" type="text" class="form-control" disabled></td>
            <td><input name="pi_total" id="pi_total_${counter}" type="text" class="form-control" disabled></td>
          </tr>`
        );
        items.push(response.id);
        $('.table').show();
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
              if (quantity == "") {
                quantity = 0;
              }
              price = $(`#pi_amount_${i}`).val();
              existence = $(`#pi_existence_${i}`).val();
              if (ac_id.value == 3) {
                balance = Number.parseFloat(existence) + Number.parseFloat(quantity);
                total = Number.parseFloat(quantity) * Number.parseFloat(price);
              }
              if (ac_id.value == 4) {
                balance = Number.parseFloat(existence) - Number.parseFloat(quantity);
                total = Number.parseFloat(quantity) * Number.parseFloat(price);
              }
              if (ac_id.value == 5) {
                balance = Number.parseFloat(quantity) - Number.parseFloat(existence);
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
    company = $('#am_company2').val();
    category = $('#ac_id3').val();
    date = $('#im_date').val();
    rtype = $('input[name="rtype"]:checked').val();
    rate = $('#im_rate').val();
    name = $('#im_name').val().toUpperCase();
    amount = $('#im_amount').val();
    change = $('#im_change').val();
    for (let i = 0; i < item.length; i++) {
      const id = i_id[i].value;
      const name = i_name[i].value;
      const cate = ci_id[i].value;
      const unit = ui_id[i].value;
      const amount = i_amount[i].value;
      const quantity = i_quantity[i].value;
      const existence = i_existence[i].value;
      const balance = i_balance[i].value;
      const total = i_total[i].value;
      infoitems.push({ id: id, name: name, cate: cate, unit: unit, amount: amount, quantity: quantity, existence: existence, balance: balance, total: total });
    }
   // console.log({id: id, company: company, category: category, date: date, rtype: rtype, rate: rate, name: name, amount: amount, change: change, items: infoitems});
    
    dato = new FormData();
    dato.append('id', id);
    dato.append('company', company);
    dato.append('category', category);
    dato.append('date', date);
    dato.append('rtype', rtype);
    dato.append('rate', rate);
    dato.append('name', name);
    dato.append('amount', amount);
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
    var product = $(this).data('product');
    var indice = items.indexOf(product)
    items.splice(indice, 1)
    const container = document.getElementById('cont_' + id)
    container.remove();
    const del_container = document.getElementById('cont_' + id);   
    if (items.length === 0) {
      $('.table').hide();
    }
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

  $('#im_date').change(function (e) {
    e.preventDefault();
    rtype = $('input[name="rtype"]:checked').val();
    loadDataRateByDate(rtype);

  });
  $(document).on('click', 'input[name="rtype"]', function () {
    const id = $(this).attr('value');
    loadDataRateByDate(id);
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
          $('#cont_opcion2').append(`
            <div class="form-check form-check-inline">
              <input class="form-check-input" type="radio" name="rtype" id="${opt.id}" value="${opt.id}">
              <label class="form-check-label" for="${opt.id}">${opt.acr}</label>
            </div>`
          );
          if (opt.id == 1) {
            loadDataRateByDate(opt.id);
            document.getElementById(opt.id).checked = true;
          }
        })
      }
    });
  }

  function loadDataSelectCompanies(id) {
    $.ajax({
      url: URI + 'empresas/empresas_controller.php?op=get_list_companies',
      method: 'POST',
      dataType: 'json',
      success: function (response) {
        $("#am_company2").empty();
        $("#am_company2").append('<option value="">_-_Seleccione_-_</option>');
        $.each(response, function (idx, opt) {
          $("#am_company2").append((opt.id == id) ?
            '<option value="' + opt.id + '" selected>' + opt.name + "</option>" :
            '<option value="' + opt.id + '">' + opt.name + "</option>"
          );
        });
      }
    });
  }
  function loadDataRateByDate(type) {
    let date = $('#im_date').val();
    $.ajax({
      url: URI + 'tasacambiaria/tasacambiaria_controller.php?op=get_data_rate',
      method: 'POST',
      dataType: 'json',
      data: { type: type, date: date },
      success: function (response) {
        $('#im_rate').val(response.rate);
        getTotalMovement();
      }
    });
  }
  LoadDataTableInventoryMovements();
});