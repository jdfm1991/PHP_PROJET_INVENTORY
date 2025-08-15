$(document).ready(function () {
  
  const removeAccentsFromString = (str) => {
    str.normalize("NFD").replace(/[\u0300-\u036f]/g, "");
    return str.toUpperCase();
  }

  const removeHyphenFromString = (str) => {
    return str.replace(/-/g, "");
  }
  /* Arrow Function Que se Encarga de Cargar los Datos del Cliente en la Tabla */
  const loadDataTableClients = async () => {
    const table = $('#client_table').DataTable({
      responsive: true,
      scrollX: true,
      autoWidth: true,
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
        url: "clientes_controller.php?op=get_list_clients",
        type: "GET",
        dataType: "json",
        dataSrc: "",
      },
      columns: [
        { data: "name" },
        { data: "dni" },
        { data: "email" },
        { data: "phone" },
        { data: "phonealt" },
        {
          data: "id", render: (data, _, __, meta) =>
            `<button id="b_edit_client" class="btn btn-outline-primary btn-sm" data-value="${data}"><i class="fa fa-edit"></i></button>
            <button id="b_delete_client" class="btn btn-outline-danger btn-sm" data-value="${data}"><i class="fa fa-trash"></i></button>`, className: "text-center"
        }
      ],
      columnsDefs: [
        { targets: 5, width: "20%" },
      ],
    });

  }
  /* Accion para Guardar o Actualizar Informacion del Cliente en la Base de Datos */
  $('#formClient').submit(function (e) {
    e.preventDefault();
    sfdni = removeHyphenFromString($('#clientDni').val()); // Numero de DNI Sin Formatear
    sfphone = $('#clientPhone').val(); // Numero de Telefono Sin Formatear
    sfname = $('#clientName').val() // Nombre de Cliente Sin Formatear
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
    if (sfphone.length < 10) { // Si el Numero de Telefono no tiene 10 Digitos Arroja Mensaje de Error
      $('#m_client_cont').removeClass('d-none');
      $('#m_client_text').addClass('text-danger font-weight-bold text-center');
      $('#m_client_text').text('El Numero de Telefono debe tener 10 Digitos');
      setTimeout(() => {
        $('#m_client_cont').addClass('d-none');
      }, 2000);
      return false;
    } 
    if (sfphone.length == 10) { // Si el Numero de Telefono tiene 10 Digitos Le Agrega el 58 al Comienzo
      sfphone = '58' + sfphone;
    }
    id = $('#clientId').val();
    name = removeAccentsFromString(sfname);
    nfdni = sfdni.charAt(0) + '-' + sfdni.substring(1); // Numero de DNI Formato Previo
    dni = nfdni.toUpperCase(); // Numero de DNI Formateado
    phone = sfphone.replace(/(\d{2})(\d{3})(\d{3})(\d{4})/, '+($1) $2-$3-$4'); // Numero de Telefono Formateado
    phonealt = $('#clientPhoneAlt').val();
    email = $('#clientEmail').val();
    dato = new FormData();
    dato.append('id', id);
    dato.append('name', name);
    dato.append('dni', dni);
    dato.append('phone', phone);
    dato.append('phonealt', phonealt);
    dato.append('email', email);
    $.ajax({
      url: 'clientes_controller.php?op=new_client',
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
          $('#formClient')[0].reset();
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
  $(document).on('click', '#b_edit_client', function () {
    var id = $(this).data('value');
    $.ajax({
      url: 'clientes_controller.php?op=get_data_client',
      method: 'POST',
      dataType: 'json',
      data: { id: id },
      success: function (response) {
        $.each(response, function (idx, opt) {
          $('#clientId').val(opt.id);
          $('#clientName').val(opt.name);
          $('#clientDni').val(opt.dni);
          $('#clientPhone').val(opt.phone);
          $('#clientPhoneAlt').val(opt.phonealt);
          $('#clientEmail').val(opt.email);
        });
        $('.modal-title').text('Editar Informacion del Cliente');
        $('#newClientModal').modal('show');
      }
    });
  })
   /* Accion para Eliminar Usuario de la Lista de usuario Visibles */
  $(document).on('click', '#b_delete_client', function () {
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
          url: 'clientes_controller.php?op=delete_client',
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
  loadDataTableClients();
});