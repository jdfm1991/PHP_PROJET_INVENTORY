<?php
error_reporting(0);
require_once("../../config/abrir_sesion.php");
require_once("../../config/conexion.php");
require_once(PATH_VENDOR . "/autoload.php");
require_once(PATH_APP . "/cuentagasto/cuentagasto_module.php");
require_once(PATH_APP . "/registrogasto/registrogasto_module.php");
require_once(PATH_APP . "/cuentaingresos/cuentaingresos_module.php");
require_once(PATH_APP . "/registroingresos/registroingresos_module.php");
require_once(PATH_APP . "/unidaddepartamental/unidaddepartamental_module.php");
require_once(PATH_APP . "/cxc/cxc_module.php");
require_once("pdf.php");
require_once("recibocobro_module.php");

$colrec = new Receipts();
$expaccount = new ExpenseAccounts();
$expenses = new Expenses();
$incomeaccounts = new IncomeAccounts();
$unitdep = new Unitdepartmental();
$incomes = new Incomes();
$receivable = new AccountsReceivable();
$generatepdf = new Generatepdf();

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require_once(PATH_VENDOR . "/phpmailer/phpmailer/src/Exception.php");
require_once(PATH_VENDOR . "/phpmailer/phpmailer/src/PHPMailer.php");
require_once(PATH_VENDOR . "/phpmailer/phpmailer/src/SMTP.php");

$id = (isset($_POST['id'])) ? $_POST['id'] : '6840b778d8798';
$cid = (isset($_POST['cid'])) ? $_POST['cid'] : '';
$uid = (isset($_POST['uid'])) ? $_POST['uid'] : '';
$typerec = (isset($_POST['typerec'])) ? $_POST['typerec'] : '';
$depart = (isset($_POST['depart'])) ? $_POST['depart'] : '';
$nreceipt = (isset($_POST['nrecibo'])) ? $_POST['nrecibo'] : '';
$inquilino = (isset($_POST['inquilino'])) ? $_POST['inquilino'] : '';
$concepto = (isset($_POST['concepto'])) ? $_POST['concepto'] : '';
$vence = (isset($_POST['vence'])) ? $_POST['vence'] : '';
$nivel = (isset($_POST['nivel'])) ? $_POST['nivel'] : '';
$aliquot = (isset($_POST['aliquot'])) ? $_POST['aliquot'] : 0;
$email = (isset($_POST['email'])) ? $_POST['email'] : '';
$monto_gf = (isset($_POST['monto_gf'])) ? $_POST['monto_gf'] : 0;
$monto_gv = (isset($_POST['monto_gv'])) ? $_POST['monto_gv'] : 0;
$monto_p = (isset($_POST['monto_p'])) ? $_POST['monto_p'] : 0;
$monto_i = (isset($_POST['monto_i'])) ? $_POST['monto_i'] : 0;
$amout_a = (isset($_POST['amout_a'])) ? $_POST['amout_a'] : 0;
$amout_m = (isset($_POST['amout_m'])) ? $_POST['amout_m'] : 0;
$amout_g = (isset($_POST['amout_g'])) ? $_POST['amout_g'] : 0;
$monto_tg = (isset($_POST['monto_tg'])) ? $_POST['monto_tg'] : 0;
$receipt = (isset($_POST['receipt'])) ? $_POST['receipt'] : null;
$itemreceipt = (isset($_POST['dataexpense'])) ? $_POST['dataexpense'] : '';
$now = new DateTime(date('Y-m-d'));
$year = date('Y');
$month = date('n');
$daysxmonth = cal_days_in_month(CAL_GREGORIAN, $month, $year);

switch ($_GET["op"]) {
  case 'get_new_number':
    $dato = $colrec->getNewNumberReceiptDB();
    echo json_encode($dato);
    break;
  case 'get_data_expense_fixed':
    $dato = array();
    $data = $expaccount->getDataExpenseAcountFixedDB();
    foreach ($data as $row) {
      $sub_array = array();
      $sub_array['id'] = $row['id'];
      $details = $expenses->getDataDetailsExpenseDB($row['id']);
      if (!empty($details)) {
        $sub_array['code'] = $row['codeaccount'];
        $sub_array['account'] = $row['expenseaccount'];
        $sub_array['details'] = $details;
        $dato[] = $sub_array;
      }
    }
    echo json_encode($dato, JSON_UNESCAPED_UNICODE);
    break;
  case 'get_data_expense_non_fixed':
    $dato = array();
    $data = $expaccount->getDataExpenseAcountNonFixedDB();
    foreach ($data as $row) {
      $sub_array = array();
      $sub_array['id'] = $row['id'];
      $details = $expenses->getDataDetailsExpenseDB($row['id']);
      if (!empty($details)) {
        $sub_array['code'] = $row['codeaccount'];
        $sub_array['account'] = $row['expenseaccount'];
        $sub_array['details'] = $details;
        $dato[] = $sub_array;
      }
    }
    echo json_encode($dato, JSON_UNESCAPED_UNICODE);
    break;
  case 'get_data_income':
    $dato = array();
    $data = $incomeaccounts->getDataIncomeAcountDB();
    foreach ($data as $row) {
      $sub_array = array();
      $sub_array['id'] = $row['id'];
      $details = $incomes->getDataDetailsIncomeDB($row['id']);
      if (!empty($details)) {
        $sub_array['code'] = $row['codeaccount'];
        $sub_array['account'] = $row['incomeaccount'];
        $sub_array['details'] = $details;
        $dato[] = $sub_array;
      }
    }
    echo json_encode($dato, JSON_UNESCAPED_UNICODE);
    break;
  case 'get_data_penalty':
    $dato = array();
    $data = $incomeaccounts->getDataPenaltyAcountDB();
    foreach ($data as $row) {
      $sub_array = array();
      $sub_array['id'] = $row['id'];
      $details = $incomes->getDataIncomeWithoutInterestDB($row['id']);
      if (!empty($details)) {
        $sub_array['code'] = $row['codeaccount'];
        $sub_array['account'] = $row['incomeaccount'];
        $sub_array['details'] = $details;
        $dato[] = $sub_array;
      }
    }
    echo json_encode($dato, JSON_UNESCAPED_UNICODE);
    break;
  case 'new_receipt':
    $dato = array();
    $check = $colrec->checkPeriodReceiptDB($cid, $uid);
    if ($check > 0 && $typerec == 'COBRO') {
      $dato['status'] = false;
      $dato['httpstatus'] = '400';
      $dato['message'] = "Esta Departamento ya Existe Un Recibo En Este Periodo";
      echo json_encode($dato, JSON_UNESCAPED_UNICODE);
      return;
    }
    $id = uniqid();
    if ($receipt != '') {
      $uptpenal = $incomes->updatePenaltiesReceiptByUnitDB($receipt);
      $uptrecexp = $colrec->updateBalanceReceiptExpiredDB($receipt, $id);
    }
    $data = $colrec->createDataReceiptsDB($id, $cid, $uid, $nreceipt, $inquilino, $concepto, $vence, $nivel, $aliquot, $email, $monto_gf, $monto_gv, $monto_p, $monto_i, $amout_a, $amout_m, $amout_g, $monto_tg, $typerec, $depart);
    if ($data) {
      $i = 0;
      foreach (json_decode($itemreceipt, true) as $row) {
        $dataitems = $colrec->createDataReceiptItemsDB($id, $row['type'], $row['code'], $row['expense'], $row['amount'], $row['aliquot']);
        if ($dataitems) {
          $i++;
        }
      }
      if ($i == count(json_decode($itemreceipt, true))) {
        $dato['status'] = true;
        $dato['httpstatus'] = '200';
        $dato['message'] = "El Recibo Fue Creado Satisfactoriamente \n";
      } else {
        $dato['status'] = false;
        $dato['httpstatus'] = '500';
        $dato['message'] = "Error Al Registar algun Item, Por Favor Intente Nuevamente \n";
      }
    } else {
      $dato['status'] = false;
      $dato['httpstatus'] = '500';
      $dato['message'] = "Error Al Registrar el Recibo, Por Favor Intente Nuevamente \n";
    }
    echo json_encode($dato, JSON_UNESCAPED_UNICODE);
    break;
  case 'generate_receipt_automatic':
    $dato = array();
    $i = 0;
    $j = 0;
    $data = $unitdep->getDataAllUnitClientDB();
    foreach ($data as $row) {
      $check = $colrec->checkPeriodReceiptDB($row['cid'], $row['uid']);
      if ($check > 0) {
        $i++;
        $dato['status'] = true;
        $dato['httpstatus'] = '200';
        $dato['message'] = "De los " . count($data) . " Departamentos que Existen, se gerenaron " . $j . " Recibos de cobro, ya que " . $i . " Se Generaron,  Exitosamente En Este Periodo con anterioridad \n";
      } else {
        $j++;
        $id = uniqid();
        $previbalance = $colrec->getPrevBalanceReceiptByUnitClientDB($row['cid'], $row['uid']);
        if ($previbalance > 0) {
          $receipt = $colrec->getIdPrevReceiptByUnitClientDB($row['cid'], $row['uid']);
          $amout_a = $previbalance;
          $amout_m = $incomes->getPrevLateReceiptByUnitDB($row['uid']);
          $amout_g = $incomes->getPrevAdmExpReceiptByUnitDB($row['uid']);
          $uptpenal = $incomes->updatePenaltiesReceiptByUnitDB($receipt);
          $uptrecexp = $colrec->updateBalanceReceiptExpiredDB($receipt, $id);
        } else {
          $amout_a = 0;
          $amout_m = 0;
          $amout_g = 0;
        }
        $nreceipt = $colrec->getNewNumberReceiptDB();
        $typerec = 'COBRO';
        $depart = $row['unit'];
        $receipt = $colrec->createDataReceiptsDB($id, $row['cid'], $row['uid'], $nreceipt, $row['nameClient'], $row['concepto'], $row['vence'], $row['level'], $row['aliquot'], $row['emailClient'], $monto_gf, $monto_gv, $monto_p, $monto_i, $amout_a, $amout_m, $amout_g, $monto_tg, $typerec, $depart);
        if ($receipt) {
          $af = $expaccount->getDataExpenseAcountFixedDB();
          foreach ($af as $row2) {
            $details = $expenses->getDataDetailsExpenseDB($row2['id']);
            if (!empty($details)) {
              foreach ($details as $row3) {
                $dataitems = $colrec->createDataReceiptItemsDB($id, $row2['id'], $row3['id'], $row3['expenseName'], $row3['aumont'], (($row3['aumont'] * $row['aliquot']) / 100));
                if ($dataitems) {
                  $monto_gf = $monto_gf + (($row3['aumont'] * $row['aliquot']) / 100);
                }
              }
            }
          }
          $anf = $expaccount->getDataExpenseAcountNonFixedDB();
          foreach ($anf as $row2) {
            $details = $expenses->getDataDetailsExpenseDB($row2['id']);
            if (!empty($details)) {
              foreach ($details as $row3) {
                $dataitems = $colrec->createDataReceiptItemsDB($id, $row2['id'], $row3['id'], $row3['expenseName'], $row3['aumont'], (($row3['aumont'] * $row['aliquot']) / 100));
                if ($dataitems) {
                  $monto_gv = $monto_gv + (($row3['aumont'] * $row['aliquot']) / 100);
                }
              }
            }
          }
          $ai = $incomeaccounts->getDataIncomeAcountDB();
          foreach ($ai as $row2) {
            $details = $incomes->getDataDetailsIncomeDB($row2['id']);
            if (!empty($details)) {
              foreach ($details as $row3) {
                $dataitems = $colrec->createDataReceiptItemsDB($id, $row2['id'], $row3['id'], $row3['incomename'], $row3['incomebalance'], (($row3['incomebalance'] * $row['aliquot']) / 100));
                if ($dataitems) {
                  $monto_i = $monto_i + (($row3['incomebalance'] * $row['aliquot']) / 100);
                }
              }
            }
          }
          $monto_tg = $monto_gf + $monto_gv + $monto_i + $amout_a + $amout_m + $amout_g;
          $uptdatereceipt = $colrec->updateReceiptBalancestDB($id, $monto_gf, $monto_gv, $monto_i, $monto_tg);
          $monto_gf = 0;
          $monto_gv = 0;
          $monto_i = 0;
          $amout_a = 0;
          $amout_m = 0;
          $amout_g = 0;
          if ($uptdatereceipt) {
            $dato['status'] = true;
            $dato['httpstatus'] = '200';
            $dato['message'] = "Actualmente Se Existe " . count($data) . " Recibos Pendientes Por Generar, De los cuales " . $j . " Se Generaron Exitosamente y " . $i . " No Se Generaron Porque Ya Existen Recibos En Este Periodo\n";
          }
        }
      }
    }
    echo json_encode($dato, JSON_UNESCAPED_UNICODE);
    break;
  case 'get_list_receipts':
    $dato = array();
    $data = $colrec->getDataReceiptsDB();
    foreach ($data as $row) {
      $sub_array = array();
      $sub_array['id'] = $row['id'];
      $sub_array['date'] = $row['daterec'];
      $sub_array['number'] = $row['numrec'];
      $sub_array['unit'] = $row['unitdep'];
      $sub_array['name'] = $row['nametenant'];
      $sub_array['concept'] = $row['conceptreceipt'];
      $sub_array['aumont'] = number_format($row['aumont'], 2);
      $sub_array['type'] = $row['typerec'];
      $sub_array['expiration'] = $row['expirationdate'];
      $dato[] = $sub_array;
    }
    echo json_encode($dato, JSON_UNESCAPED_UNICODE);
    break;
  case 'delete_receipt':
    $valided = $receivable->validatePaymentReceiptDB($id);
    if ($valided > 0) {
      $dato['status'] = false;
      $dato['error'] = '500';
      $dato['message'] = "No Puede Eliminiar Este Recibo, Ya que Tiene un pago asociado, Por Favor Intente Con Un Recibo Diferente \n";
      echo json_encode($dato, JSON_UNESCAPED_UNICODE);
      return;
    }
    $receipt = $colrec->getIdReceiptafectedDB($id);
    if ($receipt != '') {
      $uptrecexp = $colrec->updateBalanceReceiptExpiredDB($receipt, $id);
    }
    $data = $colrec->deleteDataReceiptDB($id);
    if ($data) {
      $dato['status'] = true;
      $dato['error'] = '200';
      $dato['message'] = "El Recibo Fue Eliminado Satisfactoriamente \n";
    } else {
      $dato['status'] = false;
      $dato['error'] = '500';
      $dato['message'] = "Error Al actualizar El Recibo, Por Favor Intente Nuevamente \n";
    }
    echo json_encode($dato, JSON_UNESCAPED_UNICODE);
    break;
  case 'get_interest_free_penalties':
    $dato = array();
    $nreceipts = 0;
    $i = 0;
    $j = 0;
    $k = 0;
    $data = $colrec->getDataReceiptsExpiredDB();
    $penalty = $incomeaccounts->getIdAcountPenaltyDB();
    foreach ($data as $row) {
      $expiredate = new DateTime($row['expirationdate']);
      $difference = $now->diff($expiredate);
      if ($difference->days > 0) {
        $vence = '0000-00-00';
        $typerec = 'PENAL';
        $items = $incomes->getDataIncomeWithoutInterestDB($penalty);
        $nreceipts = count($data) * count($items);
        foreach ($items as $items) {
          $id = uniqid();
          $nreceipt = $colrec->getNewNumberReceiptDB();
          $concepto = $items['incomename'] . ' APTO N°: ' . $row['unitdep'] . ' ' . $row['conceptreceipt'];
          $check = $colrec->checkPenaliesReceiptDB($row['uid'], $concepto);
          if ($check == 0) {
            $receipt = $colrec->createDataReceiptsDB($id, $row['cid'], $row['uid'], $nreceipt, $row['nametenant'], $concepto, $vence, $row['levelrec'], $aliquot, $row['emailrec'], $monto_gf, $monto_gv, $items['incomebalance'], $monto_i, $amout_a, $amout_m, $amout_g, $items['incomebalance'], $typerec, $row['unitdep']);
            if ($receipt) {
              $dataitems = $colrec->createDataReceiptItemsDB($id, $penalty, $items['id'], $items['incomename'], $items['incomebalance'], $items['incomebalance']);
              if ($dataitems) {
                $i++;
              } else {
                $j++;
              }
            } else {
              $dato['status'] = false;
              $dato['httpstatus'] = '500';
              $dato['message'] = "Error Al Generar la Penalidad en el Recibo de Cobro" . $row['unitdep'] . $row['conceptreceipt'] . ", Por Favor Intente Nuevamente \n";
              echo json_encode($dato, JSON_UNESCAPED_UNICODE);
              return;
            }
          } else {
            $k++;
          }
        }
        if ($nreceipts == $i) {
          $dato['status'] = true;
          $dato['httpstatus'] = '200';
          $dato['message'] = "Las penalidades en los Recibos de Cobro vencidos Fueron Creadas Satisfactoriamente \n";
        }
        if ($nreceipts == $j) {
          $dato['status'] = true;
          $dato['httpstatus'] = '200';
          $dato['message'] = "Las penalidades en los Recibos de Cobro vencidos se crearon anteriormente \n";
        }
        if ($nreceipts == $k) {
          $dato['status'] = true;
          $dato['httpstatus'] = '200';
          $dato['message'] = "No existen Recibos de Cobro Pendiente por Penalizar \n";
        }
        if ($nreceipts == ($i + $j)) {
          $dato['status'] = true;
          $dato['httpstatus'] = '200';
          $dato['message'] = "Se crearon " . $i . " Recibos de penalizacion, por vencimiento de recibo de cobro\n";
        }
      } else {
        $dato['status'] = true;
        $dato['httpstatus'] = '200';
        $dato['message'] = "Actualmente No Hay Recibos Vencidos \n";
      }
    }
    echo json_encode($dato, JSON_UNESCAPED_UNICODE);
    break;
  case 'get_interest_whith_penalties':
    $dato = array();
    $nreceipts = 0;
    $i = 0;
    $j = 0;
    $k = 0;
    $late = 0;
    $data = $colrec->getDataReceiptsExpiredDB();
    foreach ($data as $row) {
      $expiredate = new DateTime($row['expirationdate']);
      $difference = $now->diff($expiredate);
      if ($difference->days > 0) {
        $penalty = $incomeaccounts->getDataPenaltyAcountDB();
        foreach ($penalty as $penalty) {
          $items = $incomes->getDataIncomeWithInterestDB($penalty['id']);
          $nreceipts = count($data) * count($items);
          foreach ($items as $items) {
            if ($row['balencereceipt'] != $row['aumont']) {
              $late = (((($row['aumont'] * $items['amountpercent']) / 100) / $daysxmonth) * $difference->days) + (((($row['balencereceipt'] * $items['amountpercent']) / 100) / $daysxmonth) * $difference->days);
            }
            if ($row['balencereceipt'] == $row['aumont']) {
              $late = (((($row['balencereceipt'] * $items['amountpercent']) / 100) / $daysxmonth) * $difference->days);
            }
            $validate = $incomes->validatePenaltyReceiptDB($row['id'],  $penalty['id'], $items['id']);
            if ($validate > 0) {
              $penal = $incomes->updateDataPenaltyReceiptsDB($row['id'], $penalty['id'], $items['id'], $late);
              if ($penal) {
                $i++;
              } else {
                $j++;
              }
            } else {
              $penal = $incomes->createDataPenaltyReceiptsDB($row['id'], $row['uid'], $penalty['id'], $items['id'], $items['incomename'], $late);
              if ($penal) {
                $i++;
              } else {
                $j++;
              }
            }
          }
        }
        if ($nreceipts == $i) {
          $dato['status'] = true;
          $dato['httpstatus'] = '200';
          $dato['message'] = "Las penalidades en los Recibos de Cobro vencidos Fueron Creadas Satisfactoriamente \n";
        }
        if ($nreceipts == $j) {
          $dato['status'] = false;
          $dato['httpstatus'] = '200';
          $dato['message'] = "Las penalidades en los Recibos de Cobro vencidos se crearon anteriormente \n";
        }
        if ($nreceipts == ($i + $j)) {
          $dato['status'] = true;
          $dato['httpstatus'] = '200';
          $dato['message'] = "Se crearon " . $i . " Recibos de penalizacion, por vencimiento de recibo de cobro\n";
        }
      } else {
        $dato['status'] = true;
        $dato['httpstatus'] = '200';
        $dato['message'] = "No existen Recibos de Cobro Pendiente por Penalizar \n";
      }
    }
    echo json_encode($dato, JSON_UNESCAPED_UNICODE);
    break;
  case 'get_penalties_receipt':
    $dato = array();
    $data = $incomes->getDataPenaltiesByReceivableDB($id);
    foreach ($data as $row) {
      $sub_array = array();
      $sub_array['name'] = $row['namepenalty'];
      $sub_array['amount'] = number_format($row['amount'], 2);
      $dato[] = $sub_array;
    }
    echo json_encode($dato, JSON_UNESCAPED_UNICODE);
    break;
  case 'generate_pdf_receipt':
    $dato = array();
    $head = '';
    $body = '';
    $foot = '';
    $stylesheet = file_get_contents(URL_ASSETS . '/css/style-custom.css');
    $logo = URL_ASSETS . '/img/logo.png';
    $name = '';
    $type = '';
    $data = $colrec->getDataHeaderReceiptDB($id);
    $name = $generatepdf->getNameReceipt($data);
    $type = $generatepdf->getTypeReceipt($data);
    $head .= $generatepdf->getInfoHeadCondominium($logo, $type);
    $head .= $generatepdf->getInfoHeadReceipt($data);
    if ($type == 'COBRO') {
      $body .= $generatepdf->getInfoBodyReceipt($id, $expaccount, $colrec, 'EAF');
      $body .= '<br>';
      $body .= $generatepdf->getInfoBodyReceipt($id, $expaccount, $colrec, 'EANF');
      $body .= '<br>';
      $body .= $generatepdf->getInfoBodyReceipt($id, $incomeaccounts, $colrec, 'IAF');
      $body .= '<br>';
      $body .= $generatepdf->getTotalOfReceiptById($data, $type);
    }
    if ($type == 'PENAL') {
      $body .= $generatepdf->getInfoBodyReceipt($id, $incomeaccounts, $colrec, 'PAF');
      $body .= '<br>';
      $body .= $generatepdf->getTotalOfReceiptById($data, $type);
    }
    $body .= $generatepdf->getInformativeNote($type);
    $mpdf = new \Mpdf\Mpdf([
      'mode' => 'utf-8',
      'format' => 'letter',
      'margin_header' => 10,
      'margin_footer' => 10,
      'margin_left' => 10,
      'margin_right' => 10,
      'margin_top' => 70,
      'margin_bottom' => 10
    ]);
    $mpdf->SetHeader($head);
    $mpdf->SetFooter('Numero de Pagina: {PAGENO}| Fecha de impresion: {DATE j-m-Y}');
    $mpdf->WriteHTML($stylesheet, \Mpdf\HTMLParserMode::HEADER_CSS);
    $mpdf->WriteHTML($body, \Mpdf\HTMLParserMode::HTML_BODY);
    $mpdf->Output($name . '.pdf', \Mpdf\Output\Destination::DOWNLOAD);

    break;
  case 'sendmail_pdf_receipt':
    $dato = array();
    $head = '';
    $body = '';
    $foot = '';
    $stylesheet = file_get_contents(URL_ASSETS . '/css/style-custom.css');
    $logo = URL_ASSETS . '/img/logo.png';
    $name = '';
    $type = '';
    $data = $colrec->getDataHeaderReceiptDB($id);
    $name = $generatepdf->getNameReceipt($data);
    $type = $generatepdf->getTypeReceipt($data);
    $head .= $generatepdf->getInfoHeadCondominium($logo, $type);
    $head .= $generatepdf->getInfoHeadReceipt($data);
    if ($type == 'COBRO') {
      $body .= $generatepdf->getInfoBodyReceipt($id, $expaccount, $colrec, 'EAF');
      $body .= '<br>';
      $body .= $generatepdf->getInfoBodyReceipt($id, $expaccount, $colrec, 'EANF');
      $body .= '<br>';
      $body .= $generatepdf->getInfoBodyReceipt($id, $incomeaccounts, $colrec, 'IAF');
      $body .= '<br>';
      $body .= $generatepdf->getTotalOfReceiptById($data, $type);
    }
    if ($type == 'PENAL') {
      $body .= $generatepdf->getInfoBodyReceipt($id, $incomeaccounts, $colrec, 'PAF');
      $body .= '<br>';
      $body .= $generatepdf->getTotalOfReceiptById($data, $type);
    }
    $body .= $generatepdf->getInformativeNote($type);
    $mpdf = new \Mpdf\Mpdf([
      'mode' => 'utf-8',
      'format' => 'letter',
      'margin_header' => 10,
      'margin_footer' => 10,
      'margin_left' => 10,
      'margin_right' => 10,
      'margin_top' => 70,
      'margin_bottom' => 10
    ]);
    $mpdf->SetHeader($head);
    $mpdf->SetFooter('Numero de Pagina: {PAGENO}| Fecha de impresion: {DATE j-m-Y}');
    $mpdf->WriteHTML($stylesheet, \Mpdf\HTMLParserMode::HEADER_CSS);
    $mpdf->WriteHTML($body, \Mpdf\HTMLParserMode::HTML_BODY);
    $document = $mpdf->Output('', \Mpdf\Output\Destination::STRING_RETURN);
    $content = "Recibo de Cobro";
    $subject = "Recibo de Cobro";
    $mail = sendMail("jovannifranco@gmail.com", $subject, $body, $name, $document);
    if (!$mail['error']) {
      $dato['status'] = true;
      $dato['httpstatus'] = '200';
      $dato['message'] = "El Correo Fue Enviado Satisfactoriamente \n";
    } else {
      $dato['status'] = false;
      $dato['httpstatus'] = '500';
      $dato['message'] = $mail['error'];
    }
    echo json_encode($dato, JSON_UNESCAPED_UNICODE);
    break;
  default:
    header("Location:" . URL_APP . "recibocobro");
    break;
}
