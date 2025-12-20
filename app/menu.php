<!-- Sidebar -->
<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">
  <!-- Sidebar - Brand -->
  <a class="sidebar-brand d-flex align-items-center justify-content-center" href="<?php echo  URL_APP; ?>">
    <div class="sidebar-brand-icon rotate-n-15">
      <i class="fas fa-laugh-wink"></i>
    </div>
    <div class="sidebar-brand-text mx-3">SB Admin <sup>2</sup></div>
  </a>
  <!-- Divider -->
  <hr class="sidebar-divider my-0">
  <!-- Nav Item - Dashboard -->
  <li class="nav-item active">
    <a class="nav-link" href="<?php echo  URL_APP; ?>">
      <i class="fas fa-fw fa-tachometer-alt"></i>
      <span>Dashboard</span></a>
  </li>
  <!-- Divider -->
  <hr class="sidebar-divider d-none">
  <?php
  if (isset($_SESSION['name'])) { ?>
    <!-- Heading -->
    <div class="sidebar-heading d-none">
      Desarrollo de Sistema
    </div>
    <!-- Nav Item - Pages Collapse Menu -->
    <li class="nav-item d-none">
      <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#development"
        aria-expanded="true" aria-controls="collapseTwo">
        <i class="fas fa-fw fa-code"></i>
        <span>Development </span>
      </a>
      <div id="development" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
        <div class="bg-white py-2 collapse-inner rounded">
          <h6 class="collapse-header">Nucleo:</h6>
          <a class="collapse-item" href="<?php echo  URL_APP; ?>/development/">Fase Creacion</a>
          <a class="collapse-item" href="<?php echo  URL_APP; ?>/manager/">Fase Configuracion</a>
        </div>
      </div>
    </li>
    <!-- Divider -->
    <hr class="sidebar-divider">
    <!-- Heading -->
    <div class="sidebar-heading">
      Gestiones
    </div>
    <div id="accordionSidebarMenu">
      <!-- El constenido del menu se carga a traves de Ajax a traves de archivos javascript -->
    </div>
    <!-- Divider -->
    <hr class="sidebar-divider">
    <!-- Nav Item - Dashboard -->

  <?php } ?>

  <?php
  if (!isset($_SESSION['name'])) { ?>
    <li id="userloginoff" class="nav-item active">
      <a id="btnLogin" class="nav-link" href="#">
        <i class="bi bi-shield-lock"></i>
        <span>Iniciar Sesion</span></a>
    </li>
  <?php } else { ?>
    <li id="userloginon" class="nav-item active">
      <a id="btnLogout" class="nav-link" href="#">
        <i class="bi bi-shield-lock"></i>
        <span>Cerrar Sesion</span></a>
    </li>
  <?php } ?>
  <!-- Divider -->
  <hr class="sidebar-divider d-none d-md-block">
  <!-- Sidebar Toggler (Sidebar) -->
  <div class="text-center d-none d-md-inline">
    <button class="rounded-circle border-0" id="sidebarToggle"></button>
  </div>
</ul>
<!-- End of Sidebar -->