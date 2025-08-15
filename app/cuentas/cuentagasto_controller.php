<?php
require_once("../../config/abrir_sesion.php");
require_once("../../config/conexion.php");
require_once(PATH_APP . "/registrogasto/registrogasto_module.php");
require_once("cuentagasto_module.php");

$expaccount = new ExpenseAccounts();
$expenses = new Expenses();

$id = (isset($_POST['id'])) ? $_POST['id'] : '6878e170425f1';
$type = (isset($_POST['type'])) ? $_POST['type'] : '1';
$code = (isset($_POST['code'])) ? $_POST['code'] : '';
$fixe = (isset($_POST['fixed'])) ? $_POST['fixed'] : 'false';
$expense = (isset($_POST['expense'])) ? $_POST['expense'] : '';

switch ($_GET["op"]) {
  case 'get_type_expenses':
    $dato = array();
    $data = $expaccount->getTypeExpensesBD();
    foreach ($data as $row) {
      $sub_array = array();
      $sub_array['id'] = $row['id'];
      $sub_array['type'] = $row['expensetypename'];
      $dato[] = $sub_array;
    }
    echo json_encode($dato);
    break;
  case 'get_code_expense_by_type':
    $prefix = substr($type, 0, 4);
    $code = $expaccount->getNewCodeExpenseByTypeDB($id, $prefix);
    echo json_encode($code, JSON_UNESCAPED_UNICODE);
    break;
  case 'new_expense_account':
    $dato = array();
    if (empty($id)) {
      $id = uniqid();
      $fixed = ($fixe == 'true') ? 1 : 0;
      $data = $expaccount->createExpenseAccountDB($id, $type, $code, $fixed, $expense);
      if ($data) {
        $dato['status'] = true;
        $dato['error'] = '200';
        $dato['message'] = "La Cuenta de Gasto " . $expense . " Fue Creada Satisfactoriamente \n";
      } else {
        $dato['status'] = false;
        $dato['error'] = '500';
        $dato['message'] = "Error Al Crear La Cuenta de Gasto" . $expense . ", Por Favor Intente Nuevamente \n";
      }
    } else {
      $fixed = ($fixe == 'true') ? 1 : 0;
      $data = $expaccount->updateDataExpenseAccountDB($id, $type, $code, $fixed, $expense);
      if ($data) {
        $dato['status'] = true;
        $dato['error'] = '200';
        $dato['message'] = "La Cuenta de Gastol " . $expense . " Fue Actiualizado Satisfactoriamente \n";
      } else {
        $dato['status'] = false;
        $dato['error'] = '500';
        $dato['message'] = "Error Al Actualizar La Cuenta de Gasto" . $expense . ", Por Favor Intente Nuevamente \n";
      }
    }
    echo json_encode($dato, JSON_UNESCAPED_UNICODE);
    break;

  case 'get_list_expense_accounts':
    $dato = array();
    $data = $expaccount->getListExpenseAccountsDB();
    foreach ($data as $row) {
      $sub_array = array();
      $sub_array['id'] = $row['id'];
      $sub_array['type'] = $row['type'];
      $sub_array['code'] = $row['code'];
      $sub_array['fixed'] = ($row['fixed'] == 1) ? 'GASTO FIJO' : 'GASTO VARIABLE';
      $sub_array['expense'] = $row['expense'];
      $dato[] = $sub_array;
    }
    echo json_encode($dato, JSON_UNESCAPED_UNICODE);
    break;
  case 'get_data_expense_account':
    $dato = array();
    $data = $expaccount->getDataExpenseAccountDB($id);
    foreach ($data as $data) {
      $dato['id'] = $data['id'];
      $dato['type'] = $data['typeaccount'];
      $dato['code'] = $data['codeaccount'];
      $dato['fixed'] = $data['fixedaccount'];
      $dato['expense'] = $data['expenseaccount'];
    }
    echo json_encode($dato, JSON_UNESCAPED_UNICODE);
    break;
  case 'delete_expense_account':
    $valided = $expenses->validateAccountsRelatedExpensesDB($id);
    if ($valided > 0) {
      $dato['status'] = false;
      $dato['error'] = '500';
      $dato['message'] = "No Puede Eliminiar Esta Cuenta, Ya que Tiene Relacion Con Un Gasto, Por Favor Intente Con Un Cliente Diferente \n";
      echo json_encode($dato, JSON_UNESCAPED_UNICODE);
      return;
    } 
    $data = $expaccount->deleteExpenseAccountDB($id);
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
