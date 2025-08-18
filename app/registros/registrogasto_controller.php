<?php
require_once("../../config/abrir_sesion.php");
require_once("../../config/conexion.php");
require_once(PATH_APP . "/tasacambiaria/tasacambiaria_module.php");
require_once("registrogasto_module.php");

$mov = new Movements();
$exchange = new Exchange();

$id = (isset($_POST['id'])) ? $_POST['id'] : '';
$cate = (isset($_POST['cate'])) ? $_POST['cate'] : 0;
$date = (isset($_POST['date'])) ? $_POST['date'] : '0000-00-00';
$entity = (isset($_POST['entity'])) ? $_POST['entity'] : 0;
$account = (isset($_POST['account'])) ? $_POST['account'] : 0;
$name = (isset($_POST['name'])) ? $_POST['name'] : '';
$amount = (isset($_POST['amount'])) ? $_POST['amount'] : 0;


switch ($_GET["op"]) {
  case 'new_account_movement':
    $dato = array();
    if (empty($id)) {
      $id = uniqid();
      $data = $mov->createDataAccountMovementDB($id, $cate, $date, $entity, $account, $name, $amount);
      if ($data) {
        $dato['status'] = true;
        $dato['error'] = '200';
        $dato['message'] = "El Gasto Fue Creada Satisfactoriamente \n";
      } else {
        $dato['status'] = false;
        $dato['error'] = '500';
        $dato['message'] = "Error Al Crear El Gasto, Por Favor Intente Nuevamente \n";
      }
    } else {
      $data = $mov->updateDataAccountMovementDB($id, $date, $name, $amount);
      if ($data) {
        $dato['status'] = true;
        $dato['error'] = '200';
        $dato['message'] = "El Gasto Fue Actiualizado Satisfactoriamente \n";
      } else {
        $dato['status'] = false;
        $dato['error'] = '500';
        $dato['message'] = "Error Al Actualizar el Gasto, Por Favor Intente Nuevamente \n";
      }
    }
    echo json_encode($dato, JSON_UNESCAPED_UNICODE);
    break;
  case 'get_list_account_movements':
    $dato = array();
    $data = $mov->getDataListAccountMovementsDB();
    foreach ($data as $row) {
      $sub_array = array();
      $sub_array['id'] = $row['am_id'];
      $sub_array['cate'] = ($row['ac_id'] == 1) ? 'Ingreso' : 'Egreso';
      $sub_array['date'] = $row['am_date'];
      $sub_array['account'] = $row['a_name'];
      $sub_array['entity'] = is_null($row['client']) ? $row['supplier'] : $row['client'];
      $sub_array['movement'] = $row['am_name'];
      $sub_array['amount'] = number_format( $row['am_amount'] , 2);
      $dato[] = $sub_array;
    }
    echo json_encode($dato, JSON_UNESCAPED_UNICODE);
    break;
  case 'get_data_account_movement':
    $dato = array();
    $data = $mov->getDataAccountMovementDB($id);
    foreach ($data as $data) {
      $dato['id'] = $data['am_id'];
      $dato['cate'] = $data['ac_id'];
      $dato['account'] = $data['a_id'];
      $dato['entity'] = $data['e_id'];
      $dato['date'] = $data['am_date'];
      $dato['movement'] = $data['am_name'];
      $dato['amount'] = number_format($data['am_amount'], 2);     
    }
    echo json_encode($dato, JSON_UNESCAPED_UNICODE);
    break;

  case 'delete_account_movement':
    $dato = array();
    $data = $mov->deleteDataAccountMovementDB($id);
    if ($data) {
      $dato['status'] = true;
      $dato['error'] = '200';
      $dato['message'] = "La Cuenta Fue Eliminado Satisfactoriamente \n";
    } else {
      $dato['status'] = false;
      $dato['error'] = '500';
      $dato['message'] = "Error Al Elminar La Cuenta, Por Favor Intente Nuevamente \n";
    }
    echo json_encode($dato, JSON_UNESCAPED_UNICODE);
    break;
  default:
    header("Location:" . URL_APP);
    break;
}
