$(document).ready(function () {
  const at = document.getElementById('at_id');
  /* Funcion para Cargar Select de los tipos de gastos departamentales */
  const loadDataSelectAccontTypes = async (id) => {
    try {
      const response = await fetch('cuentagasto_controller.php?op=get_account_types');
      const data = await response.json();
      const container = document.getElementById('at_id');
      container.innerHTML = '';
      const defaultOption = document.createElement('option');
      defaultOption.setAttribute('value', '');
      defaultOption.innerHTML = 'Tipo de Cuenta...';
      container.appendChild(defaultOption);
      data.forEach((opt, idx) => {
        const option = document.createElement('option');
        if (id == opt.id) {
          option.setAttribute('value', opt.id);
          option.innerHTML = `${opt.type}`;
          option.setAttribute('selected', 'selected');
          container.appendChild(option);
        } else {
          option.setAttribute('value', opt.id);
          option.innerHTML = `${opt.type}`;
          container.appendChild(option);
        }
      })
    } catch (error) {
      console.log('Error', error);
    }
  }
  /* Funcion para listar todos los unidades departamentales existentes en la base de datos */
  const LoadDataTableAccounts = async () => {
    const table = $('#expense_account_table').DataTable({
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
        url: "cuentagasto_controller.php?op=get_list_accounts",
        type: "GET",
        dataType: "json",
        dataSrc: "",
      },
      columns: [
        { data: "cate" },
        { data: "type" },
        { data: "code" },
        { data: "name" },
        {
          data: "id", render: (data, _, __, meta) =>
            `<button id="b_update" class="btn btn-outline-primary btn-sm" data-value="${data}" data-toggle="tooltip" data-placement="top" title="Editar Cuenta"><i class="fa fa-edit"></i></button>
            <button id="b_delete" class="btn btn-outline-danger btn-sm" data-value="${data}" data-toggle="tooltip" data-placement="top" title="Eliminar Cuenta"><i class="bi bi-trash3"></i></button>`, className: "text-center"
        }
      ]
    });
  }
  /* Funcion para obtener el nombre del Tipo de Gasto seleccionado */
  $('#at_id').change(function (e) {
    e.preventDefault();
    var id = at.value;
    var text = at.options[at.selectedIndex].text;
    $.ajax({
      url: "cuentagasto_controller.php?op=get_code_by_type",
      method: 'POST',
      dataType: "json",
      data: { id: id, type: text },
      success: function (response) {
        $('#a_code').val(response);
      }
    });
  });
  /* Accion para Guardar o Actualizar Informacion de los Gastos en la Base de Datos */
  $('#formaccount').submit(function (e) {
    e.preventDefault();
    id = $('#a_id').val();
    cate = $('#ac_id').val();
    type = $('#at_id').val();
    code = $('#a_code').val();
    name = $('#a_name').val().toUpperCase();
    if (cate == '' || type == '') {
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
    dato.append('type', type);
    dato.append('code', code);
    dato.append('name', name);
    $.ajax({
      url: 'cuentagasto_controller.php?op=new_account',
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
          $('#expense_account_table').DataTable().ajax.reload();
          $('#formaccount')[0].reset();
          $('#newAccountModal').modal('hide');
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
  /* Funcion Para Cargar El Contenido del Select "at_id" */
  $('#newExpense').click(function (e) {
    e.preventDefault();
    $('#at_id').attr('disabled', false);
    $("#ac_id").prop('disabled', false);
    $('#formaccount')[0].reset();
    loadDataSelectAccontTypes();
  });
  /* Accion Para Editar Una Cuenta de Gasto Existente En La Lista de Cuentas de Gastos*/
  $(document).on('click', '#b_update', function (e) {
    e.preventDefault();
    var id = $(this).data('value');
    $.ajax({
      url: 'cuentagasto_controller.php?op=get_data_account',
      method: 'POST',
      dataType: 'json',
      data: { id: id },
      success: function (response) {       
        loadDataSelectAccontTypes(response.type);
        $('#a_id').val(response.id);
        $('#ac_id').val(response.cate);
        $('#a_code').val(response.code);        
        $('#a_name').val(response.name);
        $('#at_id').attr('disabled', true);
        $('#ac_id').attr('disabled', true);
        $('#newAccountModal').modal('show');
      }
    });
  })
  /* Accion para cambiar el estado de la disponibilidad de unidad departamental */
  $(document).on('click', '#b_delete', function (e) {
    e.preventDefault();
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
          url: 'cuentagasto_controller.php?op=delete_account',
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
              $('#expense_account_table').DataTable().ajax.reload();
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
  LoadDataTableAccounts();
});