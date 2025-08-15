<?php
require_once("../../config/conexion.php");

class Expenses extends Conectar
{
  public function createExpenseDB($id, $date, $suplier, $account, $expense, $mont, $quota)
  {
    $conectar = parent::conexion();
    parent::set_names();
    $stmt = $conectar->prepare("INSERT INTO expense_data_table (id, dateExpense, idSuplier, idExpenseAccount, expenseName, montExpense, quotasExpense, balanceExpense, dateRegExp) VALUES (:id, :date, :suplier, :account, :expense, :mont, :quota, :balence, :dater)");
    $stmt->execute(['id' => $id, 'date' => $date, 'suplier' => $suplier, 'account' => $account, 'expense' => $expense, 'mont' => $mont, 'quota' => $quota, 'balence' => $mont, 'dater' => date('Y-m-d')]);
    return $stmt->rowCount();
  }
  /* FUNCION PARA EJECUTAR CONSULTAS SQL PARA TRAER INFORMACION DE LAS CUENTAS DE GASTOS EXISTENTES EN LA BASE DE DATOS */
  public function getListExpensesDB()
  {
    $conectar = parent::conexion();
    parent::set_names();
    $stmt = $conectar->prepare("SELECT A.id, dateExpense, B.nameSuplier, C.expenseaccount, expenseName, montExpense, quotasExpense, C.typeaccount
                                    FROM expense_data_table AS A 
                                  INNER JOIN suplier_data_table AS B ON A.idSuplier=B.id
                                  INNER JOIN expense_accounts_data_table AS C ON A.idExpenseAccount=C.id
                                WHERE statusExpense=1 ORDER BY A.dateExpense DESC, C.typeaccount ASC");
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
  }
   /* FUNCION PARA EJECUTAR CONSULTAS SQL PARA TRAER INFORMACION UNA UNIDAD DEPARTAMENTAL EXISTENTE EN LA BASE DE DATOS */
  public function getDataExpenseDB($id)
  {
    $conectar = parent::conexion();
    parent::set_names();
    $stmt = $conectar->prepare("SELECT * FROM expense_data_table WHERE id = :id");
    $stmt->execute(['id' => $id]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
  }

  public function updateDataExpenseDB($id, $date, $detail, $mont, $quota)
  {
    $conectar = parent::conexion();
    $stmt = $conectar->prepare("UPDATE expense_data_table SET dateExpense=:date, expenseName=:expense, montExpense=:mont, quotasExpense=:quota WHERE id = :id");
    $stmt->execute(['date' => $date, 'expense' => $detail, 'mont' => $mont, 'quota' => $quota, 'id' => $id]);
    return $stmt->rowCount();
  }

  public function validateAccountsRelatedExpensesDB($id)
  {
     $conectar = parent::conexion();
    parent::set_names();
    $stmt = $conectar->prepare("SELECT * FROM expense_data_table WHERE idExpenseAccount = :account AND statusExpense = 1");
    $stmt->execute(['account' => $id]);
    return $stmt->rowCount();
    
  }
  public function deleteClideleteExpenseDB($id)
  {
    $conectar = parent::conexion();
    $stmt = $conectar->prepare("UPDATE expense_data_table SET statusExpense = :status WHERE id = :id");
    $stmt->execute(['status' => 0, 'id' => $id]);
    return $stmt->rowCount();
  }

   public function getDataExpenseDB2($id)
  {
    $conectar = parent::conexion();
    parent::set_names();
    $stmt = $conectar->prepare("SELECT A.id, dateExpense, B.nameSuplier, C.expenseaccount AS expense, expenseName, balanceExpense 
                                    FROM expense_data_table AS A 
                                  INNER JOIN suplier_data_table AS B ON A.idSuplier=B.id
                                  INNER JOIN expense_accounts_data_table AS C ON A.idExpenseAccount=C.id
                                WHERE statusExpense=1 AND A.id = :id");
    $stmt->execute(['id' => $id]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
  }

   public function updateBalanceExpenseDB($account, $payd)
  {
    $conectar = parent::conexion();
    $stmt = $conectar->prepare("UPDATE expense_data_table SET balanceExpense = (balanceExpense - :balence) WHERE id = :id");
    $stmt->execute(['balence' => $payd, 'id' => $account]);
    return $stmt->rowCount();
  }

  public function getDataDetailsExpenseDB($id)
  {
    $conectar = parent::conexion();
    parent::set_names();
    $stmt = $conectar->prepare("SELECT id, expenseName, IFNULL(quotasExpense, montExpense) AS aumont 
                                  FROM expense_data_table 
                                  WHERE idExpenseAccount=:id AND statusExpense=1 AND balanceExpense>0");
    $stmt->execute(['id' => $id]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
  }

    public function getNameAccountByIdDB($id)
  {
    $conectar = parent::conexion();
    parent::set_names();
    $stmt = $conectar->prepare("SELECT expenseName FROM expense_data_table WHERE id = :id");
    $stmt->execute(['id' => $id]);
    return $stmt->fetchColumn();
  }

  public function updateAmountExpenseByIdDB($id, $amount)
  {
    $conectar = parent::conexion();
    $stmt = $conectar->prepare("UPDATE expense_data_table SET balanceExpense = :amount, montExpense = :amount WHERE id = :id");
    $stmt->execute(['amount' => $amount, 'id' => $id]);
    return $stmt->rowCount();
  }

}
