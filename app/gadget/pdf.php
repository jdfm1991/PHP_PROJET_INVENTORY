<?php

use Mpdf\Tag\P;

require_once("../../config/const.php");
require_once(PATH_APP . "/empresas/empresas_module.php");
require_once(PATH_VENDOR . "/autoload.php");

$pdf = new PdfGenerator();
$html = new HtmlGenerator();
$empresas = new Empresas();

$company = (isset($_POST['company'])) ? $_POST['company'] : 1;



class PdfGenerator
{
  public function generatePdf($stylesheet, $header, $html)
  {
    $mpdf = new \Mpdf\Mpdf([
      'mode' => 'utf-8',
      'format' => 'letter',
      'margin_header' => 5,
      'margin_footer' => 15,
      'margin_left' => 10,
      'margin_right' => 10,
      'margin_top' => 65,
      'margin_bottom' => 15
    ]);
    //$mpdf->SetDisplayMode('fullpage');
    $mpdf->SetHTMLHeader($header);
    $mpdf->WriteHTML($stylesheet, \Mpdf\HTMLParserMode::HEADER_CSS);
    $mpdf->WriteHTML($html, \Mpdf\HTMLParserMode::HTML_BODY);
    //$mpdf->Output($name . '.pdf', \Mpdf\Output\Destination::DOWNLOAD);
    
    //$mpdf->WriteHTML($html);
    $mpdf->Output();
  }
}

class HtmlGenerator
{
  public function generateHeaderHtml($empresas, $company)
  {
    $data = $empresas->getDataCompanyDB($company);
    $html = '<h1>Empresa: ' . $data[0]['c_name'] . '</h1>';
    $html .= '<h2>Direccion: ' . $data[0]['c_address'] . '</h2>';
    $html .= '<h3>Telefono: ' . $data[0]['c_phone'] . '</h3>';
    return $html;
  }
}



$stylesheet = file_get_contents(PATH_ASSETS . '/css/style-custom.css');
$dataheader = $html->generateHeaderHtml($empresas, $company);

$header = '<div class="contenedor-flotante">
  <div class="item-flotante">'.$dataheader.'</div>
  <div class="item-flotante">'.$dataheader.'</div>
</div>';


$pdf->generatePdf($stylesheet, $header,'<h1>PDF</h1>');
//echo '<link  href="' . URL_ASSETS . '/css/style-custom.css" rel="stylesheet">';

/* 
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

    //$mail->send();
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
    $name = $data[0]['numrec']. ' - ' .$data[0]['unitdep'] . ' - ' . $data[0]['nametenant'];
    return $name;
  }

  public function getTypeReceipt($data)
  {
    $type = $data[0]['typerec'];
    return $type;
  }
  public function getInfoHeadCondominium($logo, $type)
  {
    $condominium = '';
    $condominium .= '
	<div style="width: 16%; margin: 0; float: left">
		<img style="width: 100px" src="' . $logo . '" alt="">
	</div>
	<div style="width: 65%; margin: 0; float: left; text-align: center;">
		<div style="color: #000; font-size: large; font-family: "Courier New", Courier, monospace; font-weight: bold; font-style: italic; margin-bottom: -20px">CONDOMINIO RESIDENCIAS "TU CONDOMINIO"</div>
		<div style="color: #464646; font-size: small; font-family: "Times New Roman", Times, serif; font-weight: bold; text-align: end;">J-00000000-0 </div>
	</div>
	<div style="width: 17%; margin: 0; float: left; text-align: center;">
	    <div style="color: #000; font-size: small; font-family: "Times New Roman", Times, serif; font-weight: bold" >Fecha de Impresion: {DATE j-m-Y}</div>	
	</div>
	<div style="width: 100%; margin-top: -60px; text-align: center;">
        <div style="color: #000; font-size: medium; font-family: "Courier New", Courier, monospace; font-weight: bold; font-style: italic"> RECIBO DE COBRO </div>
    </div>';
    if ($type == 'COBRO') {
      $condominium .= '
      <div style="width: 100%; margin-top: -40px; text-align: center;">
        <div style="color: #000; font-size: medium; font-family: "Courier New", Courier, monospace; font-weight: bold; font-style: italic"> RELACION DE COBROS </div>
      </div>';
    }
    if ($type == 'PENAL') {
      $condominium .= '
      <div style="width: 100%; margin-top: -40px; text-align: center;">
        <div style="color: #000; font-size: medium; font-family: "Courier New", Courier, monospace; font-weight: bold; font-style: italic"> RELACION DE PENALIZACIONES </div>
      </div>';
    }
    return $condominium;
  }

  public function getInfoHeadReceipt($data)
  {
    $headreceipt = '';
    foreach ($data as $row) {
      $headreceipt = '
	<div style="background-color: #dde3f1da; padding: 10px; border-radius: 2%; border: #747474 1px solid">
		<div style="width: 50%; margin: 0; float: left; text-align: start;">
		<br><br>
			<div style="font-size: medium; font-family: "Courier New", Courier, monospace; font-weight: bold; color: #000">' . $row['conceptreceipt'] . '</div>
		</div>
		<div style="width: 50%; margin: 0; float: left"> 
			<div style="font-size: small; font-family: "Courier New", Courier, monospace; font-weight: bold; color: #000; margin: 0">N° RECIBO: ' . $row['numrec'] . '</div>
			<div style="font-size: small; font-family: "Courier New", Courier, monospace; font-weight: bold; color: #000; margin: 0">FEC. DE VENC.: ' . $row['expirationdate'] . '</div>
			<div style="font-size: small; font-family: "Courier New", Courier, monospace; font-weight: bold; color: #000; margin: 0">N° DEPARTAMENTO: ' . $row['unitdep'] . '</div>
			<div style="font-size: small; font-family: "Courier New", Courier, monospace; font-weight: bold; color: #000; margin: 0">NIVEL: ' . $row['levelrec'] . '</div>
			<div style="font-size: small; font-family: "Courier New", Courier, monospace; font-weight: bold; color: #000; margin: 0">ALICUOTA: ' . $row['aliquotrec'] . '</div>
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
      <br>';
    return $infobody;
  }

  public function getTotalOfReceiptById($data, $type)
  {
    $infobody = '';
    if ($type == 'COBRO') {
      $infobody .= '
    <table style="width:100%; margin-top: -30px">
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
    <table style="width:100%; margin-top: -30px">
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
      <div style="background-color: hsla(181, 46%, 64%, 0.40); border: 1px solid #747474; border-radius: 5px; margin: 0px; padding: 10px">';
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
 */