<?php
require_once("../../config/conexion.php");

class Inventory extends Conectar
{
  public function createDataInventoryMovementDB($id, $company, $category, $date, $rtype, $rate, $partner, $amount, $change, $name)
  {
    $conectar = parent::conexion();
    parent::set_names();
    $stmt = $conectar->prepare("INSERT INTO inventory_movements_data_table (im_id, im_company, im_type, im_date, im_partner, im_description, im_amount, im_rate, im_rtype, im_change, im_datereg) VALUES (:id, :company, :type, :date, :partner, :description, :amount, :rate, :rtype, :change, :dater)");
    $stmt->execute(['id' => $id, 'company' => $company, 'type' => $category, 'date' => $date, 'rtype' => $rtype, 'rate' => $rate, 'partner' => $partner, 'amount' => $amount, 'change' => $change, 'description' => $name, 'dater' => date('Y-m-d H:i:s'), ]);
    return $stmt->rowCount();
  }

   public function createDataMovementItemsDB($movement, $date, $product, $type,  $unit, $amount, $quantity, $total)
  {
    $conectar = parent::conexion();
    parent::set_names();
    $stmt = $conectar->prepare("INSERT INTO inventory_movement_items_data_table (imi_movement, imi_date, imi_product, imi_type, imi_unit, imi_amount, imi_quantity, imi_total) VALUES (:movement, :date, :product, :type, :unit, :amount, :quantity, :total)");
    $stmt->execute(['movement' => $movement, 'date' => $date, 'product' => $product, 'type' => $type, 'unit' => $unit, 'amount' => $amount, 'quantity' => $quantity, 'total' => $total]);
    return $stmt->rowCount();
  }
  /* FUNCION PARA EJECUTAR CONSULTAS SQL PARA TRAER INFORMACION DE LAS CUENTAS DE GASTOS EXISTENTES EN LA BASE DE DATOS */
  public function getDataListAccountMovementsDB()
  {
    $conectar = parent::conexion();
    parent::set_names();
    $stmt = $conectar->prepare("SELECT im_id, B.c_name, C.imt_name, im_type, D.bp_name, im_date, im_description, im_amount, im_rate, im_change, im_status
                                  FROM inventory_movements_data_table AS A
                                  INNER JOIN company_data_table AS B ON A.im_company=B.c_id
                                  INNER JOIN inventory_movement_types_data_table AS C ON A.im_type=C.imt_id 
                                  INNER JOIN bp_data_table AS D ON A.im_partner=D.bp_id
                                  ORDER BY im_datereg DESC, im_description ASC");
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
  }
  /* FUNCION PARA EJECUTAR CONSULTAS SQL PARA TRAER INFORMACION UNA UNIDAD DEPARTAMENTAL EXISTENTE EN LA BASE DE DATOS */
  public function getDataInventoryMovementDB($id)
  {
    $conectar = parent::conexion();
    parent::set_names();
    $stmt = $conectar->prepare("SELECT * FROM account_movements_data_table WHERE am_id = :id");
    $stmt->execute(['id' => $id]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
  }

  public function updateDataInventoryMovementDB($id, $date, $name, $amount)
  {
    $conectar = parent::conexion();
    $stmt = $conectar->prepare("UPDATE account_movements_data_table SET am_date=:date, am_name=:name, am_amount=:amount WHERE am_id = :id");
    $stmt->execute(['date' => $date, 'name' => $name, 'amount' => $amount, 'id' => $id]);
    return $stmt->rowCount();
  }

  public function deleteDataInventoryMovementDB($id)
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
