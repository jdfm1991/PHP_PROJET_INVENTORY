<?php
require_once("../../config/conexion.php");
require_once(PATH_VENDOR . "/autoload.php");


use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require_once(PATH_VENDOR . "/phpmailer/phpmailer/src/Exception.php");
require_once(PATH_VENDOR . "/phpmailer/phpmailer/src/PHPMailer.php");
require_once(PATH_VENDOR . "/phpmailer/phpmailer/src/SMTP.php");

function sendMail($email, $subject, $body, $name, $document)
{
  $mail = new PHPMailer(true);
  try {
    //Server settings
    $mail->SMTPDebug = 0;                      //Enable verbose debug output
    $mail->isSMTP();                                            //Send using SMTP
    $mail->Host       = MAIL_SERVER;                     //Set the SMTP server to send through
    $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
    $mail->Username   = MAIL_USER;                                       //SMTP username
    $mail->Password   = MAIL_PASS;                               //SMTP password
    $mail->SMTPSecure = 'tls';            //Enable implicit TLS encryption
    $mail->Port       = 587;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

    //Recipients
    $mail->setFrom(MAIL_USER, 'SOPORTE TECNICO');
    $mail->addAddress($email);     //Add a recipient
    $mail->addReplyTo(MAIL_USER, 'SOPORTE TECNICO');

    //Content
    $mail->isHTML(true);                                  //Set email format to HTML
    $mail->Subject = $subject;
    $mail->Body    = $body;
    $mail->addStringAttachment($document, '' . $name . '.pdf', 'base64', 'application/pdf');

    $mail->send();
    if ($mail->send()) {
      return true;
    }
  } catch (Exception $e) {
    $send = [
      'error' => $mail->ErrorInfo,
      'status' => false];
    return $send;
  }
}

class Generatepdf
{
  public function getNameReceipt($data)
  {
    $name = '';
    foreach ($data as $row) {
      $name =  $row['numrec'] . ' - ' . $row['unitdep'] . ' - ' . $row['nametenant'];
    }
    return $name;
  }

  public function getTypeReceipt($data)
  {
    $type = '';
    foreach ($data as $row) {
      $type =  $row['typerec'];
    }
    return $type;
  }
  public function getInfoHeadCondominium($logo, $type)
  {
    $condominium = '';
    $condominium .= '
	<div class="img-head-box">
		<img class="img-head" src="' . $logo . '" alt="">
	</div>
	<div class="text-head-box">
		<h3 class="text-head">CONDOMINIO RESIDENCIAS "TU CONDOMINIO"</h3>
		<small class="text-head2">J-00000000-0 </small>
	</div>
	<h3 class="time-head">Fecha de Impresion: {DATE j-m-Y}</h3>
	<br>
  <div class="text-head"> RECIBO DE COBRO </div>';
    if ($type == 'COBRO') {
      $condominium .= '
  <div class="text-head"> RELACION DE COBROS </div>';
    }
    if ($type == 'PENAL') {
      $condominium .= '
  <div class="text-head"> RELACION DE PENALIZACIONES </div>';
    }
    return $condominium;
  }

  public function getInfoHeadReceipt($data)
  {
    $headreceipt = '';
    foreach ($data as $row) {
      $headreceipt = '
	<div class="content-info">
		<div class="info-head-box">
			<br><br> 
			<p class="info-text-1">' . $row['conceptreceipt'] . '</p>
		</div>
		<div class="info-head-box"> 
			<p class="info-text-2">N° RECIBO: ' . $row['numrec'] . '</p>
			<p class="info-text-2">FEC. DE VENC.: ' . $row['expirationdate'] . '</p>
			<p class="info-text-2">N° DEPARTAMENTO: ' . $row['unitdep'] . '</p>
			<p class="info-text-2">NIVEL: ' . $row['levelrec'] . '</p>
			<p class="info-text-2">ALICUOTA: ' . $row['aliquotrec'] . '</p>
		</div>
	</div>';
    }
    return $headreceipt;
  }

  public function getInfoBodyReceipt($id, $account, $item, $type)
  {
    $data = [];
    $consultation = '';
    $totalaumont = 0;
    $totalaliquota = 0;
    if ($type == 'EAF') {
      $data = $account->getDataExpenseAcountFixedDB();
      $consultation = 'GASTOS FIJOS';
    }
    if ($type == 'EANF') {
      $data = $account->getDataExpenseAcountNonFixedDB();
      $consultation = 'GASTOS VARIABLES';
    }
    if ($type == 'IAF') {
      $data = $account->getDataIncomeAcountDB();
      $consultation = 'INGRESOS PERCIBIDOS';
    }
    if ($type == 'PAF') {
      $data = $account->getDataPenaltyAcountDB();
      $consultation = 'PENALIDADES';
    }

    $infobody = '
    <table style="text-align:justify; width:100%">
      <tr>
        <th style="padding-bottom: -15px; width:15%">CODIGO</th>
        <th style="padding-bottom: -15px; width:65%">' . $consultation . '</th>
        <th style="padding-bottom: -15px;">MONTO</th>
        <th style="padding-bottom: -15px;">CUOTA</th>
      </tr>';
    foreach ($data as $row) {
      $items = $item->getDataItemsByReceiptDB($id, $row['id']);
      if (!empty($items)) {
        $infobody .= '
        <tr>
          <td style="text-align:center; font-weight: bold; padding-top: 20px;">' . $row['codeaccount'] . '</td>
          <td style="font-weight: bold; padding-top: 20px;">' . $row['expenseaccount'] . '</td>
          <td style="padding-top: 2px;"></td>
          <td style="padding-top: 20px;"></td>
        </tr>';
        foreach ($items as $items) {
          $infobody .= '
					<tr>
						<td></td>
						<td>' . $items['detailexpense'] . '</td>
						<td style="text-align:center; font-weight: bold;">' . number_format($items['amountexpense'], 2) . '</td>
						<td style="text-align:center; font-weight: bold;">' . number_format($items['aumontaliquot'], 2) . '</td>
					</tr>';

          $totalaumont += $items['amountexpense'];
          $totalaliquota += $items['aumontaliquot'];
        }
      }
    }
    $infobody .= '
          <tr style="background-color: #dde3f1da; border: 1px solid #747474;">
						<td style="text-align:center; font-weight: bold; padding-top: 30px;"></td>
						<td style="text-align:center; font-weight: bold; padding-top: 30px;"> TOTAL DE ' . $consultation . '</td>
						<td style="text-align:center; font-weight: bold; padding-top: 30px;">' . number_format($totalaumont, 2) . '</td>
						<td style="text-align:center; font-weight: bold; padding-top: 30px;">' . number_format($totalaliquota, 2) . '</td>
					</tr>
      </table>
      <hr>';
    return $infobody;
  }

  public function getTotalOfReceiptById($data, $type)
  {
    $infobody = '';
    if ($type == 'COBRO') {
      $infobody .= '
    <table style="width:100%">
      <tr>
        <td colspan="3" style="text-align:right; font-weight: bold;"> Total Gastos Fijos </td>
        <td style="text-align:right; font-weight: bold;"> ' . number_format($data[0]['aumontgf'], 2) . ' </td>
      </tr>
      <tr>
        <td colspan="3" style="text-align:right; font-weight: bold;"> Total Gastos Variables </td>
        <td style="text-align:right; font-weight: bold;"> ' . number_format($data[0]['aumontgv'], 2) . ' </td>
      </tr>
      <tr>
        <td colspan="3" style="text-align:right; font-weight: bold;"> Total Ingresos Percibidos </td>
        <td style="text-align:right; font-weight: bold;"> ' . number_format($data[0]['aumonti'], 2) . ' </td>
      </tr>
      <tr>
        <td colspan="3" style="text-align:right; font-weight: bold;"> Saldo Anterior </td>
        <td style="text-align:right; font-weight: bold;"> ' . number_format($data[0]['amouta'], 2) . ' </td>
      </tr>
      <tr>
        <td colspan="3" style="text-align:right; font-weight: bold;"> Intereses Por Mora </td>
        <td style="text-align:right; font-weight: bold;"> ' . number_format($data[0]['amoutm'], 2) . ' </td>
      </tr>
      <tr>
        <td colspan="3" style="text-align:right; font-weight: bold;"> Intereses Por Gastos Administrativos </td>
        <td style="text-align:right; font-weight: bold;"> ' . number_format($data[0]['amoutg'], 2) . ' </td>
      </tr>
    </table>
    <hr>
    <table style="width:100%">
      <tr>
        <td colspan="3" style="text-align:right; font-weight: bold;"> Total a pagar </td>
        <td style="text-align:right; font-weight: bold;"> ' . number_format($data[0]['aumont'], 2) . ' </td>
      </tr>
    </table>
    ';
    }
    if ($type == 'PENAL') {
      $infobody .= '
    <table style="width:100%">
      <tr>
        <td colspan="3" style="text-align:right; font-weight: bold;"> Total a pagar </td>
        <td style="text-align:right; font-weight: bold;"> ' . number_format($data[0]['aumontp'], 2) . ' </td>
      </tr>
    </table>';
    }
    return $infobody;
  }

  public function getInformativeNote($type)
  {
    $infobody = '';
    $infobody .= '
      <div style="background-color: hsla(181, 46%, 64%, 0.40); border: 1px solid #747474; border-radius: 5px; margin: 30px; padding: 10px">';
    if ($type == 'COBRO') {
      $infobody .= '<p style="text-align: center; font-weight: bold; font-size: 10px;">ESTE RECIBO VENCE A LOS 15 DIAS DE SU EMISION, A PARTIR DE ALLI GENERA GASTOS POR MORA, COBRANZA Y BLOQUEO DE LLAVES DE ACCESO</p>';
    }

    $infobody .= '<p style="text-align: justify; font-weight: bold; font-size: 10px;">EL MONTO REFLEJADO EN EL RECIBO SE EXPRESA EN DOLARES AMERICANOS. <br><br> DATOS PARA GESTION DE PAGOS: <br> JUNTA DE CONDOMINIO RESIDENCIAL GRAND PALMS CUENTA CORRIENTE. <br> BANESCO Nº: 0134-0348-14-3483041305 <br> RIF: J-29360171-1 <br><br>
  La tasa de referencia =  BCV del día del pago. <br><br> Si realiza TRANSFERENCIA  desde un banco distinto a Banesco, debe sumar el 1,523% correspondiente a 
  la comisión que cobra el banco por ser nuestra cuenta de una persona juridica. <br><br>
  Atención telefónica 0286-9613576 y 0426-4100059
  Enviar los comprobantes de pagos con fecha y hora de transacción al correo condominiograndpalms@gmail.com <br><br>
  Se aceptan dólares americanos en efectivo, excepcionalmente Zelle (siempre que que sean MONTOS REDONDOS</p>
      </div>
      ';
    return $infobody;
  }
}
