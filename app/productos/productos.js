$(document).ready(function () {
  const item = document.getElementsByName('item');
  const pc = document.getElementById('pc_id');
  const i_id = document.getElementsByName('pi_id');
  const i_name = document.getElementsByName('pi_name');
  const i_amount = document.getElementsByName('pi_amount');
  const i_unit = document.getElementsByName('pi_unit');
  const i_quantity = document.getElementsByName('pi_quantity');
  const i_total = document.getElementsByName('pi_total');

  let items = [];
  let counter = 0;
  let list = [];


  /* Funcion para listar todos los unidades departamentales existentes en la base de datos */
  const LoadDataTableProducts = async () => {
    const table = $('#product_table').DataTable({
      responsive: true,
      scrollX: true,
      autoWidth: false,
      paging: true,
      lengthChange: true,
      searching: true,
      ordering: true,
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
        url: "productos_controller.php?op=get_list_products",
        type: "GET",
        dataType: "json",
        dataSrc: "",
      },
      columns: [
        { data: "cate" },
        { data: "code" },
        { data: "name" },
        { data: "unit" },
        { data: "aumontp" },
        { data: "aumonts" },
        { data: "quan" },
        {
          data: "id", render: (data, _, __, meta) =>
            `<button id="b_additional" class="btn btn-outline-info btn-sm" data-value="${data}" data-toggle="tooltip" data-placement="top" title="Ver Detalles"><i class="bi bi-info-circle"></i></button>
            <button id="b_update" class="btn btn-outline-primary btn-sm" data-value="${data}" data-toggle="tooltip" data-placement="top" title="Editar Cuenta"><i class="fa fa-edit"></i></button>
            <button id="b_delete" class="btn btn-outline-danger btn-sm" data-value="${data}" data-toggle="tooltip" data-placement="top" title="Eliminar Cuenta"><i class="bi bi-trash3"></i></button>`, className: "text-center"
        }
      ]
    });
  }
  /* Funcion Para Cargar El Contenido del Select "at_id" */
  $('#newProduct').click(function (e) {
    e.preventDefault();
    $('#formproduct')[0].reset();
    $('#pc_id').attr('disabled', false);
    loadDataSelectProductCategories();
    loadDataSelectProductUnits();
  });
  /* Funcion para obtener el nombre del Tipo de Gasto seleccionado */
  $('#pc_id').change(function (e) {
    e.preventDefault();
    var id = pc.value;
    var text = pc.options[pc.selectedIndex].text;
    if (id == '2') {
      $('.recipe').removeClass('d-none');
      $('.containt-recipe').addClass('modal-lg');
    } else {
      $('.recipe').addClass('d-none');
      $('.containt-recipe').removeClass('modal-lg');
    }
    $.ajax({
      url: "productos_controller.php?op=get_code_by_category",
      method: 'POST',
      dataType: "json",
      data: { id: id, cate: text },
      success: function (response) {
        $('#p_code').val(response);
      }
    });
  });

  $('#p_recipe').keyup(function (e) {
    e.preventDefault();
    name = $(this).val();
    $.ajax({
      url: 'productos_controller.php?op=get_list_recipe_product',
      method: 'POST',
      dataType: 'json',
      data: { name: name },
      success: function (response) {
        $("#listrecipe").empty();
        $.each(response, function (idx, opt) {
          $("#listrecipe").append(`<option value="${opt.name} - ${opt.id}">`);
        });
      }
    });
  });

  $('#add_ingredient').click(function (e) {
    e.preventDefault();
    id = $('#p_recipe').val().split(' - ')[1];
    if (id == undefined) {
      $(".mr-auto").text("Procesos Fallido");
      $(".toast").css("background-color", "rgb(36 113 163 / 85%)");
      $(".toast").css("color", "dark");
      $("#toastText").text("Debe de Seleccionar Producto para continuar");
      $('.toast').toast('show');
      return false;
    }
    $.ajax({
      url: 'productos_controller.php?op=get_data_recipe_product',
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
            <button id="b_trash" type="button" class="col-md-1 btn btn-danger btn-group-sm" data-value="${counter}" title="Eliminar Item"><i class="bi bi-dash"></i></button>
            <input name="pi_name" id="pi_name_${counter}" type="text" class="form-control col-md-4" value="${response.name}" disabled>
            <input name="pi_amount" id="pi_amount_${counter}" type="text" class="form-control col-md-2" value="${ response.aumontp}" disabled>
            <input name="pi_quantity" id="pi_quantity_${counter}" type="text" class="form-control col-md-2" step="0.1">
            <input name="pi_unit" id="pi_unit_${counter}" type="text" class="form-control col-md-1" value="${response.acronym}" disabled>
            <input name="pi_total" id="pi_total_${counter}" type="text" class="form-control col-md-2" value="" disabled></div>`
        );
        counter++;
        $('#p_recipe').val('');
        for (let i = 0; i < counter; i++) {
          const element = document.getElementById('pi_quantity_' + i);
          if (element) {
            element.addEventListener('keyup', function () {
              quantity = $(element).val();
              if (quantity == '') {
                quantity = 0;
              }
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

  $(document).on('click', '#b_trash', function () {
    const row = $(this).data('value');
    var product = $(this).data('product');
    var recipe = $(this).data('recipe');
    deleteItemRecipe(recipe, product);
    const container = document.getElementById('cont_' + row)
    container.remove();
    const del_container = document.getElementById('cont_' + row);
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

  /* Accion para Guardar o Actualizar Informacion de los Gastos en la Base de Datos */
  $('#formproduct').submit(function (e) {
    e.preventDefault();
    let infoitems = [];
    id = $('#p_id').val();
    cate = $('#pc_id').val();
    code = $('#p_code').val();
    name = $('#p_name').val().toUpperCase();
    unit = $('#p_unit').val();
    amount_p = $('#p_amount_p').val();
    amount_s = $('#p_amount_s').val();
    for (let i = 0; i < item.length; i++) {
      const id = i_id[i].value;
      const name = i_name[i].value;
      const amount = i_amount[i].value;
      const quantity = i_quantity[i].value;
      const unit = i_unit[i].value;
      const total = i_total[i].value;
      infoitems.push({ id: id, name: name, amount: amount, quantity: quantity, unit: unit, total: total });
    }

    if (cate == '') {
      $(".mr-auto").text("Procesos Fallido");
      $(".toast").css("background-color", "rgb(36 113 163 / 85%)");
      $(".toast").css("color", "white");
      $("#toastText").text("Debe de Seleccionar Categoria y tipo para continuar");
      $('.toast').toast('show');
      return false;
    }
    dato = new FormData();
    dato.append('id', id);
    dato.append('cate', cate);
    dato.append('code', code);
    dato.append('name', name);
    dato.append('unit', unit);
    dato.append('amountp', amount_p);
    dato.append('amounts', amount_s);
    dato.append('items', JSON.stringify(infoitems));
    $.ajax({
      url: 'productos_controller.php?op=new_product',
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
          $('#product_table').DataTable().ajax.reload();
          $('#formproduct')[0].reset();
          $('#content_item').empty();
          $('.recipe').addClass('d-none');
          $('.containt-recipe').removeClass('modal-lg');
          $('#newProductModal').modal('hide');
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

  /* Accion Para Editar Una Cuenta de Gasto Existente En La Lista de Cuentas de Gastos*/
  $(document).on('click', '#b_update', function (e) {
    e.preventDefault();
    var id = $(this).data('value');
    $.ajax({
      url: 'productos_controller.php?op=get_data_product',
      method: 'POST',
      dataType: 'json',
      data: { id: id },
      success: function (response) {
        loadDataSelectProductCategories(response.cate);
        loadDataSelectProductUnits(response.unit);
        $('#p_id').val(response.id);
        $('#p_code').val(response.code);
        $('#p_name').val(response.name);
        $('#p_amount_p').val(response.aumontp);
        $('#p_amount_s').val(response.aumonts);
        $('#pc_id').attr('disabled', true);
        if (response.cate == 2) {
          loadDataItemsRecipe(response.id)
          $('.recipe').removeClass('d-none');
          $('.containt-recipe').addClass('modal-lg');
        } else {
          $('#content_item').empty();
          $('.recipe').addClass('d-none');
          $('.containt-recipe').removeClass('modal-lg');
        }
        $('#newProductModal').modal('show');
      }
    });
  })
  /* Accion para cambiar el estado de la disponibilidad de unidad departamental */
  $(document).on('click', '#b_delete', function (e) {
    e.preventDefault();
    var id = $(this).data('value');
    Swal.fire({
      title: 'Estas seguro de eliminar el producto?',
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Si, Eliminar!'
    }).then((result) => {
      if (result.isConfirmed) {
        $.ajax({
          url: 'productos_controller.php?op=delete_product',
          method: 'POST',
          dataType: 'json',
          data: { id: id },
          success: function (response) {
            console.log(response);
            
            if (response.status == true) {
              Swal.fire({
                icon: "success",
                title: response.message,
                showConfirmButton: false,
                timer: 1500
              });
              $('#product_table').DataTable().ajax.reload();
            } else {
              Swal.fire({
                icon: "info",
                title: response.message,
                showConfirmButton: false,
                timer: 2500
              });
            }
          }
        });
      }
    })
  })
  /* Accion Para Editar Una Cuenta de Gasto Existente En La Lista de Cuentas de Gastos*/
  $(document).on('click', '#b_additional', function (e) {
    e.preventDefault();
    var id = $(this).data('value');
    if (list) {
      $('#product_list_table').DataTable().destroy();
    }
    list = $('#product_list_table').DataTable({
      "responsive": true,
      "scrollX": true,
      "autoWidth": true,
      "paging": true,
      "lengthChange": true,
      "searching": false,
      "ordering": true,
      "displayLength": 10,
      "lengthMenu": [10, 25, 50, 100],
      "pageLength": 10,
      "info": true,
      "language": {
        "lengthMenu": "Mostrar _MENU_ registros por pagina",
        "zeroRecords": "No se encontraron registros",
        "info": "Mostrando pagina _PAGE_ de _PAGES_",
        "infoEmpty": "No hay registros disponibles",
        "infoFiltered": "(filtrado de _MAX_ registros totales)",
        "search": "Buscar:",
        "paginate": {
          "first": "Primero",
          "last": "Ultimo",
          "next": "Siguiente",
          "previous": "Anterior"
        },
        "loadingRecords": "Cargando...",
        "processing": "Procesando..."
      },
      "ajax": {
        "url": "productos_controller.php?op=get_data_product_movements",
        "method": 'POST', //usamos el metodo POST
        "dataSrc": "",
        "data": { id: id },
      },
      "columns": [
        { "data": "name" },
        { "data": "move" },
        { "data": "quantity" },
      ],
    });
    $('#listProductMovementsModal').modal('show');
  })

  function loadDataSelectProductCategories(id) {
    try {
      $.ajax({
        url: 'productos_controller.php?op=get_product_categories',
        method: 'POST',
        dataType: 'json',
        success: function (response) {
          $("#pc_id").empty();
          $("#pc_id").append('<option value="">_-_Seleccione_-_</option>');
          $.each(response, function (idx, opt) {
            $("#pc_id").append((opt.id == id) ?
              '<option value="' + opt.id + '" selected>' + opt.cate + "</option>" :
              '<option value="' + opt.id + '">' + opt.cate + "</option>"
            );
          });
        }
      });
    } catch (error) {
      console.log('Error', error);
    }
  }

  function loadDataSelectProductUnits(id) {
    try {
      $.ajax({
        url: 'productos_controller.php?op=get_product_units',
        method: 'POST',
        dataType: 'json',
        success: function (response) {
          $("#p_unit").empty();
          $("#p_unit").append('<option value="">_-Seleccione-_</option>');
          $.each(response, function (idx, opt) {
            $("#p_unit").append((opt.id == id) ?
              '<option value="' + opt.id + '" selected>' + opt.name + "</option>" :
              '<option value="' + opt.id + '">' + opt.name + "</option>"
            );
          });
        }
      });
    } catch (error) {
      console.log('Error', error);
    }
  }

  function loadDataItemsRecipe(id) {
    try {
      $.ajax({
        url: 'productos_controller.php?op=get_items_recipe',
        method: 'POST',
        dataType: 'json',
        data: { id: id },
        success: function (response) {
          $("#content_item").empty();
          $.each(response, function (idx, opt) {
            $("#content_item").append(`<div name="item" id="cont_${counter}" class="row d-flex justify-content-between">
            <input type="hidden" name="pi_id" id="pi_id_${counter}" value="${opt.product}">
            <button id="b_trash" type="button" class="col-md-1 btn btn-danger btn-group-sm" data-value="${counter}" data-product="${opt.product}" data-recipe="${opt.recipe}" title="Eliminar Item"><i class="bi bi-dash"></i></button>
            <input name="pi_name" id="pi_name_${counter}" type="text" class="form-control col-md-4" value="${opt.name}" disabled>
            <input name="pi_amount" id="pi_amount_${counter}" type="text" class="form-control col-md-2" value="${opt.amount}" disabled>
            <input name="pi_quantity" id="pi_quantity_${counter}" type="number" class="form-control col-md-2" step="0.1" value="${opt.quantity}">
            <input name="pi_unit" id="pi_unit_${counter}" type="text" class="form-control col-md-1" value="${opt.unit}" disabled>
            <input name="pi_total" id="pi_total_${counter}" type="text" class="form-control col-md-2" value="${opt.total}" disabled></div>`
            );
            counter++;
            $('#p_recipe').val('');
            for (let i = 0; i < counter; i++) {
              const element = document.getElementById('pi_quantity_' + i);
              if (element) {
                element.addEventListener('keyup', function () {
                  quantity = $(element).val();
                  if (quantity == '') {
                    quantity = 0;
                  }
                  price = $(`#pi_amount_${i}`).val();
                  total = Number.parseFloat(quantity) * Number.parseFloat(price);
                  $(`#pi_total_${i}`).val(total.toFixed(2));
                  getTotalMovement();
                })
              }

            }
          });
        }
      });
    } catch (error) {
      console.log('Error', error);
    }
  }

  function getTotalMovement() {
    let sum = 0;
    let total = 0;
    for (let i = 0; i <= counter; i++) {
      total = $(`#pi_total_${i}`).val();
      total = Number.parseFloat(total);
      if (!isNaN(total)) {
        sum += Number.parseFloat(total);
      }
      $('#p_amount_p').val(sum.toFixed(2));
    }
  }

  function deleteItemRecipe(recipe, product) {
    $.ajax({
      url: 'productos_controller.php?op=delete_item_recipe',
      method: 'POST',
      dataType: 'json',
      data: { id: recipe, code: product },
      success: function (response) {
        if (response.status == true) {
          Swal.fire({
            icon: "success",
            title: response.message,
            showConfirmButton: false,
            timer: 1500
          });
        } else {
          Swal.fire({
            icon: "info",
            title: response.message,
            showConfirmButton: false,
            timer: 2500
          });
        }
      }
    });
  }


  LoadDataTableProducts();
});