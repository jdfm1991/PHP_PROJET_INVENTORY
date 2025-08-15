<?php
require_once("../../config/conexion.php");

class Manager extends Conectar
{
  function createRelationDepartmentModuleDB($depart, $module)
  {
    $conectar = parent::conexion();
    parent::set_names();
    $stmt = $conectar->prepare("INSERT INTO model_department_data_table(department,module) VALUES (?,?)");
    $stmt->execute([$depart, $module]);
    return $stmt;
  }
  public function availabilityModuleOffDB($id)
  {
    $conectar = parent::conexion();
    $stmt = $conectar->prepare("UPDATE module_data_table SET statusModule = :available WHERE id = :id");
    $stmt->execute(['available' => 0, 'id' => $id]);
    return $stmt->rowCount();
  }
  public function availabilityModuleOnDB($id)
  {
    $conectar = parent::conexion();
    $stmt = $conectar->prepare("UPDATE module_data_table SET statusModule = :available WHERE id = :id");
    $stmt->execute(['available' => 1, 'id' => $id]);
    return $stmt->rowCount();
  }
  public function getModuleByContanerDB($id)
  {
    $conectar = parent::conexion();
    parent::set_names();
    $stmt = $conectar->prepare("SELECT A.id, A.cont_id, A.m_id, B.m_name, B.m_namelist 
                                  FROM container_model_data_table AS A INNER JOIN module_data_table AS B ON A.m_id = B.m_id
                                  WHERE  A.cont_id = :id");
    $stmt->execute(['id' => $id]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
  }
  public function deleteRelationDepartmentModuleDB($id)
  {
    $conectar = parent::conexion();
    $stmt = $conectar->prepare("DELETE FROM model_department_data_table WHERE id = :id");
    $stmt->execute(['id' => $id]);
    return $stmt->rowCount();
  }
}
