<?php
require_once("../../config/abrir_sesion.php");
require_once("../../config/conexion.php");
require_once(PATH_APP . "/clientes/clientes_module.php");
require_once("proveedores_module.php");

$supliers = new Supliers();
$clientes = new Clientes();

$id = (isset($_POST['id'])) ? $_POST['id'] : '';
$name = (isset($_POST['name'])) ? $_POST['name'] : '';
$client = (isset($_POST['client'])) ? $_POST['client'] : '';


switch ($_GET["op"]) {
  case 'new_supplier':
    $dato = array();
    if (empty($id)) {
      $id = uniqid();
      $data = $supliers->createNewSuplierDB($id, $name);
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
      $data = $supliers->updateDataSuplierDB($id, $name);
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
      $sub_array['id'] = $row['id'];
      $sub_array['name'] = $row['nameSuplier'];
      $sub_array['status'] = $row['statusSuplier'];
      $clients = $clientes->getRelationshipClientSuplierDB($row['id']);
      $sub_array['clients'] = $clients;
      $dato[] = $sub_array;
    }
    echo json_encode($dato, JSON_UNESCAPED_UNICODE);
    break;
  case 'get_data_supplier':
    $dato = array();
    $data = $supliers->getDataSuplierDB($id);
    foreach ($data as $row) {
      $dato['id'] = $row['id'];
      $dato['name'] = $row['nameSuplier'];
    }
    echo json_encode($dato, JSON_UNESCAPED_UNICODE);
    break;
  case 'get_data_relationship_suplier':
    $dato = array();
    $data = $clientes->getRelationshipClientSuplierDB($id);
    foreach ($data as $row) {
      $sub_array = array();
      $sub_array['id'] = $row['id'];
      $sub_array['suplier'] = $row['suplier'];
      $sub_array['client'] = $row['nameClient'];
      $dato[] = $sub_array;
    }
    echo json_encode($dato, JSON_UNESCAPED_UNICODE);
    break;
  case 'delete_supplier':
    $valided = $supliers->validedRelationClientSuplierDB($id);
    if ($valided > 0) {
      $dato['status'] = false;
      $dato['error'] = '500';
      $dato['message'] = "No Puede Eliminiar Este Proveedor, Ya que Tiene Relacion Con Un Cliente, Por Favor Intente Con Un Cliente Diferente \n";
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
  case 'new_link':
    $data = $supliers->createRelationClientSuplierDB($id, $client);
    if ($data) {
      $dato['status'] = true;
      $dato['error'] = '200';
      $dato['message'] = "La Relacion Fue Creado Satisfactoriamente \n";
    } else {
      $dato['status'] = false;
      $dato['error'] = '500';
      $dato['message'] = "Error Al Crear La Relacion, Por Favor Intente Nuevamente \n";
    }
    echo json_encode($dato, JSON_UNESCAPED_UNICODE);
    break;
  case 'delete_link':
    $data = $supliers->deleteRelationClientSuplierDB($id);
    if ($data) {
      $dato['status'] = true;
      $dato['error'] = '200';
      $dato['message'] = "La Relacion Fue Creado Satisfactoriamente \n";
    } else {
      $dato['status'] = false;
      $dato['error'] = '500';
      $dato['message'] = "Error Al Crear La Relacion, Por Favor Intente Nuevamente \n";
    }
    echo json_encode($dato, JSON_UNESCAPED_UNICODE);
    break;
  default:
    header("Location:" . URL_APP);
    break;
}
