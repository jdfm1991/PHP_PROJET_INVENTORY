$(document).ready(function () {
  const type = document.getElementById('typeExpense');
  /* Funcion para Cargar Select de los tipos de gastos departamentales */
  const loadDataSelectTypeExpenses = async (id) => {
    try {
      const response = await fetch('cuentagasto_controller.php?op=get_type_expenses');
      const data = await response.json();
      const container = document.getElementById('typeExpense');
      container.innerHTML = '';
      const defaultOption = document.createElement('option');
      defaultOption.setAttribute('value', '');
      defaultOption.innerHTML = 'Tipo de Gasto...';
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
  const LoadDataTableExpenseAccounts = async () => {
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
        url: "cuentagasto_controller.php?op=get_list_expense_accounts",
        type: "GET",
        dataType: "json",
        dataSrc: "",
      },
      columns: [
        { data: "type" },
        { data: "code" },
        { data: "fixed" },
        { data: "expense" },
        {
          data: "id", render: (data, _, __, meta) =>
            `<button id="b_edit_expense_account" class="btn btn-outline-primary btn-sm" data-value="${data}" data-toggle="tooltip" data-placement="top" title="Editar Cuenta"><i class="fa fa-edit"></i></button>
            <button id="b_trash_expense_account" class="btn btn-outline-danger btn-sm" data-value="${data}" data-toggle="tooltip" data-placement="top" title="Eliminar Cuenta"><i class="bi bi-trash3"></i></button>`, className: "text-center"
        }
      ]
    });
  }
  /* Funcion para obtener el nombre del Tipo de Gasto seleccionado */
  $('#typeExpense').change(function (e) {
    e.preventDefault();
    const id = type.value;
    const text = type.options[type.selectedIndex].text;
    $.ajax({
      url: "cuentagasto_controller.php?op=get_code_expense_by_type",
      method: 'POST',
      dataType: "json",
      data: { id: id, type: text },
      success: function (response) {
        $('#codeExpense').val(response);
      }
    });
  });
  /* Accion para marcar la casilla de los gastos fijos */
  $("#fixedExpense").change(function () {
    if ($(this).is(":checked")) {
      $("#fixedExpense").prop('checked', true);
    } else {
      $("#fixedExpense").prop('checked', false);
    }
  });
  /* Accion para Guardar o Actualizar Informacion de los Gastos en la Base de Datos */
  $('#formNewExpense').submit(function (e) {
    e.preventDefault();
    id = $('#idExpense').val();
    typed = $('#typeExpense').val();
    code = $('#codeExpense').val();
    fixed = $('#fixedExpense').is(':checked');
    expense = $('#nameExpense').val().toUpperCase();
    dato = new FormData();
    dato.append('id', id);
    dato.append('type', typed);
    dato.append('code', code);
    dato.append('fixed', fixed);
    dato.append('expense', expense);
    $.ajax({
      url: 'cuentagasto_controller.php?op=new_expense_account',
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
          $('#formNewExpense')[0].reset();
          $('#newExpenseAccountModal').modal('hide');
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
  /* Funcion Para Cargar El Contenido del Select "typeExpense" */
  $('#newExpense').click(function (e) {
    e.preventDefault();
    $('#typeExpense').attr('disabled', false);
    $("#fixedExpense").prop('checked', false);
    $('#idExpense').val('');
    $('#codeExpense').val('');
    $('#nameExpense').val('');
    loadDataSelectTypeExpenses();
  });
  /* Accion Para Editar Una Cuenta de Gasto Existente En La Lista de Cuentas de Gastos*/
  $(document).on('click', '#b_edit_expense_account', function (e) {
    e.preventDefault();
    var id = $(this).data('value');
    $.ajax({
      url: 'cuentagasto_controller.php?op=get_data_expense_account',
      method: 'POST',
      dataType: 'json',
      data: { id: id },
      success: function (response) {
        loadDataSelectTypeExpenses(response.type);
        $('#idExpense').val(response.id);
        $('#codeExpense').val(response.code);
        if (response.fixed == 1) {
          $("#fixedExpense").prop('checked', true);
        } else {
          $("#fixedExpense").prop('checked', false);
        }
        $('#nameExpense').val(response.expense);
        $('#typeExpense').attr('disabled', true);
        $('#newExpenseAccountModal').modal('show');
      }
    });
  })
  /* Accion para cambiar el estado de la disponibilidad de unidad departamental */
  $(document).on('click', '#b_trash_expense_account', function (e) {
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
          url: 'cuentagasto_controller.php?op=delete_expense_account',
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
  LoadDataTableExpenseAccounts();
});