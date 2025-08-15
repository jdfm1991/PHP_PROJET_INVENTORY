$(document).ready(function () {
  /* Funcion para listar todos los modulos existentes en la base de datos */
  const loadListModulesAvailableDB = async () => {
    try {
      const response = await fetch('man_controller.php?op=get_name_module2');
      const data = await response.json();
      const container = document.getElementById('modulescontainer');
      container.innerHTML = '';
      data.forEach((opt, idx) => {
        const button = document.createElement('button');
        button.style.width = '220px';
        button.style.margin = '10px';
        button.classList.add('btn');
        button.classList.add('btn-outline-info');
        button.classList.add('btn-group-sm');
        button.setAttribute('id', 'b_assign_module');
        button.setAttribute('data-value', opt.id);
        button.setAttribute('type', 'button');
        button.setAttribute('value', opt.name);
        button.innerHTML = `${opt.name}`;
        container.appendChild(button);
      })
    } catch (error) {
      console.log('Error', error);
    }
  };
  /* Funcion para Cargar Select de los departamentos */
  const loadSelectDepartmentsAvailableDB = async () => {
    try {
      const response = await fetch('man_controller.php?op=get_name_depart');
      const data = await response.json();
      const container = document.getElementById('nameDepartAssign');
      container.innerHTML = '';
      data.forEach((opt, idx) => {
        const option = document.createElement('option');
        option.setAttribute('value', opt.id);
        option.innerHTML = `${opt.name}`;
        container.appendChild(option);
      })
    } catch (error) {
      console.log('Error', error);
    }
  };
  /* Funcion para Cargar los departamentos junto con sus respectivos modulos */
  const loadListDepartmentsAvailableDB = async () => {
    try {
      const response = await fetch('man_controller.php?op=list_modules_by_depart');
      const data = await response.json();
      const container = document.getElementById('accordionDepartment');
      container.innerHTML = '';
      data.forEach((opt, idx) => {
        const DivHeader = document.createElement('div');
        DivHeader.classList.add('card-header');
        DivHeader.classList.add('btn-outline-info');
        DivHeader.setAttribute('id', `heading${idx + 1}`);
        DivHeader.setAttribute('data-toggle', 'collapse');
        DivHeader.setAttribute('data-target', `#collapse${opt.id}`);
        DivHeader.setAttribute('aria-expanded', 'true');
        DivHeader.setAttribute('aria-controls', `collapse${opt.id}`);
        DivHeader.innerHTML = `${opt.name}`;
        container.appendChild(DivHeader);
        const DivBody = document.createElement('div');
        DivBody.classList.add('collapse');
        //DivBody.classList.add('show');
        DivBody.setAttribute('id', `collapse${opt.id}`);
        DivBody.setAttribute('aria-labelledby', `heading${idx + 1}`);
        DivBody.setAttribute('data-parent', '#accordionDepartment');
        opt.modules.forEach((mod, idx) => {
          const button = document.createElement('button');
          button.style.width = '220px';
          button.style.margin = '10px';
          button.classList.add('btn');
          button.classList.add('btn-outline-info');
          button.classList.add('btn-group-sm');
          button.setAttribute('id', 'b_unassign_module');
          button.setAttribute('data-value', mod.module);
          button.setAttribute('type', 'button');
          button.setAttribute('value', mod.id);
          button.innerHTML = `${mod.nameListModule}`;
          DivBody.appendChild(button);
        })
        container.appendChild(DivBody);
      })
    } catch (error) {
      console.log('Error', error);
    }
  };
  /* */
  $('#formAssignModule').submit(function (e) {
    e.preventDefault();
    var module = $('#idModuleByAssign').val();
    var depart = $('#nameDepartAssign').val();
    var formData = new FormData();
    formData.append('module', module);
    formData.append('depart', depart);
    $.ajax({
      url: 'man_controller.php?op=assign_module',
      method: 'POST',
      dataType: "json",
      data: formData,
      contentType: false,
      processData: false,
      success: function (response) {
        if (response.status == true) {
          $('#assignModuleModal').modal('hide');
          $('#formAssignModule').trigger('reset');
          Swal.fire({
            icon: "success",
            title: response.message,
            showConfirmButton: false,
            timer: 1500
          });
          loadListModulesAvailableDB();
          loadListDepartmentsAvailableDB();
          loadSidebarMenu();
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
  /* Accion para asignar modulo */
  $(document).on('click', '#b_assign_module', function () {
    var module = $(this).data('value');
    var value = $(this).attr('value');
    $('#nameModuleByAssign').val(value); //Cargamos el nombre
    $('#idModuleByAssign').val(module); //Cargamos el id
    $('#assignModuleModal').modal('show') //mostramos el modal
    loadListModulesAvailableDB(); //cargamos los modulos
    loadSelectDepartmentsAvailableDB(); //cargamos los departamentos
  })
  /* Accion para desasignar modulo */
  $(document).on('click', '#b_unassign_module', function () {
    var module = $(this).data('value');
    var id = $(this).attr('value');
    Swal.fire({
      title: 'Estas seguro de desasignar el modulo?',
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Si, Desasignar!'
    }).then((result) => {
      if (result.isConfirmed) {
        $.ajax({
          url: 'man_controller.php?op=unassign_module',
          method: 'POST',
          dataType: 'json',
          data: { id: id, module: module },
          success: function (response) {
            if (response.status == true) {
              Swal.fire({
                icon: "success",
                title: response.message,
                showConfirmButton: false,
                timer: 1500
              });
              loadListModulesAvailableDB();
              loadListDepartmentsAvailableDB();
              loadSidebarMenu();
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
  loadListDepartmentsAvailableDB();
  loadListModulesAvailableDB();
});
