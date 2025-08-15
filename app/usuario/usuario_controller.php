<?php
require_once("../../config/abrir_sesion.php");
require_once("../../config/conexion.php");
require_once("usuario_module.php");

$usuario = new Usuario();

$id = (isset($_POST['id'])) ? $_POST['id'] : '';
$name = (isset($_POST['name'])) ? $_POST['name'] : '';
$email = (isset($_POST['email'])) ? $_POST['email'] : '';
$login = (isset($_POST['login'])) ? $_POST['login'] : 'jfranco';
$password = (isset($_POST['password'])) ? $_POST['password'] : '20975144';
$type = (isset($_POST['type'])) ? $_POST['type'] : 0;

switch ($_GET["op"]) {
  case 'get_user_types':
    $dato = array();
    $data = $usuario->getNameUserTypes();
    foreach ($data as $row) {
      $sub_array = array();
      $sub_array['id'] = $row['id'];
      $sub_array['type'] = $row['nameusertype'];
      $dato[] = $sub_array;
    }
    echo json_encode($dato);
    break;
  case 'new_user':
    $dato = array();
    if (empty($id)) {
      $loginexist = $usuario->loginUserExistsDB($login);
      if ($loginexist) {
        $dato['status'] = false;
        $dato['error'] = '400';
        $dato['message'] = "Error Ya existe Un Usuario Con Este Login Registrado, Por Favor Intente Con Otro Login Diferente \n";
      } else {
        $id = uniqid();
        $pwhash = password_hash($password, PASSWORD_DEFAULT);
        $data = $usuario->createNewUserDB($id, $name, $email, $login, $pwhash, $type);
        if ($data) {
          $dato['status'] = true;
          $dato['error'] = '200';
          $dato['message'] = "El Usuario " . $name . " Fue Creado Satisfactoriamente \n";
        } else {
          $dato['status'] = false;
          $dato['error'] = '500';
          $dato['message'] = "Error Al Crear El Usuario" . $name . ", Por Favor Intente Nuevamente \n";
        }
      }
    } else {
      $pwhashdb = $usuario->getPasswordUserDB($id);
      if ($pwhashdb == $password) {
        $data = $usuario->updateUserDataDBPasswordOff($id, $name, $email, $login, $type);
        if ($data) {
          $dato['status'] = true;
          $dato['error'] = '200';
          $dato['message'] = "El Usuario " . $name . " Fue Actiualizado Satisfactoriamente \n";
        } else {
          $dato['status'] = false;
          $dato['error'] = '500';
          $dato['message'] = "Error Al Actualizar El Usuario" . $name . ", Por Favor Intente Nuevamente \n";
        }
      } else {
        $pwhash = password_hash($password, PASSWORD_DEFAULT);
        $data = $usuario->updateUserDataDBPasswordOn($id, $name, $email, $login, $pwhash, $type);
        if ($data) {
          $dato['status'] = true;
          $dato['error'] = '200';
          $dato['message'] = "El Usuario " . $name . " Fue Actiualizado Satisfactoriamente \n";
        } else {
          $dato['status'] = false;
          $dato['error'] = '500';
          $dato['message'] = "Error Al Actualizar El Usuario" . $name . ", Por Favor Intente Nuevamente \n";
        }
      }
    }
    echo json_encode($dato, JSON_UNESCAPED_UNICODE);
    break;

  case 'get_list_users':
    $dato = array();
    $data = $usuario->getListUsersDB();
    foreach ($data as $row) {
      $sub_array = array();
      $sub_array['id'] = $row['id'];
      $sub_array['name'] = $row['nameuser'];
      $sub_array['email'] = $row['emailuser'];
      $sub_array['login'] = $row['loginuser'];
      $sub_array['type'] = $row['nameusertype'];
      $dato[] = $sub_array;
    }
    echo json_encode($dato, JSON_UNESCAPED_UNICODE);
    break;
  case 'delete_user':
    $data = $usuario->deleteUserDB($id);
    if ($data) {
      $dato['status'] = true;
      $dato['error'] = '200';
      $dato['message'] = "El Usuario Fue Eliminado Satisfactoriamente \n";
    } else {
      $dato['status'] = false;
      $dato['error'] = '500';
      $dato['message'] = "Error Al Eliminar El Usuario, Por Favor Intente Nuevamente \n";
    }
    echo json_encode($dato, JSON_UNESCAPED_UNICODE);
    break;
  case 'get_data_user':
    $dato = array();
    $data = $usuario->getDataUsersDB($id);
    foreach ($data as $row) {
      $dato['id'] = $row['id'];
      $dato['name'] = $row['nameuser'];
      $dato['email'] = $row['emailuser'];
      $dato['login'] = $row['loginuser'];
      $dato['password'] = $row['passworduser'];
      $dato['type'] = $row['leveluser'];
    }
    echo json_encode($dato, JSON_UNESCAPED_UNICODE);
    break;
  case 'login':
    $dato = array();
    $data = $usuario->getDataUserLogin($login);
    if (is_array($data) and count($data) > 0) {
      foreach ($data as $data) {
        if (password_verify($password, $data['passworduser'])) {
          //sesion
          $_SESSION['id'] = $data['id'];
          //para js
          $dato['id'] = $data['id'];
          $dato['status']  = true;
          $dato['name'] = $data['nameuser'];
          $dato['message'] = 'Ingreso de Manera Exitosa, Sea Bienvenido!';
        } else {
          $dato['status']  = false;
          $dato['message'] = 'La Contraseña es incorrecto';
        }
      }
    } else {
      $dato['status']  = false;
      $dato['message'] = 'El Usuario es incorrecto';
    }
    echo json_encode($dato, JSON_UNESCAPED_UNICODE);
    break;
  default:
    header("Location:" . URL_APP);
    break;
}
