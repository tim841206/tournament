<?php
include_once("resource/database.php");
include_once("resource/custom.php");

$account = $_COOKIE['account'];
$gameno = $_POST['gameno'];
$above = explode(',', $_POST['above']);
$below = explode(',', $_POST['below']);
for ($i = 1; $i < count($above); $i++) {
	$temp_above = $above[$i];
	$temp_below = $below[$i];
	if ($temp_above > $temp_below) {
		mysql_query("UPDATE GAMESTATE SET ABOVESCORE='$temp_above', BELOWSCORE='$temp_below', WINNER=ABOVE WHERE USERNO='$account' AND GAMENO='$gameno' AND PLAYNO='$i'");
	}
	elseif ($temp_above < $temp_below) {
		mysql_query("UPDATE GAMESTATE SET ABOVESCORE='$temp_above', BELOWSCORE='$temp_below', WINNER=BELOW WHERE USERNO='$account' AND GAMENO='$gameno' AND PLAYNO='$i'");
	}
}
date_default_timezone_set('Asia/Taipei');
$date = date("Y-m-d H:i:s");
mysql_query("UPDATE GAMEMAIN SET UPDATEDATE='$date' WHERE USERNO='$account' AND GAMENO='$gameno'");
updateGameChart($account, $gameno);
echo json_encode(array('message' => 'Success'));