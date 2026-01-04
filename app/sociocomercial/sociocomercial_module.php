<?php
require_once("../../config/conexion.php");

class Socioscomerciales extends Conectar
{
  public function getDataPartnerTypesDB()
  {
    $conectar = parent::conexion();
    parent::set_names();
    $stmt = $conectar->prepare("SELECT * FROM bp_types_data_table");
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
  }
  public function createNewClientDB($id, $type, $name, $dni, $phone, $address)
  {
    $conectar = parent::conexion();
    parent::set_names();
    $stmt = $conectar->prepare("INSERT INTO bp_data_table(bp_id, bp_type, bp_name, bp_indentity, bp_numphone, bp_address) VALUES (:id, :type, :name, :ident, :phone, :address)");
    $stmt->execute(['id' => $id, 'type' => $type, 'name' => $name, 'ident' => $dni, 'phone' => $phone, 'address' => $address]);
    return $stmt->rowCount();
  }
  public function updateDataClientDB($id, $type, $name, $dni, $phone, $address)
  {
    $conectar = parent::conexion();
    $stmt = $conectar->prepare("UPDATE bp_data_table SET bp_type=:type, bp_name=:name, bp_indentity=:dni, bp_numphone=:phone, bp_address=:address WHERE bp_id = :id");
    $stmt->execute(['type' => $type, 'name' => $name, 'dni' => $dni, 'phone' => $phone, 'address' => $address, 'id' => $id]);
    return $stmt->rowCount();
  }
  public function getListClientsDB($search)
  {
    $conectar = parent::conexion();
    parent::set_names();
    $stmt = $conectar->prepare("SELECT * FROM bp_data_table AS A
    INNER JOIN bp_types_data_table AS B ON A.bp_type = B.bpt_id
     WHERE bp_status = 1 $search ORDER BY bp_name ASC");
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
  }
  public function getDataClientDB($id)
  {
    $conectar = parent::conexion();
    parent::set_names();
    $stmt = $conectar->prepare("SELECT * FROM bp_data_table WHERE bp_id = :id");
    $stmt->execute(['id' => $id]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
  }
  public function deleteClientDB($id)
  {
    $conectar = parent::conexion();
    $stmt = $conectar->prepare("UPDATE bp_data_table SET bp_status = :status WHERE bp_id = :id");
    $stmt->execute(['status' => 0, 'id' => $id]);
    return $stmt->rowCount();
  }
}
