$(document).ready(function () {
  const loadDataSelectUserTypes = async (id) => {
    try {
      const response = await fetch('usuario_controller.php?op=get_user_types');
      const data = await response.json();
      const container = document.getElementById('usertypes');
      container.innerHTML = '';
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
  const LoadDataTableUsers = async () => {
    const table = $('#user_table').DataTable({
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
        url: "usuario_controller.php?op=get_list_users",
        type: "GET",
        dataType: "json",
        dataSrc: "",
      },
      columns: [
        { data: "name" },
        { data: "email" },
        { data: "login" },
        { data: "type" },
        {
          data: "id", render: (data, _, __, meta) =>
            `<button id="b_edit_user" class="btn btn-outline-primary" data-value="${data}"><i class="fa fa-edit"></i></button>
          <button id="b_delete_user" class="btn btn-outline-danger" data-value="${data}"><i class="fa fa-trash"></i></button>`, className: "text-center"
        }
      ]
    });

  }

  $('#newUser').click(function (e) {
    e.preventDefault();
    loadDataSelectUserTypes();
  });

  $('#formUser').submit(function (e) {
    e.preventDefault();
    id = $('#userId').val();
    name = $('#userName').val();
    email = $('#userEmail').val();
    login = $('#userLogin').val();
    password = $('#userpassword').val();
    type = $('#usertypes').val();
    dato = new FormData();
    dato.append('id', id);
    dato.append('name', name);
    dato.append('email', email);
    dato.append('login', login);
    dato.append('password', password);
    dato.append('type', type);
    $.ajax({
      url: 'usuario_controller.php?op=new_user',
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
          $('#user_table').DataTable().ajax.reload();
          $('#formUser')[0].reset();
          $('#newUserModal').modal('hide');
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

  /* Accion para Eliminar Usuario de la Lista de usuario Visibles */
  $(document).on('click', '#b_delete_user', function () {
    var id = $(this).data('value');
    Swal.fire({
      title: 'Estas seguro de eliminar el usuario?',
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Si, Eliminar!'
    }).then((result) => {
      if (result.isConfirmed) {
        $.ajax({
          url: 'usuario_controller.php?op=delete_user',
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
              $('#user_table').DataTable().ajax.reload();
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
  $(document).on('click', '#b_edit_user', function () {
    var id = $(this).data('value');
    $.ajax({
      url: 'usuario_controller.php?op=get_data_user',
      method: 'POST',
      dataType: 'json',
      data: { id: id },
      success: function (response) {
        loadDataSelectUserTypes(response.type);
        $('#userId').val(response.id);
        $('#userName').val(response.name);
        $('#userEmail').val(response.email);
        $('#userLogin').val(response.login);
        $('#userpassword').val(response.password);
        $('#newUserModal').modal('show');
      }
    });
  })

  LoadDataTableUsers();

  console.log(localStorage.getItem('login'));
  
});