<?php
require_once("../../config/conexion.php");

class Clientes extends Conectar
{
  public function createNewClientDB($id, $name, $dni, $phone, $phonealt, $email)
  {
    $conectar = parent::conexion();
    parent::set_names();
    $stmt = $conectar->prepare("INSERT INTO client_data_table(id, nameClient, dniClient, emailClient, phoneClient, phoneClientAlt) VALUES (?,?,?,?,?,?)");
    $stmt->execute([$id, $name, $dni, $email, $phone, $phonealt]);
    return $stmt;
  }
  public function updateDataClientDB($id, $name, $dni, $phone, $phonealt, $email)
  {
    $conectar = parent::conexion();
    $stmt = $conectar->prepare("UPDATE client_data_table SET nameClient=:name, dniClient=:dni, emailClient=:email, phoneClient=:phone, phoneClientAlt=:phonealt WHERE id = :id");
    $stmt->execute(['name' => $name, 'dni' => $dni, 'email' => $email, 'phone' => $phone, 'phonealt' => $phonealt, 'id' => $id]);
    return $stmt->rowCount();
  }
  public function getListClientsDB($search)
  {
    $conectar = parent::conexion();
    parent::set_names();
    $stmt = $conectar->prepare("SELECT * FROM client_data_table WHERE statusClient = 1 $search ORDER BY nameClient ASC");
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
  }
  public function getDataClientDB($id)
  {
    $conectar = parent::conexion();
    parent::set_names();
    $stmt = $conectar->prepare("SELECT * FROM client_data_table WHERE id = :id");
    $stmt->execute(['id' => $id]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
  }
  public function deleteClientDB($id)
  {
    $conectar = parent::conexion();
    $stmt = $conectar->prepare("UPDATE client_data_table SET statusClient = :status WHERE id = :id");
    $stmt->execute(['status' => 0, 'id' => $id]);
    return $stmt->rowCount();
  }

  public function getRelationshipClientSuplierDB($id)
  {
    $conectar = parent::conexion();
    parent::set_names();
    $stmt = $conectar->prepare("SELECT A.id, A.suplier, B.nameClient FROM client_suplier_data_table AS A 
                                  INNER JOIN client_data_table AS B ON A.client=B.id
                                WHERE suplier = :id");
    $stmt->execute(['id' => $id]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
  }
}
