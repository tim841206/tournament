<?php
include_once("resource/database.php");

$type = $_GET['type'];
if ($type == 'view') {
	$content = '<table><tr><th>競賽編號</th><th>競賽名稱</th><th>競賽建立時間</th><th>競賽最後更新時間</th></tr>';
	$sql = mysql_query("SELECT * FROM GAMEMAIN ORDER BY UPDATEDATE DESC");
	while ($fetch = mysql_fetch_array($sql)) {
		$content .= '<tr><td>'.$fetch['GAMENO'].'</td><td>'.$fetch['GAMENM'].'</td><td>'.$fetch['CREATEDATE'].'</td><td>'.$fetch['UPDATEDATE'].'</td><td><button onclick="location.assign(\''.$fetch['GAMENO'].'/public.html\')">查看</button></td></tr>';
	}
	$content .= '</table>';
	echo json_encode(array('message' => 'Success', 'content' => $content));
}