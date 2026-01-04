$(document).ready(function () {
  const removeHyphenFromString = (str) => {
    return str.replace(/-/g, "");
  }
  /* Funcion para llamar a la carga de los select de niveles y alicuotas al crear una unidad departamental */
  $('#newCompany').click(function (e) {
    e.preventDefault();
    $('.modal-title').text('Datos de Nueva Empresa');
    $('#newEmpresaModal').modal('show');
  });
  /* Arrow Function Que se Encarga de Cargar los Datos del Cliente en la Tabla */
  const loadDataTableCompanies = async () => {
    const table = $('#company_table').DataTable({
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
        url: "empresas_controller.php?op=get_list_companies",
        type: "GET",
        dataType: "json",
        dataSrc: "",
      },
      columns: [
        { data: "name" },
        { data: "dni" },
        { data: "address" },
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
  $('#formEmpresa').submit(function (e) {
    e.preventDefault();
    id = $('#c_id2').val();
    name = $('#c_name2').val();
    identity = $('#c_identity2').val();
    address = $('#c_address').val();
    dato = new FormData();
    dato.append('id', id);
    dato.append('name', name);
    dato.append('identity', identity);
    dato.append('address', address);
    $.ajax({
      url: 'empresas_controller.php?op=new_company',
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
          $('#company_table').DataTable().ajax.reload();
          $('#formEmpresa')[0].reset();
          $('#newEmpresaModal').modal('hide');
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
      url: 'empresas_controller.php?op=get_data_company',
      method: 'POST',
      dataType: 'json',
      data: { id: id },
      success: function (response) {
        $('#c_id2').val(response.id);
        $('#c_name2').val(response.name);
        $('#c_identity2').val(response.dni);
        $('#c_address').val(response.address);
        $('.modal-title').text('Editar Informacion de la Empresa');
        $('#newEmpresaModal').modal('show');
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
          url: 'empresas_controller.php?op=delete_company',
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
              $('#company_table').DataTable().ajax.reload();
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
  loadDataTableCompanies();
});