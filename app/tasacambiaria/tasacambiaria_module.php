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
    $stmt = $conectar->prepare("SELECT A.id, dateRate, exchRate, acronym FROM rate_data_table AS A 
                                  INNER JOIN rate_types_data_table AS B ON A.typeRate=B.id ORDER BY dateRate DESC");
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
  }
  public function getExchangeRateDB($id)
  {
    $conectar = parent::conexion();
    parent::set_names();
    $stmt = $conectar->prepare("SELECT * FROM rate_data_table WHERE id = :id");
    $stmt->execute(['id' => $id]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
  }
  public function updateRateDataDB($date, $rate, $type)
  {
    $conectar = parent::conexion();
    $stmt = $conectar->prepare("UPDATE rate_data_table SET  exchRate=:rate  WHERE dateRate=:date AND typeRate=:type");
    $stmt->execute(['rate' => $rate, 'date' => $date, 'type' => $type]);
    return $stmt->rowCount();
  }

  public function createDataRateDB($date, $rate, $type)
  {
    $conectar = parent::conexion();
    $stmt = $conectar->prepare("INSERT INTO rate_data_table (dateRate, exchRate, typeRate) VALUES (:date, :rate, :type)");
    $stmt->execute(['date' => $date, 'rate' => $rate, 'type' => $type]);
    return $stmt->rowCount();
  }

  public function validateDateRateDB($date, $type)
  {
    $conectar = parent::conexion();
    parent::set_names();
    $stmt = $conectar->prepare("SELECT * FROM rate_data_table WHERE dateRate = :date AND typeRate = :type");
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
