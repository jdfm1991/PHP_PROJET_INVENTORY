<?php
require_once("../../config/conexion.php");
require_once(PATH_APP . "/registros/registrogasto_module.php");;
require_once("proveedores_module.php");

$supliers = new Supliers();
$movements = new Movements();

$id = (isset($_POST['id'])) ? $_POST['id'] : '';
$name = (isset($_POST['name'])) ? $_POST['name'] : '';
$dni = (isset($_POST['dni'])) ? $_POST['dni'] : '';
$phone = (isset($_POST['phone'])) ? $_POST['phone'] : '';


switch ($_GET["op"]) {
  case 'new_supplier':
    $dato = array();
    if (empty($id)) {
      $id = uniqid();
      $data = $supliers->createNewSuplierDB($id, $name, $dni, $phone);
      if ($data) {
        $dato['status'] = true;
        $dato['error'] = '200';
        $dato['message'] = "El Usuario " . $name . " Fue Creado Satisfactoriamente \n";
      } else {
        $dato['status'] = false;
        $dato['error'] = '500';
        $dato['message'] = "Error Al Crear El Usuario" . $name . ", Por Favor Intente Nuevamente \n";
      }
    } else {
      $data = $supliers->updateDataSuplierDB($id, $name, $dni, $phone);
      if ($data) {
        $dato['status'] = true;
        $dato['error'] = '200';
        $dato['message'] = "El Usuario " . $name . " Fue Actiualizado Satisfactoriamente \n";
      } else {
        $dato['status'] = false;
        $dato['error'] = '500';
        $dato['message'] = "Error Al Actualizar El Usuario " . $name . ", Por Favor Intente Nuevamente \n";
      }
    }
    echo json_encode($dato, JSON_UNESCAPED_UNICODE);
    break;
  case 'get_list_suppliers':
    $dato = array();
    $data = $supliers->getListSupliersDB();
    foreach ($data as $row) {
      $sub_array = array();
      $sub_array['id'] = $row['s_id'];
      $sub_array['name'] = $row['s_name'];
      $sub_array['dni'] = $row['s_indentity'];
      $sub_array['phone'] = $row['s_numphone'];
      $dato[] = $sub_array;
    }
    echo json_encode($dato, JSON_UNESCAPED_UNICODE); 
    break;
  case 'get_data_supplier':
    $dato = array();
    $data = $supliers->getDataSuplierDB($id);
    foreach ($data as $row) {
      $dato['id'] = $row['s_id'];
      $dato['name'] = $row['s_name'];
      $dato['dni'] = $row['s_indentity'];
      $dato['phone'] = $row['s_numphone'];
    }
    echo json_encode($dato, JSON_UNESCAPED_UNICODE);
    break;
  case 'delete_supplier':
    $valided = $movements->validateAccountMovementsByEntityDB($id);
    if ($valided > 0) {
      $dato['status'] = false;
      $dato['error'] = '500';
      $dato['message'] = "No Puede Eliminiar Este Proveedor, Ya que Tiene Relacion Con Uno o Mas Movimientos de Cuenta, Por Favor Intente Con Un Proveedor Diferente \n";
      echo json_encode($dato, JSON_UNESCAPED_UNICODE);
      return;
    } 
    $data = $supliers->deleteDataSuplierDB($id);
    if ($data) {
      $dato['status'] = true;
      $dato['error'] = '200';
      $dato['message'] = "El Cliente Fue Eliminado Satisfactoriamente \n";
    } else {
      $dato['status'] = false;
      $dato['error'] = '500';
      $dato['message'] = "Error Al Cliente El Usuario, Por Favor Intente Nuevamente \n";
    }
    echo json_encode($dato, JSON_UNESCAPED_UNICODE);
    break;
  default:
    header("Location:" . URL_APP);
    break;
}
