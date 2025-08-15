<?php
require_once("../../config/conexion.php");

class ExpenseAccounts extends Conectar
{
  /* FUNCION PARA EJECUTAR CONSULTAS SQL PARA TRAER INFORMACION DE LOS TIPO DE GASTOS EXISTENTES EN LA BASE DE DATOS*/
  public function getTypeExpensesBD()
  {
    $conectar = parent::conexion();
    parent::set_names();
    $stmt = $conectar->prepare("SELECT * FROM expense_type_data_table");
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
  }
  /* FUNCION PARA EJECUTAR CONSULTAS SQL PARA TRAER INFORMACION DEL NUEVO CODIGO DE GASTO QUE SE DESEAN CREAR EN LA BASE DE DATOS */
  public function getNewCodeExpenseByTypeDB($id, $prefix)
  {
    $conectar = parent::conexion();
    parent::set_names();
    $stmt = $conectar->prepare("SELECT CONCAT('$prefix-', LPAD(COUNT(*) + 1, 2, '0')) AS newcode
            FROM expense_accounts_data_table
            WHERE typeaccount = :type");
    $stmt->execute(['type' => $id]);
    return $stmt->fetchColumn();
  }
  /* FUNCION PARA EJECUTAR CONSULTAS SQL PARA CREAR EL NUEVO GASTO EN LA BASE DE DATOS */
  public function createExpenseAccountDB($id, $type, $code, $fixed, $expense)
  {
    $conectar = parent::conexion();
    parent::set_names();
    $stmt = $conectar->prepare("INSERT INTO expense_accounts_data_table (id, typeaccount, codeaccount, fixedaccount, expenseaccount) VALUES (:id, :type, :code, :fixed, :expense)");
    $stmt->execute(['id' => $id, 'type' => $type, 'code' => $code, 'fixed' => $fixed, 'expense' => $expense]);
    return $stmt->rowCount();
  }
  /* FUNCION PARA EJECUTAR CONSULTAS SQL PARA TRAER INFORMACION DE LAS CUENTAS DE GASTOS EXISTENTES EN LA BASE DE DATOS */
  public function getListExpenseAccountsDB()
  {
    $conectar = parent::conexion();
    parent::set_names();
    $stmt = $conectar->prepare("SELECT A.id, B.expensetypename AS type, codeaccount AS code, fixedaccount AS fixed, expenseaccount AS expense FROM expense_accounts_data_table AS A
                                  INNER JOIN expense_type_data_table AS B ON A.typeaccount=B.id
                                WHERE statusaccount=1");
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
  }
  /* FUNCION PARA EJECUTAR CONSULTAS SQL PARA TRAER INFORMACION UNA UNIDAD DEPARTAMENTAL EXISTENTE EN LA BASE DE DATOS */
  public function getDataExpenseAccountDB($id)
  {
    $conectar = parent::conexion();
    parent::set_names();
    $stmt = $conectar->prepare("SELECT * FROM expense_accounts_data_table WHERE id = :id");
    $stmt->execute(['id' => $id]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
  }
  public function updateDataExpenseAccountDB($id, $type, $code, $fixed, $expense)
  {
    $conectar = parent::conexion();
    $stmt = $conectar->prepare("UPDATE expense_accounts_data_table SET typeaccount=:type, codeaccount=:code, fixedaccount=:fixed, expenseaccount=:expense WHERE id = :id");
    $stmt->execute(['type' => $type, 'code' => $code, 'fixed' => $fixed, 'expense' => $expense, 'id' => $id]);
    return $stmt->rowCount();
  }
  public function deleteExpenseAccountDB($id)
  {
    $conectar = parent::conexion();
    $stmt = $conectar->prepare("UPDATE expense_accounts_data_table SET statusaccount = :status WHERE id = :id");
    $stmt->execute(['status' => 0, 'id' => $id]);
    return $stmt->rowCount();
  }

  public function getDataExpenseAcountFixedDB()
  {
    $conectar = parent::conexion();
    parent::set_names();
    $stmt = $conectar->prepare("SELECT id, codeaccount, expenseaccount FROM expense_accounts_data_table WHERE fixedaccount = 1");
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
  }

  public function getDataExpenseAcountNonFixedDB()
  {
    $conectar = parent::conexion();
    parent::set_names();
    $stmt = $conectar->prepare("SELECT id, codeaccount, expenseaccount FROM expense_accounts_data_table WHERE fixedaccount = 0");
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
  }

}
