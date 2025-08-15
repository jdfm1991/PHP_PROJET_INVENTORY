<!DOCTYPE html>
<html lang="en">
<?php
require_once("../../config/const.php");
require_once(PATH_APP . "/head.php");
?>
<body id="page-top">
  <!-- Page Wrapper -->
  <div id="wrapper">
    <?php
    require_once(PATH_APP . "/menu.php");
    ?>
    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">
      <!-- Main Content -->
      <div id="content">
        <?php
        require_once(PATH_APP . "/navbar.php");
        ?>
        <!-- Begin Page Content -->
        <div class="container-fluid">
          <!-- Page Heading -->
          <h1 class="h3 mb-4 text-gray-800 text-center">Modulo de Clientes // Propietarios <br> .::Creacion y Modificacion::.</h1>
          <div class="card mb-2">
            <div class="card-body">
              <div class="row list-group-item d-flex justify-content-end lh-sm align-items-center">
                <button type="button" class="btn btn-outline-success btn-group-sm" data-toggle="modal" data-target="#newClientModal"> Nuevo Cliente </button>
              </div>
            </div>
          </div>
          <div class="card">
            <div class="card-body">
              <div id="module_body">
                <table id="client_table" class="table table-striped table-bordered">
                  <thead>
                    <tr>
                      <th>Nombre</th>
                      <th>N° Documento</th>
                      <th>Correo Electronico</th>
                      <th>Telefono Pricipal</th>
                      <th>Telefono Secundario</th>
                    </tr>
                  </thead>
                  <tbody>
                  </tbody>
                </table>
                <!-- El Contenido  se carga a traves de Ajax -->
              </div>
            </div>
          </div>
        </div>
        <!-- /.container-fluid -->
      </div>
      <!-- End of Main Content -->
      <?php
      require_once(PATH_APP . "/footer.php");
      ?>
    </div>
    <!-- End of Content Wrapper -->
  </div>
  <!-- End of Page Wrapper -->
  <!-- Scroll to Top Button-->
  <a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
  </a>
  <?php
  require_once(PATH_APP . "/plugins.php");
  require_once(PATH_ASSETS . '/components/modal.php');
  ?>
  <script src="clientes.js"></script>
</body>

</html>