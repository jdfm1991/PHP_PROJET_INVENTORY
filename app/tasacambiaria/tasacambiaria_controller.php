<?php
require_once("../../config/abrir_sesion.php");
require_once("../../config/conexion.php");
require_once(PATH_VENDOR . "/autoload.php");
require_once("tasacambiaria_module.php");

use Goutte\Client;

$exchange = new Exchange();

$id = (isset($_POST['id'])) ? $_POST['id'] : '';
$date = (isset($_POST['date'])) ? $_POST['date'] : date('Y-m-d');
$rate = (isset($_POST['rate'])) ? $_POST['rate'] : '';
$type = (isset($_POST['type'])) ? $_POST['type'] : '';

switch ($_GET["op"]) {
  case 'get_exchange_rate_types':
    $dato = array();
    $data = $exchange->getExchangeRateTypesDB();
    foreach ($data as $row) {
      $sub_array = array();
      $sub_array['id'] = $row['rt_id'];
      $sub_array['type'] = $row['rt_exchange'];
      $sub_array['acr'] = $row['rt_acronym'];
      $dato[] = $sub_array;
    }
    echo json_encode($dato, JSON_UNESCAPED_UNICODE);
    break;
  case 'new_rate':
    $dato = array();
    $datevalidate = $exchange->validateDateRateDB($date); //Validar Fecha de Exchange
    if ($datevalidate > 0) {
      if ($type == 1) {
        $data = $exchange->updateRateDollarDataDB($date, $rate);
      } 
      if ($type == 2) {
        $data = $exchange->updateRateEuroDataDB($date, $rate);
      }
      if ($type == 3) {
        $data = $exchange->updateRatePreferenceDataDB($date, $rate);
      }
      if ($data) {
        $dato['status'] = true;
        $dato['error'] = '200';
        $dato['message'] = "La Tasa Cambiaria del Dia  " . $date . " Fue Actiualizado Satisfactoriamente \n";
      } else {
        $dato['status'] = false;
        $dato['error'] = '500';
        $dato['message'] = "Error Al Actualizar Tasa Cambiaria del Dia " . $date . ", Por Favor Intente Nuevamente \n";
      }
    } else {
      if ($type == 1) {
        $data = $exchange->createDataRateDollarDB($date, $rate);
      } 
      if ($type == 2) {
        $data = $exchange->createDataRateEuroDB($date, $rate);
      }
      if ($type == 3) {
        $data = $exchange->createDataRatePreferenceDB($date, $rate);
      }
      if ($data) {
        $dato['status'] = true;
        $dato['error'] = '200';
        $dato['message'] = "La Tasa Cambiaria del Dia " . $date . " Fue Creada Satisfactoriamente \n";
      } else {
        $dato['status'] = false;
        $dato['error'] = '500';
        $dato['message'] = "Error Al Registrar La Tasa Cambiaria del Dia " . $date . ", Por Favor Intente Nuevamente \n";
      }
    }
    echo json_encode($dato, JSON_UNESCAPED_UNICODE);
    break;
  case 'get_list_rates':
    $dato = array();
    $data = $exchange->getListExchangeRatesDB();
    foreach ($data as $row) {
      $sub_array = array();
      $sub_array['id'] = $row['r_id'];
      $sub_array['date'] = $row['r_date'];
      $sub_array['dollar'] = is_null($row['r_exchange_d']) ? 0 : number_format($row['r_exchange_d'], 2); 
      $sub_array['euro'] = is_null($row['r_exchange_e']) ? 0 : number_format($row['r_exchange_e'], 2);
      $sub_array['pref'] = is_null($row['r_exchange_p']) ? 0 : number_format($row['r_exchange_p'], 2);
      $dato[] = $sub_array;
    }
    echo json_encode($dato, JSON_UNESCAPED_UNICODE);
    break;
  case 'get_data_rate':
    $dato = array();
    $data = $exchange->getExchangeRateDB($date);
    foreach ($data as $row) {
      $dato['id'] = $row['r_id'];
      $dato['date'] = $row['r_date'];
      $dato['dollar'] = is_null($row['r_exchange_d']) ? 0 : number_format($row['r_exchange_d'], 2); 
      $dato['euro'] = is_null($row['r_exchange_e']) ? 0 : number_format($row['r_exchange_e'], 2);
      $dato['pref'] = is_null($row['r_exchange_p']) ? 0 : number_format($row['r_exchange_p'], 2);
    }
    echo json_encode($dato, JSON_UNESCAPED_UNICODE);
    break;
  case 'web_scraping':
    error_reporting(0);
    $rate = 0;
    $date = '';
    $client = new Client();
    $crawler = $client->request('GET', 'https://www.bcv.org.ve/');
    $conectado = @fsockopen("www.google.com", 80, $errno, $errstr, 3);
    if ($conectado) {
      fclose($conectado);
      $dollar = $crawler->filter('#dolar')->each(function ($node) {
        $rate = $node->text() . "\n";
        $rate = str_replace(",", ".", $rate);
        $rate = str_replace("USD", "", $rate);
        $rate = str_replace(" ", "", $rate);
        $rate = floatval($rate);
        return $rate;
      });
      $euro = $crawler->filter('#euro')->each(function ($node) {
        $rate = $node->text() . "\n";
        $rate = str_replace(",", ".", $rate);
        $rate = str_replace("EUR", "", $rate);
        $rate = str_replace(" ", "", $rate);
        $rate = floatval($rate);
        return $rate;
      });
      $date = $crawler->filter('.dinpro span')->each(function ($node) {
        $date =  $node->attr('content');
        $date = explode(" ", $date);
        $date = explode("T", $date[0]);
        $date = $date[0];
        return $date;
      });
      $date = date("Y-m-d", strtotime($date[0]));
      $dollar = $dollar[0];
      $euro = $euro[0];
      $datevalidate = $exchange->validateDateRateDB($date);
      if ($datevalidate > 0) {
        $dato['status'] = true;
        $dato['error'] = '200';
        $dato['message'] = "La Tasa Cambiaria del Dia  " . $date . " ya fue registrada previamente \n";
      } else {
        $data = $exchange->createDataRateDB($date, $dollar, $euro);
        if ($data) {
          $dato['status'] = true;
          $dato['error'] = '200';
          $dato['message'] = "La Tasa Cambiaria del Dia " . $date . " Fue Creada Satisfactoriamente \n";
        } else {
          $dato['status'] = false;
          $dato['error'] = '500';
          $dato['message'] = "Error Al Registrar La Tasa Cambiaria del Dia " . $date . ", Por Favor Intente Nuevamente \n";
        }
      }
    } else {
      fclose($conectado);
      $dato['status'] = false;
      $dato['error'] = '500';
      $dato['message'] = "No Existe Conexion a Internet \n";
    }
    echo json_encode($dato, JSON_UNESCAPED_UNICODE);
    break;
  default:
    header("Location:" . URL_APP);
    break;
}
