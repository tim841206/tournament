<?php
include_once("resource/database.php");
include_once("resource/custom.php");

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
elseif ($type == 'update') {
	$gameno = $_GET['gameno'];
	$content = '<table><tr><th>場次</th><th>單位</th><th>名稱</th><th>單位</th><th>名稱</th><th>勝者</th></tr>';
	$sql = mysql_query("SELECT * FROM GAMESTATE WHERE GAMENO='$gameno' ORDER BY SYSTEMPLAYNO ASC");
	while ($fetch = mysql_fetch_array($sql)) {
		if (!empty($fetch['PLAYNO'])) {
			$above = queryPosition($gameno, $fetch['ABOVE']);
			$below = queryPosition($gameno, $fetch['BELOW']);
			if (!empty($fetch['WINNER'])) {
				$winner = queryPosition($gameno, $fetch['WINNER']);
				$content .= '<tr><td>'.$fetch['PLAYNO'].'</td><td>'.$above['unit'].'</td><td>'.$above['name'].'</td><td>'.$below['unit'].'</td><td>'.$below['name'].'</td><td>'.$winner['name'].'</td></tr>';
			}
			else {
				$content .= '<tr><td>'.$fetch['PLAYNO'].'</td><td>'.$above['unit'].'</td><td>'.$above['name'].'</td><td>'.$below['unit'].'</td><td>'.$below['name'].'</td></tr>';
			}
		}
	}
	$content .= '</table>';
	echo json_encode(array('message' => 'Success', 'content' => $content));
}