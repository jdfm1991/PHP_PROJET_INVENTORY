<?php
require_once("../../config/abrir_sesion.php");
require_once("../../config/conexion.php");
require_once(PATH_APP . "/compraventas/compraventas_module.php");
require_once("sociocomercial_module.php");

$cliente = new Socioscomerciales();
$movements = new Movements();

$id = (isset($_POST['id'])) ? $_POST['id'] : '';
$type = (isset($_POST['type'])) ? $_POST['type'] : '';
$name = (isset($_POST['name'])) ? $_POST['name'] : '';
$dni = (isset($_POST['dni'])) ? $_POST['dni'] : '';
$phone = (isset($_POST['phone'])) ? $_POST['phone'] : '';
$address = (isset($_POST['address'])) ? $_POST['address'] : '';

switch ($_GET["op"]) {
  case 'get_partner_types':
    $dato = array();
    $data = $cliente->getDataPartnerTypesDB();
    foreach ($data as $row) {
      $sub_array = array();
      $sub_array['id'] = $row['bpt_id'];
      $sub_array['name'] = $row['bpt_name'];
      $dato[] = $sub_array;
    }
    echo json_encode($dato, JSON_UNESCAPED_UNICODE);
    break;
  case 'new_client':
    $dato = array();
    if (empty($id)) {
      $id = uniqid();
      $data = $cliente->createNewClientDB($id, $type, $name, $dni, $phone, $address);
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
      $data = $cliente->updateDataClientDB($id, $type, $name, $dni, $phone, $address);
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
    $search = (isset($_POST['name'])) ? ' AND bp_name LIKE "%' . $_POST['name'] . '%" OR bp_indentity LIKE "%' . $_POST['name'] . '%"' : '';
    $data = $cliente->getListClientsDB($search);
    foreach ($data as $row) {
      $sub_array = array();
      $sub_array['id'] = $row['bp_id'];
      $sub_array['name'] = $row['bp_name'];
      $sub_array['type'] = $row['bpt_name'];
      $sub_array['dni'] = $row['bp_indentity'];
      $sub_array['phone'] = $row['bp_numphone'];
      $sub_array['address'] = $row['bp_address'];
      $dato[] = $sub_array;
    }
    echo json_encode($dato, JSON_UNESCAPED_UNICODE);
    break;
  case 'get_data_client':
    $dato = array();
    $data = $cliente->getDataClientDB($id);
    foreach ($data as $row) {
      $dato['id'] = $row['bp_id'];
      $dato['name'] = $row['bp_name'];
      $dato['type'] = $row['bp_type'];
      $dato['dni'] = $row['bp_indentity'];
      $dato['phone'] = $row['bp_numphone'];
      $dato['address'] = $row['bp_address'];
    }
    echo json_encode($dato, JSON_UNESCAPED_UNICODE);
    break;
  case 'delete_client':
    $valided = $movements->validatePartnerMovementsDB($id);
    if ($valided > 0) {
      $dato['status'] = false;
      $dato['error'] = '500';
      $dato['message'] = "No Puede Eliminiar Este Socio, Ya que Tiene Relacion Con Uno o Mas Movimientos, Por Favor Intente Con Un Socio Diferente \n";
      echo json_encode($dato, JSON_UNESCAPED_UNICODE);
      return;
    }
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
