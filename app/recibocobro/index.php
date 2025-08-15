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
          <h4 class="text-gray-800 text-center">Modulo de Recibos de Cobro <br> .::Creacion y Modificacion::.</h4>
          <div class="card">
            <div class="card-body">
              <div class="row list-group-item d-flex justify-content-end lh-sm align-items-center">
                <button id="rc_all" type="button" class="btn btn-outline-primary btn-group-sm"> Generar Todos los Recibos de Cobro </button>
                <button id="rc_indivual" type="button" class="btn btn-outline-info btn-group-sm"> Generar Recibo de Cobro Individual </button>
              </div>
            </div>
          </div>
          <div class="card">
            <div class="card-body">
              <table id="receipt_table" class="table table-striped table-bordered" style="width:100%">
                <thead>
                  <tr>
                    <th>Fecha</th>
                    <th>N° Recibo</th>
                    <th>Departamento</th>
                    <th>Inqulino</th>
                    <th>Concepto</th>
                    <th>Vencimiento</th>
                    <th>Monto</th>
                    <th>Opcion</th>
                  </tr>
                </thead>
                <tbody>
                </tbody>
              </table>
              <!-- El Contenido  se carga a traves de Ajax -->
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
  <script src="recibocobro.js"></script>
</body>

</html>