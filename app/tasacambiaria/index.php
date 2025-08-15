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
          <h1 class="h3 mb-4 text-gray-800 text-center">Modulo Tasa Cambiaria .::Creacion y Modificacion::.</h1>
          <div class="card mb-2">
            <div class="card-body">
              <div class="row list-group-item d-flex justify-content-end lh-sm align-items-center">
                <button id="ratebcv" type="button" class="btn btn-outline-info btn-group-sm"> Cargar Tasa BCV </button>
                <button id="newRate" type="button" class="btn btn-outline-success btn-group-sm" data-toggle="modal" data-target="#newRateModal"> Nuevo Tasa </button>
              </div>
            </div>
          </div>
          <div class="card">
            <div class="card-body">
                <table id="rate_table" class="table table-striped table-bordered" style="width:100%">
                  <thead>
                    <tr>
                      <th>Fecha</th>
                      <th>Tasa Cambiaria</th>
                      <th>Tipo Cambio</th>
                    </tr>
                  </thead>
                  <tbody>
                    <!-- El Contenido  se carga a traves de Ajax Mediante Archivo js -->
                  </tbody>
                </table>
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
  <script src="tasacambiaria.js"></script>
</body>

</html>