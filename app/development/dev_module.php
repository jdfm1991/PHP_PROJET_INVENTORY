<?php
require_once("../../config/conexion.php");

class Development extends Conectar
{
  function createContainerDB($id, $cont_name, $cont_tag)
  {
    $conectar = parent::conexion();
    parent::set_names();
    $stmt = $conectar->prepare("INSERT INTO container_data_table(cont_id, cont_name, cont_tag) VALUES (:id, :name,:tag)");
    $stmt->execute(['id' => $id, 'name' => $cont_name, 'tag' => $cont_tag]);
    return $stmt->rowCount();
  }
  public function updateContainerDB($id, $cont_name, $cont_tag)
  {
    $conectar = parent::conexion();
    $stmt = $conectar->prepare("UPDATE container_data_table SET cont_name = :name, cont_tag = :tag WHERE cont_id = :id");
    $stmt->execute(['name' => $cont_name, 'tag' => $cont_tag, 'id' => $id]);
    return $stmt->rowCount();
  }
  function getListContainerDB()
  {
    $conectar = parent::conexion();
    parent::set_names();
    $stmt = $conectar->query("SELECT * FROM container_data_table WHERE cont_status=1 ORDER BY cont_order ASC");
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
  }

  public function getContainerNameDB($id)
  {
    $conectar = parent::conexion();
    parent::set_names();
    $stmt = $conectar->prepare("SELECT cont_name FROM container_data_table WHERE cont_id = :id");
    $stmt->execute(['id' => $id]);
    return $stmt->fetchColumn();
  }
  function validateContainerModuleDB($id)
  {
    $conectar = parent::conexion();
    parent::set_names();
    $stmt = $conectar->prepare("SELECT id FROM container_model_data_table WHERE cont_id = :id");
    $stmt->execute(['id' => $id]);
    return $stmt->fetchColumn();
  }
  public function deleteContainerDB($id)
  {
    $conectar = parent::conexion();
    $stmt = $conectar->prepare("UPDATE container_data_table SET cont_status = :status WHERE cont_id = :id");
    $stmt->execute(['status' => 0, 'id' => $id]);
    return $stmt->rowCount();
  }
  function createNewModuleDB($id, $module, $namelist)
  {
    $conectar = parent::conexion();
    parent::set_names();
    $stmt = $conectar->prepare("INSERT INTO module_data_table(m_id, m_name, m_namelist) VALUES (:id, :module, :namelist)");
    $stmt->execute(['id' => $id, 'module' => $module, 'namelist' => $namelist]);
    return $stmt->rowCount();
  }
  public function updateNewModuleDB($id, $namelist)
  {
    $conectar = parent::conexion();
    $stmt = $conectar->prepare("UPDATE module_data_table SET m_namelist = :namelist WHERE m_id = :id");
    $stmt->execute(['namelist' => $namelist, 'id' => $id]);
    return $stmt->rowCount();
  }
  function getListNameModulesDB()
  {
    $conectar = parent::conexion();
    parent::set_names();
    $stmt = $conectar->query("SELECT m_name FROM module_data_table");
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
  }
  function getListModulesDB()
  {
    $conectar = parent::conexion();
    parent::set_names();
    $stmt = $conectar->query("SELECT * FROM module_data_table  WHERE m_status=1");
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
  }
  function getListModulesDB2()
  {
    $conectar = parent::conexion();
    parent::set_names();
    $stmt = $conectar->query("SELECT * FROM module_data_table WHERE m_available=1 AND m_status=1");
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
  }
  function getValitedModuleDB($id)
  {
    $conectar = parent::conexion();
    parent::set_names();
    $stmt = $conectar->prepare("SELECT id FROM container_model_data_table WHERE m_id = :id");
    $stmt->execute(['id' => $id]);
    return $stmt->fetchColumn();
  }

  public function deleteModuleDB($id)
  {
    $conectar = parent::conexion();
    parent::set_names();
    $stmt = $conectar->prepare("UPDATE module_data_table SET m_status = :status WHERE m_id = :id");
    $stmt->execute(['status' => 0, 'id' => $id]);
    return $stmt->rowCount();
  }
}
