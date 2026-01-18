<?php
require_once("../../config/abrir_sesion.php");
require_once("../../config/conexion.php");
require_once(PATH_APP . "/productos/productos_module.php");
require_once("compraventas_module.php");

$mov = new Movements();
$products = new Products();

$id = (isset($_POST['id'])) ? $_POST['id'] : '6964130eb448f';
$company = (isset($_POST['company'])) ? $_POST['company'] : '';
$category = (isset($_POST['category'])) ? $_POST['category'] : '';
$date = (isset($_POST['date'])) ? $_POST['date'] : '0000-00-00';
$rtype = (isset($_POST['rtype'])) ? $_POST['rtype'] : 0;
$rate = (isset($_POST['rate'])) ? $_POST['rate'] : 0;
$partner = (isset($_POST['partner'])) ? $_POST['partner'] : '';
$amount = (isset($_POST['amount'])) ? $_POST['amount'] : 0;
$change = (isset($_POST['change'])) ? $_POST['change'] : 0;
$name = (isset($_POST['name'])) ? $_POST['name'] : 0;
$items = (isset($_POST['items'])) ? $_POST['items'] : [];

switch ($_GET["op"]) {
  case 'new_account_movement':
    $dato = array();
    if (empty($id)) {
      $id = uniqid();
      $data = $mov->createDataAccountMovementDB($id, $company, $category, $date, $rtype, $rate, $partner, $amount, $change, $name);
      if ($data) {
        foreach (json_decode($items, true) as $row) {
          $dataitems = $mov->createDataMovementItemsDB($id, $date, $row['id'], $row['cate'], $row['unit'], $row['amount'], $row['quantity'], $row['total']);
          $newqty = ($category== 1) ? $products->subtractQuantityByProductDB($row['id'], $row['quantity']) : $products->addQuantityByProductDB($row['id'], $row['quantity']);
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
      $sub_array['id'] = $row['im_id'];
      $sub_array['company'] = $row['c_name'];
      $sub_array['type'] = $row['im_type'];
      $sub_array['category'] = $row['imt_name'];
      $sub_array['partner'] = $row['bp_name'];
      $sub_array['date'] = $row['im_date'];
      $sub_array['movement'] = $row['im_description'];
      $sub_array['status'] = $row['im_status'];
      $sub_array['amount'] = number_format($row['im_amount'], 2);
      $sub_array['rate'] = number_format($row['im_rate'], 2);
      $sub_array['change'] = number_format($row['im_change'], 2);
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
    $items = $mov->getDataMovementItemsByMovementDB($id);
    $id = uniqid();
    $date = date('Y-m-d');
    $category = ($movement[0]['im_type'] == 1) ? 6 : 7;
    if ($data) {
      $ope = $mov->createDataAccountMovementDB($id, $movement[0]['im_company'], $category, $date, $movement[0]['im_rtype'], $movement[0]['im_rate'], $movement[0]['im_partner'], $movement[0]['im_amount'], $movement[0]['im_change'], 'DEV. ' . $movement[0]['im_description']);
      if ($ope) {
        foreach ($items as $row) {
          $dataitems = $mov->createDataMovementItemsDB($id, $date, $row['imi_product'], $row['imi_type'], $row['imi_unit'], $row['imi_amount'], $row['imi_quantity'], $row['imi_total']);
          $newqty = ($category== 7) ? $products->subtractQuantityByProductDB($row['imi_product'], $row['imi_quantity']) : $products->addQuantityByProductDB($row['imi_product'], $row['imi_quantity']);
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
      $dato['message'] = "Error Al Eliminar La Cuenta, Por Favor Intente Nuevamente parte 1 \n";
    }
    echo json_encode($dato, JSON_UNESCAPED_UNICODE);
    break;
  default:
    header("Location:" . URL_APP);
    break;
}
