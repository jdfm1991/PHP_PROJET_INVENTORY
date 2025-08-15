<?php
$today = date('Y-m-d');
$newday = strtotime('+1 day', strtotime($today));
$tomorrow = date('Y-m-d', $newday);
?>
<!--
  *************************************************
  Modal Para Registro de Usuario e Inicio de Sesion
  *************************************************
-->
<div class="modal fade" id="loginModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="exampleModalLabel">Login - Modulo Admin</h1>
        <button type="button" id="closeLogin" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="container-fluid">
          <form id="formLogin">
            <div class="modal-body">
              <div class="mb-3">
                <label for="email" class="form-label">Usuario o Email</label>
                <input type="email" class="form-control" id="email" placeholder="Usuario o Email" required>
              </div>
              <div class="mb-3">
                <label for="pass" class="form-label">Contraseña</label>
                <input type="password" class="form-control" id="pass" placeholder="Contraseña" required>
              </div>
            </div>
            <div class="modal-footer">
              <div id="options" class="mx-3 px-3">
                <!--<a href="" id="lnkRegister">Registrarme</a>
                    <br>
                    <a href="" id="forget">Olvide Contraseña</a>-->
              </div>
              <button type="button" class="btn btn-outline-danger btn-light" data-bs-dismiss="modal" aria-label="Close">Cancelar</button>
              <button type="submit" class="btn btn-outline-primary btn-light">Entrar</button>
              <!--<button type="button" id="btnRegister" class="btn btn-outline-primary btn-light">Registar</button>-->
            </div>
            <div id="messegel" class="alert alert-warning" role="alert">
              <p id="errorl" class="mb-0">Alert Description</p>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
<!--
  *************************************************
  Modal Para visualizar los productos
  *************************************************
-->
<div class="modal fade mt-4" id="productomodal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <table id="pmtable" style="width:100%;">
          <thead>
            <tr>
              <th>Descripcion</th>
              <th>Cantidad</th>
              <th></th>
            </tr>
          </thead>
        </table>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
<!--
  *************************************************
  Modal Para visualizar los Proveedores
  *************************************************
-->
<div class="modal fade mt-4" id="proveedormodal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <table id="modaproveedortable" style="width:100%;">
          <thead>
            <tr>
              <th>Descripcion</th>
              <th>Codigo</th>
              <th></th>
            </tr>
          </thead>
        </table>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
<!--
  *************************************************
  Modal Para visualizar los Departamento
  *************************************************
-->
<div class="modal fade mt-4" id="departmodal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form id="departform">
          <div class="modal-body">
            <input type="hidden" id="iddepart">
            <div class="row">
              <div class="col-sm">
                <div class="form-floating mb-3">
                  <input type="text" class="form-control" id="namedepart" placeholder="name@example.com" required>
                  <label for="namedepart">Departamento</label>
                </div>
              </div>
              <div class="col-sm-3">
                <div class="form-floating mb-3">
                  <select id="posisiond" class="form-control">
                    <!--Carga Mediante Ajax-->
                  </select>
                  <label for="posisiond" class="form-label">Posicion</label>
                </div>
              </div>
              <div class="col-sm-12">
                <div class="form-floating">
                  <textarea class="form-control" placeholder="Leave a comment here" id="detaild"></textarea>
                  <label for="detaild">Descripcion</label>
                </div>
              </div>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-outline-danger btn-light" data-bs-dismiss="modal" aria-label="Close">Cancelar</button>
            <button type="submit" class="btn btn-outline-primary btn-light">Entrar</button>
          </div>
          <div id="messeged" class="alert alert-warning" role="alert">
            <p id="errord" class="mb-0">Alert Description</p>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
<!--
  *************************************************
  Modal Para visualizar los Modulos
  *************************************************
-->
<div class="modal fade mt-4" id="modulomodal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form id="moduloform">
          <div class="row">
            <div class="col-sm-6">
              <div class="form-floating mb-3">
                <select id="namemodulo" class="form-control" required>
                  <!--Carga Mediante Ajax-->
                </select>
                <label for="namemodulo" class="form-label">Modulos Disponible</label>
              </div>
            </div>
            <div class="col-sm-6">
              <div class="form-floating mb-3">
                <select id="depmodulo" class="form-control" required>
                  <!--Carga Mediante Ajax-->
                </select>
                <label for="depmodulo" class="form-label">Departamento</label>
              </div>
            </div>
            <div class="col-sm-12">
              <div class="form-floating mb-3">
                <textarea class="form-control" placeholder="Leave a comment here" id="detailm"></textarea>
                <label for="detailm">Descripcion</label>
              </div>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-outline-danger btn-light" data-bs-dismiss="modal" aria-label="Close">Cancelar</button>
            <button type="submit" class="btn btn-outline-primary btn-light">Entrar</button>
          </div>
          <div id="messegem" class="alert alert-warning" role="alert">
            <p id="errorm" class="mb-0">Alert Description</p>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>