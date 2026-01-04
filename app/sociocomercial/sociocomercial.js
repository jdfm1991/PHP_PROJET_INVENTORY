$(document).ready(function () {
  const removeHyphenFromString = (str) => {
    return str.replace(/-/g, "");
  }
  /* Cargar informacion de los tipos de socios comerciales al select despues de hacer clic en el boton de agregar un socio comercial */
  $('#newClient').click(function (e) {
    e.preventDefault();
    loadDataSelectTipoSocios();
    $('.modal-title').text('Nuevo Socio Comercial');
    $('#newClientModal').modal('show');
  })
  /* Arrow Function Que se Encarga de Cargar los Datos del Cliente en la Tabla */
  const loadDataTableClients = async () => {
    const table = $('#client_table').DataTable({
      responsive: true,
      scrollX: true,
      autoWidth: true,
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
        url: "sociocomercial_controller.php?op=get_list_clients",
        type: "GET",
        dataType: "json",
        dataSrc: "",
      },
      columns: [
        { data: "type" },
        { data: "name" },
        { data: "dni" },
        { data: "phone" },
        {
          data: "id", render: (data, _, __, meta) =>
            `<button id="b_update" class="btn btn-outline-primary btn-sm" data-value="${data}"><i class="fa fa-edit"></i></button>
            <button id="b_delete" class="btn btn-outline-danger btn-sm" data-value="${data}"><i class="fa fa-trash"></i></button>`, className: "text-center"
        }
      ],
      columnsDefs: [
        { targets: 5, width: "20%" },
      ],
    });

  }
  /* Accion para Guardar o Actualizar Informacion del Cliente en la Base de Datos */
  $('#formclient').submit(function (e) {
    e.preventDefault();
    sfdni = removeHyphenFromString($('#c_identity').val()); // Numero de DNI Sin Formatear
    fc = sfdni.charAt(0); // Primer Caracter del DNI
    if (!fc.match(/[a-zA-Z]/)) { // Si el Primer Caracter del DNI no es una Letra Arroja Mensaje de Error
      $('#m_client_cont').removeClass('d-none');
      $('#m_client_text').addClass('text-danger font-weight-bold text-center');
      $('#m_client_text').text('Primer Caracter debe ser una Letra del Alfabeto Indicando la Naturalidad del DNI (V E J G etc)');
      setTimeout(() => {
        $('#m_client_cont').addClass('d-none');
      }, 2000);
      return false;
    }
    nfdni = sfdni.charAt(0) + '-' + sfdni.substring(1); // Numero de DNI Formato Previo

    id = $('#c_id').val();
    type = $('#c_type').val();
    name = $('#c_name').val();
    dni = nfdni.toUpperCase(); // Numero de DNI Formateado
    phone = $('#c_phone').val();
    address = $('#c_address1').val();
    dato = new FormData();
    dato.append('id', id);
    dato.append('type', type);
    dato.append('name', name);
    dato.append('dni', dni);
    dato.append('phone', phone);
    dato.append('address', address);
    $.ajax({
      url: 'sociocomercial_controller.php?op=new_client',
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
          $('#client_table').DataTable().ajax.reload();
          $('#formclient')[0].reset();
          $('#newClientModal').modal('hide');
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
  $(document).on('click', '#b_update', function () {
    var id = $(this).data('value');
    $.ajax({
      url: 'sociocomercial_controller.php?op=get_data_client',
      method: 'POST',
      dataType: 'json',
      data: { id: id },
      success: function (response) {        
        loadDataSelectTipoSocios(response.type);
        $('#c_id').val(response.id);
        $('#c_name').val(response.name);
        $('#c_identity').val(response.dni);
        $('#c_phone').val(response.phone);
        $('#c_address1').val(response.address);
        $('.modal-title').text('Editar Informacion del Socio Comercial');
        $('#newClientModal').modal('show');
      }
    });
  })
  /* Accion para Eliminar Usuario de la Lista de usuario Visibles */
  $(document).on('click', '#b_delete', function () {
    var id = $(this).data('value');
    Swal.fire({
      title: 'Estas seguro de eliminar el cliente?',
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Si, Eliminar!'
    }).then((result) => {
      if (result.isConfirmed) {
        $.ajax({
          url: 'sociocomercial_controller.php?op=delete_client',
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
              $('#client_table').DataTable().ajax.reload();
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
  
  function loadDataSelectTipoSocios(id) {  
    $.ajax({
      url: 'sociocomercial_controller.php?op=get_partner_types',
      method: 'POST',
      dataType: 'json',
      success: function (response) {
        $("#c_type").empty();
        $("#c_type").append('<option value="">_-_Seleccione_-_</option>');
        $.each(response, function (idx, opt) {
          $("#c_type").append((opt.id == id) ?
            '<option value="' + opt.id + '" selected>' + opt.name + "</option>" :
            '<option value="' + opt.id + '">' + opt.name + "</option>"
          );
        });
      }
    });
  }

  loadDataTableClients();
});