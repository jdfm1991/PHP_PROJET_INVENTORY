<?php
require_once("../../config/abrir_sesion.php");
require_once("../../config/conexion.php");
require_once(PATH_APP . "/banco/banco_module.php");
require_once(PATH_APP . "/tasacambiaria/tasacambiaria_module.php");
require_once("registrogasto_module.php");

$expenses = new Expenses();
$bankmov = new BankingMovements();
$exchange = new Exchange();

$id = (isset($_POST['id'])) ? $_POST['id'] : '';
$date = (isset($_POST['date'])) ? $_POST['date'] : '';
$suplier = (isset($_POST['suplier'])) ? $_POST['suplier'] : '';
$account = (isset($_POST['account'])) ? $_POST['account'] : '';
$detail = (isset($_POST['detail'])) ? $_POST['detail'] : '';
$mont = (isset($_POST['mont'])) ? $_POST['mont'] : '';
$quota = (isset($_POST['quota']) && (!empty($_POST['quota']))) ? $_POST['quota'] : NULL;

switch ($_GET["op"]) {
  case 'new_expense':
    $dato = array();
    if (empty($id)) {
      $id = uniqid();
      $data = $expenses->createExpenseDB($id, $date, $suplier, $account, $detail, $mont, $quota);
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
      $data = $expenses->updateDataExpenseDB($id, $date, $detail, $mont, $quota);
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
  case 'get_list_expenses':
    $dato = array();
    $data = $expenses->getListExpensesDB();
    foreach ($data as $row) {
      $sub_array = array();
      $sub_array['id'] = $row['id'];
      $sub_array['date'] = $row['dateExpense'];
      $sub_array['suplier'] = $row['nameSuplier'];
      $sub_array['type'] = $row['typeaccount'];
      $sub_array['account'] = $row['expenseaccount'];
      $sub_array['expense'] = $row['expenseName'];
      $sub_array['mont'] = number_format(($row['quotasExpense'] > 0) ? $row['quotasExpense']  : $row['montExpense'], 2);
      $dato[] = $sub_array;
    }
    echo json_encode($dato, JSON_UNESCAPED_UNICODE);
    break;
  case 'get_data_expense':
    $dato = array();
    $data = $expenses->getDataExpenseDB($id);
    foreach ($data as $data) {
      $dato['id'] = $data['id'];
      $dato['date'] = $data['dateExpense'];
      $dato['suplier'] = $data['idSuplier'];
      $dato['account'] = $data['idExpenseAccount'];
      $dato['expense'] = $data['expenseName'];
      $dato['mont'] = number_format($data['montExpense'], 2);
      $dato['quota'] = ($data['quotasExpense'] != null) ? number_format($data['quotasExpense'], 2) : NULL;
      $dato['dater'] = $data['dateRegExp'];
    }
    echo json_encode($dato, JSON_UNESCAPED_UNICODE);
    break;

  case 'delete_expense':
    $dato = array();
    $data = $expenses->deleteClideleteExpenseDB($id);
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

  case 'get_sum_movement':
    $dato = array();
    $descrip = '';
    $sum = 0;
    $mov = $expenses->getNameAccountByIdDB($id);
    if (strpos($mov, 'TRANSFERECIAS BA') !== false) {
      $descrip = 'com.';
    }
    if (strpos($mov, 'TRANSACCIONES FIN') !== false) {
      $descrip = 'ITF 20';
    }
    $sum = $bankmov->getSumMovementByMovementDB($descrip);
    $data = $expenses->updateAmountExpenseByIdDB($id, $sum);
    if ($data) {
      $dato['status'] = true;
      $dato['error'] = '200';
      $dato['message'] = "La Actualizacion se realizo Satisfactoriamente \n";
    } else {
      $dato['status'] = false;
      $dato['error'] = '500';
      $dato['message'] = "No Hubo Informacion para actualizar \n";
    }
    echo json_encode($dato, JSON_UNESCAPED_UNICODE);
    break;
  default:
    header("Location:" . URL_APP);
    break;
}
