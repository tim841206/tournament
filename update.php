<?php
include_once("resource/database.php");
include_once("resource/custom.php");

$account = $_COOKIE['account'];
$gameno = $_POST['gameno'];
$above = explode(',', $_POST['above']);
$below = explode(',', $_POST['below']);

$gametype = getGametype($account, $gameno);
$amount = getAmount($account, $gameno);
$distribute = distribute($amount);
$gap = 3 * ($distribute['3_1'] + $distribute['3_2']) + 6 * ($distribute['4_1'] + $distribute['4_2']);

for ($i = 1; $i < count($above); $i++) {
	$temp_above = $above[$i];
	$temp_below = $below[$i];
	if ($temp_above > $temp_below) {
		mysqli_query($mysql, "UPDATE GAMESTATE SET ABOVESCORE='$temp_above', BELOWSCORE='$temp_below', WINNER=ABOVE WHERE USERNO='$account' AND GAMENO='$gameno' AND PLAYNO='$i'");
	}
	elseif ($temp_above < $temp_below) {
		mysqli_query($mysql, "UPDATE GAMESTATE SET ABOVESCORE='$temp_above', BELOWSCORE='$temp_below', WINNER=BELOW WHERE USERNO='$account' AND GAMENO='$gameno' AND PLAYNO='$i'");
	}
	elseif ($temp_above == $temp_below && $temp_above != '') {
		mysqli_query($mysql, "UPDATE GAMESTATE SET ABOVESCORE='$temp_above', BELOWSCORE='$temp_below', WINNER='-1' WHERE USERNO='$account' AND GAMENO='$gameno' AND PLAYNO='$i'");
	}
	if ($gametype == 'A' || $i > $gap) {
		updateGameChart($account, $gameno);
	}
}
date_default_timezone_set('Asia/Taipei');
$date = date("Y-m-d H:i:s");
mysqli_query($mysql, "UPDATE GAMEMAIN SET UPDATEDATE='$date' WHERE USERNO='$account' AND GAMENO='$gameno'");
echo json_encode(array('message' => 'Success'));