<?php
require_once("../../config/conexion.php");

class Movements extends Conectar
{
  public function createDataAccountMovementDB($id, $cate, $date, $entity, $account, $name, $amount, $rate, $change)
  {
    $conectar = parent::conexion();
    parent::set_names();
    $stmt = $conectar->prepare("INSERT INTO account_movements_data_table (am_id, ac_id, a_id, e_id, am_date, am_name, am_amount, am_datereg, am_rate, am_change) VALUES (:id, :cate, :account, :entity, :date, :name, :amount, :dater, :rate, :change)");
    $stmt->execute(['id' => $id, 'cate' => $cate, 'account' => $account, 'entity' => $entity, 'date' => $date, 'name' => $name, 'amount' => $amount, 'dater' => date('Y-m-d'), 'rate' => $rate, 'change' => $change]);
    return $stmt->rowCount();
  }
  public function createDataAccountMovementItemsDB($movement, $product, $rate, $amount, $quantity, $total)
  {
    $conectar = parent::conexion();
    parent::set_names();
    $stmt = $conectar->prepare("INSERT INTO account_movement_items_data_table (ami_movement, ami_producto, ami_rate, ami_amount, ami_quantity, ami_total) VALUES (:movement, :product, :rate, :amount, :quantity, :total)");
    $stmt->execute(['movement' => $movement, 'product' => $product, 'rate' => $rate, 'amount' => $amount, 'quantity' => $quantity, 'total' => $total]);
    return $stmt->rowCount();
  }
  /* FUNCION PARA EJECUTAR CONSULTAS SQL PARA TRAER INFORMACION DE LAS CUENTAS DE GASTOS EXISTENTES EN LA BASE DE DATOS */
  public function getDataListAccountMovementsDB()
  {
    $conectar = parent::conexion();
    parent::set_names();
    $stmt = $conectar->prepare("SELECT A.am_id, A.ac_id, B.a_name, 
                                (SELECT c_name FROM client_data_table WHERE c_id = A.e_id) AS client, 
                                (SELECT s_name FROM supplier_data_table WHERE s_id = A.e_id) AS supplier, 
                                A.am_date, A.am_name, A.am_amount 
                                  FROM account_movements_data_table AS A
                                  INNER JOIN account_data_table AS B ON A.a_id = B.a_id
                                WHERE A.am_status=1 ORDER BY A.am_datereg DESC, A.am_name ASC");
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
  }
  /* FUNCION PARA EJECUTAR CONSULTAS SQL PARA TRAER INFORMACION UNA UNIDAD DEPARTAMENTAL EXISTENTE EN LA BASE DE DATOS */
  public function getDataAccountMovementDB($id)
  {
    $conectar = parent::conexion();
    parent::set_names();
    $stmt = $conectar->prepare("SELECT * FROM account_movements_data_table WHERE am_id = :id");
    $stmt->execute(['id' => $id]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
  }

  public function updateDataAccountMovementDB($id, $date, $name, $amount)
  {
    $conectar = parent::conexion();
    $stmt = $conectar->prepare("UPDATE account_movements_data_table SET am_date=:date, am_name=:name, am_amount=:amount WHERE am_id = :id");
    $stmt->execute(['date' => $date, 'name' => $name, 'amount' => $amount, 'id' => $id]);
    return $stmt->rowCount();
  }

  public function deleteDataAccountMovementDB($id)
  {
    $conectar = parent::conexion();
    $stmt = $conectar->prepare("UPDATE account_movements_data_table SET am_status = :status WHERE am_id = :id");
    $stmt->execute(['status' => 0, 'id' => $id]);
    return $stmt->rowCount();
  }

  public function validateAccountMovementsDB($id)
  {
    $conectar = parent::conexion();
    parent::set_names();
    $stmt = $conectar->prepare("SELECT * FROM account_movements_data_table WHERE a_id = :account AND am_status = 1");
    $stmt->execute(['account' => $id]);
    return $stmt->rowCount();
  }

  public function validateAccountMovementsByEntityDB($id)
  {
    $conectar = parent::conexion();
    parent::set_names();
    $stmt = $conectar->prepare("SELECT * FROM account_movements_data_table WHERE e_id = :entity AND am_status = 1");
    $stmt->execute(['entity' => $id]);
    return $stmt->rowCount();
  }
}
