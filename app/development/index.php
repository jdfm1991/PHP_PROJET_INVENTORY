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
          <h1 class="h3 mb-4 text-gray-800 text-center">Modulo de Desarrollo .::Creacion Contenedores y Modulos::.</h1>
          <div class="card mb-2">
            <div class="card-body">
              <div class="row list-group-item d-flex justify-content-between lh-sm align-items-center">
                <button id="newDepartment" type="button" class="btn btn-outline-success btn-group-sm" data-toggle="modal" data-target="#NewContainerModal"> Nuevo Contenedor </button>
                <button id="listContainer" type="button" class="btn btn-outline-success btn-group-sm"> Lista de Contenedores </button>
                <button id="newModule" type="button" class="btn btn-outline-success btn-group-sm">Nuevo Modulo </button>
                <button id="listModules" type="button" class="btn btn-outline-success btn-group-sm"> Modulos en Proceso </button>
                <button id="listModulesdb" type="button" class="btn btn-outline-success btn-group-sm"> Lista de Modulos </button>

              </div>
            </div>
          </div>
          <div class="card">
            <div class="card-body">
              <div id="module_body">
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
  <script src="dev.js"></script>
</body>

</html>