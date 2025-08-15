$(document).ready(function () {
  /* Funcion para Cargar Select de los Tipos de Cambio */
  const loadSelectExchangeRatesDB = async (id) => {
    try {
      const response = await fetch('tasacambiaria_controller.php?op=get_exchange_rate_types');
      const data = await response.json();
      const container = document.getElementById('exchange_rate');
      container.innerHTML = '';
      data.forEach((opt, idx) => {
        const option = document.createElement('option');
        if (id == opt.id) {
          option.setAttribute('value', opt.id);
          option.innerHTML = `${opt.acr}`;
          option.setAttribute('selected', 'selected');
          container.appendChild(option);
        } else {
          option.setAttribute('value', opt.id);
          option.innerHTML = `${opt.acr}`;
          container.appendChild(option);
        }
      })
    } catch (error) {
      console.log('Error', error);
    }
  };
  /* Arrow Function Que se Encarga de Cargar los Datos de todas las Tasas en la Tabla */
  const loadDataTableRates = async () => {
    const table = $('#rate_table').DataTable({
      responsive: true,
      scrollX: true,
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
        url: "tasacambiaria_controller.php?op=get_list_rates",
        type: "GET",
        dataType: "json",
        dataSrc: "",
      },
      columns: [
        { data: "date" },
        { data: "exchange" },
        { data: "type" },
        {
          data: "id", render: (data, _, __, meta) =>
            `<button id="b_edit_rate" class="btn btn-outline-primary btn-sm" data-value="${data}"><i class="fa fa-edit"></i></button>`, className: "text-center"
        }
      ]
    });

  }
  $('#newRate').click(function (e) {
    e.preventDefault();
    loadSelectExchangeRatesDB();
  });
  /* Accion para Guardar o Actualizar Informacion del Cliente en la Base de Datos */
  $('#formNewRate').submit(function (e) {
    e.preventDefault();
    id = $('#idRate').val();
    rate = $('#exchangeRate').val();
    date = $('#dateRate').val();
    type = $('#exchange_rate').val();
    dato = new FormData();
    dato.append('id', id);
    dato.append('rate', rate);
    dato.append('date', date);
    dato.append('type', type);
    $.ajax({
      url: 'tasacambiaria_controller.php?op=new_rate',
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
          $('#rate_table').DataTable().ajax.reload();
          $('#formNewRate')[0].reset();
          $('#newRateModal').modal('hide');
        } else {
          $('#m_rate_cont').removeClass('d-none');
          $('#m_rate_text').text(response.message);
          setTimeout(function () {
            $('#m_rate_cont').addClass('d-none');
          }, 3000);
        }

      }
    });

  });
  $('#ratebcv').click(function (e) {
    e.preventDefault();
    $.ajax({
      url: 'tasacambiaria_controller.php?op=web_scraping',
      method: 'POST',
      dataType: 'json',
      success: function (response) {        
        if (response.status == true) {
          $(".mr-auto").text("Procesos Exitoso");
          $(".toast").css("background-color", "rgba(8, 140, 201, 0.842)");
          $(".toast").css("color", "black");
          $(".toast").attr("background-color", "");
          $("#toastText").text(response.message);
          $('.toast').toast('show');
          $('#rate_table').DataTable().ajax.reload();
        }else{
          $(".mr-auto").text("Procesos Exitoso");
          $(".toast").css("background-color", "rgba(201, 8, 8, 0.84)");
          $(".toast").css("color", "black");
          $(".toast").attr("background-color", "");
          $("#toastText").text(response.message);
          $('.toast').toast('show');
        }
      }
    });
  });
  /* Accion para Eliminar Usuario de la Lista de usuario Visibles */
  $(document).on('click', '#b_edit_rate', function () {
    var id = $(this).data('value');
    $.ajax({
      url: 'tasacambiaria_controller.php?op=get_data_rate',
      method: 'POST',
      dataType: 'json',
      data: { id: id },
      success: function (response) {
        $.each(response, function (idx, opt) {
          $('#idRate').val(opt.id);
          $('#exchangeRate').val(opt.exchange);
          $('#dateRate').val(opt.date);
          $('#dateRate').attr('disabled', true);
          $('#exchange_rate').val(opt.type);
        });
        loadSelectExchangeRatesDB(id);
        $('.modal-title').text('Actualizar Tasa de Cambio');
        $('#newRateModal').modal('show');
      }
    });
  })

  loadDataTableRates();
});