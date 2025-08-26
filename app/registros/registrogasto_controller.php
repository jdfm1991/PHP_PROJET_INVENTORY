<?php
require_once("../../config/abrir_sesion.php");
require_once("../../config/conexion.php");
require_once(PATH_APP . "/productos/productos_module.php");
require_once("registrogasto_module.php");

$mov = new Movements();
$products = new Products();

$id = (isset($_POST['id'])) ? $_POST['id'] : '';
$cate = (isset($_POST['cate'])) ? $_POST['cate'] : 0;
$date = (isset($_POST['date'])) ? $_POST['date'] : '0000-00-00';
$entity = (isset($_POST['entity'])) ? $_POST['entity'] : 0;
$account = (isset($_POST['account'])) ? $_POST['account'] : 0;
$name = (isset($_POST['name'])) ? $_POST['name'] : '';
$amount = (isset($_POST['amount'])) ? $_POST['amount'] : 0;
$rate = (isset($_POST['rate'])) ? $_POST['rate'] : 0;
$change = (isset($_POST['change'])) ? $_POST['change'] : 0;
$items = (isset($_POST['items'])) ? $_POST['items'] : [];

switch ($_GET["op"]) {
  case 'new_account_movement':
    $dato = array();
    if (empty($id)) {
      $id = uniqid();
      $data = $mov->createDataAccountMovementDB($id, $cate, $date, $entity, $account, $name, $amount, $rate, $change);
      if ($data) {
        foreach (json_decode($items, true) as $row) {
          $dataitems = $mov->createDataAccountMovementItemsDB($id, $row['id'], $rate, $row['amount'], $row['quantity'], $row['total']);
          if ($cate == 1) {
            $products->subtractQuantityByProductDB($row['id'], $row['quantity']);
          };
          if ($cate == 2) {
            $products->addQuantityByProductDB($row['id'], $row['quantity']);
          };
        }
        $dato['status'] = true;
        $dato['error'] = '200';
        $dato['message'] = "El Movimiento Fue Creado Satisfactoriamente \n";
      } else {
        $dato['status'] = false;
        $dato['error'] = '500';
        $dato['message'] = "Error Al Crear El Movimiento, Por Favor Intente Nuevamente \n";
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
      $sub_array['cate'] = $row['amt_name'];
      $sub_array['date'] = $row['am_date'];
      $sub_array['a_id'] = $row['ac_id'];
      $sub_array['account'] = $row['a_name'];
      $sub_array['entity'] = is_null($row['client']) ? $row['supplier'] : $row['client'];
      $sub_array['movement'] = $row['am_name'];
      $sub_array['amount'] = number_format($row['am_amount'], 2);
      $sub_array['status'] = $row['am_status'];
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
    $movement = $mov->getDataAccountMovementDB($id);
    $items = $mov->getDataAccountMovementItemsByMovementDB($id);

    $nid = uniqid();
    $date = date('Y-m-d');
    $cate = ($movement[0]['ac_id'] == 1) ? 6 : 7;
    if ($data) {
      $ope = $mov->createDataAccountMovementDB($nid, $cate, $date, $movement[0]['e_id'], $movement[0]['a_id'], 'DEV. ' . $movement[0]['am_name'], $movement[0]['am_amount'], $movement[0]['am_rate'], $movement[0]['am_change']);
      if ($ope) {
        foreach ($items as $row) {
          $dataitems = $mov->createDataAccountMovementItemsDB($nid, $row['ami_product'], $row['ami_rate'], $row['ami_amount'], $row['ami_quantity'], $row['ami_total']);
          if ($dataitems) {
            $products->addQuantityByProductDB($row['ami_product'], $row['ami_quantity']);
          }
        }
        $dato['status'] = true;
        $dato['error'] = '200';
        $dato['message'] = "El Movimiento Fue Eliminado Satisfactoriamente \n";
      } else {
        $dato['status'] = false;
        $dato['error'] = '500';
        $dato['message'] = "Error Regresando El Movimiento de la Cuenta, Por Favor Intente Nuevamente \n";
      }
    } else {
      $dato['status'] = false;
      $dato['error'] = '500';
      $dato['message'] = "Error Al Eliminar La Cuenta, Por Favor Intente Nuevamente \n";
    }
    echo json_encode($dato, JSON_UNESCAPED_UNICODE);
    break;
  default:
    header("Location:" . URL_APP);
    break;
}
