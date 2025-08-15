<?php
require_once("../../config/abrir_sesion.php");
require_once("../../config/conexion.php");
require_once(PATH_APP . "/relafidu/relafidu_module.php");
require_once("clientes_module.php");

$cliente = new Clientes();
$ralafidu = new FiduciaryRelationship();

$id = (isset($_POST['id'])) ? $_POST['id'] : '';
$name = (isset($_POST['name'])) ? $_POST['name'] : '';
$dni = (isset($_POST['dni'])) ? $_POST['dni'] : '';
$phone = (isset($_POST['phone'])) ? $_POST['phone'] : '';
$phonealt = (isset($_POST['phonealt'])) ? $_POST['phonealt'] : '';
$email = (isset($_POST['email'])) ? $_POST['email'] : '';

switch ($_GET["op"]) {
  case 'new_client':
    $dato = array();
    if (empty($id)) {
      $id = uniqid();
      $data = $cliente->createNewClientDB($id, $name, $dni, $phone, $phonealt, $email);
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
      $data = $cliente->updateDataClientDB($id, $name, $dni, $phone, $phonealt, $email);
      if ($data) {
        $dato['status'] = true;
        $dato['error'] = '200';
        $dato['message'] = "El Usuario " . $name . " Fue Actiualizado Satisfactoriamente \n";
      } else {
        $dato['status'] = false;
        $dato['error'] = '500';
        $dato['message'] = "Error Al Actualizar El Usuario" . $name . ", Por Favor Intente Nuevamente \n";
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
      $sub_array['id'] = $row['id'];
      $sub_array['name'] = $row['nameClient'];
      $sub_array['dni'] = $row['dniClient'];
      $sub_array['email'] = $row['emailClient'];
      $sub_array['phone'] = $row['phoneClient'];
      $sub_array['phonealt'] = $row['phoneClientAlt'];
      $dato[] = $sub_array;
    }
    echo json_encode($dato, JSON_UNESCAPED_UNICODE);
    break;
  case 'get_data_client':
    $dato = array();
    $data = $cliente->getDataClientDB($id);
    foreach ($data as $row) {
      $sub_array['id'] = $row['id'];
      $sub_array['name'] = $row['nameClient'];
      $sub_array['dni'] = $row['dniClient'];
      $sub_array['email'] = $row['emailClient'];
      $sub_array['phone'] = $row['phoneClient'];
      $sub_array['phonealt'] = $row['phoneClientAlt'];
      $dato[] = $sub_array;
    }
    echo json_encode($dato, JSON_UNESCAPED_UNICODE);
    break;
  case 'delete_client':
    $valided = $ralafidu->validedFiduciaryRelationshipDB($id);
    if ($valided > 0) {
      $dato['status'] = false;
      $dato['error'] = '500';
      $dato['message'] = "No Puede Eliminiar Este Cliente, Ya que Tiene Relacion Con Una Unidad Departamental, Por Favor Intente Con Un Cliente Diferente \n";
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
      $dato['message'] = "Error Al Cliente El Usuario, Por Favor Intente Nuevamente \n";
    }
    echo json_encode($dato, JSON_UNESCAPED_UNICODE);
    break;
  default:
    header("Location:" . URL_APP);
    break;
}
