const URI = 'http://localhost/inventariogastos/app/';
const URL_ASSETS = 'http://localhost/inventariogastos/assets/';

const loadSidebarMenu = async () => {
  const response = await fetch(URI + 'manager/man_controller.php?op=list_modules_by_depart');
  const data = await response.json();
  const container = document.getElementById('accordionSidebarMenu');
  container.innerHTML = '';
  data.forEach((opt, idx) => {
    const li = document.createElement('li');
    li.classList.add('nav-item');
    const link = document.createElement('a');
    link.classList.add('nav-link');
    link.setAttribute('href', '#');
    link.setAttribute('data-toggle', 'collapse');
    link.setAttribute('data-target', `#collaps${opt.id}`);
    link.setAttribute('aria-expanded', 'true');
    link.setAttribute('aria-controls', `collapse${opt.id}`);
    const icon = document.createElement('i');
    icon.classList.add('bi');
    //icon.classList.add('fa-fw');
    icon.classList.add(`bi-${idx + 1}-square`);
    const span = document.createElement('span');
    span.innerHTML = `${opt.name}`;
    link.appendChild(icon);
    link.appendChild(span);
    li.appendChild(link);
    const divContainer = document.createElement('div');
    divContainer.classList.add('collapse');
    divContainer.setAttribute('id', `collaps${opt.id}`);
    divContainer.setAttribute('aria-labelledby', `heading${idx + 1}`);
    divContainer.setAttribute('data-parent', '#accordionSidebarMenu');
    const divContainerInner = document.createElement('div');
    divContainerInner.classList.add('bg-white');
    divContainerInner.classList.add('py-2');
    divContainerInner.classList.add('collapse-inner');
    const tag = document.createElement('h6');
    tag.classList.add('collapse-header');
    tag.innerHTML = `${opt.tag}: `;
    divContainerInner.appendChild(tag);
    divContainer.appendChild(divContainerInner);
    opt.modules.forEach((mod, idx) => {
      const a = document.createElement('a');
      a.classList.add('collapse-item');
      a.setAttribute('href', URI + mod.nameModule);
      a.innerHTML = `${mod.nameListModule}`;
      divContainerInner.appendChild(a);
    })
    li.appendChild(divContainer);
    container.appendChild(li);
  })
};

const loadPenaltiesFreeInterest = async () => {
  const response = await fetch(URI + 'recibocobro/recibocobro_controller.php?op=get_interest_free_penalties');
  const data = await response.json();
  $(".mr-auto").text("Procesos Exitoso");
  $(".toast").css("background-color", "rgba(8, 140, 201, 0.842)");
  $(".toast").css("color", "black");
  $(".toast").attr("background-color", "");
  $("#toastText").text(data.message);
  $('.toast').toast('show');
}

const loadPenaltiesWhithInterest = async () => {
  Swal.fire({
    title: 'Loading...',
    allowEscapeKey: false,
    allowOutsideClick: false,
    showConfirmButton: false,
    willOpen: () => {
      Swal.showLoading();
    }
  });
  const response = await fetch(URI + 'recibocobro/recibocobro_controller.php?op=get_interest_whith_penalties');
  const data = await response.json();
  if (data) {
    Swal.close();
    $(".mr-auto").text("Procesos Exitoso");
    $(".toast").css("background-color", "rgba(8, 140, 201, 0.842)");
    $(".toast").css("color", "black");
    $(".toast").attr("background-color", "");
    $("#toastText").text(data.message);
    $('.toast').toast('show');
  }

}

const getPenaltiesByReceipt = async (id) => {
  const response = await fetch(URI + 'recibocobro/recibocobro_controller.php?op=get_penalties_receipt&id=' + id);
  const data = await response.json();
}

/* Funcion para Ingresar Solo los Numeros en el Input de Telefono */
$(function () {
  $("input[name='onlynumber']").on("input", function (e) {
    $(this).val(
      $(this)
        .val()
        .replace(/[^0-9.]/g, "")
    );
  });
});
const chargeDayRate = async () => {
  const response = await fetch(URI + 'tasacambiaria/tasacambiaria_controller.php?op=web_scraping');
  const data = await response.json();
  if (data.status == false) {
    $(".mr-auto").text("Procesos Exitoso");
    $(".toast").css("background-color", "rgba(8, 140, 201, 0.842)");
    $(".toast").css("color", "black");
    $(".toast").attr("background-color", "");
    $("#toastText").text(data.message);
    $('.toast').toast('show');
  }
}
$(document).ready(function () {
  $('#btnLogin').click(function (e) {
    e.preventDefault();
    $('.modal-title').text('Iniciar Sesion');
    $('#loginModal').modal('show')
  });

  $('#formLogin').submit(function (e) {
    e.preventDefault();
    login = $('#sessionlogin').val();
    password = $('#sessionpassword').val();
    $.ajax({
      url: URI + 'usuario/usuario_controller.php?op=login',
      method: 'POST',
      dataType: "json",
      data: { login: login, password: password },
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
          $('#loginModal').modal('hide');
          loadSidebarMenu();
          localStorage.setItem('login', response.id);
        } else {
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

  loadSidebarMenu();
  //chargeDayRate();
});









