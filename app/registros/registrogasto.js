$(document).ready(function () {
  $('#quota_content').hide();
  /* Funcion para Cargar Select de los proveedores */
  const loadDataSelectSupplier = async (id) => {
    try {
      const response = await fetch(URI + 'proveedores/proveedores_controller.php?op=get_list_suppliers');
      const data = await response.json();
      const container = document.getElementById('suplierExpense');
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
  const loadDataSelectExpenseAccounts = async (id) => {
    try {
      const response = await fetch(URI + 'cuentagasto/cuentagasto_controller.php?op=get_list_expense_accounts');
      const data = await response.json();
      const container = document.getElementById('accountExpense');
      container.innerHTML = '';
      data.forEach((opt, idx) => {
        const option = document.createElement('option');
        if (id == opt.id) {
          option.setAttribute('value', opt.id);
          option.innerHTML = `${opt.expense}`;
          option.setAttribute('selected', 'selected');
          container.appendChild(option);
        } else {
          option.setAttribute('value', opt.id);
          option.innerHTML = `${opt.expense}`;
          container.appendChild(option);
        }
      })
    } catch (error) {
      console.log('Error', error);
    }
  }
  /* Funcion para listar todos los unidades departamentales existentes en la base de datos */
  const LoadDataTableExpenses = async () => {
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
        url: "registrogasto_controller.php?op=get_list_expenses",
        type: "GET",
        dataType: "json",
        dataSrc: "",
      },
      columns: [
        { data: "date" },
        { data: "suplier" },
        { data: "account" },
        { data: "expense" },
        { data: "mont" },
        {
          data: null, render: (data, type, row) =>
            row.type == 5 ?
              `<button id="b_edit_expense" class="btn btn-outline-primary btn-sm" data-value="${row.id}"><i class="fa fa-edit" title="Editar Gasto"></i></button>
              <button id="b_uptdate_expense" class="btn btn-outline-primary btn-sm" data-value="${row.id}"><i class="bi bi-arrow-repeat" title="Actualizar Gasto"></i></button>
            <button id="b_trash_expense" class="btn btn-outline-danger btn-sm" data-value="${row.id}"><i class="bi bi-trash3" title="Eliminar Gasto"></i></button>`
              :
              `<button id="b_edit_expense" class="btn btn-outline-primary btn-sm" data-value="${row.id}"><i class="fa fa-edit" title="Editar Gasto"></i></button>
            <button id="b_trash_expense" class="btn btn-outline-danger btn-sm" data-value="${row.id}"><i class="bi bi-trash3" title="Eliminar Gasto"></i></button>`
        }
      ]
    });
  }
  /* Funcion Para Cargar El Contenido del Selectores del Modal "newExpenseModal" */
  $('#newExpense').click(function (e) {
    e.preventDefault();
    $('.modal-title').text('Nuevo Gasto');
    $('#suplierExpense').attr('disabled', false);
    $('#accountExpense').attr('disabled', false);
    $('#idExp').val('');
    $('#formExpense')[0].reset();
    loadDataSelectSupplier();
    loadDataSelectExpenseAccounts();
  });
  /* Accion para contar los caracteres de la descripcion */
  $('#datailExpense').keyup(function (e) {
    letters = $(this).val().length;
    $('#count').removeClass('bg-success bg-warning bg-danger test-black');
    $('#count').addClass('badge');
    $('#count').addClass('text-white');
    $('#count').addClass('font-weight-bold');
    if (letters > 0 && letters <= 80) {
      $('#count').addClass('bg-success');
      $('#count').text(letters + ' / 150');
    }
    if (letters >= 81 && letters <= 130) {
      $('#count').addClass('bg-warning');
      $('#count').addClass('text-black');
      $('#count').text(letters + ' / 150');
    }
    if (letters >= 131) {
      $('#count').addClass('bg-danger');
      $('#count').text('Le queda pocos caracteres ' + letters + ' / 150');
    }
  });
  /* Accion para visualizar el campo para agregar la cuota en caso de ser necesario */
  $("#quotaExpense").change(function () {
    if ($(this).is(":checked")) {
      $('#quota_content').show();
    } else {
      $('#quota_content').hide();
    }
  });
  /* Accion para Guardar o Actualizar Informacion de los Gastos en la Base de Datos */
  $('#formExpense').submit(function (e) {
    e.preventDefault();
    id = $('#idExp').val();
    suplier = $('#suplierExpense').val();
    account = $('#accountExpense').val();
    detail = $('#datailExpense').val().toUpperCase();
    mont = $('#montExpense').val();
    quota = $('#montQuota').val();
    date = $('#dateExpense').val();
    dato = new FormData();
    dato.append('id', id);
    dato.append('suplier', suplier);
    dato.append('account', account);
    dato.append('detail', detail);
    dato.append('mont', mont);
    dato.append('quota', quota);
    dato.append('date', date);
    $.ajax({
      url: 'registrogasto_controller.php?op=new_expense',
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
          $('#formExpense')[0].reset();
          $('#newExpenseModal').modal('hide');
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
  $(document).on('click', '#b_edit_expense', function (e) {
    e.preventDefault();
    var id = $(this).data('value');
    $.ajax({
      url: 'registrogasto_controller.php?op=get_data_expense',
      method: 'POST',
      dataType: 'json',
      data: { id: id },
      success: function (response) {
        loadDataSelectSupplier(response.suplier);
        loadDataSelectExpenseAccounts(response.account);
        $('.modal-title').text('Editar Gasto');
        $('#idExp').val(response.id);
        $('#datailExpense').val(response.expense);
        $('#dateExpense').val(response.date);
        $('#montExpense').val(response.mont);
        if (response.quota != null) {
          $("#quotaExpense").prop('checked', true);
          $('#quota_content').show();
          $('#montQuota').val(response.quota);
        } else {
          $("#quotaExpense").prop('checked', false);
          $('#quota_content').hide();
        }
        $('#suplierExpense').attr('disabled', true);
        $('#accountExpense').attr('disabled', true);
        $('#newExpenseModal').modal('show');
      }
    });
  })
  $(document).on('click', '#b_uptdate_expense', function (e) {
    e.preventDefault();
    var id = $(this).data('value');
    $.ajax({
      url: 'registrogasto_controller.php?op=get_sum_movement',
      method: 'POST',
      dataType: 'json',
      data: { id: id },
      success: function (response) {
        if (response.status == true) {
          $(".mr-auto").text("Procesos Exitoso");
          $(".toast").css("background-color", "rgba(8, 140, 201, 0.842)");
          $(".toast").css("color", "black");
          $(".toast").attr("background-color", "");
          $("#toastText").text(response.message);
          $('.toast').toast('show');
          $('.toast').toast('show');
          $('#expense_table').DataTable().ajax.reload();
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
  /* Accion para cambiar el estado de la disponibilidad de unidad departamental */
  $(document).on('click', '#b_trash_expense', function (e) {
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
          url: 'registrogasto_controller.php?op=delete_expense',
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
  LoadDataTableExpenses();
});