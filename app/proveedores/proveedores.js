$(document).ready(function () {
  /* Arrow Function Que se Encarga de Cargar los Datos del Cliente en la Tabla */
  const loadDataTableSuppliers = async () => {
    const table = $('#supplier_table').DataTable({
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
        url: "proveedores_controller.php?op=get_list_suppliers",
        type: "GET",
        dataType: "json",
        dataSrc: "",
      },
      columns: [
        { data: "name" },
        {
          data: null, render: (data, type, row, meta) =>
            data.clients.length > 0 ? data.clients.map((client) => client.nameClient).join(', ') : 'Sin Clientes'
        },
        {
          data: "id", render: (data, _, __, meta) =>
            `<button id="b_edit_supplier" class="btn btn-outline-primary btn-sm" data-value="${data}"><i class="fa fa-edit"></i></button>
          <button id="b_delete_supplier" class="btn btn-outline-danger btn-sm" data-value="${data}"><i class="fa fa-trash"></i></button>`, className: "text-center"
        }
      ]
    });

  }
  const loadRelacionSuppliers = async (id) => {
    $.ajax({
      url: 'proveedores_controller.php?op=get_data_relationship_suplier',
      method: 'POST',
      dataType: 'json',
      data: { id: id },
      success: function (response) {
        $("#liked").empty();
        $.each(response, function (idx, opt) {
          $("#liked").append(`<li class=" d-flex justify-content-between lh-sm">
                  <div>
                    <small class="text-body-secondary d-inline">${idx + 1} - </small>
                    <h6 class="font-weight-bold d-inline">${opt.client}</h6>
                  </div>
                  <div class="btn-group" role="group" aria-label="Button group name">
                    <button id="b_trash_link" type="button" class="btn btn-outline-danger btn-group-sm" data-value="${opt.id}" value="${opt.suplier}" title="Eliminar Vinculo"><i class="bi bi-dash"></i></button>
                  </div>
                </li>`);
        });
      }
    });
  }
  /* Funcion para llamar a la carga de los select de niveles y alicuotas al crear una unidad departamental */
  $('#newSupplier').click(function (e) {
    e.preventDefault();
    $('#idSuplier').val("");
    $('#nameSuplier').val("");
    $('#container_link').hide();
    $('.modal-title').text('Nuevo Proveedor');
    $('#newSuplierModal').modal('show');
  });
  $('#searchClient').keyup(function (e) {
    e.preventDefault();
    search = $('#searchClient').val();
    $.ajax({
      url: URI + 'relafidu/relafidu_controller.php?op=get_list_related_clients',
      method: 'POST',
      dataType: 'json',
      data: { search: search },
      success: function (response) {
        $("#listClients").empty();
        $.each(response, function (idx, opt) {
          $("#listClients").append(`<option value="${opt.unit} ${opt.name} - ${opt.iclient}">`);
        });
      }
    });
  });

  $('#newLink').click(function (e) {
    e.preventDefault();
    id = $('#idSuplier').val();
    client = $('#searchClient').val().split(' - ')[1];
    $.ajax({
      url: 'proveedores_controller.php?op=new_link',
      method: 'POST',
      dataType: 'json',
      data: { id: id, client: client },
      success: function (response) {
        if (response.status == true) {
          $(".mr-auto").text("Procesos Exitoso");
          $(".toast").css("background-color", "rgb(29 255 34 / 85%)");
          $(".toast").css("color", "white");
          $(".toast").attr("background-color", "");
          $("#toastText").text(response.message);
          $('.toast').toast('show');
          $('#searchClient').val("");
          loadRelacionSuppliers(id);
          $('#supplier_table').DataTable().ajax.reload();
        } else {
          $(".mr-auto").text("Procesos Fallido");
          $(".toast").css("background-color", "rgb(255 80 80 / 85%)");
          $(".toast").css("color", "white");
          $(".toast").attr("background-color", "");
          $("#toastText").text(response.message);
          $('.toast').toast('show');
        }
      }
    });
  });


  /* Accion para Guardar o Actualizar Informacion del Cliente en la Base de Datos */
  $('#formNewSuplier').submit(function (e) {
    e.preventDefault();
    id = $('#idSuplier').val();
    name = $('#nameSuplier').val().toUpperCase();
    link = $('#selectClient').val();
    dato = new FormData();
    dato.append('id', id);
    dato.append('name', name);
    dato.append('link', link);
    $.ajax({
      url: 'proveedores_controller.php?op=new_supplier',
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
          $('#supplier_table').DataTable().ajax.reload();
          $('#formNewSuplier')[0].reset();
          $('#newSuplierModal').modal('hide');
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

  });
  /* Accion para Eliminar Usuario de la Lista de usuario Visibles */
  $(document).on('click', '#b_edit_supplier', function () {
    var id = $(this).data('value');
    $.ajax({
      url: 'proveedores_controller.php?op=get_data_supplier',
      method: 'POST',
      dataType: 'json',
      data: { id: id },
      success: function (response) {
        loadRelacionSuppliers(response.id);
        $('#idSuplier').val(response.id);
        $('#nameSuplier').val(response.name);
        $('#container_link').show();
        $('.modal-title').text('Editar Informacion del Proveedor');
        $('#newSuplierModal').modal('show');
      }
    });
  })
  /* Accion para Eliminar Usuario de la Lista de usuario Visibles */
  $(document).on('click', '#b_delete_supplier', function () {
    var id = $(this).data('value');
    Swal.fire({
      title: 'Estas seguro de eliminar este proveedor?',
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Si, Eliminar!'
    }).then((result) => {
      if (result.isConfirmed) {
        $.ajax({
          url: 'proveedores_controller.php?op=delete_supplier',
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
              $('#supplier_table').DataTable().ajax.reload();
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

  $(document).on('click', '#b_trash_link', function () {
    id = $(this).data('value');
    var suplier = $(this).attr('value');
    $.ajax({
      url: 'proveedores_controller.php?op=delete_link',
      method: 'POST',
      dataType: 'json',
      data: { id: id },
      success: function (response) {
        if (response.status == true) {
          $(".mr-auto").text("Procesos Exitoso");
          $(".toast").css("background-color", "rgb(29 255 34 / 85%)");
          $(".toast").css("color", "white");
          $(".toast").attr("background-color", "");
          $("#toastText").text(response.message);
          $('.toast').toast('show');
          $('#searchClient').val("");
          loadRelacionSuppliers(suplier);
          $('#supplier_table').DataTable().ajax.reload();
        } else {
          $(".mr-auto").text("Procesos Fallido");
          $(".toast").css("background-color", "rgb(255 80 80 / 85%)");
          $(".toast").css("color", "white");
          $(".toast").attr("background-color", "");
          $("#toastText").text(response.message);
          $('.toast').toast('show');
        }
      }
    });

  })
  loadDataTableSuppliers();
});