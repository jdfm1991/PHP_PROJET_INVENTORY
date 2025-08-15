<?php
require_once("../../config/abrir_sesion.php");
require_once("../../config/conexion.php");
require_once("clientes_module.php");

$cliente = new Clientes();

$id = (isset($_POST['id'])) ? $_POST['id'] : '';
$name = (isset($_POST['name'])) ? $_POST['name'] : '';
$dni = (isset($_POST['dni'])) ? $_POST['dni'] : '';
$phone = (isset($_POST['phone'])) ? $_POST['phone'] : '';

switch ($_GET["op"]) {
  case 'new_client':
    $dato = array();
    if (empty($id)) {
      $id = uniqid();
      $data = $cliente->createNewClientDB($id, $name, $dni, $phone);
      if ($data) {
        $dato['status'] = true;
        $dato['error'] = '200';
        $dato['message'] = "El Cliente " . $name . " Fue Creado Satisfactoriamente \n";
      } else {
        $dato['status'] = false;
        $dato['error'] = '500';
        $dato['message'] = "Error Al Crear El Cliente " . $name . ", Por Favor Intente Nuevamente \n";
      }
    } else {
      $data = $cliente->updateDataClientDB($id, $name, $dni, $phone);
      if ($data) {
        $dato['status'] = true;
        $dato['error'] = '200';
        $dato['message'] = "El Cliente " . $name . " Fue Actiualizado Satisfactoriamente \n";
      } else {
        $dato['status'] = false;
        $dato['error'] = '500';
        $dato['message'] = "Error Al Actualizar El Cliente" . $name . ", Por Favor Intente Nuevamente \n";
      }
    }
    echo json_encode($dato, JSON_UNESCAPED_UNICODE);
    break;
  case 'get_list_clients':
    $dato = array();
    $search = (isset($_GET['search'])) ? ' AND nameClient LIKE "%' . $_GET['search'] . '%"' : '';
    $data = $cliente->getListClientsDB($search);
    foreach ($data as $row) {
      $sub_array = array();
      $sub_array['id'] = $row['c_id'];
      $sub_array['name'] = $row['c_name'];
      $sub_array['dni'] = $row['c_indentity'];
      $sub_array['phone'] = $row['c_numphone'];
      $dato[] = $sub_array;
    }
    echo json_encode($dato, JSON_UNESCAPED_UNICODE);
    break;
  case 'get_data_client':
    $dato = array();
    $data = $cliente->getDataClientDB($id);
    foreach ($data as $row) {
      $dato['id'] = $row['c_id'];
      $dato['name'] = $row['c_name'];
      $dato['dni'] = $row['c_indentity'];
      $dato['phone'] = $row['c_numphone'];
    }
    echo json_encode($dato, JSON_UNESCAPED_UNICODE);
    break;
  case 'delete_client':
    $data = $cliente->deleteClientDB($id);
    if ($data) {
      $dato['status'] = true;
      $dato['error'] = '200';
      $dato['message'] = "El Cliente Fue Eliminado Satisfactoriamente \n";
    } else {
      $dato['status'] = false;
      $dato['error'] = '500';
      $dato['message'] = "Error Al Cliente El Cliente, Por Favor Intente Nuevamente \n";
    }
    echo json_encode($dato, JSON_UNESCAPED_UNICODE);
    break;
  default:
    header("Location:" . URL_APP);
    break;
}
