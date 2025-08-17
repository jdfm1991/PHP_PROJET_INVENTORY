<?php
require_once("../../config/abrir_sesion.php");
require_once("../../config/conexion.php");
require_once("usuario_module.php");

$usuario = new Usuario();

$id = (isset($_POST['id'])) ? $_POST['id'] : '68a245a97e353';
$name = (isset($_POST['name'])) ? $_POST['name'] : 'namo';
$email = (isset($_POST['email'])) ? $_POST['email'] : 'mao';
$login = (isset($_POST['login'])) ? $_POST['login'] : 'mano';
$password = (isset($_POST['password'])) ? $_POST['password'] : '';
$type = (isset($_POST['type'])) ? $_POST['type'] : 1;

switch ($_GET["op"]) {
  case 'get_user_types':
    $dato = array();
    $data = $usuario->getNameUserTypes();
    foreach ($data as $row) {
      $sub_array = array();
      $sub_array['id'] = $row['ut_id'];
      $sub_array['type'] = $row['ut_name'];
      $dato[] = $sub_array;
    }
    echo json_encode($dato);
    break;
  case 'new_user':
    $dato = array();
    if (empty($id)) {
      $loginexist = $usuario->getDataUsersDB($login);
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
      if ($password == '') {
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
      $sub_array['id'] = $row['u_id'];
      $sub_array['name'] = $row['u_name'];
      $sub_array['email'] = $row['u_email'];
      $sub_array['login'] = $row['u_login'];
      $sub_array['type'] = $row['ut_name'];
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
      $dato['id'] = $row['u_id'];
      $dato['name'] = $row['u_name'];
      $dato['email'] = $row['u_email'];
      $dato['login'] = $row['u_login'];
      $dato['password'] = $row['u_pass'];
      $dato['type'] = $row['u_level'];
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
