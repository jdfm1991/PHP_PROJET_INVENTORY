<?php
require_once("../../config/conexion.php");

class Receipts extends Conectar
{
  public function getNewNumberReceiptDB()
  {
    $conectar = parent::conexion();
    parent::set_names();
    $stmt = $conectar->prepare("SELECT CONCAT('REC-',LPAD(COUNT(*) + 1, 3, '0'), '-', YEAR(NOW())) AS receipt
                                  FROM receipts_data_table
                                WHERE YEAR(daterec) = YEAR(NOW())");
    $stmt->execute();
    return $stmt->fetchColumn();
  }

  public function createDataReceiptsDB($id, $cid, $uid, $nreceipt, $inquilino, $concepto, $vence, $nivel, $aliquot, $email, $monto_gf, $monto_gv, $monto_p, $monto_i, $amout_a, $amout_m, $amout_g, $monto_tg, $typerec, $depart)
  {
    $conectar = parent::conexion();
    parent::set_names();
    $stmt = $conectar->prepare("INSERT INTO receipts_data_table (id, cid, uid, daterec, numrec, nametenant, conceptreceipt, levelrec, aliquotrec, emailrec, aumontgf, aumontgv, aumontp, aumonti, amouta, amoutm, amoutg, aumont, expirationdate, balencereceipt, typerec, unitdep) VALUES (:id, :cid, :uid, :date, :number, :tenant, :concept, :level, :aliquot, :email, :aumontgf, :aumontgv, :aumontp, :aumonti, :amouta, :amoutm, :amoutg, :aumont, :expiration, :balence, :typerec, :depart)");
    $stmt->execute(['id' => $id, 'cid' => $cid, 'uid' => $uid, 'date' => date('Y-m-d'), 'number' => $nreceipt, 'tenant' => $inquilino, 'concept' => $concepto, 'level' => $nivel, 'aliquot' => $aliquot, 'email' => $email, 'aumontgf' => $monto_gf, 'aumontgv' => $monto_gv, 'aumontp' => $monto_p, 'aumonti' => $monto_i, 'amouta' => $amout_a, 'amoutm' => $amout_m, 'amoutg' => $amout_g,  'aumont' => $monto_tg, 'expiration' => $vence, 'balence' => $monto_tg, 'typerec' => $typerec, 'depart' => $depart]);
    return $stmt->rowCount();
  }

  public function createDataReceiptItemsDB($id, $type, $code, $expense, $amount, $aliquot)
  {
    $conectar = parent::conexion();
    parent::set_names();
    $stmt = $conectar->prepare("INSERT INTO receipts_items_data_table(idreceipt, typeexpense, idexpense, detailexpense, amountexpense, aumontaliquot) VALUES (:idr, :type, :code, :expense, :amount, :aliquot)");
    $stmt->execute(['idr' => $id, 'type' => $type, 'code' => $code, 'expense' => $expense, 'amount' => $amount, 'aliquot' => $aliquot]);
    return $stmt->rowCount();
  }

  public function getDataReceiptsDB()
  {
    $conectar = parent::conexion();
    parent::set_names();
    $stmt = $conectar->prepare("SELECT * FROM receipts_data_table WHERE statusrec = 1 ORDER BY daterec DESC");
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
  }

  public function checkPeriodReceiptDB($cid, $uid)
  {
    $conectar = parent::conexion();
    parent::set_names();
    $stmt = $conectar->prepare("SELECT * FROM receipts_data_table WHERE MONTH(daterec)=MONTH(NOW()) AND statusrec = 1 AND cid = :cid AND uid = :uid AND typerec = 'COBRO'");
    $stmt->execute(['cid' => $cid, 'uid' => $uid]);
    return $stmt->rowCount();
  }

  public function checkPenaliesReceiptDB($uid, $concepto)
  {
    $conectar = parent::conexion();
    parent::set_names();
    $stmt = $conectar->prepare("SELECT * FROM receipts_data_table WHERE statusrec = 1 AND uid = :uid AND conceptreceipt = :concept AND typerec = 'PENAL'");
    $stmt->execute([ 'uid' => $uid, 'concept' => $concepto]);
    return $stmt->rowCount();
  }

  public function deleteDataReceiptDB($id)
  {
    $conectar = parent::conexion();
    $stmt = $conectar->prepare("UPDATE receipts_data_table SET statusrec = :status WHERE id = :id");
    $stmt->execute(['status' => 0, 'id' => $id]);
    return $stmt->rowCount();
  }

  public function updateBalanceReceiptDB($account, $payd)
  {
    $conectar = parent::conexion();
    $stmt = $conectar->prepare("UPDATE receipts_data_table SET balencereceipt = (balencereceipt - :balence) WHERE id = :id");
    $stmt->execute(['balence' => $payd, 'id' => $account]);
    return $stmt->rowCount();
  }

  public function updateReceiptBalancestDB($id, $monto_gf, $monto_gv, $monto_i, $monto_tg)
  {
    $conectar = parent::conexion();
    $stmt = $conectar->prepare("UPDATE receipts_data_table SET aumontgf	= :aumontgf, aumontgv = :aumontgv, aumonti = :aumonti, aumont = :aumont, balencereceipt = :balence WHERE id = :id");
    $stmt->execute(['aumontgf' => $monto_gf, 'aumontgv' => $monto_gv, 'aumonti' => $monto_i, 'aumont' => $monto_tg, 'balence' => $monto_tg, 'id' => $id]);
    return $stmt->rowCount();
  }

  public function getDataHeaderReceiptDB($id)
  {
    $conectar = parent::conexion();
    parent::set_names();
    $stmt = $conectar->prepare("SELECT id, daterec, numrec, nametenant, unitdep, conceptreceipt, levelrec, aliquotrec, aumontgf, aumontgv, aumontp, aumonti, amouta, amoutm, amoutg, aumont, expirationdate, typerec FROM receipts_data_table WHERE id = :id");
    $stmt->execute(['id' => $id]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
  }

  public function getDataItemsByReceiptDB($receipt, $expense)
  {
    $conectar = parent::conexion();
    parent::set_names();
    $stmt = $conectar->prepare("SELECT * FROM receipts_items_data_table WHERE idreceipt = :receipt AND typeexpense = :expense");
    $stmt->execute(['receipt' => $receipt, 'expense' => $expense]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
  }

  public function getDataReceiptsExpiredDB()
  {
    $conectar = parent::conexion();
    parent::set_names();
    $stmt = $conectar->prepare("SELECT * FROM receipts_data_table WHERE balencereceipt > 0 AND expirationdate < NOW() AND expirationdate != '0000-00-00' AND statusrec = 1 ORDER BY daterec DESC");
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
  }

  public function updateBalanceReceiptExpiredDB($id, $affected)
  {
    $conectar = parent::conexion();
    $stmt = $conectar->prepare("UPDATE receipts_data_table SET balencereceipt = (IF(balencereceipt=aumont,0,aumont)), affectedby = :affected WHERE id = :id");
    $stmt->execute(['affected' => $affected, 'id' => $id]);
    return $stmt->rowCount();
  }

  public function getIdReceiptafectedDB($id)
  {
    $conectar = parent::conexion();
    parent::set_names();
    $stmt = $conectar->prepare("SELECT affectedby FROM receipts_data_table WHERE id = :id");
    $stmt->execute(['id' => $id]);
    return $stmt->fetchColumn();
  }

  public function getPrevBalanceReceiptByUnitClientDB($cid, $uid)
  {
    $conectar = parent::conexion();
    parent::set_names();
    $stmt = $conectar->prepare("SELECT balencereceipt FROM receipts_data_table WHERE cid = :cid AND uid = :uid AND typerec = 'COBRO' AND statusrec = 1 AND balencereceipt > 0 AND expirationdate != '0000-00-00' ORDER BY daterec DESC LIMIT 1");
    $stmt->execute(['cid' => $cid, 'uid' => $uid]);
    return $stmt->fetchColumn();
  }

  public function getIdPrevReceiptByUnitClientDB($cid, $uid)
  {
    $conectar = parent::conexion();
    parent::set_names();
    $stmt = $conectar->prepare("SELECT id FROM receipts_data_table WHERE cid = :cid AND uid = :uid AND typerec = 'COBRO' AND statusrec = 1 AND balencereceipt > 0 AND expirationdate != '0000-00-00' ORDER BY daterec DESC LIMIT 1");
    $stmt->execute(['cid' => $cid, 'uid' => $uid]);
    return $stmt->fetchColumn();
  }

}
