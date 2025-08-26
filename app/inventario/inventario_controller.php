<?php
require_once("../../config/abrir_sesion.php");
require_once("../../config/conexion.php");
require_once(PATH_APP . "/productos/productos_module.php");
require_once("inventario_module.php");

$inv = new Inventory();
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
  case 'new_inventory_movement':
    $dato = array();
    $id = uniqid();
    $data = $inv->createDataInventoryMovementDB($id, $cate, $date, $entity, $account, $name, $amount, $rate, $change);
    if ($data) {
      foreach (json_decode($items, true) as $row) {
        $dataitems = $inv->createDataAccountMovementItemsDB($id, $row['id'], $rate, $row['amount'], $row['quantity'], $row['total']);
        if ($cate == 4) {
          $products->subtractQuantityByProductDB($row['id'], $row['quantity']);
        };
        if ($cate == 3) {
          $products->addQuantityByProductDB($row['id'], $row['quantity']);
        };
        if ($cate == 5) {
          $products->matchQuantityByProductDB($row['id'], $row['quantity']);
        };
      }
      $dato['status'] = true;
      $dato['error'] = '200';
      $dato['message'] = "El Gasto Fue Creada Satisfactoriamente \n";
    } else {
      $dato['status'] = false;
      $dato['error'] = '500';
      $dato['message'] = "Error Al Crear El Gasto, Por Favor Intente Nuevamente \n";
    }

    echo json_encode($dato, JSON_UNESCAPED_UNICODE);
    break;
  case 'get_list_inventory_movements':
    $dato = array();
    $data = $inv->getDataListAccountMovementsDB();
    foreach ($data as $row) {
      $sub_array = array();
      $sub_array['id'] = $row['am_id'];
      $sub_array['cate'] = $row['amt_name'];
      $sub_array['date'] = $row['am_date'];
      $sub_array['account'] = is_null($row['account']) ? 'MOVIMIENTOS DE INVENTARIO' : $row['account'];
      $sub_array['entity'] = (is_null($row['client']) ? $row['supplier'] : $row['client']) ? (is_null($row['supplier']) ? $row['client'] : $row['supplier']) : 'CONTROL INTERNO';
      $sub_array['movement'] = $row['am_name'];
      $sub_array['amount'] = number_format($row['am_amount'], 2);
      $dato[] = $sub_array;
    }
    echo json_encode($dato, JSON_UNESCAPED_UNICODE);
    break;
  case 'get_data_inventory_movement':
    $dato = array();
    $data = $inv->getDataInventoryMovementDB($id);
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

  case 'delete_inventory_movement':
    $dato = array();
    $data = $inv->deleteDataInventoryMovementDB($id);
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
