<?php
require_once("../../config/conexion.php");

class Supliers extends Conectar
{
  public function createNewSuplierDB($id, $name, $dni, $phone)
  {
    $conectar = parent::conexion();
    parent::set_names();
    $stmt = $conectar->prepare("INSERT INTO supplier_data_table(s_id, s_name, s_indentity, s_numphone) VALUES (:id, :name, :dni, :phone)");
    $stmt->execute(['id' => $id, 'name' => $name, 'dni' => $dni, 'phone' => $phone]);
    return $stmt->rowCount();
  }
  public function updateDataSuplierDB($id, $name, $dni, $phone)
  {
    $conectar = parent::conexion();
    $stmt = $conectar->prepare("UPDATE supplier_data_table SET s_name=:name, s_indentity=:dni, s_numphone=:phone WHERE s_id = :id");
    $stmt->execute(['name' => $name, 'dni' => $dni, 'phone' => $phone, 'id' => $id]);
    return $stmt->rowCount();
  }
  public function getListSupliersDB()
  {
    $conectar = parent::conexion();
    parent::set_names();
    $stmt = $conectar->prepare("SELECT * FROM supplier_data_table WHERE s_status = 1 ORDER BY s_name ASC");
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
  }
  public function getDataSuplierDB($id)
  {
    $conectar = parent::conexion();
    parent::set_names();
    $stmt = $conectar->prepare("SELECT * FROM supplier_data_table WHERE s_id = :id");
    $stmt->execute(['id' => $id]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
  }
  public function deleteDataSuplierDB($id)
  {
    $conectar = parent::conexion();
    $stmt = $conectar->prepare("UPDATE supplier_data_table SET s_status = :status WHERE s_id = :id");
    $stmt->execute(['status' => 0, 'id' => $id]);
    return $stmt->rowCount();
  }
}
