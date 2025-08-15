<?php
require_once("../../config/conexion.php");
require_once(PATH_APP . "/development/dev_module.php");
require_once("man_module.php");

$man = new Manager();
$dev = new Development();

$id = (isset($_POST['id'])) ? $_POST['id'] : '';
$module = (isset($_POST['module'])) ? $_POST['module'] : '';
$depart = (isset($_POST['depart'])) ? $_POST['depart'] : '';

switch ($_GET["op"]) {
  case 'get_name_module':
    $dato = array();
    $data = $dev->getListModulesDB();
    foreach ($data as $row) {
      $sub_array = array();
      $sub_array['id'] = $row['id'];
      $sub_array['name'] = $row['nameListModule'];
      $dato[] = $sub_array;
    }
    echo json_encode($dato, JSON_UNESCAPED_UNICODE);
    break;
  case 'get_name_module2':
    $dato = array();
    $data = $dev->getListModulesDB2();
    foreach ($data as $row) {
      $sub_array = array();
      $sub_array['id'] = $row['id'];
      $sub_array['name'] = $row['nameListModule'];
      $dato[] = $sub_array;
    }
    echo json_encode($dato, JSON_UNESCAPED_UNICODE);
    break;
  case 'get_name_depart':
    $dato = array();
    $data = $dev->getListDepartmentDB();
    foreach ($data as $row) {
      $sub_array = array();
      $sub_array['id'] = $row['id'];
      $sub_array['name'] = $row['nameDepartment'];
      $dato[] = $sub_array;
    }
    echo json_encode($dato, JSON_UNESCAPED_UNICODE);
    break;
  case 'assign_module':
    $data = $man->createRelationDepartmentModuleDB($depart, $module);
    if ($data) {
      $uptmodule = $man->availabilityModuleOffDB($module);
      $dato['status'] = true;
      $dato['message'] = "El modulo Fue Asignado Satisfactoriamente \n";
      echo json_encode($dato, JSON_UNESCAPED_UNICODE);
    } else {
      $dato['status'] = false;
      $dato['message'] = "Error Al Asignar Modulo, Por Favor Intente Nuevamente \n";
      echo json_encode($dato, JSON_UNESCAPED_UNICODE);
    }
    break;
  case 'list_modules_by_depart':
    $dato = array();
    $data = $dev->getListDepartmentDB();
    foreach ($data as $row) {
      $sub_array = array();
      $sub_array['id'] = $row['cont_id'];
      $sub_array['name'] = $row['cont_name'];
      $sub_array['tag'] = $row['cont_tag'];
      $modules = $man->getModuleByContanerDB($row['cont_id']);
      $sub_array['modules'] = $modules;
      $dato[] = $sub_array;
    }
    echo json_encode($dato, JSON_UNESCAPED_UNICODE);
    break;
  case 'unassign_module':
    $data = $man->deleteRelationDepartmentModuleDB($id);
    if ($data) {
      $uptmodule = $man->availabilityModuleOnDB($module);
      $dato['id'] = $id;
      $dato['status'] = true;
      $dato['message'] = "El modulo Fue Desasignado Satisfactoriamente \n";
      echo json_encode($dato, JSON_UNESCAPED_UNICODE);
    } else {
      $dato['status'] = false;
      $dato['message'] = "Error Al Designar Modulo, Por Favor Intente Nuevamente \n";
      echo json_encode($dato, JSON_UNESCAPED_UNICODE);
    }
    break;
  default:
    header("Location:" . URL_APP);
    break;
}
