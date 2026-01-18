<?php
require_once("../../config/abrir_sesion.php");
require_once("../../config/conexion.php");
require_once(PATH_APP . "/productos/productos_module.php");
require_once("inventario_module.php");

$inv = new Inventory();
$products = new Products();

$id = (isset($_POST['id'])) ? $_POST['id'] : '';
$company = (isset($_POST['company'])) ? $_POST['company'] : '';
$category = (isset($_POST['category'])) ? $_POST['category'] : '';
$date = (isset($_POST['date'])) ? $_POST['date'] : '0000-00-00';
$rtype = (isset($_POST['rtype'])) ? $_POST['rtype'] : 0;
$rate = (isset($_POST['rate'])) ? $_POST['rate'] : 0;
$partner = (isset($_POST['partner'])) ? $_POST['partner'] : 1;
$amount = (isset($_POST['amount'])) ? $_POST['amount'] : 0;
$change = (isset($_POST['change'])) ? $_POST['change'] : 0;
$name = (isset($_POST['name'])) ? $_POST['name'] : 0;
$items = (isset($_POST['items'])) ? $_POST['items'] : [];

switch ($_GET["op"]) {
  case 'new_inventory_movement':
    $dato = array();
    $id = uniqid();
    $data = $inv->createDataInventoryMovementDB($id, $company, $category, $date, $rtype, $rate, $partner, $amount, $change, $name);
    if ($data) {
      foreach (json_decode($items, true) as $row) {
        $dataitems = $inv->createDataMovementItemsDB($id, $date, $row['id'], $row['cate'], $row['unit'], $row['amount'], $row['quantity'], $row['total']);
        if ($category == 4) {
          $products->subtractQuantityByProductDB($row['id'], $row['quantity']);
        };

        if ($category == 3) {
          $products->addQuantityByProductDB($row['id'], $row['quantity']);
          if ($row['cate'] == 2) {
            $id = uniqid();
            $category = 4;
            $amount = 0;
            $change = 0;
            $recipe = $products->getDataItemsRecipeDB($row['id']);
            foreach ($recipe as $row2) {
              $dataitems = $inv->createDataMovementItemsDB($id, $date, $row2['ir_product'], 1, 1, $row2['ir_total'], $row2['ir_quantity'] * $row['quantity'], $row2['ir_total'] * $row['quantity']);
              $products->subtractQuantityByProductDB($row2['ir_product'], $row2['ir_quantity'] * $row['quantity']);
              $amount += $row2['ir_total'] * $row['quantity'];
            }
            $change = $amount * $rate;
            $data = $inv->createDataInventoryMovementDB($id, $company, $category, $date, $rtype, $rate, $partner, $amount, $change, 'Descargo por cargo de '.$row['quantity'].' '.$row['name']);
          };
          
        };

        if ($category == 5) {
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
