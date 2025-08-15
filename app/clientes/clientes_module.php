<?php
require_once("../../config/conexion.php");

class Clientes extends Conectar
{
  public function createNewClientDB($id, $name, $dni, $phone)
  {
    $conectar = parent::conexion();
    parent::set_names();
    $stmt = $conectar->prepare("INSERT INTO client_data_table(c_id, c_name, c_indentity, c_numphone) VALUES (:id, :name, :ident, :phone)");
    $stmt->execute(['id' => $id, 'name' => $name, 'ident' => $dni, 'phone' => $phone]);
    return $stmt->rowCount();
  }
  public function updateDataClientDB($id, $name, $dni, $phone)
  {
    $conectar = parent::conexion();
    $stmt = $conectar->prepare("UPDATE client_data_table SET c_name=:name, c_indentity=:dni, c_numphone=:phone WHERE c_id = :id");
    $stmt->execute(['name' => $name, 'dni' => $dni, 'phone' => $phone, 'id' => $id]);
    return $stmt->rowCount();
  }
  public function getListClientsDB($search)
  {
    $conectar = parent::conexion();
    parent::set_names();
    $stmt = $conectar->prepare("SELECT * FROM client_data_table WHERE c_status = 1 $search ORDER BY c_name ASC");
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
  }
  public function getDataClientDB($id)
  {
    $conectar = parent::conexion();
    parent::set_names();
    $stmt = $conectar->prepare("SELECT * FROM client_data_table WHERE c_id = :id");
    $stmt->execute(['id' => $id]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
  }
  public function deleteClientDB($id)
  {
    $conectar = parent::conexion();
    $stmt = $conectar->prepare("UPDATE client_data_table SET c_status = :status WHERE c_id = :id");
    $stmt->execute(['status' => 0, 'id' => $id]);
    return $stmt->rowCount();
  }
}
