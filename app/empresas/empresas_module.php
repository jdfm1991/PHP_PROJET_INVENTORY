<?php
require_once("../../config/conexion.php");

class Empresas extends Conectar
{
  public function createNewCompanyDB($name, $identity, $address)
  {
    $conectar = parent::conexion();
    parent::set_names();
    $stmt = $conectar->prepare("INSERT INTO company_data_table(c_name, c_identity, c_address) VALUES (:name, :ident, :address)");
    $stmt->execute(['name' => $name, 'ident' => $identity, 'address' => $address]);
    return $stmt->rowCount();
  }
  public function updateDataCompanyDB($id, $name, $identity, $address)
  {
    $conectar = parent::conexion();
    $stmt = $conectar->prepare("UPDATE company_data_table SET c_name=:name, c_identity=:dni, c_address=:address WHERE c_id = :id");
    $stmt->execute(['name' => $name, 'dni' => $identity, 'address' => $address, 'id' => $id]);
    return $stmt->rowCount();
  }
  public function getListCompaniesDB()
  {
    $conectar = parent::conexion();
    parent::set_names();
    $stmt = $conectar->prepare("SELECT * FROM company_data_table WHERE c_status = 1 ORDER BY c_name ASC");
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
  }
  public function getDataCompanyDB($id)
  {
    $conectar = parent::conexion();
    parent::set_names();
    $stmt = $conectar->prepare("SELECT * FROM company_data_table WHERE c_id = :id");
    $stmt->execute(['id' => $id]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
  }
  public function deleteDataCompanyDB($id)
  {
    $conectar = parent::conexion();
    $stmt = $conectar->prepare("UPDATE company_data_table SET c_status = :status WHERE c_id = :id");
    $stmt->execute(['status' => 0, 'id' => $id]);
    return $stmt->rowCount();
  }
}
