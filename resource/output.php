<?php
include_once("custom.php");
include_once("database.php");
include_once("TCPDF/tcpdf.php");

$account = $_GET['account'];
$gameno = $_GET['gameno'];
$name = $_GET['name'];
output($account, $gameno, $name);

function output($account, $gameno, $name) {
	$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
	$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
	$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
	$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
	$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
	$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
	$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
	$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
	
	$pdf->AddPage();
	$pdf->SetFont('cid0jp', 'B', 20);

	$sql = mysql_query("SELECT * FROM GAMESTATE WHERE USERNO='$account' AND GAMENO='$gameno' AND PLAYNO!='NULL'");
	while ($fetch = mysql_fetch_array($sql)) {
		$query1 = queryPosition($account, $gameno, $fetch['ABOVE']);
		$query2 = queryPosition($account, $gameno, $fetch['BELOW']);
		$tbl = '<table border="1" cellpadding="2" cellspacing="2" align="center">
		<tr nobr="true">
		<td>'.$name.' 第 '.$fetch['PLAYNO'].' 場次<br>時間 ________<br>第 ___ 場地</td>
		<td>'.$query1['unit'].'  '.$query1['name'].'</td>
		<td>'.$query2['unit'].'  '.$query2['name'].'</td>
		</tr>
		<tr nobr="true">
		<td>得分</td>
		<td></td>
		<td></td>
		</tr>
		<tr nobr="true">
		<td>裁判簽名</td>
		<td colspan="2"></td>
		</tr>
		</table>';
		$pdf->writeHTML($tbl, true, false, false, false, '');
	}
	ob_end_clean();
	$pdf->Output('output.pdf', 'D');
}