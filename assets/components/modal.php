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
        <span>&times;</span>
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
          <span>&times;</span>
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
          <span>&times;</span>
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
          <span>&times;</span>
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
        <!-- Contenido se Carga A traves de Ajax -->
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
          <span>&times;</span>
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
        <h5 class="modal-title" id="newUserModalLabel">Informacion de Nuevo Socio</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span>&times;</span>
        </button>
      </div>
      <div class="modal-body" id="modal_body">
        <form id="formclient">
          <div class="modal-body form-row">
            <input type="hidden" id="c_id">
            <div class="form-group col-md-3">
              <label for="validationCustom04">Tipo de Socio</label>
              <select class="custom-select" id="c_type" required>
                <!-- El Contenido  se carga a traves de Ajax Mediante Archivo js -->
              </select>
            </div>
            <div class="form-group col-md-5">
              <label for="c_name" class="form-label">Nombre Completo</label>
              <input type="text" class="form-control" id="c_name" placeholder="Nombre y Apellido"
                required>
            </div>
            <div class="form-group col-md-4">
              <label for="c_identity" class="form-label">N° Cedula</label>
              <input type="text" class="form-control" id="c_identity" placeholder="N° Cedula de Identidad"
                maxlength="20">
            </div>
            <div class="form-group col-md-3">
              <label for="c_phone" class="form-label">N° Telefonico Principal</label>
              <input type="text" class="form-control" id="c_phone" name="onlynumber"
                placeholder="N° Telefonico" maxlength="11">
            </div>
            <div class="form-floating col-md-9 mt-2">
              <textarea class="form-control" placeholder="Por favor Ingrese la Direccion" id="c_address1"></textarea>
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
<div class="modal fade" id="newRateModal" tabindex="-1" aria-labelledby="newRateModalLabel">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="NewDepartModalLabel">Nueva Tasa de Cambio</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span>&times;</span>
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
              <input type="date" class="form-control" id="dateRate" aria-describedby="dateRateHelp" value="<?php echo date('Y-m-d'); ?>"
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
<div class="modal fade" id="newUserModal" tabindex="-1" aria-labelledby="newUserModalLabel">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="newUserModalLabel">Nuevo Usuario</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span>&times;</span>
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
<div class="modal fade" id="newAccountModal" tabindex="-1" aria-labelledby="newAccountModalLabel">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Nueva Cuenta</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span>&times;</span>
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
 Modal Nuevo Producto
****************************************************************************
 -->
<div class="modal fade" id="newProductModal" tabindex="-1" aria-labelledby="newProductModalLabel">
  <div class="modal-dialog containt-recipe">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Nuevo Producto</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span>&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="formproduct">
          <input type="hidden" id="p_id">
          <div class="form-row">
            <div class="form-group col-md-5">
              <label for="pc_id" class="form-label">Categoria</label>
              <select class="form-control" id="pc_id" required>
                <!-- Se carga a Traves de Archivo JS con arrow function "loadDataSelectProductCategories" -->
              </select>
            </div>
            <div class="form-group col-md-3">
              <label for="p_code" class="form-label">Codigo</label>
              <input type="text" class="form-control" id="p_code" placeholder="Codigo" disabled>
            </div>
            <div class="form-group col-md-8">
              <label for="p_name">Producto</label>
              <input class="form-control" id="p_name" aria-describedby="p_nameHelp"
                placeholder="Ingrese el Nombre del Producto" required>
              <small id="p_nameHelp" class="form-text text-white">Detalle de la Producto que se va a
                crear</small>
            </div>
            <div class="form-group col-md-4">
              <label for="p_unit" class="form-label">Unidad</label>
              <select class="form-control" id="p_unit" required>
                <!-- Se carga a Traves de Archivo JS con arrow function "loadDataSelectProductCategories" -->
              </select>
            </div>
            <div class="form-group col-md-3">
              <label for="p_amount_p">Precio Compra</label>
              <input type="text" class="form-control" id="p_amount_p" name="onlynumber" required>
            </div>
            <div class="form-group col-md-3">
              <label for="p_amount_s">Precio Venta</label>
              <input type="text" class="form-control" id="p_amount_s" name="onlynumber" required>
            </div>
            <div class="form-group col-md-6 d-none recipe">
              <label for="p_recipe" class="form-label">Buscar Producto</label>
              <div class="d-flex">
                <input type="search" id="p_recipe" class="form-control d-inline" list="listrecipe">
                <datalist id="listrecipe">
                  <!-- Se carga a Traves de Archivo JS con arrow function "loadDataSelectUnitLevel" -->
                </datalist>
                <button id="add_ingredient" type="button" class="btn btn-outline-light btn-group-sm d-inline" title="Crear Vinculo"><i class="fas fa-plus"></i></button>
              </div>
            </div>
            <!-- Inicio de contenedor de los Items Movimiento -->
            <div id="content_item" class="col-md-12 mb-0 p-2">
            </div>
            <!-- Fin de contenedor de los Items Movimiento -->
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
<div class="modal fade" id="newRegisterModal" tabindex="-1" aria-labelledby="newRegisterModalLabel">
  <div class="modal-dialog modal-xl modal-dialog-scrollable">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Registro de Movimiento</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span>&times;</span>
        </button>
      </div>
      <div class="modal-body ">
        <form id="formmovementaccount">
          <input type="hidden" id="am_id">
          <input type="hidden" id="am_partnerid">
          <div class="form-row">
            <div class="form-group col-md-3">
              <label for="am_company" class="form-label">Empresa</label>
              <select class="form-control" id="am_company" required>
                <!-- Se carga a Traves de Archivo JS con arrow function "loadDataSelectCompany" -->
              </select>
            </div>
            <div class="form-group col-md-2">
              <label for="am_category" class="form-label">Categorias</label>
              <select class="form-control" id="am_category" required>
                <option value="">Tipo</option>
                <option value="1">VENTAS</option>
                <option value="2">COMPRAS</option>
              </select>
            </div>
            <div class="form-group col-md-2">
              <label for="am_date" class="form-label">Fec. del Mov.</label>
              <input type="date" class="form-control" id="am_date" max="<?php echo date('Y-m-d'); ?>"
                value="<?php echo date('Y-m-d'); ?>" required>
            </div>
            <div id="cont_opcion" class="form-group col-md-2">
              <!-- Se carga a Traves de Archivo JS con function "loadDataRateTypes" -->
            </div>
            <div class="form-group col-md-2">
              <label for="am_rate">Tasa de Cambio</label>
              <input type="text" class="form-control" id="am_rate" name="onlynumber" required disabled>
            </div>
            <div class="form-group col-md-2">
              <label for="am_id_partner" class="form-label">Identificacion</label>
              <input type="search" id="am_id_partner" class="form-control d-inline" list="listsocio" placeholder="Identificacion">
              <datalist id="listsocio">
                <!-- Se carga a Traves de Archivo JS con arrow function "loadDataSelectUnitLevel" -->
              </datalist>
            </div>
            <div class="form-group col-md-3">
              <label for="am_partner" class="form-label">Proveedor o Cliente</label>
              <input type="search" id="am_partner" class="form-control d-inline" list="listsocios" placeholder="Nombre del Proveedor o Cliente">
              <datalist id="listsocios">
                <!-- Se carga a Traves de Archivo JS con arrow function "loadDataSelectUnitLevel" -->
              </datalist>
            </div>
            <div class="form-group col-md-2">
              <label for="am_amount">Monto Total $</label>
              <input type="text" class="form-control" id="am_amount" name="onlynumber" required disabled>
            </div>
            <div class="form-group col-md-2">
              <label for="am_change">Cambio Bolivares</label>
              <input type="text" class="form-control" id="am_change" name="onlynumber" required disabled>
            </div>
            <div class="form-group col-md-8">
              <label for="am_name">Detalle</label>
              <textarea id="am_name" class="form-control" rows="2"
                placeholder="Ingrese el Detalle del Movimiento a realizar"
                aria-describedby="am_nameHelp" maxlength="150" required></textarea>
              <small id="am_nameHelp" class="form-text text-white">Detalle del Movimiento que se va a
                realizar</small>
              <label id="count" class="float-right"></label>
            </div>
            <div class="form-group col-md-4">
              <label for="a_id2" class="form-label">Buscar Producto</label>
              <div class="d-flex">
                <input type="search" id="p_search" class="form-control d-inline" list="listproducts">
                <datalist id="listproducts">
                  <!-- Se carga a Traves de Archivo JS con arrow function "loadDataSelectUnitLevel" -->
                </datalist>
                <button id="b_add_p" type="button" class="btn btn-outline-light btn-group-sm d-inline" title="Crear Vinculo"><i class="fas fa-plus"></i></button>
              </div>
            </div>
          </div>
          <!-- Inicio de contenedor de los Items Movimiento -->
          <div class="mb-1">
            <div id="content_item3">

            </div>
          </div>
          <!-- Fin de contenedor de los Items Movimiento -->
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
 Modal Nueva Registro de detalle de Movimiento de Inventario
****************************************************************************
 -->
<div class="modal fade" id="newInventoryMovementModal" tabindex="-1" aria-labelledby="newInventoryMovementModalLabel">
  <div class="modal-dialog modal-xl modal-dialog-scrollable">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Registro de Movimiento</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span>&times;</span>
        </button>
      </div>
      <div class="modal-body ">
        <form id="formmovementinventory">
          <input type="hidden" id="im_id">
          <div class="form-row">
            <div class="form-group col-md-3">
              <label for="am_company2" class="form-label">Empresa</label>
              <select class="form-control" id="am_company2" required>
                <!-- Se carga a Traves de Archivo JS con arrow function "loadDataSelectCompany" -->
              </select>
            </div>
            <div class="form-group col-md-2">
              <label for="ac_id3" class="form-label">Categorias</label>
              <select class="form-control" id="ac_id3" required>
                <option value="">Tipo</option>
                <option value="3">CARGOS</option>
                <option value="4">DESCARGOS</option>
                <option value="5">AJUSTES</option>
              </select>
            </div>
            <div class="form-group col-md-2">
              <label for="im_date" class="form-label">Fec. del Mov.</label>
              <input type="date" class="form-control" id="im_date" max="<?php echo date('Y-m-d'); ?>"
                value="<?php echo date('Y-m-d'); ?>" required>
            </div>
            <div id="cont_opcion2" class="form-group col-md-2">
              <!-- Se carga a Traves de Archivo JS con function "loadDataRateTypes" -->
            </div>
            <div class="form-group col-md-2">
              <label for="im_rate">tasa de cambio</label>
              <input type="text" class="form-control" id="im_rate" name="onlynumber" required disabled>
            </div>
            <div class="form-group col-md-2">
              <label for="im_amount">Monto Total $</label>
              <input type="text" class="form-control" id="im_amount" name="onlynumber" required disabled>
            </div>
            
            <div class="form-group col-md-2">
              <label for="im_change">Cambio Bolivares</label>
              <input type="text" class="form-control" id="im_change" name="onlynumber" required disabled>
            </div>
            <div class="form-group col-md-5">
              <label for="im_name">Detalle</label>
              <textarea id="im_name" class="form-control" rows="2"
                placeholder="Ingrese el Detalle del Movimiento a realizar"
                aria-describedby="im_nameHelp" maxlength="150" required></textarea>
              <small id="im_nameHelp" class="form-text text-white">Detalle del Movimiento que se va a
                realizar</small>
              <label id="count" class="float-right"></label>
            </div>
            <div class="form-group col-md-3">
              <label for="p_search2" class="form-label">Buscar Producto</label>
              <div class="d-flex">
                <input type="search2" id="p_search2" class="form-control d-inline" list="listproducts2">
                <datalist id="listproducts2">
                  <!-- Se carga a Traves de Archivo JS con arrow function "loadDataSelectUnitLevel" -->
                </datalist>
                <button id="b_add_p2" type="button" class="btn btn-outline-light btn-group-sm d-inline" title="Crear Vinculo"><i class="fas fa-plus"></i></button>
              </div>
            </div>
          </div>
          <!-- Inicio de contenedor de los Items Movimiento -->
          <div class="card mb-2">
            <table class="table table-striped table-bordered table-sm table-hover table-responsive m-0" style="width:100%">
              <thead>
                <tr class="table-active text-center text-white bg-primary">
                  <th scope="col-sm-1" >Acciones</th>
                  <th style="width:300px">Producto</th>
                  <th style="width:100px">Costo</th>
                  <th scope="col-sm-1">Cantidad</th>
                  <th scope="col-sm-1">Existencia</th>
                  <th scope="col-sm-1">Unidad</th>
                  <th scope="col-sm-1">Ajuste</th>
                  <th scope="col-sm-1">Costo Total</th>
                </tr>
              </thead>
              <tbody id="content_item2">
              </tbody>
            </table>
            <div id="content_ite" class="m-0">

            </div>
          </div>
          <!-- Fin de contenedor de los Items Movimiento -->
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
************************************************
Modal Listado de Modulos 
************************************************
-->
<div class="modal fade" id="listProductMovementsModal" tabindex="-1">
  <div class="modal-dialog modal-lg modal-dialog-scrollable">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title text-black" id="listProductMovementslabel">Lista Movimientos de Producto</h5>
        <button type="button" class="close closemodal" data-dismiss="modal" aria-label="Close">
          <span>&times;</span>
        </button>
      </div>
      <div class="modal-body">
          <div class="card" style="color: rgb(84 84 84)">
            <table id="product_list_table" class="table table-striped" style="width:100%">
              <thead>
                <tr>
                  <th>Categoria</th>
                  <th>Codigo</th>
                  <th>Producto</th>
                </tr>
              </thead>
              <tbody>
              </tbody>
            </table>
          </div>
      </div>
    </div>
  </div>
</div>










<!-- 
***********************************************
Modal para Iniciar Sesion 
***********************************************
-->
<div class="modal fade" id="loginModal" tabindex="-1" aria-labelledby="loginModalLabel">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title"></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span>&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="card o-hidden border-0 shadow-lg">
          <div class="row">
            <div class="col-lg-6 d-none d-lg-block bg-login-image">
              <div class="text-center">
                <img class="img-fluid ml-5" style="width: 25rem; height: 25rem;"
                  src="<?php echo  URL_ASSETS; ?>/img/logo.webp" alt="...">
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
                      data-dismiss="modal" aria-label="Close">Cancelar</button>
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
***********************************************
Modal Nuevo Empresa
***********************************************
-->
<div class="modal fade" id="newEmpresaModal" tabindex="-1">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Informacion de Nueva Empresa</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span>&times;</span>
        </button>
      </div>
      <div class="modal-body" id="modal_body">
        <form id="formEmpresa">
          <div class="modal-body form-row">
            <input type="hidden" id="c_id2">
            <div class="form-group col-md-6">
              <label for="c_name2" class="form-label">Nombre De Empresa</label>
              <input type="text" class="form-control" id="c_name2" placeholder="Ingrese el Nombre de la Empresa"
                required>
            </div>
            <div class="form-group col-md-6">
              <label for="c_identity2" class="form-label">N° de Identificacion</label>
              <input type="text" class="form-control" id="c_identity2" placeholder="N° de R.I.F de la Empresa"
                maxlength="30">
            </div>
            <div class="form-group col-md-12">
              <label for="c_address" class="form-label">Direccion Principal</label>
              <textarea class="form-control" id="c_address" rows="2" maxlength="200"></textarea>
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