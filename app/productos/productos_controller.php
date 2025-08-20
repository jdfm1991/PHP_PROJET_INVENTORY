<?php
require_once("../../config/abrir_sesion.php");
require_once("../../config/conexion.php");
require_once(PATH_APP . "/registros/registrogasto_module.php");
require_once("productos_module.php");

$products = new Products();
$movements = new Movements();

$id = (isset($_POST['id'])) ? $_POST['id'] : '';
$cate = (isset($_POST['cate'])) ? $_POST['cate'] : 0;
$code = (isset($_POST['code'])) ? $_POST['code'] : 0;
$name = (isset($_POST['name'])) ? $_POST['name'] : '';
$amountp = (isset($_POST['amountp'])) ? $_POST['amountp'] : 0;
$amounts = (isset($_POST['amounts'])) ? $_POST['amounts'] : 0;

switch ($_GET["op"]) {
  case 'get_product_categories':
    $dato = array();
    $data = $products->getDataProductCategoriesBD();
    foreach ($data as $row) {
      $sub_array = array();
      $sub_array['id'] = $row['pc_id'];
      $sub_array['cate'] = $row['pc_name'];
      $dato[] = $sub_array;
    }
    echo json_encode($dato);
    break;
  case 'get_code_by_category':
    $prefix = ($id == 1) ? 'MF' : 'MnF';
    $code = $products->getNewCodeProductByCategoryDB($id, $prefix);
    echo json_encode($code, JSON_UNESCAPED_UNICODE);
    break;
  case 'new_product':
    $dato = array();
    if (empty($id)) {
      $id = uniqid();
      $data = $products->createDataProductDB($id, $cate, $code, $name, $amountp, $amounts);
      if ($data) {
        $dato['status'] = true;
        $dato['error'] = '200';
        $dato['message'] = "La Cuenta de Gasto " . $name . " Fue Creada Satisfactoriamente \n";
      } else {
        $dato['status'] = false;
        $dato['error'] = '500';
        $dato['message'] = "Error Al Crear La Cuenta de Gasto" . $name . ", Por Favor Intente Nuevamente \n";
      }
    } else {
      $data = $products->updateDataProductDB($id, $name, $amountp, $amounts);
      if ($data) {
        $dato['status'] = true;
        $dato['error'] = '200';
        $dato['message'] = "La Cuenta de Gastol " . $name . " Fue Actiualizado Satisfactoriamente \n";
      } else {
        $dato['status'] = false;
        $dato['error'] = '500';
        $dato['message'] = "Error Al Actualizar La Cuenta de Gasto" . $name . ", Por Favor Intente Nuevamente \n";
      }
    }
    echo json_encode($dato, JSON_UNESCAPED_UNICODE);
    break;

  case 'get_list_products':
    $dato = array();
    $data = $products->getDataListProductsDB();
    foreach ($data as $row) {
      $sub_array = array();
      $sub_array['id'] = $row['p_id'];
      $sub_array['cate'] = $row['pc_name'];
      $sub_array['code'] = $row['p_code'];
      $sub_array['name'] = $row['p_name'];
      $sub_array['aumontp'] = number_format($row['p_price_p'], 2);
      $sub_array['aumonts'] = number_format($row['p_price_s'], 2);
      $dato[] = $sub_array;
    }
    echo json_encode($dato, JSON_UNESCAPED_UNICODE);
    break;
  case 'get_list_products_by_name':
    $dato = array();
    $data = $products->getDataListProductsByNameDB('%'.$name.'%');
    foreach ($data as $row) {
      $sub_array = array();
      $sub_array['id'] = $row['p_id'];
      $sub_array['cate'] = $row['pc_name'];
      $sub_array['code'] = $row['p_code'];
      $sub_array['name'] = $row['p_name'];
      $sub_array['aumontp'] = number_format($row['p_price_p'], 2);
      $sub_array['aumonts'] = number_format($row['p_price_s'], 2);
      $dato[] = $sub_array;
    }
    echo json_encode($dato, JSON_UNESCAPED_UNICODE);
    break;
  case 'get_data_product':
    $dato = array();
    $data = $products->getDataProducDB($id);
    foreach ($data as $data) {
      $dato['id'] = $data['p_id'];
      $dato['cate'] = $data['pc_id'];
      $dato['code'] = $data['p_code'];
      $dato['name'] = $data['p_name'];
      $dato['quan'] = $data['p_quantity'];
      $dato['aumontp'] = number_format($data['p_price_p'], 2);
      $dato['aumonts'] = number_format($data['p_price_s'], 2);
    }
    echo json_encode($dato, JSON_UNESCAPED_UNICODE);
    break;
  case 'delete_preoduct':
    /* $valided = $movements->validateAccountMovementsDB($id);
    if ($valided > 0) {
      $dato['status'] = false;
      $dato['error'] = '500';
      $dato['message'] = "No Puede Eliminiar Esta Cuenta, Ya que Tiene Relacion Con Uno o Mas Movimientos de Cuenta, Por Favor Intente Con Una Cuenta Diferente \n";
      echo json_encode($dato, JSON_UNESCAPED_UNICODE);
      return;
    }  */
    $data = $products->deleteDataProductDB($id);
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
