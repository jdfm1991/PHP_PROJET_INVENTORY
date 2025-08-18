<!--
  *************************************************
  Notificacion Para visualizar proceso terminado
  *************************************************
-->
<div class="position-fixed bottom-0 right-0 p-3" style="z-index: 9999; right: 0; bottom: 0;">
  <div id="bodyToast" class="toast" role="alert" aria-live="assertive" aria-atomic="true" data-delay="5000">
    <div class="toast-header">
      <img src="<?php echo  URL_ASSETS; ?>/img/undraw_rocket.svg" class="rounded mr-2" alt="alt" width="20">
      <strong class="mr-auto"></strong>
      <!-- <small>11 mins ago</small> -->
      <button type="button" class="ml-2 mb-1 close" data-dismiss="toast" aria-label="Close">
        <span aria-hidden="true">&times;</span>
      </button>
    </div>
    <div class="toast-body">
      <p><span id="toastText" class="text-center"></span></p>
    </div>
  </div>
</div>
<!--
  *************************************************
  Modal Nuevo Contenedor del Sistema 
  *************************************************
-->
<div class="modal fade" id="NewContainerModal" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="NewDepartModalLabel">Nuevo Contenedor</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body" id="modal_body">
        <form id="formContainer">
          <input type="hidden" id="cont_id">
          <div class="form-group">
            <label for="cont_name">Nombre del Contenedor</label>
            <input type="text" class="form-control" id="cont_name" aria-describedby="cont_nameHelp"
              required>
            <small id="cont_nameHelp" class="form-text text-muted">Escriba el Nombre del Contenedor</small>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
            <button type="submit" class="btn btn-primary">Guardar</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
<!-- 
*************************************************
Modal Nuevo Modulo 
*************************************************
-->
<div class="modal fade" id="newModuleModal" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="assingModuleModalLabel">Nuevo Modulo</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body" id="modal_body">
        <form id="formModule">
          <input type="hidden" id="m_id">
          <div class="form-group">
            <label for="m_name">Nombre del Modulo</label>
            <input type="text" class="form-control" id="m_name" aria-describedby="m_nameHelp" required>
            <input type="text" class="form-control" id="m_namelist" aria-describedby="m_namelistHelp"
              hidden>
            <small id="m_nameHelp" class="form-text text-muted">Escriba el Nombre que tendra la carpeta
              dentro de
              sistema</small>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary closemodal" data-dismiss="modal">Cerrar</button>
            <button type="submit" class="btn btn-primary">Guardar</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
<!-- 
************************************************
Modal Listado de Modulos 
************************************************
-->
<div class="modal fade" id="listModuleModal" tabindex="-1">
  <div class="modal-dialog modal-dialog-scrollable">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="listModuleModalLabel">Lista de Modulo Existentes</h5>
        <button type="button" class="close closemodal" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="container-sm !justify !spacing">
        <div class="form-group">
          <label for="nameNewDepart">Nombre del Modulo</label>
          <input type="text" class="form-control" id="m_name2" aria-describedby="m_name2Help" required>
          <small id="m_name2Help" class="form-text text-muted">Escriba el Nombre del Modulo que Desea
            Crear</small>
        </div>
      </div>
      <div id="alert_container" class="container-sm !justify !spacing">
        <div class="alert alert-danger" role="alert">
          <p id="text_alert"></p>
        </div>
      </div>

      <div class="modal-body" id="list_modal_body">
        <!-- Conteni SE Carga A traves de Ajax -->
      </div>
    </div>
  </div>
</div>

<!-- 
************************************************
Modal Para Asignacion de Modulo 
************************************************
-->
<div class="modal fade" id="assignModuleModal" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="assingModuleModalLabel">Assingnacion de Modulo</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body" id="modal_body">
        <form id="formAssignModule">
          <input type="hidden" id="ma_id">
          <div class="form-row">
            <div class="col-md-6">
              <label for="validationCustom03">Modulo</label>
              <input type="text" class="form-control" id="ma_name" required disabled>
            </div>
            <div class="col-md-6">
              <label for="nameDepartAssign">Departamentos</label>
              <select class="custom-select" id="nameDepartAssign" required>
                <option value="">Choose...</option>
                <option>...</option>
              </select>
            </div>
            <small id="nameNewHelp" class="form-text text-muted text-center">Escriba el Nombre que tendra la
              carpeta
              dentro de
              sistema</small>
          </div>

          <div class="modal-footer">
            <button type="button" class="btn btn-secondary closemodal" data-dismiss="modal">Cerrar</button>
            <button type="submit" class="btn btn-primary">Guardar</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
<!-- 
***********************************************
Modal Nuevo Cliente || Proveedor
***********************************************
-->
<div class="modal fade" id="newClientModal" tabindex="-1">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="newUserModalLabel">Nuevo Cliente</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body" id="modal_body">
        <form id="formclient">
          <div class="modal-body form-row">
            <input type="hidden" id="c_id">
            <div class="form-group col-md-6">
              <label for="c_name" class="form-label">Nombre Completo</label>
              <input type="text" class="form-control" id="c_name" placeholder="Nombre y Apellido"
                required>
            </div>
            <div class="form-group col-md-6">
              <label for="c_identity" class="form-label">N° Cedula</label>
              <input type="text" class="form-control" id="c_identity" placeholder="N° Cedula de Identidad"
                maxlength="20">
            </div>
            <div class="form-group col-md-6">
              <label for="c_phone" class="form-label">N° Telefonico Principal</label>
              <input type="text" class="form-control" id="c_phone" name="onlynumber"
                placeholder="N° Telefonico" maxlength="11">
              <small id="c_phoneHelp" class="form-text text-white">Escriba Codigo de Area Sin el Primer 0
                + N° Telefonico</small>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-outline-danger btn-light" data-bs-dismiss="modal"
              aria-label="Close">Cancelar</button>
            <button type="submit" class="btn btn-outline-primary btn-light">Guardar</button>
          </div>
          <div id="m_client_cont" class="alert alert-warning d-none" role="alert">
            <p id="m_client_text" class="mb-0">Alert Description</p>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
<!-- 
***********************************************
Modal Nueva Tasa de Cambio 
***********************************************
-->
<div class="modal fade" id="newRateModal" tabindex="-1" aria-labelledby="newRateModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="NewDepartModalLabel">Nueva Tasa de Cambio</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body " id="modal_body">
        <form id="formNewRate">
          <input type="hidden" id="idRate">
          <div class="form-row">
            <div class="form-group col-md-4">
              <label for="exchangeRate">Mont de la Tasa</label>
              <input type="text" class="form-control" id="exchangeRate" name="onlynumber"
                aria-describedby="exchangeRateHelp" required>
              <small id="exchangeRateHelp" class="form-text text-muted">Monto de la Tasa de Cambio</small>
            </div>
            <div class="form-group col-md-4">
              <label for="dateRate">Fecha de la Tasa</label>
              <input type="date" class="form-control" id="dateRate" aria-describedby="dateRateHelp"
                max="<?php echo date('Y-m-d'); ?>" required>
              <small id="dateRateHelp" class="form-text text-muted">Fecha de la Tasa de Cambio</small>
            </div>
            <div class="form-group col-md-4">
              <label for="validationCustom04">Tipo de Cambio</label>
              <select class="custom-select" id="exchange_rate" required>
                <!-- El Contenido  se carga a traves de Ajax Mediante Archivo js -->
              </select>
            </div>
          </div>
          <div id="m_rate_cont" class="alert alert-warning d-none" role="alert">
            <p id="m_rate_text" class="mb-0">Alert Description</p>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
            <button type="submit" class="btn btn-primary">Guardar</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
<!-- 
************************************************
Modal Nuevo Usuario 
************************************************
-->
<div class="modal fade" id="newUserModal" tabindex="-1" aria-labelledby="newUserModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="newUserModalLabel">Nuevo Usuario</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body" id="modal_body">
        <form id="formUser">
          <div class="modal-body form-row">
            <input type="hidden" id="userId">
            <div class="form-group col-md-6">
              <label for="userName" class="form-label">Nombre Completo</label>
              <input type="text" class="form-control" id="userName" placeholder="Nombre y Apellido"
                required>
            </div>
            <div class="form-group col-md-6">
              <label for="userEmail" class="form-label">Email</label>
              <input type="email" class="form-control" id="userEmail" placeholder="Correo Electronico"
                required>
            </div>
            <div class="form-group col-lg-4">
              <label for="userLogin" class="form-label">Login</label>
              <input type="text" class="form-control" id="userLogin" placeholder="Para Iniciar Sesion"
                required>
            </div>
            <div class="form-group col-lg-4">
              <label for="pass" class="form-label">Contraseña</label>
              <input type="password" class="form-control" id="userpassword"
                placeholder="Para Iniciar Sesion" required>
            </div>
            <div class="form-group col-lg-4">
              <label for="usertypes" class="form-label">Tipo de Usuario</label>
              <select class="form-control" id="usertypes">
                <!-- Se carga a Traves de Archivo JS con arrow function "loadDataSelectUserTypes" -->
              </select>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-outline-danger btn-light" data-bs-dismiss="modal"
              aria-label="Close">Cancelar</button>
            <button type="submit" class="btn btn-outline-primary btn-light">Guardar</button>
          </div>
          <div id="messegecont" class="alert alert-warning d-none" role="alert">
            <p id="messegetext" class="mb-0">Alert Description</p>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
<!--
****************************************************************************
 Modal Nueva Cuenta
****************************************************************************
 -->
<div class="modal fade" id="newAccountModal" tabindex="-1" aria-labelledby="newAccountModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Nueva Cuenta</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body ">
        <form id="formaccount">
          <input type="hidden" id="a_id">
          <div class="form-row">
            <div class="form-group col-md-4">
              <label for="ac_id" class="form-label">Categorias</label>
              <select class="form-control" id="ac_id" required>
                <option value="">Tipo</option>
                <option value="1">INGRESOS</option>
                <option value="2">EGRESOS</option>
              </select>
            </div>
            <div class="form-group col-md-5">
              <label for="at_id" class="form-label">Tipos de Cuenta</label>
              <select class="form-control" id="at_id" required>
                <!-- Se carga a Traves de Archivo JS con arrow function "loadDataSelectUnitLevel" -->
              </select>
            </div>
            <div class="form-group col-md-3">
              <label for="a_code" class="form-label">Codigo</label>
              <input type="text" class="form-control" id="a_code" placeholder="Codigo" disabled>
            </div>
            <div class="form-group col-md-12">
              <label for="a_name">Cuenta</label>
              <input class="form-control" id="a_name" aria-describedby="a_nameHelp"
                placeholder="Ingrese el Nombre de la Cuenta" required>
              <small id="a_nameHelp" class="form-text text-white">Detalle de la cuenta que se va a
                crear</small>
            </div>
          </div>
          <div id="m_unit_cont" class="alert alert-warning d-none" role="alert">
            <p id="m_unit_text" class="mb-0">Alert Description</p>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
            <button type="submit" class="btn btn-primary">Guardar</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
<!--
****************************************************************************
 Modal Nueva Registro de detalle de Movimiento de Cuenta
****************************************************************************
 -->
<div class="modal fade" id="newAccountMovementModal" tabindex="-1" aria-labelledby="newAccountMovementModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Registro de Movimiento</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body ">
        <form id="formmovementaccount">
          <input type="hidden" id="am_id">
          <div class="form-row">
            <div class="form-group col-md-4">
              <label for="ac_id2" class="form-label">Categorias</label>
              <select class="form-control" id="ac_id2" required>
                <option value="">Tipo</option>
                <option value="1">INGRESOS</option>
                <option value="2">EGRESOS</option>
              </select>
            </div>
            <div class="form-group col-md-4">
              <label for="am_date" class="form-label">Fecha del Gasto</label>
              <input type="date" class="form-control" id="am_date" max="<?php echo date('Y-m-d'); ?>"
                value="<?php echo date('Y-m-d'); ?>" required>
            </div>
            <div class="form-group col-md-5" id="e_content">
              <label for="e_id" class="form-label">Sujeto</label>
              <select class="form-control" id="e_id" size="3" required>
                <!-- Se carga a Traves de Archivo JS con arrow function "loadDataSelectUnitLevel" -->
              </select>
            </div>
            <div class="form-group col-md-7" id="a_content">
              <label for="a_id2" class="form-label">Cuenta de Gasto</label>
              <select class="form-control" id="a_id2" size="3" required>
                <!-- Se carga a Traves de Archivo JS con arrow function "loadDataSelectUnitLevel" -->
              </select>
            </div>
            <div class="form-group col-md-8">
              <label for="am_name">Detalle del Gasto</label>
              <textarea id="am_name" class="form-control" rows="3"
                placeholder="Ingrese el Detalle del Gasto a Realizar"
                aria-describedby="am_nameHelp" maxlength="150" required></textarea>
              <small id="am_nameHelp" class="form-text text-white">Detalle del Gasto que se va a
                realizar</small>
              <label id="count" class="float-right"></label>
            </div>
            <div class="form-group col-md-4">
              <label for="am_amount">Monto Del Gasto</label>
              <input type="text" class="form-control" id="am_amount" name="onlynumber" required>
            </div>
          </div>
          <div id="m_unit_cont" class="alert alert-warning d-none" role="alert">
            <p id="m_unit_text" class="mb-0">Alert Description</p>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
            <button type="submit" class="btn btn-primary">Guardar</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>












<!-- 
***********************************************
Modal para Iniciar Sesion 
***********************************************
-->
<div class="modal fade" id="loginModal" tabindex="-1" aria-labelledby="loginModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title"></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="card o-hidden border-0 shadow-lg">
          <div class="row">
            <div class="col-lg-6 d-none d-lg-block bg-login-image">
              <div class="text-center">
                <img class="img-fluid mt-5 mb-5 ml-5" style="width: 25rem;"
                  src="<?php echo  URL_ASSETS; ?>/img/undraw_posting_photo.svg" alt="...">
              </div>
            </div>
            <div class="col-lg-6">
              <div class="p-5">
                <div class="text-center">
                  <h1 class="h4 text-gray-900 mb-4">¡Bienvenido de nuevo!</h1>
                </div>
                <form class="user" id="formLogin">
                  <div class="form-group">
                    <input type="text" class="form-control form-control-user" id="sessionlogin"
                      aria-describedby="emailHelp" placeholder="Ingrese su Login...">
                  </div>
                  <div class="form-group">
                    <input type="password" class="form-control form-control-user"
                      id="sessionpassword" placeholder="Ingrese su Contraseña...">
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-outline-danger btn-light"
                      data-bs-dismiss="modal" aria-label="Close">Cancelar</button>
                    <button type="submit" class="btn btn-outline-primary btn-light">Iniciar
                      Sesion</button>
                  </div>
                  <div id="m_login_cont" class="alert alert-warning d-none" role="alert">
                    <p id="m_login_text" class="mb-0">Alert Description</p>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>







<!--
****************************************************************************
 Modal Nueva Registro de Ingresos Penalizaciones
****************************************************************************
 -->
<div class="modal fade" id="newIncomeModal" tabindex="-1" aria-labelledby="newIncomeModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Cuenta de Ingreso o Penalizacion</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body ">
        <form id="formIncome">
          <input type="hidden" id="idinc">
          <div class="form-row">
            <div class="form-group col-md-8">
              <label for="accountIncome" class="form-label">Cuenta de Ingreso</label>
              <select class="form-control" id="accountIncome" required>
                <!-- Se carga a Traves de Archivo JS con arrow function "loadDataSelectUnitLevel" -->
              </select>
            </div>
            <div id="c_penal" class="form-check form-check-inline col-md-3 text-center d-none">
              <input class="form-check-input" type="checkbox" id="penalty">
              <label class="form-check-label" for="penalty">Por Recibo de Cobro</label>
            </div>
            <div class="form-group col-md-8">
              <label for="datailIncome">Detalle del Ingreso</label>
              <input type="text" class="form-control" id="datailIncome"
                placeholder="Ingrese el Detalle del Gasto a Realizar" maxlength="50" required>
              <label id="count2" class="float-right"></label>
            </div>
            <div id="c_formula" class="form-check form-check-inline col-md-3 text-center d-none">
              <input class="form-check-input" type="checkbox" id="percent">
              <label class="form-check-label" for="percent">Aplicar %</label>
            </div>
            <div id="aumot_content" class="form-group col-md-4">
              <label for="montIncome">Monto Del Ingreso</label>
              <input type="text" class="form-control" id="montIncome" name="onlynumber">
            </div>
            <div id="per_content" class="form-group col-md-3 d-none">
              <label for="m_percent">% de Cobro</label>
              <input type="text" class="form-control" id="m_percent" name="onlynumber">
            </div>
          </div>
          <div id="m_unit_cont" class="alert alert-warning d-none" role="alert">
            <p id="m_unit_text" class="mb-0">Alert Description</p>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
            <button type="submit" class="btn btn-primary">Guardar</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
<!--
****************************************************************************
 Modal Registro de Pago de Cuenta Por Pagar y Por Cobrar
****************************************************************************
 -->
<div class="modal fade" id="cxpPayModal" tabindex="-1" aria-labelledby="cxpPayModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Datos de Cuentas Por Pagar</h5>
        <button type="button" class="close x" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body ">
        <form id="formExpensePay">
          <input type="hidden" id="idcx">
          <div class="form-group row">
            <label id="l_date" for="t_date" class="text-uppercase text-monospace col-sm-5">Fecha de Gasto:
            </label>
            <p id="t_date" class="font-weight-bold text-uppercase col-sm-7"> </p>
            <label id="l_name" class="text-uppercase text-monospace col-sm-5">Proveedor: </label>
            <p id="t_name" class="font-weight-bold text-uppercase col-sm-7"> </p>
            <label id="l_account" class="text-uppercase text-monospace col-sm-5">Cuenta de Gasto: </label>
            <p id="t_account" class="font-weight-bold text-uppercase col-sm-7"> </p>
            <label id="l_detail" class="text-uppercase text-monospace col-sm-5">Detalle del Gasto: </label>
            <p id="t_detail" class="font-weight-bold text-uppercase col-sm-7"> </p>
            <span class="text-uppercase text-monospace col-sm-5">Saldo del Gasto: </span>
            <div class="col-sm-3">
              <input type="text" class="form-control" id="t_balance" disabled>
            </div>
            <div id="c_inte" class="form-check form-check-inline col-md-3 text-center d-none">
              <input class="form-check-input" type="checkbox" id="interes">
              <label class="form-check-label" for="interes">Incluir Penalizaciones</label>
            </div>
            <div class="col-sm-4 mb-2"></div>
            <div id="cont_amunt_cxc" class="form-row col-md-12">
              <div class="form-group col-md-4">
                <label for="refercxc">Numero de Ref:</label>
                <input type="hidden" id="idrefer">
                <input type="text" class="form-control" id="refercxc" name="onlynumber"
                  list="listrefer">
                <datalist id="listrefer">
                  <!-- Se carga a Traves de Archivo JS con arrow function "loadDataSelectUnitLevel" -->
                </datalist>
              </div>
              <div class="form-group col-md-4">
                <label for="datepaycxc">Fecha de Pago:</label>
                <input type="date" class="form-control" id="datepaycxc"
                  max="<?php echo date('Y-m-d'); ?>" disabled>
              </div>
              <div class="form-group col-md-4">
                <label for="amountpaycxc">Monto de Pago:</label>
                <input type="text" class="form-control" id="amountpaycxc" name="onlynumber" disabled>
              </div>
              <div class="form-group col-md-4">
                <label for="ratepaycxc">Tasa del Dia:</label>
                <input type="text" class="form-control" id="ratepaycxc" name="onlynumber" disabled>
              </div>
              <div class="form-group col-md-4">
                <label for="amountpaycxcd">Monto de Pago $:</label>
                <input type="text" class="form-control" id="amountpaycxcd" name="onlynumber" disabled>
              </div>
              <div class="form-check form-check-inline col-md-3 text-center">
                <input class="form-check-input" type="checkbox" id="dollarpay">
                <label class="form-check-label" for="dollarpay">Pago en $</label>
              </div>
              <div class="form-group col-md-12">
                <span id="notecxc"></span>
              </div>
            </div>

          </div>
          <div id="m_unit_cont" class="alert alert-warning d-none" role="alert">
            <p id="m_unit_text" class="mb-0">Alert Description</p>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary x" data-dismiss="modal">Cerrar</button>
            <button type="submit" class="btn btn-primary">Guardar</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
<!--
****************************************************************************
 Modal Registro de Pago de Cuenta Por Pagar
****************************************************************************
 -->
<div class="modal fade" id="rcIndividualModal" tabindex="-1" aria-labelledby="rcIndividualModalLabel"
  aria-hidden="true">
  <div class="modal-dialog modal-xl modal-dialog-scrollable">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title text-center"></h5>
        <button type="button" class="close x" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="col-sm-4">
          <select class="custom-select mb-3" id="typereceiot" required>
            <option value="">Seleccione el Tipo de Recibo</option>
            <option value="COBRO">COBRO MENSUAL</option>
            <option value="PENAL">PENALIZACION</option>
          </select>
        </div>
        <form id="formReceipt" class="formreceipt">
          <input type="hidden" id="id_rc">
          <input type="hidden" id="id_u">
          <input type="hidden" id="id_c">
          <!-- Inicio de contenedor de cabezera de Recibo de Cobro -->
          <div class="container-sm !justify !spacing">
            <div class="form-row mb-3 mt-3 justify-content-between">
              <div class="col-sm-8 mb-3 text-right text-uppercase text-monospace mb-3">N° de Recibo:
              </div>
              <div class="col-sm-4 mb-3 text-left text-uppercase text-monospace mb-3"><i
                  class="bi bi-geo"></i> <span id="n_rc" class="h4 font-weight-bold text-info"></span>
                <i class="bi bi-geo"></i>
              </div>
              <!-- Inicio de contenedor de datos de Recibo de Cobro -->
              <div class="form-row col-sm-8">
                <label class="form-label col-sm-3 mb-2" for="p_cobro">Periodo de Cobro</label>
                <div class="col-sm-3 mb-2">
                  <input id="p_cobro" type="text" class="form-control" placeholder="Periodo de Cobro">
                </div>
                <label class="col-sm-3 mb-2" for="f_vence">Fecha de vencimiento</label>
                <div class="col-sm-3 mb-2">
                  <input id="f_vence" type="date" class="form-control" placeholder="Periodo de Cobro">
                </div>
                <div class="col-sm-2 mb-2">
                  <input id="n_dpto" type="text" class="form-control" placeholder="N° Dpto">
                </div>
                <div class="col-sm-6 mb-2">
                  <input id="name_client" type="text" class="form-control"
                    placeholder="Nombre de Inquilino">
                </div>
                <div class="col-sm-2 mb-2">
                  <input id="l_dpto" type="text" class="form-control" placeholder="Piso">
                </div>
                <div class="col-sm-2 mb-2">
                  <input id="a_dpto" type="text" class="form-control" placeholder="Alicuota">
                </div>
                <div class="col-sm-6 mb-2">
                  <input id="e_dpto" type="text" class="form-control" placeholder="Email Inquilino">
                </div>
              </div>
              <!-- Fin de contenedor de datos de Recibo de Cobro -->
              <!-- Inicio de contenedor de totales de Recibo de Cobro -->
              <div class="form-row col-sm-4 p-0 mt-0">
                <div class="row col-sm-12">
                  <label class="col-sm-8 text-uppercase text-monospace">
                    Total Gastos Fijos
                  </label>
                  <input type="text" id="amout_gf"
                    class="form-control form-control-sm col-sm-4 text-uppercase text-monospace"
                    disabled>
                </div>
                <div class="row col-sm-12">
                  <label class="col-sm-8 text-uppercase text-monospace">
                    Total Gastos Variables
                  </label>
                  <input type="text" id="amout_gv"
                    class="form-control form-control-sm col-sm-4 text-uppercase text-monospace"
                    disabled>
                </div>
                <div class="row col-sm-12">
                  <label class="col-sm-8 text-uppercase text-monospace">
                    Total Penalizaciones
                  </label>
                  <input type="text" id="amout_p"
                    class="form-control form-control-sm col-sm-4 text-uppercase text-monospace"
                    disabled>
                </div>
                <div class="row col-sm-12">
                  <label class="col-sm-8 text-uppercase text-monospace">
                    Total Ingresos
                  </label>
                  <input type="text" id="amout_i"
                    class="form-control form-control-sm col-sm-4 text-uppercase text-monospace"
                    disabled>
                </div>
                <div class="row col-sm-12">
                  <label class="col-sm-8 text-uppercase text-monospace">
                    Saldo Anterior
                  </label>
                  <input type="text" id="amout_a"
                    class="form-control form-control-sm col-sm-4 text-uppercase text-monospace"
                    disabled>
                </div>
                <div class="row col-sm-12">
                  <label class="col-sm-8 text-uppercase text-monospace">
                    Monto Por Mora
                  </label>
                  <input type="text" id="amout_m"
                    class="form-control form-control-sm col-sm-4 text-uppercase text-monospace"
                    disabled>
                </div>
                <div class="row col-sm-12">
                  <label class="col-sm-8 text-uppercase text-monospace">
                    Monto Por Gastos Admtvo.
                  </label>
                  <input type="text" id="amout_g"
                    class="form-control form-control-sm col-sm-4 text-uppercase text-monospace"
                    disabled>
                </div>
                <div class="row col-sm-12">
                  <label class="col-sm-8 text-uppercase text-monospace">
                    Total General
                  </label>
                  <input type="text" id="amout_tg"
                    class="form-control form-control-sm col-sm-4 text-uppercase text-monospace"
                    disabled>
                </div>
              </div>
              <!-- Fin de contenedor de totales de Recibo de Cobro -->
            </div>
          </div>
          <!-- Fin de contenedor de cabezera de Recibo de Cobro -->
          <!-- Inicio de contenedor de los Items del Recibo de Cobro -->
          <div class="form-row col-sm-12 p-0 mt-0">
            <div class="col-sm-8">
              <!-- Inicio de contenedor de los Items Gastos Fijos -->
              <div id="content_fixed" class="card mb-2 d-none">
                <div id="title_fixed" class="card-header text-muted text-center p-0"></div>
                <div id="content_fixed_body" class="card-body pb-1 pt-1">

                </div>
                <div class="card-footer text-muted text-right p-0">
                  <p class="card-text mr-5">Total: <span id="total_fixed"
                      class="font-weight-bold text-uppercase text-monospace text-right text-info h5"></span>
                  </p>
                </div>
              </div>
              <!-- Fin de contenedor de los Items Gastos Fijos -->
              <!-- Inicio de contenedor de los Items Gastos Variables -->
              <div id="content_non_fixed" class="card mb-2 d-none">
                <div id="title_non_fixed" class="card-header text-muted text-center p-0"></div>
                <div id="content_non_fixed_body" class="card-body pb-1 pt-1">

                </div>
                <div class="card-footer text-muted text-right p-0">
                  <p class="card-text mr-5">Total: <span id="total_non_fixed"
                      class="font-weight-bold text-uppercase text-monospace text-right text-info h5"></span>
                  </p>
                </div>
              </div>
              <!-- Fin de contenedor de los Items Gastos Variables -->
              <!-- Inicio de contenedor de los Items Penalizaciones -->
              <div id="content_penalty" class="card mb-2 d-none">
                <div id="title_penalty" class="card-header text-muted text-center p-0"></div>
                <div id="content_penalty_body" class="card-body pb-1 pt-1">

                </div>
                <div class="card-footer text-muted text-right p-0">
                  <p class="card-text mr-5">Total: <span id="total_penalty"
                      class="font-weight-bold text-uppercase text-monospace text-right text-info h5"></span>
                  </p>
                </div>
              </div>
              <!-- Fin de contenedor de los Items Penalizaciones -->
              <!-- Inicio de contenedor de los Items Ingresos -->
              <div id="content_income" class="card mb-2 d-none">
                <div id="title_income" class="card-header text-muted text-center p-0"></div>
                <div id="content_income_body" class="card-body pb-1 pt-1">

                </div>
                <div class="card-footer text-muted text-right p-0">
                  <p class="card-text mr-5">Total: <span id="total_income"
                      class="font-weight-bold text-uppercase text-monospace text-right text-info h5"></span>
                  </p>
                </div>
              </div>
              <!-- Fin de contenedor de los Items Ingresos -->
            </div>
            <div class="col-sm-4 p-0 mt-0 d-block">
              <div class="btn-group justify-content-center" role="group" aria-label="Botones de opciones">
                <button id="b_gastos_f" type="button" class="btn btn-outline-info col-sm btnd"> Gastos
                  Fijos </button>
                <button id="b_gastos_v" type="button" class="btn btn-outline-info col-sm btnd"> Gastos
                  Varios </button>
                <button id="b_ingreso" type="button" class="btn btn-outline-info col-sm btnd"> Ingresos
                </button>
              </div>
              <div class="btn-group justify-content-center" role="group" aria-label="Botones de opciones">
                <button id="b_penal" type="button" class="btn btn-outline-info col-sm btnp">
                  Penalizaciones </button>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary x" data-dismiss="modal">Cerrar</button>
                <button type="submit" class="btn btn-primary">Totalizar</button>
              </div>
            </div>

          </div>
          <!-- Fin de contenedor de los Items del Recibo de Cobro -->
        </form>
      </div>

    </div>
  </div>
</div>