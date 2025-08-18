<?php
require_once("../../config/conexion.php");

class Accounts extends Conectar
{
  /* FUNCION PARA EJECUTAR CONSULTAS SQL PARA TRAER INFORMACION DE LOS TIPO DE GASTOS EXISTENTES EN LA BASE DE DATOS*/
  public function getTypeExpensesBD()
  {
    $conectar = parent::conexion();
    parent::set_names();
    $stmt = $conectar->prepare("SELECT * FROM account_types_data_table");
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
  }
  /* FUNCION PARA EJECUTAR CONSULTAS SQL PARA TRAER INFORMACION DEL NUEVO CODIGO DE GASTO QUE SE DESEAN CREAR EN LA BASE DE DATOS */
  public function getNewCodeExpenseByTypeDB($id, $prefix)
  {
    $conectar = parent::conexion();
    parent::set_names();
    $stmt = $conectar->prepare("SELECT CONCAT('$prefix-', LPAD(COUNT(*) + 1, 2, '0')) AS newcode
            FROM account_data_table
            WHERE at_id = :type");
    $stmt->execute(['type' => $id]);
    return $stmt->fetchColumn();
  }
  /* FUNCION PARA EJECUTAR CONSULTAS SQL PARA CREAR EL NUEVO GASTO EN LA BASE DE DATOS */
  public function createDataAccountDB($id, $cate, $type, $code, $name)
  {
    $conectar = parent::conexion();
    parent::set_names();
    $stmt = $conectar->prepare("INSERT INTO account_data_table (a_id, ac_id, at_id, a_code, a_name) VALUES (:id, :cate, :type, :code, :name)");
    $stmt->execute(['id' => $id, 'cate' => $cate, 'type' => $type, 'code' => $code, 'name' => $name]);
    return $stmt->rowCount();
  }
  /* FUNCION PARA EJECUTAR CONSULTAS SQL PARA TRAER INFORMACION DE LAS CUENTAS DE GASTOS EXISTENTES EN LA BASE DE DATOS */
  public function getDataListAccountsDB()
  {
    $conectar = parent::conexion();
    parent::set_names();
    $stmt = $conectar->prepare("SELECT A.a_id, ac_id, B.at_name, a_code, a_name 
                                  FROM account_data_table AS A
                                  INNER JOIN account_types_data_table AS B ON A.at_id=B.at_id
                                WHERE a_status=1");
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
  }
  /* FUNCION PARA EJECUTAR CONSULTAS SQL PARA TRAER INFORMACION UNA UNIDAD DEPARTAMENTAL EXISTENTE EN LA BASE DE DATOS */
  public function getDataAccountDB($id)
  {
    $conectar = parent::conexion();
    parent::set_names();
    $stmt = $conectar->prepare("SELECT * FROM account_data_table WHERE a_id = :id");
    $stmt->execute(['id' => $id]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
  }
  public function updateDataAccountDB($id, $name)
  {
    $conectar = parent::conexion();
    $stmt = $conectar->prepare("UPDATE account_data_table SET a_name = :name WHERE a_id = :id");
    $stmt->execute(['name' => $name, 'id' => $id]);
    return $stmt->rowCount();
  }
  public function deleteDataAccountDB($id)
  {
    $conectar = parent::conexion();
    $stmt = $conectar->prepare("UPDATE account_data_table SET a_status = :status WHERE a_id = :id");
    $stmt->execute(['status' => 0, 'id' => $id]);
    return $stmt->rowCount();
  }

}
