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
    $stmt = $conectar->prepare("SELECT r_date,
                                  MAX(CASE WHEN r_type = 1 THEN r_exchange ELSE 0 END) AS rate_usd,
                                  MAX(CASE WHEN r_type = 2 THEN r_exchange ELSE 0 END) AS rate_eur
                                FROM rate_data_table GROUP BY r_date ORDER BY r_date DESC");
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
  }
  public function getExchangeRateDB($type, $date)
  {
    $conectar = parent::conexion();
    parent::set_names();
    $stmt = $conectar->prepare("SELECT * FROM rate_data_table WHERE r_date = :date AND r_type = :type");
    $stmt->execute(['date' => $date, 'type' => $type]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
  }

  public function createDataRateDB($date, $rate, $type)
  {
    $conectar = parent::conexion();
    $stmt = $conectar->prepare("INSERT INTO rate_data_table (r_date, r_exchange, r_type) VALUES (:date, :rate, :type)");
    $stmt->execute(['date' => $date, 'rate' => $rate, 'type' => $type]);
    return $stmt->rowCount();
  }

  public function updateRateDataDB($date, $rate, $type)
  {
    $conectar = parent::conexion();
    $stmt = $conectar->prepare("UPDATE rate_data_table SET  r_exchange=:rate  WHERE r_date=:date AND r_type=:type");
    $stmt->execute(['rate' => $rate, 'date' => $date, 'type' => $type]);
    return $stmt->rowCount();
  }

  public function validateDateRateDB($date, $type)
  {
    $conectar = parent::conexion();
    parent::set_names();
    $stmt = $conectar->prepare("SELECT * FROM rate_data_table WHERE r_date = :date AND r_type = :type LIMIT 1");
    $stmt->execute(['date' => $date, 'type' => $type]);
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
