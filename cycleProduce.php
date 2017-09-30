<?php
include_once("resource/database.php");
include_once("resource/custom.php");

$account = $_COOKIE['account'];
$mode = $_POST['mode'];
$amount = $_POST['amount'];
$gameno = $_POST['gameno'];
$gamenm = $_POST['gamenm'];
$unit = explode(',', $_POST['unit']);
$name = explode(',', $_POST['name']);
$sql = mysql_query("SELECT * FROM GAMEMAIN WHERE USERNO='$account' AND GAMENO='$gameno'");
if (empty($gameno)) {
	echo json_encode(array('message' => 'Empty game index'));
}
elseif (empty($gamenm)) {
	echo json_encode(array('message' => 'Empty game name'));
}
elseif (!is_validAmount($amount)) {
	echo json_encode(array('message' => 'Invalid player amount'));
}
elseif (mysql_num_rows($sql) != 0) {
	echo json_encode(array('message' => 'Used game index'));
}
else {
	date_default_timezone_set('Asia/Taipei');
	$date = date("Y-m-d H:i:s");
	mysql_query("INSERT INTO GAMEMAIN (USERNO, GAMENO, GAMENM, GAMETYPE, AMOUNT, CREATEDATE, UPDATEDATE) VALUES ('$account', '$gameno', '$gamenm', 'B', '$amount', '$date', '$date')");
	$distribute = distribute($amount);
	$gap = 2 * ($distribute['4_1'] + $distribute['4_2']) + $distribute['3_1'] + $distribute['3_2'];
	if ($mode == 'auto') {
		$rand = array();
		for ($i = 0; $i < $amount; $i++) {
			array_push($rand, $i);
		}
		shuffle($rand);
		$index = 0;
		$game = 1;
		for ($i = 1; $i <= $distribute['4_2']; $i++) {
			$temp_unit1 = $unit[$rand[$index+0]];
			$temp_unit2 = $unit[$rand[$index+1]];
			$temp_unit3 = $unit[$rand[$index+2]];
			$temp_unit4 = $unit[$rand[$index+3]];
			$temp_name1 = $name[$rand[$index+0]];
			$temp_name2 = $name[$rand[$index+1]];
			$temp_name3 = $name[$rand[$index+2]];
			$temp_name4 = $name[$rand[$index+3]];
			mysql_query("INSERT INTO GAMEPOSITION (USERNO, GAMENO, POSITION, UNIT, NAME) VALUES ('$account', '$gameno', $index+1, '$temp_unit1', '$temp_name1')");
			mysql_query("INSERT INTO GAMEPOSITION (USERNO, GAMENO, POSITION, UNIT, NAME) VALUES ('$account', '$gameno', $index+2, '$temp_unit2', '$temp_name2')");
			mysql_query("INSERT INTO GAMEPOSITION (USERNO, GAMENO, POSITION, UNIT, NAME) VALUES ('$account', '$gameno', $index+3, '$temp_unit3', '$temp_name3')");
			mysql_query("INSERT INTO GAMEPOSITION (USERNO, GAMENO, POSITION, UNIT, NAME) VALUES ('$account', '$gameno', $index+4, '$temp_unit4', '$temp_name4')");
			mysql_query("INSERT INTO GAMESTATE (USERNO, GAMENO, PLAYNO, SYSTEMPLAYNO, ABOVE, BELOW) VALUES ('$account', '$gameno', $game, $game, $index+1, $index+2)");
			mysql_query("INSERT INTO GAMESTATE (USERNO, GAMENO, PLAYNO, SYSTEMPLAYNO, ABOVE, BELOW) VALUES ('$account', '$gameno', $game+1, $game+1, $index+3, $index+4)");
			mysql_query("INSERT INTO GAMESTATE (USERNO, GAMENO, PLAYNO, SYSTEMPLAYNO, ABOVE, BELOW) VALUES ('$account', '$gameno', $gap+$game, $gap+$game, $index+1, $index+3)");
			mysql_query("INSERT INTO GAMESTATE (USERNO, GAMENO, PLAYNO, SYSTEMPLAYNO, ABOVE, BELOW) VALUES ('$account', '$gameno', $gap+$game+1, $gap+$game+1, $index+2, $index+4)");
			mysql_query("INSERT INTO GAMESTATE (USERNO, GAMENO, PLAYNO, SYSTEMPLAYNO, ABOVE, BELOW) VALUES ('$account', '$gameno', 2*$gap+$game, 2*$gap+$game, $index+1, $index+4)");
			mysql_query("INSERT INTO GAMESTATE (USERNO, GAMENO, PLAYNO, SYSTEMPLAYNO, ABOVE, BELOW) VALUES ('$account', '$gameno', 2*$gap+$game+1, 2*$gap+$game+1, $index+2, $index+3)");
			$index += 4;
			$game += 2;
		}
		for ($i = 1; $i <= $distribute['4_1']; $i++) {
			$temp_unit1 = $unit[$rand[$index+0]];
			$temp_unit2 = $unit[$rand[$index+1]];
			$temp_unit3 = $unit[$rand[$index+2]];
			$temp_unit4 = $unit[$rand[$index+3]];
			$temp_name1 = $name[$rand[$index+0]];
			$temp_name2 = $name[$rand[$index+1]];
			$temp_name3 = $name[$rand[$index+2]];
			$temp_name4 = $name[$rand[$index+3]];
			mysql_query("INSERT INTO GAMEPOSITION (USERNO, GAMENO, POSITION, UNIT, NAME) VALUES ('$account', '$gameno', $index+1, '$temp_unit1', '$temp_name1')");
			mysql_query("INSERT INTO GAMEPOSITION (USERNO, GAMENO, POSITION, UNIT, NAME) VALUES ('$account', '$gameno', $index+2, '$temp_unit2', '$temp_name2')");
			mysql_query("INSERT INTO GAMEPOSITION (USERNO, GAMENO, POSITION, UNIT, NAME) VALUES ('$account', '$gameno', $index+3, '$temp_unit3', '$temp_name3')");
			mysql_query("INSERT INTO GAMEPOSITION (USERNO, GAMENO, POSITION, UNIT, NAME) VALUES ('$account', '$gameno', $index+4, '$temp_unit4', '$temp_name4')");
			mysql_query("INSERT INTO GAMESTATE (USERNO, GAMENO, PLAYNO, SYSTEMPLAYNO, ABOVE, BELOW) VALUES ('$account', '$gameno', $game, $game, $index+1, $index+2)");
			mysql_query("INSERT INTO GAMESTATE (USERNO, GAMENO, PLAYNO, SYSTEMPLAYNO, ABOVE, BELOW) VALUES ('$account', '$gameno', $game+1, $game+1, $index+3, $index+4)");
			mysql_query("INSERT INTO GAMESTATE (USERNO, GAMENO, PLAYNO, SYSTEMPLAYNO, ABOVE, BELOW) VALUES ('$account', '$gameno', $gap+$game, $gap+$game, $index+1, $index+3)");
			mysql_query("INSERT INTO GAMESTATE (USERNO, GAMENO, PLAYNO, SYSTEMPLAYNO, ABOVE, BELOW) VALUES ('$account', '$gameno', $gap+$game+1, $gap+$game+1, $index+2, $index+4)");
			mysql_query("INSERT INTO GAMESTATE (USERNO, GAMENO, PLAYNO, SYSTEMPLAYNO, ABOVE, BELOW) VALUES ('$account', '$gameno', 2*$gap+$game, 2*$gap+$game, $index+1, $index+4)");
			mysql_query("INSERT INTO GAMESTATE (USERNO, GAMENO, PLAYNO, SYSTEMPLAYNO, ABOVE, BELOW) VALUES ('$account', '$gameno', 2*$gap+$game+1, 2*$gap+$game+1, $index+2, $index+3)");
			$index += 4;
			$game += 2;
		}
		for ($i = 1; $i <= $distribute['3_1']; $i++) {
			$temp_unit1 = $unit[$rand[$index+0]];
			$temp_unit2 = $unit[$rand[$index+1]];
			$temp_unit3 = $unit[$rand[$index+2]];
			$temp_name1 = $name[$rand[$index+0]];
			$temp_name2 = $name[$rand[$index+1]];
			$temp_name3 = $name[$rand[$index+2]];
			mysql_query("INSERT INTO GAMEPOSITION (USERNO, GAMENO, POSITION, UNIT, NAME) VALUES ('$account', '$gameno', $index+1, '$temp_unit1', '$temp_name1')");
			mysql_query("INSERT INTO GAMEPOSITION (USERNO, GAMENO, POSITION, UNIT, NAME) VALUES ('$account', '$gameno', $index+2, '$temp_unit2', '$temp_name2')");
			mysql_query("INSERT INTO GAMEPOSITION (USERNO, GAMENO, POSITION, UNIT, NAME) VALUES ('$account', '$gameno', $index+3, '$temp_unit3', '$temp_name3')");
			mysql_query("INSERT INTO GAMESTATE (USERNO, GAMENO, PLAYNO, SYSTEMPLAYNO, ABOVE, BELOW) VALUES ('$account', '$gameno', $game, $game, $index+1, $index+2)");
			mysql_query("INSERT INTO GAMESTATE (USERNO, GAMENO, PLAYNO, SYSTEMPLAYNO, ABOVE, BELOW) VALUES ('$account', '$gameno', $gap+$game, $gap+$game, $index+1, $index+3)");
			mysql_query("INSERT INTO GAMESTATE (USERNO, GAMENO, PLAYNO, SYSTEMPLAYNO, ABOVE, BELOW) VALUES ('$account', '$gameno', 2*$gap+$game, 2*$gap+$game, $index+2, $index+3)");
			$index += 3;
			$game++;
		}
		for ($i = 1; $i <= $distribute['3_2']; $i++) {
			$temp_unit1 = $unit[$rand[$index+0]];
			$temp_unit2 = $unit[$rand[$index+1]];
			$temp_unit3 = $unit[$rand[$index+2]];
			$temp_name1 = $name[$rand[$index+0]];
			$temp_name2 = $name[$rand[$index+1]];
			$temp_name3 = $name[$rand[$index+2]];
			mysql_query("INSERT INTO GAMEPOSITION (USERNO, GAMENO, POSITION, UNIT, NAME) VALUES ('$account', '$gameno', $index+1, '$temp_unit1', '$temp_name1')");
			mysql_query("INSERT INTO GAMEPOSITION (USERNO, GAMENO, POSITION, UNIT, NAME) VALUES ('$account', '$gameno', $index+2, '$temp_unit2', '$temp_name2')");
			mysql_query("INSERT INTO GAMEPOSITION (USERNO, GAMENO, POSITION, UNIT, NAME) VALUES ('$account', '$gameno', $index+3, '$temp_unit3', '$temp_name3')");
			mysql_query("INSERT INTO GAMESTATE (USERNO, GAMENO, PLAYNO, SYSTEMPLAYNO, ABOVE, BELOW) VALUES ('$account', '$gameno', $game, $game, $index+1, $index+2)");
			mysql_query("INSERT INTO GAMESTATE (USERNO, GAMENO, PLAYNO, SYSTEMPLAYNO, ABOVE, BELOW) VALUES ('$account', '$gameno', $gap+$game, $gap+$game, $index+1, $index+3)");
			mysql_query("INSERT INTO GAMESTATE (USERNO, GAMENO, PLAYNO, SYSTEMPLAYNO, ABOVE, BELOW) VALUES ('$account', '$gameno', 2*$gap+$game, 2*$gap+$game, $index+2, $index+3)");
			$index += 3;
			$game++;
		}
		for ($i = 1; $i < $distribute['round']; $i++) {
			mysql_query("INSERT INTO GAMESTATE (USERNO, GAMENO, PLAYNO, SYSTEMPLAYNO) VALUES ('$account', '$gameno', '$play', '$play')");
		}
		makePublic($account, $gameno);
		makeEdit($account, $gameno);
		echo json_encode(array('message' => 'Success', 'gameno' => $gameno));
		unlink($account.'/'.$gameno."/assign.html");
		makeGame($account, $gameno);
	}
	elseif ($mode == 'enter') {
		$index = 0;
		$game = 1;
		for ($i = 1; $i <= $distribute['4_2']; $i++) {
			$temp_unit1 = $unit[$index+0];
			$temp_unit2 = $unit[$index+1];
			$temp_unit3 = $unit[$index+2];
			$temp_unit4 = $unit[$index+3];
			$temp_name1 = $name[$index+0];
			$temp_name2 = $name[$index+1];
			$temp_name3 = $name[$index+2];
			$temp_name4 = $name[$index+3];
			mysql_query("INSERT INTO GAMEPOSITION (USERNO, GAMENO, POSITION, UNIT, NAME) VALUES ('$account', '$gameno', $index+1, '$temp_unit1', '$temp_name1')");
			mysql_query("INSERT INTO GAMEPOSITION (USERNO, GAMENO, POSITION, UNIT, NAME) VALUES ('$account', '$gameno', $index+2, '$temp_unit2', '$temp_name2')");
			mysql_query("INSERT INTO GAMEPOSITION (USERNO, GAMENO, POSITION, UNIT, NAME) VALUES ('$account', '$gameno', $index+3, '$temp_unit3', '$temp_name3')");
			mysql_query("INSERT INTO GAMEPOSITION (USERNO, GAMENO, POSITION, UNIT, NAME) VALUES ('$account', '$gameno', $index+4, '$temp_unit4', '$temp_name4')");
			mysql_query("INSERT INTO GAMESTATE (USERNO, GAMENO, PLAYNO, SYSTEMPLAYNO, ABOVE, BELOW) VALUES ('$account', '$gameno', $game, $game, $index+1, $index+2)");
			mysql_query("INSERT INTO GAMESTATE (USERNO, GAMENO, PLAYNO, SYSTEMPLAYNO, ABOVE, BELOW) VALUES ('$account', '$gameno', $game+1, $game+1, $index+3, $index+4)");
			mysql_query("INSERT INTO GAMESTATE (USERNO, GAMENO, PLAYNO, SYSTEMPLAYNO, ABOVE, BELOW) VALUES ('$account', '$gameno', $gap+$game, $gap+$game, $index+1, $index+3)");
			mysql_query("INSERT INTO GAMESTATE (USERNO, GAMENO, PLAYNO, SYSTEMPLAYNO, ABOVE, BELOW) VALUES ('$account', '$gameno', $gap+$game+1, $gap+$game+1, $index+2, $index+4)");
			mysql_query("INSERT INTO GAMESTATE (USERNO, GAMENO, PLAYNO, SYSTEMPLAYNO, ABOVE, BELOW) VALUES ('$account', '$gameno', 2*$gap+$game, 2*$gap+$game, $index+1, $index+4)");
			mysql_query("INSERT INTO GAMESTATE (USERNO, GAMENO, PLAYNO, SYSTEMPLAYNO, ABOVE, BELOW) VALUES ('$account', '$gameno', 2*$gap+$game+1, 2*$gap+$game+1, $index+2, $index+3)");
			$index += 4;
			$game += 2;
		}
		for ($i = 1; $i <= $distribute['4_1']; $i++) {
			$temp_unit1 = $unit[$index+0];
			$temp_unit2 = $unit[$index+1];
			$temp_unit3 = $unit[$index+2];
			$temp_unit4 = $unit[$index+3];
			$temp_name1 = $name[$index+0];
			$temp_name2 = $name[$index+1];
			$temp_name3 = $name[$index+2];
			$temp_name4 = $name[$index+3];
			mysql_query("INSERT INTO GAMEPOSITION (USERNO, GAMENO, POSITION, UNIT, NAME) VALUES ('$account', '$gameno', $index+1, '$temp_unit1', '$temp_name1')");
			mysql_query("INSERT INTO GAMEPOSITION (USERNO, GAMENO, POSITION, UNIT, NAME) VALUES ('$account', '$gameno', $index+2, '$temp_unit2', '$temp_name2')");
			mysql_query("INSERT INTO GAMEPOSITION (USERNO, GAMENO, POSITION, UNIT, NAME) VALUES ('$account', '$gameno', $index+3, '$temp_unit3', '$temp_name3')");
			mysql_query("INSERT INTO GAMEPOSITION (USERNO, GAMENO, POSITION, UNIT, NAME) VALUES ('$account', '$gameno', $index+4, '$temp_unit4', '$temp_name4')");
			mysql_query("INSERT INTO GAMESTATE (USERNO, GAMENO, PLAYNO, SYSTEMPLAYNO, ABOVE, BELOW) VALUES ('$account', '$gameno', $game, $game, $index+1, $index+2)");
			mysql_query("INSERT INTO GAMESTATE (USERNO, GAMENO, PLAYNO, SYSTEMPLAYNO, ABOVE, BELOW) VALUES ('$account', '$gameno', $game+1, $game+1, $index+3, $index+4)");
			mysql_query("INSERT INTO GAMESTATE (USERNO, GAMENO, PLAYNO, SYSTEMPLAYNO, ABOVE, BELOW) VALUES ('$account', '$gameno', $gap+$game, $gap+$game, $index+1, $index+3)");
			mysql_query("INSERT INTO GAMESTATE (USERNO, GAMENO, PLAYNO, SYSTEMPLAYNO, ABOVE, BELOW) VALUES ('$account', '$gameno', $gap+$game+1, $gap+$game+1, $index+2, $index+4)");
			mysql_query("INSERT INTO GAMESTATE (USERNO, GAMENO, PLAYNO, SYSTEMPLAYNO, ABOVE, BELOW) VALUES ('$account', '$gameno', 2*$gap+$game, 2*$gap+$game, $index+1, $index+4)");
			mysql_query("INSERT INTO GAMESTATE (USERNO, GAMENO, PLAYNO, SYSTEMPLAYNO, ABOVE, BELOW) VALUES ('$account', '$gameno', 2*$gap+$game+1, 2*$gap+$game+1, $index+2, $index+3)");
			$index += 4;
			$game += 2;
		}
		for ($i = 1; $i <= $distribute['3_1']; $i++) {
			$temp_unit1 = $unit[$index+0];
			$temp_unit2 = $unit[$index+1];
			$temp_unit3 = $unit[$index+2];
			$temp_name1 = $name[$index+0];
			$temp_name2 = $name[$index+1];
			$temp_name3 = $name[$index+2];
			mysql_query("INSERT INTO GAMEPOSITION (USERNO, GAMENO, POSITION, UNIT, NAME) VALUES ('$account', '$gameno', $index+1, '$temp_unit1', '$temp_name1')");
			mysql_query("INSERT INTO GAMEPOSITION (USERNO, GAMENO, POSITION, UNIT, NAME) VALUES ('$account', '$gameno', $index+2, '$temp_unit2', '$temp_name2')");
			mysql_query("INSERT INTO GAMEPOSITION (USERNO, GAMENO, POSITION, UNIT, NAME) VALUES ('$account', '$gameno', $index+3, '$temp_unit3', '$temp_name3')");
			mysql_query("INSERT INTO GAMESTATE (USERNO, GAMENO, PLAYNO, SYSTEMPLAYNO, ABOVE, BELOW) VALUES ('$account', '$gameno', $game, $game, $index+1, $index+2)");
			mysql_query("INSERT INTO GAMESTATE (USERNO, GAMENO, PLAYNO, SYSTEMPLAYNO, ABOVE, BELOW) VALUES ('$account', '$gameno', $gap+$game, $gap+$game, $index+1, $index+3)");
			mysql_query("INSERT INTO GAMESTATE (USERNO, GAMENO, PLAYNO, SYSTEMPLAYNO, ABOVE, BELOW) VALUES ('$account', '$gameno', 2*$gap+$game, 2*$gap+$game, $index+2, $index+3)");
			$index += 3;
			$game++;
		}
		for ($i = 1; $i <= $distribute['3_2']; $i++) {
			$temp_unit1 = $unit[$index+0];
			$temp_unit2 = $unit[$index+1];
			$temp_unit3 = $unit[$index+2];
			$temp_name1 = $name[$index+0];
			$temp_name2 = $name[$index+1];
			$temp_name3 = $name[$index+2];
			mysql_query("INSERT INTO GAMEPOSITION (USERNO, GAMENO, POSITION, UNIT, NAME) VALUES ('$account', '$gameno', $index+1, '$temp_unit1', '$temp_name1')");
			mysql_query("INSERT INTO GAMEPOSITION (USERNO, GAMENO, POSITION, UNIT, NAME) VALUES ('$account', '$gameno', $index+2, '$temp_unit2', '$temp_name2')");
			mysql_query("INSERT INTO GAMEPOSITION (USERNO, GAMENO, POSITION, UNIT, NAME) VALUES ('$account', '$gameno', $index+3, '$temp_unit3', '$temp_name3')");
			mysql_query("INSERT INTO GAMESTATE (USERNO, GAMENO, PLAYNO, SYSTEMPLAYNO, ABOVE, BELOW) VALUES ('$account', '$gameno', $game, $game, $index+1, $index+2)");
			mysql_query("INSERT INTO GAMESTATE (USERNO, GAMENO, PLAYNO, SYSTEMPLAYNO, ABOVE, BELOW) VALUES ('$account', '$gameno', $gap+$game, $gap+$game, $index+1, $index+3)");
			mysql_query("INSERT INTO GAMESTATE (USERNO, GAMENO, PLAYNO, SYSTEMPLAYNO, ABOVE, BELOW) VALUES ('$account', '$gameno', 2*$gap+$game, 2*$gap+$game, $index+2, $index+3)");
			$index += 3;
			$game++;
		}
		for ($i = 1; $i < $distribute['round']; $i++) {
			mysql_query("INSERT INTO GAMESTATE (USERNO, GAMENO, PLAYNO, SYSTEMPLAYNO) VALUES ('$account', '$gameno', 3*$gap+$i, 3*$gap+$i)");
		}
		makePublic($account, $gameno);
		makeEdit($account, $gameno);
		echo json_encode(array('message' => 'Success', 'route' => $account.'/'.$gameno.'/edit.html'));
		unlink($account.'/'.$gameno."/cycleAssign.html");
		makeGame($account, $gameno);
	}
}

function is_validAmount($amount) {
	if ((ceil($amount) == floor($amount)) && $amount >= 12 && $amount <= 512) {
		return true;
	}
	else {
		return false;
	}
}