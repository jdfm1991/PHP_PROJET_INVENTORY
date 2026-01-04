<?php
require_once("../../config/abrir_sesion.php");
require_once("../../config/conexion.php");
require_once("empresas_module.php");

$empresa = new Empresas();

$id = (isset($_POST['id'])) ? $_POST['id'] : '';
$name = (isset($_POST['name'])) ? $_POST['name'] : '';
$identity = (isset($_POST['identity'])) ? $_POST['identity'] : '';
$address = (isset($_POST['address'])) ? $_POST['address'] : '';

switch ($_GET["op"]) {
  case 'new_company':
    $dato = array();
    if (empty($id)) {
      $data = $empresa->createNewCompanyDB($name, $identity, $address);
      if ($data) {
        $dato['status'] = true;
        $dato['error'] = '200';
        $dato['message'] = "La Empresa " . $name . " Fue Creado Satisfactoriamente \n";
      } else {
        $dato['status'] = false;
        $dato['error'] = '500';
        $dato['message'] = "Error Al Crear La Empresa " . $name . ", Por Favor Intente Nuevamente \n";
      }
    } else {
      $data = $empresa->updateDataCompanyDB($id, $name, $identity, $address);
      if ($data) {
        $dato['status'] = true;
        $dato['error'] = '200';
        $dato['message'] = "La Empresa " . $name . " Fue Actiualizado Satisfactoriamente \n";
      } else {
        $dato['status'] = false;
        $dato['error'] = '500';
        $dato['message'] = "Error Al Actualizar La Empresa" . $name . ", Por Favor Intente Nuevamente \n";
      }
    }
    echo json_encode($dato, JSON_UNESCAPED_UNICODE);
    break;
  case 'get_list_companies':
    $dato = array();
    $data = $empresa->getListCompaniesDB();
    foreach ($data as $row) {
      $sub_array = array();
      $sub_array['id'] = $row['c_id'];
      $sub_array['name'] = $row['c_name'];
      $sub_array['dni'] = $row['c_identity'];
      $sub_array['address'] = $row['c_address'];
      $dato[] = $sub_array;
    }
    echo json_encode($dato, JSON_UNESCAPED_UNICODE);
    break;
  case 'get_data_company':
    $dato = array();
    $data = $empresa->getDataCompanyDB($id);
    foreach ($data as $row) {
      $dato['id'] = $row['c_id'];
      $dato['name'] = $row['c_name'];
      $dato['dni'] = $row['c_identity'];
      $dato['address'] = $row['c_address'];
    }
    echo json_encode($dato, JSON_UNESCAPED_UNICODE);
    break;
  case 'delete_company':
    /* $valided = $movements->validateAccountMovementsByEntityDB($id);
    if ($valided > 0) {
      $dato['status'] = false;
      $dato['error'] = '500';
      $dato['message'] = "No Puede Eliminiar Este Cliente, Ya que Tiene Relacion Con Uno o Mas Movimientos de Cuenta, Por Favor Intente Con Un Cliente Diferente \n";
      echo json_encode($dato, JSON_UNESCAPED_UNICODE);
      return;
    }  */
    $data = $empresa->deleteDataCompanyDB($id);
    if ($data) {
      $dato['status'] = true;
      $dato['error'] = '200';
      $dato['message'] = "La Empresa Fue Eliminado Satisfactoriamente \n";
    } else {
      $dato['status'] = false;
      $dato['error'] = '500';
      $dato['message'] = "Error Al Cliente La Empresa, Por Favor Intente Nuevamente \n";
    }
    echo json_encode($dato, JSON_UNESCAPED_UNICODE);
    break;
  default:
    header("Location:" . URL_APP);
    break;
}
