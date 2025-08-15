$(document).ready(function () {
  /* Definiendo variables para calcular, obtener, almacenar y formatear fechas */
  const DateNow = new Date();
  const opciones = { year: 'numeric', month: 'long' };
  const period = DateNow.toLocaleDateString('es-VE', opciones).toUpperCase();
  const vencimento = new Date(DateNow.getTime() + 15 * 24 * 60 * 60 * 1000); // 15 Representa La cantidad de dias a sumar, 24 * 60 * 60 * 1000 Representa la cantidad de milisegundos en un dia
  const vence = vencimento.getFullYear() + '-' + String(vencimento.getMonth() + 1).padStart(2, '0') + '-' + String(vencimento.getDate()).padStart(2, '0');
  /* Definiendo elementos para obtener valores de los gastos fijos y almacenarlos en un arreglo */
  const codef = document.getElementsByName('codef')
  const typef = document.getElementsByName('typef')
  const expensef = document.getElementsByName('expensef')
  const ef_amount = document.getElementsByName('ef_amount')
  const gf_amount = document.getElementsByName('gf_amount')
  /* Definiendo elementos para obtener valores de los gastos variables y almacenarlos en un arreglo */
  const codenf = document.getElementsByName('codenf')
  const typenf = document.getElementsByName('typenf')
  const expensenf = document.getElementsByName('expensenf')
  const enf_amount = document.getElementsByName('enf_amount')
  const gv_amount = document.getElementsByName('gv_amount')
  /* Definiendo elementos para obtener valores de los ingresos y almacenarlos en un arreglo */
  const codei = document.getElementsByName('codei')
  const typei = document.getElementsByName('typei')
  const incomef = document.getElementsByName('incomef')
  const ii_amount = document.getElementsByName('ii_amount')
  const i_amount = document.getElementsByName('i_amount')
  /* Definiendo elementos para obtener valores de las penalidades y almacenarlos en un arreglo */
  const typep = document.getElementsByName('typep')
  const codep = document.getElementsByName('codep')
  const incomep = document.getElementsByName('incomep')
  const ip_amount = document.getElementsByName('ip_amount')
  const p_amount = document.getElementsByName('p_amount')
  /* Funcion para cargar la tabla de recibos que se encuentran en la base de datos */
  const loadDataTableReceipts = async () => {
    const table = $('#receipt_table').DataTable({
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
        url: "recibocobro_controller.php?op=get_list_receipts",
        type: "GET",
        dataType: "json",
        dataSrc: "",
      },
      columns: [
        { data: "date" },
        { data: "number" },
        { data: "unit" },
        { data: "name" },
        { data: "concept" },
        { data: "expiration" },
        { data: "aumont" },
        {
          data: "id", render: (data, _, __, meta) =>
            `<button id="b_delete_receipt" class="btn btn-outline-danger btn-sm" data-value="${data}" title="Eliminar Recibo"><i class="fa fa-trash"></i></button>
            <button id="b_view_receipt" class="btn btn-outline-info btn-sm" data-value="${data}" title="Ver Recibo"><i class="bi bi-eye-fill"></i></button>
            <button id="b_send_receipt" class="btn btn-outline-success btn-sm" data-value="${data}" title="Enviar Recibo"><i class="bi bi-send"></i></button> `, className: "text-center"
        }
      ],
      rowCallback: function (row, data, index) {
        if (data.type === 'PENAL') {
          $(row).css('background-color', 'rgba(252, 138, 138, 0.31)');
          $(row).css('color', 'black');
          $(row).css('font-weight', 'bold');
        } else {
          $(row).css('color', 'black');
          $(row).css('font-weight', 'bold');
        }
      },
      order: [[0, "desc"]],
      columnDefs: [{ width: '12%', targets: 7 }],
    });

  }
  /* Funcion para limpiar los campos */
  const clearFields = function () {
    $('#formReceipt')[0].reset();
    $('#content_fixed_body').empty();
    $('#content_non_fixed_body').empty();
    $('#content_penalty_body').empty();
    $('#content_income_body').empty();
    $('#content_fixed').addClass('d-none');
    $('#content_non_fixed').addClass('d-none');
    $('#content_penalty').addClass('d-none');
    $('#content_income').addClass('d-none');
  }
  /* Funcion para obtener el numero de recibo */
  const getNewNumberRC = function () {
    $.ajax({
      url: "recibocobro_controller.php?op=get_new_number",
      method: 'POST',
      dataType: "json",
      success: function (response) {
        $('#n_rc').text(response);
      }
    });
  }
  /* Funcion para obtener el monto de cada item para tener dos decimales */
  const getFormatting = function (amount) {
    const x = Number.parseFloat(amount);
    return x.toFixed(2);
  }
  /* Funcion para calcular el monto de cada item */
  const getCalcFormatting = function (amount, aliquot) {
    const x = (Number.parseFloat(amount) * Number.parseFloat(aliquot)) / 100;
    return x.toFixed(2);
  }
  /* Funcion para obtener el total de cada seccion del recibo */
  const getTotals = function (select) {
    let suma_gf = 0;
    let suma_gv = 0;
    let suma_i = 0;
    let suma_p = 0;
    let suma = 0;
    let saldo = 0;
    let mora = 0;
    let gastos = 0;
    for (let i = 0; i < gf_amount.length; i++) {
      const amount = parseFloat(gf_amount[i].value);
      if (!isNaN(amount)) {
        suma_gf += amount;
      }
    }
    for (let i = 0; i < gv_amount.length; i++) {
      const amount = parseFloat(gv_amount[i].value);
      if (!isNaN(amount)) {
        suma_gv += amount;
      }
    }
    for (let i = 0; i < i_amount.length; i++) {
      const amount = parseFloat(i_amount[i].value);
      if (!isNaN(amount)) {
        suma_i += amount;
      }
    }
    for (let i = 0; i < p_amount.length; i++) {
      const amount = parseFloat(p_amount[i].value);
      if (!isNaN(amount)) {
        suma_p += amount;
      }
    }
    if (select == 'PENAL' || select == 'PENAL') {
      $('#amout_a').val(saldo.toFixed(2));
      $('#amout_m').val(mora.toFixed(2));
      $('#amout_g').val(gastos.toFixed(2));
    }
    $('#amout_gf').val(suma_gf.toFixed(2));
    $('#amout_gv').val(suma_gv.toFixed(2));
    $('#amout_i').val(suma_i.toFixed(2));
    $('#amout_p').val(suma_p.toFixed(2));
    saldo = $('#amout_a').val();
    mora = $('#amout_m').val();
    gastos = $('#amout_g').val();

    $('#total_fixed').text(suma_gf.toFixed(2));
    $('#total_non_fixed').text(suma_gv.toFixed(2));
    $('#total_income').text(suma_i.toFixed(2));
    $('#total_penalty').text(suma_p.toFixed(2));

    suma = Number.parseFloat(suma_gf) + Number.parseFloat(suma_gv) + Number.parseFloat(suma_i) + Number.parseFloat(suma_p) + Number.parseFloat(saldo) + Number.parseFloat(mora) + Number.parseFloat(gastos)
    $('#amout_tg').val(suma.toFixed(2));
  }
  /* Funcion para crear un nuevo recibo */
  $('#rc_indivual').click(function (e) {
    e.preventDefault();
    loadDataDateReceipt();
    getNewNumberRC();
    $('.modal-title').text('Nuevo Recibo de Cobro');
    $('#p_cobro').attr('disabled', true);
    $('#l_dpto').attr('disabled', true);
    $('#a_dpto').attr('disabled', true);
    $('#e_dpto').attr('disabled', true);
    $('.btnd').addClass('d-none');
    $('.btnp').addClass('d-none');
    $('#rcIndividualModal').modal('show');
  });
  /* Funcion para crear todos los nuevos recibos */
  $('#rc_all').click(function (e) {
    e.preventDefault();
    Swal.fire({
      title: 'Estas seguro de Generar Todos los recibo de cobro de manera automatica?',
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Si, Generar Todos!'
    }).then((result) => {
      if (result.isConfirmed) {
        Swal.fire({
          title: 'Loading...',
          allowEscapeKey: false,
          allowOutsideClick: false,
          showConfirmButton: false,
          willOpen: () => {
            Swal.showLoading();
          }
        });
        $.ajax({
          url: 'recibocobro_controller.php?op=generate_receipt_automatic',
          method: 'POST',
          dataType: 'json',
          success: function (response) {
            Swal.close();
            if (response.status == true) {
              Swal.fire({
                icon: "success",
                title: response.message,
                showConfirmButton: false,
                timer: 3000
              });
              $('#receipt_table').DataTable().ajax.reload();
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
  });
  /* Funcion para habilitar los botones segun el tipo de recibo */
  $('#typereceiot').change(function (e) {
    e.preventDefault();
    select = $(this).val();
    if (select == 'COBRO') {
      $('.btnd').removeClass('d-none');
      $('.btnp').addClass('d-none');
      $('#content_penalty').addClass('d-none');
      $("#content_penalty_body").empty();
      getTotals(select);
    }
    if (select == 'PENAL') {
      $('.btnp').removeClass('d-none');
      $('.btnd').addClass('d-none');
      $('#content_income').addClass('d-none');
      $("#content_income_body").empty();
      $('#content_non_fixed').addClass('d-none');
      $("#content_non_fixed_body").empty();
      $('#content_fixed').addClass('d-none');
      $("#content_fixed_body").empty();
      getTotals(select);
    }
    if (select == '') {
      $('.btnp').addClass('d-none');
      $('.btnd').addClass('d-none');
      $('#content_penalty').addClass('d-none');
      $("#content_penalty_body").empty();
      $('#content_income').addClass('d-none');
      $("#content_income_body").empty();
      $('#content_non_fixed').addClass('d-none');
      $("#content_non_fixed_body").empty();
      $('#content_fixed').addClass('d-none');
      $("#content_fixed_body").empty();
      getTotals(select);
    }
  });
  /* Funcion para obtener la unidad departamental y cargar los datos en el recibo */
  $('#name_client').click(function () {
    depart = $('#n_dpto').val();
    select = $('#typereceiot').val();
    if (depart == '') {
      clearFields();
      $(".mr-auto").text("Procesos Fallido");
      $(".toast").css("z-index", "1000");
      $(".toast").css("background-color", "rgb(255 80 80 / 85%)");
      $(".toast").css("color", "white");
      $(".toast").attr("background-color", "");
      $("#toastText").text("Debe Seleccionar un Departamento Para Continuar");
      $('.toast').toast('show');
      return false;
    }
    $.ajax({
      url: URI + 'unidaddepartamental/unidaddepartamental_controller.php?op=get_unit_by_name',
      method: 'POST',
      dataType: 'json',
      data: { search: depart },
      success: function (response) {
        if (response.length == 0) {
          $(".mr-auto").text("Procesos Fallido");
          $(".toast").css("z-index", "1000");
          $(".toast").css("background-color", "rgb(255 80 80 / 85%)");
          $(".toast").css("color", "white");
          $(".toast").attr("background-color", "");
          $("#toastText").text("Departamento No Encontrado");
          $('.toast').toast('show');
          clearFields();
          getTotals(select);
          return false;
        }
        clearFields();
        loadDataDateReceipt();
        $('#id_u').val(response.uid);
        $('#id_c').val(response.cid);
        $('#id_rc').val(response.receipt);
        $('#n_dpto').val(response.unit);
        $('#name_client').val(response.name);
        $('#l_dpto').val(response.level);
        $('#a_dpto').val(response.aliquot);
        $('#e_dpto').val(response.email);
        $('#amout_a').val(response.balance);
        $('#amout_m').val(response.mora);
        $('#amout_g').val(response.gastos);
        getTotals(select);
      }
    });

  });
  /* Funcion para obtener los gastos fijos */
  $('#b_gastos_f').click(function (e) {
    e.preventDefault();
    aliquot = $('#a_dpto').val();
    if (aliquot == '') {
      $(".mr-auto").text("Procesos Fallido");
      $(".toast").css("z-index", "1000");
      $(".toast").css("background-color", "rgb(255 80 80 / 85%)");
      $(".toast").css("color", "white");
      $(".toast").attr("background-color", "");
      $("#toastText").text("Debe Seleccionar un Departamento Para Continuar");
      $('.toast').toast('show');
      return false;
    }
    $('#title_fixed').text('Relacion de Gastos Fijos');
    $('#content_fixed').removeClass('d-none');
    $.ajax({
      url: 'recibocobro_controller.php?op=get_data_expense_fixed',
      method: 'GET',
      dataType: 'json',
      success: function (response) {
        $("#content_fixed_body").empty();
        $.each(response, function (idx, opt) {
          $("#content_fixed_body").append(`
                <div id="cont_${opt.id}" class="row d-flex justify-content-between">
                  <small class="col-2 text-body-secondary">${opt.code} </small>
                  <span class="col-8 font-weight-bold">${opt.account}</span>
                  <hr>
                  <div class="col-12">`+
            opt.details.map((detail) => {
              return `
              <div id="detail_${detail.id}" name="cont_${opt.id}" class="row">
                <input type="hidden" name="typef" value="${opt.id}">
                <input type="hidden" name="codef" value="${detail.id}">
                <div class="col-sm-1" >
                <button id="b_trash" type="button" class="btn btn-outline-danger btn-group-sm" data-value="${detail.id}" value="${opt.id}" title="Eliminar"><i class="bi bi-dash"></i></button>
                </div>
                <label name="expensef" class="col-sm-7 text-body-secondary text-monospace font-weight-bold">${detail.expenseName} </label>
                <span class="col-sm-2 font-weight-bold text-right" name="ef_amount">${getFormatting(detail.aumont)}</span>
                <input name="gf_amount" type="text" class="form-control col-sm-1 inpjs" value="${getCalcFormatting(detail.aumont, aliquot)}" disabled>
              </div>
               `
            }) +
            `</div>
                </div>
          `);
        });
        getTotals();
      }
    });
  });
  /* Funcion para obtener los gastos variables */
  $('#b_gastos_v').click(function (e) {
    e.preventDefault();
    aliquot = $('#a_dpto').val();
    if (aliquot == '') {
      $(".mr-auto").text("Procesos Fallido");
      $(".toast").css("z-index", "1000");
      $(".toast").css("background-color", "rgb(255 80 80 / 85%)");
      $(".toast").css("color", "white");
      $(".toast").attr("background-color", "");
      $("#toastText").text("Debe Seleccionar un Departamento Para Continuar");
      $('.toast').toast('show');
      return false;
    }
    $('#title_non_fixed').text('Relacion de Gastos Variables');
    $('#content_non_fixed').removeClass('d-none');
    $.ajax({
      url: 'recibocobro_controller.php?op=get_data_expense_non_fixed',
      method: 'GET',
      dataType: 'json',
      success: function (response) {
        $("#content_non_fixed_body").empty();
        $.each(response, function (idx, opt) {
          $("#content_non_fixed_body").append(`
                <div id="cont_${opt.id}" class="row d-flex justify-content-between">
                  <small class="col-2 text-body-secondary">${opt.code} </small>
                  <span class="col-8 font-weight-bold">${opt.account}</span>
                  <hr>
                  <div class="col-12">`+
            opt.details.map((detail) => {
              return `
              <div id="detail_${detail.id}" name="cont_${opt.id}" class="row">
                <input type="hidden" name="typenf" value="${opt.id}">
                <input type="hidden" name="codenf" value="${detail.id}">
                <div class="col-sm-1" >
                <button id="b_trash" type="button" class="btn btn-outline-danger btn-group-sm" data-value="${detail.id}" value="${opt.id}" title="Eliminar"><i class="bi bi-dash"></i></button>
                </div>
                <label name="expensenf" class="col-sm-7 text-body-secondary text-monospace font-weight-bold">${detail.expenseName} </label>
                <span class="col-sm-2 font-weight-bold text-right" name="enf_amount">${getFormatting(detail.aumont)}</span>
                <input name="gv_amount" type="text" class="form-control col-sm-1 inpjs" value="${getCalcFormatting(detail.aumont, aliquot)}" disabled>
              </div>
               `
            }) +
            `</div>
                </div>
          `);
        });
        getTotals();
      }
    });
  });
  /* Funcion para obtener los ingresos */
  $('#b_ingreso').click(function (e) {
    e.preventDefault();
    aliquot = $('#a_dpto').val();
    if (aliquot == '') {
      $(".mr-auto").text("Procesos Fallido");
      $(".toast").css("z-index", "1000");
      $(".toast").css("background-color", "rgb(255 80 80 / 85%)");
      $(".toast").css("color", "white");
      $(".toast").attr("background-color", "");
      $("#toastText").text("Debe Seleccionar un Departamento Para Continuar");
      $('.toast').toast('show');
      return false;
    }
    $('#title_income').text('Relacion de Ingresos');
    $('#content_income').removeClass('d-none');
    $.ajax({
      url: 'recibocobro_controller.php?op=get_data_income',
      method: 'GET',
      dataType: 'json',
      success: function (response) {
        $("#content_income_body").empty();
        $.each(response, function (idx, opt) {
          $("#content_income_body").append(`
                <div id="cont_${opt.id}" class="row d-flex justify-content-between">
                  <small class="col-2 text-body-secondary">${opt.code} </small>
                  <span class="col-8 font-weight-bold">${opt.account}</span>
                  <hr>
                  <div class="col-12">`+
            opt.details.map((detail) => {
              return `
              <div id="detail_${detail.id}" name="cont_${opt.id}" class="row">
                <input type="hidden" name="typei" value="${opt.id}">
                <input type="hidden" name="codei" value="${detail.id}">
                <div class="col-sm-1" >
                <button id="b_trash" type="button" class="btn btn-outline-danger btn-group-sm" data-value="${detail.id}" value="${opt.id}" title="Eliminar"><i class="bi bi-dash"></i></button>
                </div>
                <label name="incomef" class="col-sm-7 text-body-secondary text-monospace font-weight-bold">${detail.incomename} </label>
                <span class="col-sm-2 font-weight-bold text-right" name="ii_amount">${getFormatting(detail.incomebalance)}</span>
                <input name="i_amount" type="text" class="form-control col-sm-1 inpjs" value="${getCalcFormatting(detail.incomebalance, aliquot)}" disabled>
              </div>
            `
            }) +
            `</div>
                </div>
          `);
        });
        getTotals();
      }
    });
  });
  /* Funcion para obtener los panalizaciones */
  $('#b_penal').click(function (e) {
    e.preventDefault();
    aliquot = $('#a_dpto').val();
    if (aliquot == '') {
      $(".mr-auto").text("Procesos Fallido");
      $(".toast").css("z-index", "1000");
      $(".toast").css("background-color", "rgb(255 80 80 / 85%)");
      $(".toast").css("color", "white");
      $(".toast").attr("background-color", "");
      $("#toastText").text("Debe Seleccionar un Departamento Para Continuar");
      $('.toast').toast('show');
      return false;
    }
    $('#title_penalty').text('Relacion de Penalizaciones');
    $('#content_penalty').removeClass('d-none');
    $.ajax({
      url: 'recibocobro_controller.php?op=get_data_penalty',
      method: 'GET',
      dataType: 'json',
      success: function (response) {
        $("#content_penalty_body").empty();
        $.each(response, function (idx, opt) {
          $("#content_penalty_body").append(`
                <div id="cont_${opt.id}" class="row d-flex justify-content-between">
                  <small class="col-2 text-body-secondary">${opt.code} </small>
                  <span class="col-8 font-weight-bold">${opt.account}</span>
                  <hr>
                  <div class="col-12">`+
            opt.details.map((detail) => {
              return `
              <div id="detail_${detail.id}" name="cont_${opt.id}" class="row">
                <input type="hidden" name="typep" value="${opt.id}">
                <input type="hidden" name="codep" value="${detail.id}">
                <div class="col-sm-1" >
                <button id="b_trash" type="button" class="btn btn-outline-danger btn-group-sm" data-value="${detail.id}" value="${opt.id}" title="Eliminar"><i class="bi bi-dash"></i></button>
                </div>
                <label name="incomep" class="col-sm-7 text-body-secondary text-monospace font-weight-bold">${detail.incomename} </label>
                <span class="col-sm-2 font-weight-bold text-right" name="ip_amount">${getFormatting(detail.incomebalance)}</span>
                <input name="p_amount" type="text" class="form-control col-sm-1 inpjs" value="${getFormatting(detail.incomebalance)}" disabled>
              </div>
               `
            }) +
            `</div>
                </div>
          `);
        });
        getTotals();
      }
    });
  });

  $(document).on('click', '#b_trash', function () {
    const id = $(this).data('value');
    const cont = $(this).attr('value');
    const contain = document.getElementsByName('cont_' + cont)
    const container = document.getElementById('cont_' + cont)
    const element = document.getElementById('detail_' + id);
    element.remove();
    const n_item = contain.length
    if (n_item == 0) {
      container.remove();
    }
    const elementerase = document.getElementById('detail_' + id);
    if (elementerase == null) {
      $(".mr-auto").text("Procesos Exitoso");
      $(".toast").css("z-index", "1000");
      $(".toast").css("background-color", "rgb(29 255 34 / 85%)");
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
    getTotals(cont);
  })
  $('.x').click(function (e) {
    e.preventDefault();
    clearFields();
  });
  $('#formReceipt').submit(function (e) {
    e.preventDefault();
    let dataexpense = []
    for (let i = 0; i < expensef.length; i++) {
      const type = typef[i].value;
      const code = codef[i].value;
      const expense = expensef[i].textContent;
      const amount = ef_amount[i].textContent;
      const aliquot = gf_amount[i].value;
      dataexpense.push({ type: type, code: code, expense: expense, amount: amount, aliquot: aliquot })
    }
    for (let i = 0; i < expensenf.length; i++) {
      const type = typenf[i].value;
      const code = codenf[i].value;
      const expense = expensenf[i].textContent;
      const amount = enf_amount[i].textContent;
      const aliquot = gv_amount[i].value;
      dataexpense.push({ type: type, code: code, expense: expense, amount: amount, aliquot: aliquot })
    }
    for (let i = 0; i < incomef.length; i++) {
      const type = typei[i].value;
      const code = codei[i].value;
      const income = incomef[i].textContent;
      const amount = ii_amount[i].textContent;
      const aliquot = i_amount[i].value;
      dataexpense.push({ type: type, code: code, expense: income, amount: amount, aliquot: aliquot })
    }
    for (let i = 0; i < incomep.length; i++) {
      const type = typep[i].value;
      const code = codep[i].value;
      const income = incomep[i].textContent;
      const amount = ip_amount[i].textContent;
      const aliquot = p_amount[i].value;
      dataexpense.push({ type: type, code: code, expense: income, amount: amount, aliquot: aliquot })
    }
    nrecibo = $('#n_rc').text();
    cid = $('#id_c').val();
    uid = $('#id_u').val();
    receipt = $('#id_rc').val();
    typerec = $('#typereceiot').val();
    depart = $('#n_dpto').val();
    inquilino = $('#name_client').val();
    concepto = $('#p_cobro').val();
    fvence = $('#f_vence').val();
    nivel = $('#l_dpto').val();
    aliquot = $('#a_dpto').val();
    email = $('#e_dpto').val();
    monto_gf = $('#amout_gf').val();
    monto_gv = $('#amout_gv').val();
    monto_p = $('#amout_p').val();
    monto_i = $('#amout_i').val();
    monto_tg = $('#amout_tg').val();
    amout_a = $('#amout_a').val();
    amout_m = $('#amout_m').val();
    amout_g = $('#amout_g').val();
    dataexpense = dataexpense;
    data = new FormData();
    data.append('nrecibo', nrecibo);
    data.append('cid', cid);
    data.append('uid', uid);
    data.append('typerec', typerec);
    data.append('depart', depart);
    data.append('inquilino', inquilino);
    data.append('concepto', concepto);
    data.append('vence', fvence);
    data.append('nivel', nivel);
    data.append('aliquot', aliquot);
    data.append('email', email);
    data.append('monto_gf', monto_gf);
    data.append('monto_gv', monto_gv);
    data.append('monto_p', monto_p);
    data.append('monto_i', monto_i);
    data.append('monto_tg', monto_tg);
    data.append('amout_a', amout_a);
    data.append('amout_m', amout_m);
    data.append('amout_g', amout_g);
    data.append('receipt', receipt);
    data.append('dataexpense', JSON.stringify(dataexpense));
    if (monto_tg == 0 || monto_tg == '') {
      $(".mr-auto").text("Procesos Fallido");
      $(".toast").css("background-color", "rgb(36 113 163 / 85%)");
      $(".toast").css("color", "white");
      $("#toastText").text("No Se Puede Totalizar Con Monto Total Cero");
      $('.toast').toast('show');
      return false;
    }
    $.ajax({
      url: 'recibocobro_controller.php?op=new_receipt',
      method: 'POST',
      dataType: "json",
      data: data,
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
          $('#receipt_table').DataTable().ajax.reload();
          clearFields();
          $('#typereceiot').val('');
          $('#rcIndividualModal').modal('hide');
        } else {
          if (response.httpstatus == '400') {
            $(".mr-auto").text("Procesos Fallido");
            $(".toast").css("background-color", "rgb(36 113 163 / 85%)");
            $(".toast").css("color", "white");
            $("#toastText").text(response.message);
            $('.toast').toast('show');
            return false;
          }
          Swal.fire({
            icon: "error",
            title: response.message,
            showConfirmButton: false,
            timer: 1500
          });
        }
      }
    })

  });
  /* Accion para Eliminar Usuario de la Lista de usuario Visibles */
  $(document).on('click', '#b_delete_receipt', function () {
    var id = $(this).data('value');
    Swal.fire({
      title: 'Estas seguro de eliminar este recibo?',
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Si, Eliminar!'
    }).then((result) => {
      if (result.isConfirmed) {
        $.ajax({
          url: 'recibocobro_controller.php?op=delete_receipt',
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
              $('#receipt_table').DataTable().ajax.reload();
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
  /* Accion para Eliminar Usuario de la Lista de usuario Visibles */
  $(document).on('click', '#b_view_receipt', function () {
    var id = $(this).data('value');
    $.ajax({
      url: 'recibocobro_controller.php?op=generate_pdf_receipt',
      method: 'POST',
      dataType: 'json',
      data: { id: id },
      success: function (response) {
        $(".mr-auto").text("Procesos Exitoso");
        $(".toast").css("background-color", "rgba(8, 140, 201, 0.842)");
        $(".toast").css("color", "black");
        $(".toast").attr("background-color", "");
        $("#toastText").text('El Recibo se genero de manera exitosa');
        $('.toast').toast('show');
      }
    });
  })

  $(document).on('click', '#b_send_receipt', function () {
    var id = $(this).data('value');
    $.ajax({
      url: 'recibocobro_controller.php?op=sendmail_pdf_receipt',
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
        } else {
          $(".mr-auto").text("Procesos Fallido");
          $(".toast").css("background-color", "rgba(226, 34, 34, 0.62)");
          $(".toast").css("color", "black");
          $(".toast").attr("background-color", "");
          $("#toastText").text(response.message);
        }

      }
    });
  })


  function loadDataDateReceipt() {
    $('#p_cobro').val(period);
    $('#f_vence').val(vence);
  }
  loadPenaltiesWhithInterest();
  loadPenaltiesFreeInterest();
  loadDataTableReceipts();
});


