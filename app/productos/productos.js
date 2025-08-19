$(document).ready(function () {
  const pc = document.getElementById('pc_id');
  /* Funcion para Cargar Select de los tipos de gastos departamentales */
  const loadDataSelectProductCategories = async (id) => {
    try {
      const response = await fetch('productos_controller.php?op=get_product_categories');
      const data = await response.json();
      const container = document.getElementById('pc_id');
      container.innerHTML = '';
      const defaultOption = document.createElement('option');
      defaultOption.setAttribute('value', '');
      defaultOption.innerHTML = 'Categoria...';
      container.appendChild(defaultOption);
      data.forEach((opt, idx) => {
        const option = document.createElement('option');
        if (id == opt.id) {
          option.setAttribute('value', opt.id);
          option.innerHTML = `${opt.cate}`;
          option.setAttribute('selected', 'selected');
          container.appendChild(option);
        } else {
          option.setAttribute('value', opt.id);
          option.innerHTML = `${opt.cate}`;
          container.appendChild(option);
        }
      })
    } catch (error) {
      console.log('Error', error);
    }
  }
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
        { data: "aumontp" },
        { data: "aumonts" },
        {
          data: "id", render: (data, _, __, meta) =>
            `<button id="b_update" class="btn btn-outline-primary btn-sm" data-value="${data}" data-toggle="tooltip" data-placement="top" title="Editar Cuenta"><i class="fa fa-edit"></i></button>
            <button id="b_delete" class="btn btn-outline-danger btn-sm" data-value="${data}" data-toggle="tooltip" data-placement="top" title="Eliminar Cuenta"><i class="bi bi-trash3"></i></button>`, className: "text-center"
        }
      ]
    });
  }
  /* Funcion Para Cargar El Contenido del Select "at_id" */
  $('#newProduct').click(function (e) {
    e.preventDefault();
    $("#pc_id").prop('disabled', false);
    $('#formproduct')[0].reset();
    loadDataSelectProductCategories();
  });
  /* Funcion para obtener el nombre del Tipo de Gasto seleccionado */
  $('#pc_id').change(function (e) {
    e.preventDefault();
    var id = pc.value;
    $.ajax({
      url: "productos_controller.php?op=get_code_by_category",
      method: 'POST',
      dataType: "json",
      data: { id: id },
      success: function (response) {
        $('#p_code').val(response);
      }
    });
  });
  /* Accion para Guardar o Actualizar Informacion de los Gastos en la Base de Datos */
  $('#formproduct').submit(function (e) {
    e.preventDefault();
    id = $('#p_id').val();
    cate = $('#pc_id').val();
    code = $('#p_code').val();
    name = $('#p_name').val().toUpperCase();
    amount_p = $('#p_amount_p').val();
    amount_s = $('#p_amount_s').val();
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
    dato.append('amountp', amount_p);
    dato.append('amounts', amount_s);
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
        $('#p_id').val(response.id);
        $('#p_code').val(response.code);        
        $('#p_name').val(response.name);
        $('#p_amount_p').val(response.aumontp);        
        $('#p_amount_s').val(response.aumonts);
        $('#pc_id').attr('disabled', true);
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
          url: 'productos_controller.php?op=delete_preoduct',
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
  LoadDataTableProducts();
});