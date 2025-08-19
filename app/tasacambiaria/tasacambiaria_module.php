<?php
require_once("../../config/conexion.php");

class Exchange extends Conectar
{
  public function getExchangeRateTypesDB()
  {
    $conectar = parent::conexion();
    parent::set_names();
    $stmt = $conectar->prepare("SELECT * FROM rate_types_data_table");
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
  }
  public function getListExchangeRatesDB()
  {
    $conectar = parent::conexion();
    parent::set_names();
    $stmt = $conectar->prepare("SELECT * FROM rate_data_table ORDER BY r_date DESC");
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
  }
  public function getExchangeRateDB($date)
  {
    $conectar = parent::conexion();
    parent::set_names();
    $stmt = $conectar->prepare("SELECT * FROM rate_data_table WHERE r_date = :date");
    $stmt->execute(['date' => $date]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
  }

  public function createDataRateDB($date, $dollar, $euro)
  {
    $conectar = parent::conexion();
    $stmt = $conectar->prepare("INSERT INTO rate_data_table (r_date, r_exchange_d, r_exchange_e) VALUES (:date, :dollar, :euro)");
    $stmt->execute(['date' => $date, 'dollar' => $dollar, 'euro' => $euro]);
    return $stmt->rowCount();
  }

  public function createDataRateDollarDB($date, $rate)
  {
    $conectar = parent::conexion();
    $stmt = $conectar->prepare("INSERT INTO rate_data_table (r_date, r_exchange_d) VALUES (:date, :dollar)");
    $stmt->execute(['date' => $date, 'dollar' => $rate]);
    return $stmt->rowCount();
  }
  public function createDataRateEuroDB($date, $rate)
  {
    $conectar = parent::conexion();
    $stmt = $conectar->prepare("INSERT INTO rate_data_table (r_date, r_exchange_e) VALUES (:date, :euro)");
    $stmt->execute(['date' => $date, 'dollar' => $rate]);
    return $stmt->rowCount();
  }
  public function createDataRatePreferenceDB($date, $rate)
  {
    $conectar = parent::conexion();
    $stmt = $conectar->prepare("INSERT INTO rate_data_table (r_date, r_exchange_p) VALUES (:date, :pref)");
    $stmt->execute(['date' => $date, 'pref' => $rate]);
    return $stmt->rowCount();
  }
  public function updateRateDollarDataDB($date, $rate)
  {
    $conectar = parent::conexion();
    $stmt = $conectar->prepare("UPDATE rate_data_table SET  r_exchange_d=:rate  WHERE r_date=:date");
    $stmt->execute(['rate' => $rate, 'date' => $date]);
    return $stmt->rowCount();
  }

  public function updateRateEuroDataDB($date, $rate)
  {
    $conectar = parent::conexion();
    $stmt = $conectar->prepare("UPDATE rate_data_table SET  r_exchange_e=:rate  WHERE r_date=:date");
    $stmt->execute(['rate' => $rate, 'date' => $date]);
    return $stmt->rowCount();
  }
  public function updateRatePreferenceDataDB($date, $rate)
  {
    $conectar = parent::conexion();
    $stmt = $conectar->prepare("UPDATE rate_data_table SET  r_exchange_p=:rate  WHERE r_date=:date");
    $stmt->execute(['rate' => $rate, 'date' => $date]);
    return $stmt->rowCount();
  }

  public function validateDateRateDB($date)
  {
    $conectar = parent::conexion();
    parent::set_names();
    $stmt = $conectar->prepare("SELECT * FROM rate_data_table WHERE r_date = :date");
    $stmt->execute(['date' => $date]);
    return $stmt->rowCount();
  }

  public function getDataRateByDateDB($date)
  {
    $conectar = parent::conexion();
    parent::set_names();
    $stmt = $conectar->prepare("SELECT exchRate FROM rate_data_table WHERE dateRate = :date");
    $stmt->execute(['date' => $date]);
    return $stmt->fetchColumn();
  }

  public function getDataLastRateDB()
  {
    $conectar = parent::conexion();
    parent::set_names();
    $stmt = $conectar->prepare("SELECT exchRate FROM rate_data_table ORDER BY dateRate DESC LIMIT 1");
    $stmt->execute();
    return $stmt->fetchColumn();
  }
}
