<?php
require_once("../../config/abrir_sesion.php");
require_once("../../config/conexion.php");
require_once(PATH_APP . "/registros/registrogasto_module.php");
require_once("cuentagasto_module.php");

$accounts = new Accounts();
$movements = new Movements();

$id = (isset($_POST['id'])) ? $_POST['id'] : '';
$cate = (isset($_POST['cate'])) ? $_POST['cate'] : 0;
$type = (isset($_POST['type'])) ? $_POST['type'] : 0;
$code = (isset($_POST['code'])) ? $_POST['code'] : 0;
$name = (isset($_POST['name'])) ? $_POST['name'] : '';

switch ($_GET["op"]) {
  case 'get_account_types':
    $dato = array();
    $data = $accounts->getTypeExpensesBD();
    foreach ($data as $row) {
      $sub_array = array();
      $sub_array['id'] = $row['at_id'];
      $sub_array['type'] = $row['at_name'];
      $dato[] = $sub_array;
    }
    echo json_encode($dato);
    break;
  case 'get_code_by_type':
    $prefix = substr($type, 0, 4);
    $code = $accounts->getNewCodeExpenseByTypeDB($id, $prefix);
    echo json_encode($code, JSON_UNESCAPED_UNICODE);
    break;
  case 'new_account':
    $dato = array();
    if (empty($id)) {
      $id = uniqid();
      $data = $accounts->createDataAccountDB($id, $cate, $type, $code, $name);
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
      $data = $accounts->updateDataAccountDB($id, $name);
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

  case 'get_list_accounts':
    $dato = array();
    $data = $accounts->getDataListAccountsDB();
    foreach ($data as $row) {
      $sub_array = array();
      $sub_array['id'] = $row['a_id'];
      $sub_array['cate'] = ($row['ac_id'] == 1) ? 'Ingreso' : 'Egreso';
      $sub_array['type'] = $row['at_name'];
      $sub_array['code'] = $row['a_code'];
      $sub_array['name'] = $row['a_name'];
      $dato[] = $sub_array;
    }
    echo json_encode($dato, JSON_UNESCAPED_UNICODE);
    break;
  case 'get_list_accounts_by_category':
    $dato = array();
    $data = $accounts->getDataListAccountsByCateDB($_GET['cate']);
    foreach ($data as $row) {
      $sub_array = array();
      $sub_array['id'] = $row['a_id'];
      $sub_array['cate'] = ($row['ac_id'] == 1) ? 'Ingreso' : 'Egreso';
      $sub_array['type'] = $row['at_name'];
      $sub_array['code'] = $row['a_code'];
      $sub_array['name'] = $row['a_name'];
      $dato[] = $sub_array;
    }
    echo json_encode($dato, JSON_UNESCAPED_UNICODE);
    break;
  case 'get_data_account':
    $dato = array();
    $data = $accounts->getDataAccountDB($id);
    foreach ($data as $data) {
      $dato['id'] = $data['a_id'];
      $dato['cate'] = $data['ac_id'];
      $dato['type'] = $data['at_id'];
      $dato['code'] = $data['a_code'];
      $dato['name'] = $data['a_name'];
    }
    echo json_encode($dato, JSON_UNESCAPED_UNICODE);
    break;
  case 'delete_account':
    $valided = $movements->validateAccountMovementsDB($id);
    if ($valided > 0) {
      $dato['status'] = false;
      $dato['error'] = '500';
      $dato['message'] = "No Puede Eliminiar Esta Cuenta, Ya que Tiene Relacion Con Uno o Mas Movimientos de Cuenta, Por Favor Intente Con Una Cuenta Diferente \n";
      echo json_encode($dato, JSON_UNESCAPED_UNICODE);
      return;
    } 
    $data = $accounts->deleteDataAccountDB($id);
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
