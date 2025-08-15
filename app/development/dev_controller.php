<?php
date_default_timezone_set('america/caracas');
require_once("../../config/conexion.php");
require_once("dev_module.php");

$dev = new Development();

$id = (isset($_POST['id'])) ? $_POST['id'] : '';
$cont_name = (isset($_POST['container'])) ? $_POST['container'] : '';
$module = (isset($_POST['module'])) ? $_POST['module'] : '';
$namelist = (isset($_POST['namelist'])) ? $_POST['namelist'] : '';
$copy = (isset($_POST['copy'])) ? $_POST['copy'] : 'clientes';



switch ($_GET["op"]) {
  case 'new_container':
    $dato = array();
    $container = explode(" ", $cont_name);
    $cont_tag = end($container);
    if (empty($id)) {
      $id = uniqid();
      $data = $dev->createContainerDB($id, $cont_name, $cont_tag);
      if ($data) {
        $dato['status'] = true;
        $dato['message'] = "El Contenedor " . $cont_name . " Fue Creado Satisfactoriamente \n";
      } else {
        $dato['status'] = false;
        $dato['message'] = "Error Al Crear Contenedor" . $cont_name . ", Por Favor Intente Nuevamente \n";
      }
    } else {
      $data = $dev->updateContainerDB($id, $cont_name, $cont_tag);
      if ($data) {
        $dato['status'] = true;
        $dato['message'] = "El Contenedor " . $cont_name . " Fue Actualizado Satisfactoriamente \n";
      } else {
        $dato['status'] = false;
        $dato['message'] = "Error Al Actualizar Contenedor" . $cont_name . ", Por Favor Intente Nuevamente \n";
      }
    }
    echo json_encode($dato, JSON_UNESCAPED_UNICODE);
    break;
  case 'list_container':
    $dato = array();
    $data = $dev->getListContainerDB();
    foreach ($data as $row) {
      $sub_array = array();
      $sub_array['id'] = $row['cont_id'];
      $sub_array['name'] = $row['cont_name'];
      if ($row['cont_status'] == 1) {
        $sub_array['icon'] = '<i class="bi bi-lightbulb-fill"></i>';
        $sub_array['color'] = 'warning';
      } else {
        $sub_array['icon'] = '<i class="bi bi-lightbulb-off-fill"></i>';
        $sub_array['color'] = 'dark';
      }
      $dato[] = $sub_array;
    }
    echo json_encode($dato, JSON_UNESCAPED_UNICODE);
    break;
  case 'get_container_name':
    $dato = array();
    $name = $dev->getContainerNameDB($id);
    $dato['name'] = $name;
    echo json_encode($dato, JSON_UNESCAPED_UNICODE);
    break;
  case 'delete_container':
    $dato = array();
    $valited = $dev->validateContainerModuleDB($id);
    if ($valited) {
      $dato['status'] = false;
      $dato['message'] = "Error Al Este Contenedor Posee Modulos Asignados, Por Favor Intente Nuevamente \n";
      echo json_encode($dato, JSON_UNESCAPED_UNICODE);
      return;
    }
    $data = $dev->deleteContainerDB($id);
    if ($data) {
      $dato['status'] = true;
      $dato['message'] = "El Contenedor Se Elimino Satisfactoriamente \n";
    } else {
      $dato['status'] = false;
      $dato['message'] = "Error Al Eliminar Contenedor, Por Favor Intente Nuevamente \n";
    }
    echo json_encode($dato, JSON_UNESCAPED_UNICODE);
    break;
  case 'new_folder_module':
    $dato = array();
    $files = array(
      "index.php",
      $module . "_controller.php",
      $module . "_module.php",
      $module . ".js",
    );
    $path = PATH_APP . '/' . $module;
    if (!is_dir($path)) {
      $sub_array = array();
      mkdir($path, 0777, true);
      foreach ($files as $file) {
        touch($path . '/' . $file);
      }
      $dato['status'] = true;
      $sub_array['message'] = "El Modulo Fue Creado Satisfactoriamente \n";
      $dato[] = $sub_array;
    } else {
      $dato['status'] = false;
      $sub_array['message'] = "Error Al Crear Modulo, Ya existe Un Modulo Con El Mismo Nombre Creado Previamente \n";
      $dato[] = $sub_array;
    }
    echo json_encode($dato, JSON_UNESCAPED_UNICODE);
    break;
  case 'available_modules':
    $dato = array();
    $dato1 = array();
    $dato2 = array();
    $path = PATH_APP;
    $data = $dev->getListNameModulesDB();
    foreach ($data as $row) {
      $sub_array = array();
      $dato1[] = $row['nameModule'];
    }
    if (is_dir($path)) {
      $elementos = scandir($path);
      foreach ($elementos as $elemento) {
        $sub_array = array();
        if ($elemento != "." && $elemento != "..") { // Evitar . y ..
          $ruta_completa = $path . '/' . $elemento;
          if (is_dir($ruta_completa)) {
            if ($elemento !== 'development' && $elemento !== 'manager') {
              $dato2[] = $elemento;
            }
          }
        }
      }
      $datos = array_diff($dato2, $dato1);
      foreach ($datos as $row) {
        $sub_array = array();
        $sub_array['folder'] = $row;
        $dato[] = $sub_array;
      }
    } else {
      echo "El directorio especificado no existe.";
    }
    echo json_encode($dato, JSON_UNESCAPED_UNICODE);
    break;

  case 'new_module':
    $dato = array();
    $id = uniqid();
    $data = $dev->createNewModuleDB($id, $module, $namelist);
    if ($data) {
      $dato['status'] = true;
      $dato['message'] = "El Modulo " . $namelist . " Fue Creado Satisfactoriamente \n";
    } else {
      $dato['status'] = false;
      $dato['message'] = "Error Al Crear Modulo" . $namelist . ", Por Favor Intente Nuevamente \n";
    }
    echo json_encode($dato, JSON_UNESCAPED_UNICODE);
    break;
  case 'copy_module':
    $root = PATH_APP . '/' . $module;
    if (!is_dir($root)) {
      $sub_array = array();
      mkdir($root, 0777, true);
      $path = PATH_APP;
      $from = PATH_APP . '/' . $copy;
      $to = PATH_APP . '/' . $module;
      //Abro el directorio que voy a leer
      $dir = opendir($from);
      //Recorro el directorio para leer los archivos que tiene
      while (($file = readdir($dir)) !== false) {
        $new_file = str_replace($copy, $module, $file);
        //Leo todos los archivos excepto . y ..
        if (strpos($file, '.') !== 0) {
          //Copio el archivo manteniendo el mismo nombre en la nueva carpeta
          copy($from . '/' . $file, $to . '/' . $new_file);
        }
      }
      closedir($dir);
      $dato['status'] = true;
      $sub_array['message'] = "El Modulo Fue Creado Satisfactoriamente \n";
      $dato[] = $sub_array;
    } else {
      $dato['status'] = false;
      $sub_array['message'] = "Error Al Crear Modulo, Ya existe Un Modulo Con El Mismo Nombre Creado Previamente \n";
      $dato[] = $sub_array;
    }
    echo json_encode($dato, JSON_UNESCAPED_UNICODE);
    break;
  case 'get_name_module':
    $dato = array();
    $data = $dev->getListModulesDB();
    foreach ($data as $row) {
      $sub_array = array();
      $sub_array['id'] = $row['id'];
      $sub_array['name'] = $row['nameModule'];
      $sub_array['listname'] = $row['nameListModule'];
      if ($row['statusModule'] == 1) {
        $sub_array['icon'] = '<i class="bi bi-lightbulb-fill"></i>';
        $sub_array['color'] = 'warning';
      } else {
        $sub_array['icon'] = '<i class="bi bi-lightbulb-off-fill"></i>';
        $sub_array['color'] = 'dark';
      }
      $dato[] = $sub_array;
    }
    echo json_encode($dato, JSON_UNESCAPED_UNICODE);
    break;
  case 'trash_module':
    $dato = array();
    $valited = $dev->getValitedModuleDB($id);
    if ($valited) {
      $dato['status'] = false;
      $dato['message'] = "Error Al Este Modulo Esta Asignados A Un Contenedor, Por Favor Intente Nuevamente \n";
      echo json_encode($dato, JSON_UNESCAPED_UNICODE);
      return;
    }
    $data = $dev->deleteModuleDB($id);
    if ($data) {
      $root = PATH_APP . '/' . $module;
      $files = glob(PATH_APP . '/' . $module . '/*'); //obtenemos todos los nombres de los ficheros
      foreach ($files as $file) {
        if (is_file($file))
          unlink($file); //eliminamos el fichero
      }
      if (is_dir($root)) {
        rmdir($root);
      }
      $dato['status'] = true;
      $dato['message'] = "El Contenedor Se Elimino Satisfactoriamente \n";
    } else {
      $dato['status'] = false;
      $dato['message'] = "Error Al Eliminar Contenedor, Por Favor Intente Nuevamente \n";
    }
    echo json_encode($dato, JSON_UNESCAPED_UNICODE);
    break;
  default:
    header("Location:" . URL_APP);
    break;
}
