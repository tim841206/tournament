<?php
include_once("resource/database.php");
include_once("resource/custom.php");

$account = $_COOKIE['account'];
$mode = $_POST['mode'];
$amount = $_POST['amount'];
$gameno = $_POST['gameno'];
$gamenm = $_POST['gamenm'];
$playtype = $_POST['playtype'];
if ($playtype == 'A') {
	$unit = explode(',', $_POST['unit']);
	$name = explode(',', $_POST['name']);
}
elseif ($playtype == 'B') {
	$unitu = explode(',', $_POST['unitu']);
	$unitd = explode(',', $_POST['unitd']);
	$nameu = explode(',', $_POST['nameu']);
	$named = explode(',', $_POST['named']);
}
elseif ($playtype == 'C') {
	$unit = explode(',', $_POST['unit']);
}
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
elseif (!in_array($playtype, array('A', 'B', 'C'))) {
	echo json_encode(array('message' => 'Unknown play type'));
}
else {
	date_default_timezone_set('Asia/Taipei');
	$date = date("Y-m-d H:i:s");
	mysql_query("INSERT INTO GAMEMAIN (USERNO, GAMENO, GAMENM, GAMETYPE, PLAYTYPE, AMOUNT, CREATEDATE, UPDATEDATE) VALUES ('$account', '$gameno', '$gamenm', 'B', '$playtype', '$amount', '$date', '$date')");
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
			if ($playtype == 'A') {
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
			}
			elseif ($playtype == 'B') {
				$temp_unit1u = $unitu[$rand[$index+0]];
				$temp_unit1d = $unitd[$rand[$index+0]];
				$temp_unit2u = $unitu[$rand[$index+1]];
				$temp_unit2d = $unitd[$rand[$index+1]];
				$temp_unit3u = $unitu[$rand[$index+2]];
				$temp_unit3d = $unitd[$rand[$index+2]];
				$temp_unit4u = $unitu[$rand[$index+3]];
				$temp_unit4d = $unitd[$rand[$index+3]];
				$temp_name1u = $nameu[$rand[$index+0]];
				$temp_name1d = $named[$rand[$index+0]];
				$temp_name2u = $nameu[$rand[$index+1]];
				$temp_name2d = $named[$rand[$index+1]];
				$temp_name3u = $nameu[$rand[$index+2]];
				$temp_name3d = $named[$rand[$index+2]];
				$temp_name4u = $nameu[$rand[$index+3]];
				$temp_name4d = $named[$rand[$index+3]];
				mysql_query("INSERT INTO GAMEPOSITION (USERNO, GAMENO, POSITION, PLAYERNO, UNIT, NAME) VALUES ('$account', '$gameno', $index+1, '1', '$temp_unit1u', '$temp_name1u')");
				mysql_query("INSERT INTO GAMEPOSITION (USERNO, GAMENO, POSITION, PLAYERNO, UNIT, NAME) VALUES ('$account', '$gameno', $index+1, '2', '$temp_unit1d', '$temp_name1d')");
				mysql_query("INSERT INTO GAMEPOSITION (USERNO, GAMENO, POSITION, PLAYERNO, UNIT, NAME) VALUES ('$account', '$gameno', $index+2, '1', '$temp_unit2u', '$temp_name2u')");
				mysql_query("INSERT INTO GAMEPOSITION (USERNO, GAMENO, POSITION, PLAYERNO, UNIT, NAME) VALUES ('$account', '$gameno', $index+2, '2', '$temp_unit2d', '$temp_name2d')");
				mysql_query("INSERT INTO GAMEPOSITION (USERNO, GAMENO, POSITION, PLAYERNO, UNIT, NAME) VALUES ('$account', '$gameno', $index+3, '1', '$temp_unit3u', '$temp_name3u')");
				mysql_query("INSERT INTO GAMEPOSITION (USERNO, GAMENO, POSITION, PLAYERNO, UNIT, NAME) VALUES ('$account', '$gameno', $index+3, '2', '$temp_unit3d', '$temp_name3d')");
				mysql_query("INSERT INTO GAMEPOSITION (USERNO, GAMENO, POSITION, PLAYERNO, UNIT, NAME) VALUES ('$account', '$gameno', $index+4, '1', '$temp_unit4u', '$temp_name4u')");
				mysql_query("INSERT INTO GAMEPOSITION (USERNO, GAMENO, POSITION, PLAYERNO, UNIT, NAME) VALUES ('$account', '$gameno', $index+4, '2', '$temp_unit4d', '$temp_name4d')");
			}
			elseif ($playtype == 'C') {
				$temp_unit1 = $unit[$rand[$index+0]];
				$temp_unit2 = $unit[$rand[$index+1]];
				$temp_unit3 = $unit[$rand[$index+2]];
				$temp_unit4 = $unit[$rand[$index+3]];
				mysql_query("INSERT INTO GAMEPOSITION (USERNO, GAMENO, POSITION, UNIT) VALUES ('$account', '$gameno', $index+1, '$temp_unit1')");
				mysql_query("INSERT INTO GAMEPOSITION (USERNO, GAMENO, POSITION, UNIT) VALUES ('$account', '$gameno', $index+2, '$temp_unit2')");
				mysql_query("INSERT INTO GAMEPOSITION (USERNO, GAMENO, POSITION, UNIT) VALUES ('$account', '$gameno', $index+3, '$temp_unit3')");
				mysql_query("INSERT INTO GAMEPOSITION (USERNO, GAMENO, POSITION, UNIT) VALUES ('$account', '$gameno', $index+4, '$temp_unit4')");
			}
			mysql_query("INSERT INTO GAMESTATE (USERNO, GAMENO, PLAYNO, SYSTEMPLAYNO, ABOVE, BELOW) VALUES ('$account', '$gameno', $game, $game, $index+1, $index+2)");
			mysql_query("INSERT INTO GAMESTATE (USERNO, GAMENO, PLAYNO, SYSTEMPLAYNO, ABOVE, BELOW) VALUES ('$account', '$gameno', $game+1, $game+1, $index+3, $index+4)");
			mysql_query("INSERT INTO GAMESTATE (USERNO, GAMENO, PLAYNO, SYSTEMPLAYNO, ABOVE, BELOW) VALUES ('$account', '$gameno', $gap+$game, $gap+$game, $index+1, $index+3)");
			mysql_query("INSERT INTO GAMESTATE (USERNO, GAMENO, PLAYNO, SYSTEMPLAYNO, ABOVE, BELOW) VALUES ('$account', '$gameno', $gap+$game+1, $gap+$game+1, $index+2, $index+4)");
			mysql_query("INSERT INTO GAMESTATE (USERNO, GAMENO, PLAYNO, SYSTEMPLAYNO, ABOVE, BELOW) VALUES ('$account', '$gameno', $gap+$gap+$game, $gap+$gap+$game, $index+1, $index+4)");
			mysql_query("INSERT INTO GAMESTATE (USERNO, GAMENO, PLAYNO, SYSTEMPLAYNO, ABOVE, BELOW) VALUES ('$account', '$gameno', $gap+$gap+$game+1, $gap+$gap+$game+1, $index+2, $index+3)");
			$index += 4;
			$game += 2;
		}
		for ($i = 1; $i <= $distribute['4_1']; $i++) {
			if ($playtype == 'A') {
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
			}
			elseif ($playtype == 'B') {
				$temp_unit1u = $unitu[$rand[$index+0]];
				$temp_unit1d = $unitd[$rand[$index+0]];
				$temp_unit2u = $unitu[$rand[$index+1]];
				$temp_unit2d = $unitd[$rand[$index+1]];
				$temp_unit3u = $unitu[$rand[$index+2]];
				$temp_unit3d = $unitd[$rand[$index+2]];
				$temp_unit4u = $unitu[$rand[$index+3]];
				$temp_unit4d = $unitd[$rand[$index+3]];
				$temp_name1u = $nameu[$rand[$index+0]];
				$temp_name1d = $named[$rand[$index+0]];
				$temp_name2u = $nameu[$rand[$index+1]];
				$temp_name2d = $named[$rand[$index+1]];
				$temp_name3u = $nameu[$rand[$index+2]];
				$temp_name3d = $named[$rand[$index+2]];
				$temp_name4u = $nameu[$rand[$index+3]];
				$temp_name4d = $named[$rand[$index+3]];
				mysql_query("INSERT INTO GAMEPOSITION (USERNO, GAMENO, POSITION, PLAYERNO, UNIT, NAME) VALUES ('$account', '$gameno', $index+1, '1', '$temp_unit1u', '$temp_name1u')");
				mysql_query("INSERT INTO GAMEPOSITION (USERNO, GAMENO, POSITION, PLAYERNO, UNIT, NAME) VALUES ('$account', '$gameno', $index+1, '2', '$temp_unit1d', '$temp_name1d')");
				mysql_query("INSERT INTO GAMEPOSITION (USERNO, GAMENO, POSITION, PLAYERNO, UNIT, NAME) VALUES ('$account', '$gameno', $index+2, '1', '$temp_unit2u', '$temp_name2u')");
				mysql_query("INSERT INTO GAMEPOSITION (USERNO, GAMENO, POSITION, PLAYERNO, UNIT, NAME) VALUES ('$account', '$gameno', $index+2, '2', '$temp_unit2d', '$temp_name2d')");
				mysql_query("INSERT INTO GAMEPOSITION (USERNO, GAMENO, POSITION, PLAYERNO, UNIT, NAME) VALUES ('$account', '$gameno', $index+3, '1', '$temp_unit3u', '$temp_name3u')");
				mysql_query("INSERT INTO GAMEPOSITION (USERNO, GAMENO, POSITION, PLAYERNO, UNIT, NAME) VALUES ('$account', '$gameno', $index+3, '2', '$temp_unit3d', '$temp_name3d')");
				mysql_query("INSERT INTO GAMEPOSITION (USERNO, GAMENO, POSITION, PLAYERNO, UNIT, NAME) VALUES ('$account', '$gameno', $index+4, '1', '$temp_unit4u', '$temp_name4u')");
				mysql_query("INSERT INTO GAMEPOSITION (USERNO, GAMENO, POSITION, PLAYERNO, UNIT, NAME) VALUES ('$account', '$gameno', $index+4, '2', '$temp_unit4d', '$temp_name4d')");
			}
			elseif ($playtype == 'C') {
				$temp_unit1 = $unit[$rand[$index+0]];
				$temp_unit2 = $unit[$rand[$index+1]];
				$temp_unit3 = $unit[$rand[$index+2]];
				$temp_unit4 = $unit[$rand[$index+3]];
				mysql_query("INSERT INTO GAMEPOSITION (USERNO, GAMENO, POSITION, UNIT) VALUES ('$account', '$gameno', $index+1, '$temp_unit1')");
				mysql_query("INSERT INTO GAMEPOSITION (USERNO, GAMENO, POSITION, UNIT) VALUES ('$account', '$gameno', $index+2, '$temp_unit2')");
				mysql_query("INSERT INTO GAMEPOSITION (USERNO, GAMENO, POSITION, UNIT) VALUES ('$account', '$gameno', $index+3, '$temp_unit3')");
				mysql_query("INSERT INTO GAMEPOSITION (USERNO, GAMENO, POSITION, UNIT) VALUES ('$account', '$gameno', $index+4, '$temp_unit4')");
			}
			mysql_query("INSERT INTO GAMESTATE (USERNO, GAMENO, PLAYNO, SYSTEMPLAYNO, ABOVE, BELOW) VALUES ('$account', '$gameno', $game, $game, $index+1, $index+2)");
			mysql_query("INSERT INTO GAMESTATE (USERNO, GAMENO, PLAYNO, SYSTEMPLAYNO, ABOVE, BELOW) VALUES ('$account', '$gameno', $game+1, $game+1, $index+3, $index+4)");
			mysql_query("INSERT INTO GAMESTATE (USERNO, GAMENO, PLAYNO, SYSTEMPLAYNO, ABOVE, BELOW) VALUES ('$account', '$gameno', $gap+$game, $gap+$game, $index+1, $index+3)");
			mysql_query("INSERT INTO GAMESTATE (USERNO, GAMENO, PLAYNO, SYSTEMPLAYNO, ABOVE, BELOW) VALUES ('$account', '$gameno', $gap+$game+1, $gap+$game+1, $index+2, $index+4)");
			mysql_query("INSERT INTO GAMESTATE (USERNO, GAMENO, PLAYNO, SYSTEMPLAYNO, ABOVE, BELOW) VALUES ('$account', '$gameno', $gap+$gap+$game, $gap+$gap+$game, $index+1, $index+4)");
			mysql_query("INSERT INTO GAMESTATE (USERNO, GAMENO, PLAYNO, SYSTEMPLAYNO, ABOVE, BELOW) VALUES ('$account', '$gameno', $gap+$gap+$game+1, $gap+$gap+$game+1, $index+2, $index+3)");
			$index += 4;
			$game += 2;
		}
		for ($i = 1; $i <= $distribute['3_1']; $i++) {
			if ($playtype == 'A') {
				$temp_unit1 = $unit[$rand[$index+0]];
				$temp_unit2 = $unit[$rand[$index+1]];
				$temp_unit3 = $unit[$rand[$index+2]];
				$temp_name1 = $name[$rand[$index+0]];
				$temp_name2 = $name[$rand[$index+1]];
				$temp_name3 = $name[$rand[$index+2]];
				mysql_query("INSERT INTO GAMEPOSITION (USERNO, GAMENO, POSITION, UNIT, NAME) VALUES ('$account', '$gameno', $index+1, '$temp_unit1', '$temp_name1')");
				mysql_query("INSERT INTO GAMEPOSITION (USERNO, GAMENO, POSITION, UNIT, NAME) VALUES ('$account', '$gameno', $index+2, '$temp_unit2', '$temp_name2')");
				mysql_query("INSERT INTO GAMEPOSITION (USERNO, GAMENO, POSITION, UNIT, NAME) VALUES ('$account', '$gameno', $index+3, '$temp_unit3', '$temp_name3')");
			}
			elseif ($playtype == 'B') {
				$temp_unit1u = $unitu[$rand[$index+0]];
				$temp_unit1d = $unitd[$rand[$index+0]];
				$temp_unit2u = $unitu[$rand[$index+1]];
				$temp_unit2d = $unitd[$rand[$index+1]];
				$temp_unit3u = $unitu[$rand[$index+2]];
				$temp_unit3d = $unitd[$rand[$index+2]];
				$temp_name1u = $nameu[$rand[$index+0]];
				$temp_name1d = $named[$rand[$index+0]];
				$temp_name2u = $nameu[$rand[$index+1]];
				$temp_name2d = $named[$rand[$index+1]];
				$temp_name3u = $nameu[$rand[$index+2]];
				$temp_name3d = $named[$rand[$index+2]];
				mysql_query("INSERT INTO GAMEPOSITION (USERNO, GAMENO, POSITION, PLAYERNO, UNIT, NAME) VALUES ('$account', '$gameno', $index+1, '1', '$temp_unit1u', '$temp_name1u')");
				mysql_query("INSERT INTO GAMEPOSITION (USERNO, GAMENO, POSITION, PLAYERNO, UNIT, NAME) VALUES ('$account', '$gameno', $index+1, '2', '$temp_unit1d', '$temp_name1d')");
				mysql_query("INSERT INTO GAMEPOSITION (USERNO, GAMENO, POSITION, PLAYERNO, UNIT, NAME) VALUES ('$account', '$gameno', $index+2, '1', '$temp_unit2u', '$temp_name2u')");
				mysql_query("INSERT INTO GAMEPOSITION (USERNO, GAMENO, POSITION, PLAYERNO, UNIT, NAME) VALUES ('$account', '$gameno', $index+2, '2', '$temp_unit2d', '$temp_name2d')");
				mysql_query("INSERT INTO GAMEPOSITION (USERNO, GAMENO, POSITION, PLAYERNO, UNIT, NAME) VALUES ('$account', '$gameno', $index+3, '1', '$temp_unit3u', '$temp_name3u')");
				mysql_query("INSERT INTO GAMEPOSITION (USERNO, GAMENO, POSITION, PLAYERNO, UNIT, NAME) VALUES ('$account', '$gameno', $index+3, '2', '$temp_unit3d', '$temp_name3d')");
			}
			elseif ($playtype == 'C') {
				$temp_unit1 = $unit[$rand[$index+0]];
				$temp_unit2 = $unit[$rand[$index+1]];
				$temp_unit3 = $unit[$rand[$index+2]];
				mysql_query("INSERT INTO GAMEPOSITION (USERNO, GAMENO, POSITION, UNIT) VALUES ('$account', '$gameno', $index+1, '$temp_unit1')");
				mysql_query("INSERT INTO GAMEPOSITION (USERNO, GAMENO, POSITION, UNIT) VALUES ('$account', '$gameno', $index+2, '$temp_unit2')");
				mysql_query("INSERT INTO GAMEPOSITION (USERNO, GAMENO, POSITION, UNIT) VALUES ('$account', '$gameno', $index+3, '$temp_unit3')");
			}
			mysql_query("INSERT INTO GAMESTATE (USERNO, GAMENO, PLAYNO, SYSTEMPLAYNO, ABOVE, BELOW) VALUES ('$account', '$gameno', $game, $game, $index+1, $index+2)");
			mysql_query("INSERT INTO GAMESTATE (USERNO, GAMENO, PLAYNO, SYSTEMPLAYNO, ABOVE, BELOW) VALUES ('$account', '$gameno', $gap+$game, $gap+$game, $index+1, $index+3)");
			mysql_query("INSERT INTO GAMESTATE (USERNO, GAMENO, PLAYNO, SYSTEMPLAYNO, ABOVE, BELOW) VALUES ('$account', '$gameno', $gap+$gap+$game, $gap+$gap+$game, $index+2, $index+3)");
			$index += 3;
			$game++;
		}
		for ($i = 1; $i <= $distribute['3_2']; $i++) {
			if ($playtype == 'A') {
				$temp_unit1 = $unit[$rand[$index+0]];
				$temp_unit2 = $unit[$rand[$index+1]];
				$temp_unit3 = $unit[$rand[$index+2]];
				$temp_name1 = $name[$rand[$index+0]];
				$temp_name2 = $name[$rand[$index+1]];
				$temp_name3 = $name[$rand[$index+2]];
				mysql_query("INSERT INTO GAMEPOSITION (USERNO, GAMENO, POSITION, UNIT, NAME) VALUES ('$account', '$gameno', $index+1, '$temp_unit1', '$temp_name1')");
				mysql_query("INSERT INTO GAMEPOSITION (USERNO, GAMENO, POSITION, UNIT, NAME) VALUES ('$account', '$gameno', $index+2, '$temp_unit2', '$temp_name2')");
				mysql_query("INSERT INTO GAMEPOSITION (USERNO, GAMENO, POSITION, UNIT, NAME) VALUES ('$account', '$gameno', $index+3, '$temp_unit3', '$temp_name3')");
			}
			elseif ($playtype == 'B') {
				$temp_unit1u = $unitu[$rand[$index+0]];
				$temp_unit1d = $unitd[$rand[$index+0]];
				$temp_unit2u = $unitu[$rand[$index+1]];
				$temp_unit2d = $unitd[$rand[$index+1]];
				$temp_unit3u = $unitu[$rand[$index+2]];
				$temp_unit3d = $unitd[$rand[$index+2]];
				$temp_name1u = $nameu[$rand[$index+0]];
				$temp_name1d = $named[$rand[$index+0]];
				$temp_name2u = $nameu[$rand[$index+1]];
				$temp_name2d = $named[$rand[$index+1]];
				$temp_name3u = $nameu[$rand[$index+2]];
				$temp_name3d = $named[$rand[$index+2]];
				mysql_query("INSERT INTO GAMEPOSITION (USERNO, GAMENO, POSITION, PLAYERNO, UNIT, NAME) VALUES ('$account', '$gameno', $index+1, '1', '$temp_unit1u', '$temp_name1u')");
				mysql_query("INSERT INTO GAMEPOSITION (USERNO, GAMENO, POSITION, PLAYERNO, UNIT, NAME) VALUES ('$account', '$gameno', $index+1, '2', '$temp_unit1d', '$temp_name1d')");
				mysql_query("INSERT INTO GAMEPOSITION (USERNO, GAMENO, POSITION, PLAYERNO, UNIT, NAME) VALUES ('$account', '$gameno', $index+2, '1', '$temp_unit2u', '$temp_name2u')");
				mysql_query("INSERT INTO GAMEPOSITION (USERNO, GAMENO, POSITION, PLAYERNO, UNIT, NAME) VALUES ('$account', '$gameno', $index+2, '2', '$temp_unit2d', '$temp_name2d')");
				mysql_query("INSERT INTO GAMEPOSITION (USERNO, GAMENO, POSITION, PLAYERNO, UNIT, NAME) VALUES ('$account', '$gameno', $index+3, '1', '$temp_unit3u', '$temp_name3u')");
				mysql_query("INSERT INTO GAMEPOSITION (USERNO, GAMENO, POSITION, PLAYERNO, UNIT, NAME) VALUES ('$account', '$gameno', $index+3, '2', '$temp_unit3d', '$temp_name3d')");
			}
			elseif ($playtype == 'C') {
				$temp_unit1 = $unit[$rand[$index+0]];
				$temp_unit2 = $unit[$rand[$index+1]];
				$temp_unit3 = $unit[$rand[$index+2]];
				mysql_query("INSERT INTO GAMEPOSITION (USERNO, GAMENO, POSITION, UNIT) VALUES ('$account', '$gameno', $index+1, '$temp_unit1')");
				mysql_query("INSERT INTO GAMEPOSITION (USERNO, GAMENO, POSITION, UNIT) VALUES ('$account', '$gameno', $index+2, '$temp_unit2')");
				mysql_query("INSERT INTO GAMEPOSITION (USERNO, GAMENO, POSITION, UNIT) VALUES ('$account', '$gameno', $index+3, '$temp_unit3')");
			}
			mysql_query("INSERT INTO GAMESTATE (USERNO, GAMENO, PLAYNO, SYSTEMPLAYNO, ABOVE, BELOW) VALUES ('$account', '$gameno', $game, $game, $index+1, $index+2)");
			mysql_query("INSERT INTO GAMESTATE (USERNO, GAMENO, PLAYNO, SYSTEMPLAYNO, ABOVE, BELOW) VALUES ('$account', '$gameno', $gap+$game, $gap+$game, $index+1, $index+3)");
			mysql_query("INSERT INTO GAMESTATE (USERNO, GAMENO, PLAYNO, SYSTEMPLAYNO, ABOVE, BELOW) VALUES ('$account', '$gameno', $gap+$gap+$game, $gap+$gap+$game, $index+2, $index+3)");
			$index += 3;
			$game++;
		}
		for ($i = 1; $i <= $distribute['round']; $i++) {
			mysql_query("INSERT INTO GAMESTATE (USERNO, GAMENO, PLAYNO, SYSTEMPLAYNO) VALUES ('$account', '$gameno', 3*$gap+$i, 3*$gap+$i)");
		}
		if (!is_dir($account.'/'.$gameno)) {
			mkdir($account.'/'.$gameno);
		}
		makePublic($account, $gameno);
		makeEdit($account, $gameno);
		echo json_encode(array('message' => 'Success', 'host' => $account, 'gameno' => $gameno));
		makeGame($account, $gameno);
	}
	elseif ($mode == 'enter') {
		$index = 0;
		$game = 1;
		for ($i = 1; $i <= $distribute['4_2']; $i++) {
			if ($playtype == 'A') {
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
			}
			elseif ($playtype == 'B') {
				$temp_unit1u = $unitu[$index+0];
				$temp_unit1d = $unitd[$index+0];
				$temp_unit2u = $unitu[$index+1];
				$temp_unit2d = $unitd[$index+1];
				$temp_unit3u = $unitu[$index+2];
				$temp_unit3d = $unitd[$index+2];
				$temp_unit4u = $unitu[$index+3];
				$temp_unit4d = $unitd[$index+3];
				$temp_name1u = $nameu[$index+0];
				$temp_name1d = $named[$index+0];
				$temp_name2u = $nameu[$index+1];
				$temp_name2d = $named[$index+1];
				$temp_name3u = $nameu[$index+2];
				$temp_name3d = $named[$index+2];
				$temp_name4u = $nameu[$index+3];
				$temp_name4d = $named[$index+3];
				mysql_query("INSERT INTO GAMEPOSITION (USERNO, GAMENO, POSITION, PLAYERNO, UNIT, NAME) VALUES ('$account', '$gameno', $index+1, '1', '$temp_unit1u', '$temp_name1u')");
				mysql_query("INSERT INTO GAMEPOSITION (USERNO, GAMENO, POSITION, PLAYERNO, UNIT, NAME) VALUES ('$account', '$gameno', $index+1, '2', '$temp_unit1d', '$temp_name1d')");
				mysql_query("INSERT INTO GAMEPOSITION (USERNO, GAMENO, POSITION, PLAYERNO, UNIT, NAME) VALUES ('$account', '$gameno', $index+2, '1', '$temp_unit2u', '$temp_name2u')");
				mysql_query("INSERT INTO GAMEPOSITION (USERNO, GAMENO, POSITION, PLAYERNO, UNIT, NAME) VALUES ('$account', '$gameno', $index+2, '2', '$temp_unit2d', '$temp_name2d')");
				mysql_query("INSERT INTO GAMEPOSITION (USERNO, GAMENO, POSITION, PLAYERNO, UNIT, NAME) VALUES ('$account', '$gameno', $index+3, '1', '$temp_unit3u', '$temp_name3u')");
				mysql_query("INSERT INTO GAMEPOSITION (USERNO, GAMENO, POSITION, PLAYERNO, UNIT, NAME) VALUES ('$account', '$gameno', $index+3, '2', '$temp_unit3d', '$temp_name3d')");
				mysql_query("INSERT INTO GAMEPOSITION (USERNO, GAMENO, POSITION, PLAYERNO, UNIT, NAME) VALUES ('$account', '$gameno', $index+4, '1', '$temp_unit4u', '$temp_name4u')");
				mysql_query("INSERT INTO GAMEPOSITION (USERNO, GAMENO, POSITION, PLAYERNO, UNIT, NAME) VALUES ('$account', '$gameno', $index+4, '2', '$temp_unit4d', '$temp_name4d')");
			}
			elseif ($playtype == 'C') {
				$temp_unit1 = $unit[$index+0];
				$temp_unit2 = $unit[$index+1];
				$temp_unit3 = $unit[$index+2];
				$temp_unit4 = $unit[$index+3];
				mysql_query("INSERT INTO GAMEPOSITION (USERNO, GAMENO, POSITION, UNIT) VALUES ('$account', '$gameno', $index+1, '$temp_unit1')");
				mysql_query("INSERT INTO GAMEPOSITION (USERNO, GAMENO, POSITION, UNIT) VALUES ('$account', '$gameno', $index+2, '$temp_unit2')");
				mysql_query("INSERT INTO GAMEPOSITION (USERNO, GAMENO, POSITION, UNIT) VALUES ('$account', '$gameno', $index+3, '$temp_unit3')");
				mysql_query("INSERT INTO GAMEPOSITION (USERNO, GAMENO, POSITION, UNIT) VALUES ('$account', '$gameno', $index+4, '$temp_unit4')");
			}
			mysql_query("INSERT INTO GAMESTATE (USERNO, GAMENO, PLAYNO, SYSTEMPLAYNO, ABOVE, BELOW) VALUES ('$account', '$gameno', $game, $game, $index+1, $index+2)");
			mysql_query("INSERT INTO GAMESTATE (USERNO, GAMENO, PLAYNO, SYSTEMPLAYNO, ABOVE, BELOW) VALUES ('$account', '$gameno', $game+1, $game+1, $index+3, $index+4)");
			mysql_query("INSERT INTO GAMESTATE (USERNO, GAMENO, PLAYNO, SYSTEMPLAYNO, ABOVE, BELOW) VALUES ('$account', '$gameno', $gap+$game, $gap+$game, $index+1, $index+3)");
			mysql_query("INSERT INTO GAMESTATE (USERNO, GAMENO, PLAYNO, SYSTEMPLAYNO, ABOVE, BELOW) VALUES ('$account', '$gameno', $gap+$game+1, $gap+$game+1, $index+2, $index+4)");
			mysql_query("INSERT INTO GAMESTATE (USERNO, GAMENO, PLAYNO, SYSTEMPLAYNO, ABOVE, BELOW) VALUES ('$account', '$gameno', $gap+$gap+$game, $gap+$gap+$game, $index+1, $index+4)");
			mysql_query("INSERT INTO GAMESTATE (USERNO, GAMENO, PLAYNO, SYSTEMPLAYNO, ABOVE, BELOW) VALUES ('$account', '$gameno', $gap+$gap+$game+1, $gap+$gap+$game+1, $index+2, $index+3)");
			$index += 4;
			$game += 2;
		}
		for ($i = 1; $i <= $distribute['4_1']; $i++) {
			if ($playtype == 'A') {
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
			}
			elseif ($playtype == 'B') {
				$temp_unit1u = $unitu[$index+0];
				$temp_unit1d = $unitd[$index+0];
				$temp_unit2u = $unitu[$index+1];
				$temp_unit2d = $unitd[$index+1];
				$temp_unit3u = $unitu[$index+2];
				$temp_unit3d = $unitd[$index+2];
				$temp_unit4u = $unitu[$index+3];
				$temp_unit4d = $unitd[$index+3];
				$temp_name1u = $nameu[$index+0];
				$temp_name1d = $named[$index+0];
				$temp_name2u = $nameu[$index+1];
				$temp_name2d = $named[$index+1];
				$temp_name3u = $nameu[$index+2];
				$temp_name3d = $named[$index+2];
				$temp_name4u = $nameu[$index+3];
				$temp_name4d = $named[$index+3];
				mysql_query("INSERT INTO GAMEPOSITION (USERNO, GAMENO, POSITION, PLAYERNO, UNIT, NAME) VALUES ('$account', '$gameno', $index+1, '1', '$temp_unit1u', '$temp_name1u')");
				mysql_query("INSERT INTO GAMEPOSITION (USERNO, GAMENO, POSITION, PLAYERNO, UNIT, NAME) VALUES ('$account', '$gameno', $index+1, '2', '$temp_unit1d', '$temp_name1d')");
				mysql_query("INSERT INTO GAMEPOSITION (USERNO, GAMENO, POSITION, PLAYERNO, UNIT, NAME) VALUES ('$account', '$gameno', $index+2, '1', '$temp_unit2u', '$temp_name2u')");
				mysql_query("INSERT INTO GAMEPOSITION (USERNO, GAMENO, POSITION, PLAYERNO, UNIT, NAME) VALUES ('$account', '$gameno', $index+2, '2', '$temp_unit2d', '$temp_name2d')");
				mysql_query("INSERT INTO GAMEPOSITION (USERNO, GAMENO, POSITION, PLAYERNO, UNIT, NAME) VALUES ('$account', '$gameno', $index+3, '1', '$temp_unit3u', '$temp_name3u')");
				mysql_query("INSERT INTO GAMEPOSITION (USERNO, GAMENO, POSITION, PLAYERNO, UNIT, NAME) VALUES ('$account', '$gameno', $index+3, '2', '$temp_unit3d', '$temp_name3d')");
				mysql_query("INSERT INTO GAMEPOSITION (USERNO, GAMENO, POSITION, PLAYERNO, UNIT, NAME) VALUES ('$account', '$gameno', $index+4, '1', '$temp_unit4u', '$temp_name4u')");
				mysql_query("INSERT INTO GAMEPOSITION (USERNO, GAMENO, POSITION, PLAYERNO, UNIT, NAME) VALUES ('$account', '$gameno', $index+4, '2', '$temp_unit4d', '$temp_name4d')");
			}
			elseif ($playtype == 'C') {
				$temp_unit1 = $unit[$index+0];
				$temp_unit2 = $unit[$index+1];
				$temp_unit3 = $unit[$index+2];
				$temp_unit4 = $unit[$index+3];
				mysql_query("INSERT INTO GAMEPOSITION (USERNO, GAMENO, POSITION, UNIT) VALUES ('$account', '$gameno', $index+1, '$temp_unit1')");
				mysql_query("INSERT INTO GAMEPOSITION (USERNO, GAMENO, POSITION, UNIT) VALUES ('$account', '$gameno', $index+2, '$temp_unit2')");
				mysql_query("INSERT INTO GAMEPOSITION (USERNO, GAMENO, POSITION, UNIT) VALUES ('$account', '$gameno', $index+3, '$temp_unit3')");
				mysql_query("INSERT INTO GAMEPOSITION (USERNO, GAMENO, POSITION, UNIT) VALUES ('$account', '$gameno', $index+4, '$temp_unit4')");
			}
			mysql_query("INSERT INTO GAMESTATE (USERNO, GAMENO, PLAYNO, SYSTEMPLAYNO, ABOVE, BELOW) VALUES ('$account', '$gameno', $game, $game, $index+1, $index+2)");
			mysql_query("INSERT INTO GAMESTATE (USERNO, GAMENO, PLAYNO, SYSTEMPLAYNO, ABOVE, BELOW) VALUES ('$account', '$gameno', $game+1, $game+1, $index+3, $index+4)");
			mysql_query("INSERT INTO GAMESTATE (USERNO, GAMENO, PLAYNO, SYSTEMPLAYNO, ABOVE, BELOW) VALUES ('$account', '$gameno', $gap+$game, $gap+$game, $index+1, $index+3)");
			mysql_query("INSERT INTO GAMESTATE (USERNO, GAMENO, PLAYNO, SYSTEMPLAYNO, ABOVE, BELOW) VALUES ('$account', '$gameno', $gap+$game+1, $gap+$game+1, $index+2, $index+4)");
			mysql_query("INSERT INTO GAMESTATE (USERNO, GAMENO, PLAYNO, SYSTEMPLAYNO, ABOVE, BELOW) VALUES ('$account', '$gameno', $gap+$gap+$game, $gap+$gap+$game, $index+1, $index+4)");
			mysql_query("INSERT INTO GAMESTATE (USERNO, GAMENO, PLAYNO, SYSTEMPLAYNO, ABOVE, BELOW) VALUES ('$account', '$gameno', $gap+$gap+$game+1, $gap+$gap+$game+1, $index+2, $index+3)");
			$index += 4;
			$game += 2;
		}
		for ($i = 1; $i <= $distribute['3_1']; $i++) {
			if ($playtype == 'A') {
				$temp_unit1 = $unit[$index+0];
				$temp_unit2 = $unit[$index+1];
				$temp_unit3 = $unit[$index+2];
				$temp_name1 = $name[$index+0];
				$temp_name2 = $name[$index+1];
				$temp_name3 = $name[$index+2];
				mysql_query("INSERT INTO GAMEPOSITION (USERNO, GAMENO, POSITION, UNIT, NAME) VALUES ('$account', '$gameno', $index+1, '$temp_unit1', '$temp_name1')");
				mysql_query("INSERT INTO GAMEPOSITION (USERNO, GAMENO, POSITION, UNIT, NAME) VALUES ('$account', '$gameno', $index+2, '$temp_unit2', '$temp_name2')");
				mysql_query("INSERT INTO GAMEPOSITION (USERNO, GAMENO, POSITION, UNIT, NAME) VALUES ('$account', '$gameno', $index+3, '$temp_unit3', '$temp_name3')");
			}
			elseif ($playtype == 'B') {
				$temp_unit1u = $unitu[$index+0];
				$temp_unit1d = $unitd[$index+0];
				$temp_unit2u = $unitu[$index+1];
				$temp_unit2d = $unitd[$index+1];
				$temp_unit3u = $unitu[$index+2];
				$temp_unit3d = $unitd[$index+2];
				$temp_name1u = $nameu[$index+0];
				$temp_name1d = $named[$index+0];
				$temp_name2u = $nameu[$index+1];
				$temp_name2d = $named[$index+1];
				$temp_name3u = $nameu[$index+2];
				$temp_name3d = $named[$index+2];
				mysql_query("INSERT INTO GAMEPOSITION (USERNO, GAMENO, POSITION, PLAYERNO, UNIT, NAME) VALUES ('$account', '$gameno', $index+1, '1', '$temp_unit1u', '$temp_name1u')");
				mysql_query("INSERT INTO GAMEPOSITION (USERNO, GAMENO, POSITION, PLAYERNO, UNIT, NAME) VALUES ('$account', '$gameno', $index+1, '2', '$temp_unit1d', '$temp_name1d')");
				mysql_query("INSERT INTO GAMEPOSITION (USERNO, GAMENO, POSITION, PLAYERNO, UNIT, NAME) VALUES ('$account', '$gameno', $index+2, '1', '$temp_unit2u', '$temp_name2u')");
				mysql_query("INSERT INTO GAMEPOSITION (USERNO, GAMENO, POSITION, PLAYERNO, UNIT, NAME) VALUES ('$account', '$gameno', $index+2, '2', '$temp_unit2d', '$temp_name2d')");
				mysql_query("INSERT INTO GAMEPOSITION (USERNO, GAMENO, POSITION, PLAYERNO, UNIT, NAME) VALUES ('$account', '$gameno', $index+3, '1', '$temp_unit3u', '$temp_name3u')");
				mysql_query("INSERT INTO GAMEPOSITION (USERNO, GAMENO, POSITION, PLAYERNO, UNIT, NAME) VALUES ('$account', '$gameno', $index+3, '2', '$temp_unit3d', '$temp_name3d')");
			}
			elseif ($playtype == 'C') {
				$temp_unit1 = $unit[$index+0];
				$temp_unit2 = $unit[$index+1];
				$temp_unit3 = $unit[$index+2];
				mysql_query("INSERT INTO GAMEPOSITION (USERNO, GAMENO, POSITION, UNIT) VALUES ('$account', '$gameno', $index+1, '$temp_unit1')");
				mysql_query("INSERT INTO GAMEPOSITION (USERNO, GAMENO, POSITION, UNIT) VALUES ('$account', '$gameno', $index+2, '$temp_unit2')");
				mysql_query("INSERT INTO GAMEPOSITION (USERNO, GAMENO, POSITION, UNIT) VALUES ('$account', '$gameno', $index+3, '$temp_unit3')");
			}
			mysql_query("INSERT INTO GAMESTATE (USERNO, GAMENO, PLAYNO, SYSTEMPLAYNO, ABOVE, BELOW) VALUES ('$account', '$gameno', $game, $game, $index+1, $index+2)");
			mysql_query("INSERT INTO GAMESTATE (USERNO, GAMENO, PLAYNO, SYSTEMPLAYNO, ABOVE, BELOW) VALUES ('$account', '$gameno', $gap+$game, $gap+$game, $index+1, $index+3)");
			mysql_query("INSERT INTO GAMESTATE (USERNO, GAMENO, PLAYNO, SYSTEMPLAYNO, ABOVE, BELOW) VALUES ('$account', '$gameno', $gap+$gap+$game, $gap+$gap+$game, $index+2, $index+3)");
			$index += 3;
			$game++;
		}
		for ($i = 1; $i <= $distribute['3_2']; $i++) {
			if ($playtype == 'A') {
				$temp_unit1 = $unit[$index+0];
				$temp_unit2 = $unit[$index+1];
				$temp_unit3 = $unit[$index+2];
				$temp_name1 = $name[$index+0];
				$temp_name2 = $name[$index+1];
				$temp_name3 = $name[$index+2];
				mysql_query("INSERT INTO GAMEPOSITION (USERNO, GAMENO, POSITION, UNIT, NAME) VALUES ('$account', '$gameno', $index+1, '$temp_unit1', '$temp_name1')");
				mysql_query("INSERT INTO GAMEPOSITION (USERNO, GAMENO, POSITION, UNIT, NAME) VALUES ('$account', '$gameno', $index+2, '$temp_unit2', '$temp_name2')");
				mysql_query("INSERT INTO GAMEPOSITION (USERNO, GAMENO, POSITION, UNIT, NAME) VALUES ('$account', '$gameno', $index+3, '$temp_unit3', '$temp_name3')");
			}
			elseif ($playtype == 'B') {
				$temp_unit1u = $unitu[$index+0];
				$temp_unit1d = $unitd[$index+0];
				$temp_unit2u = $unitu[$index+1];
				$temp_unit2d = $unitd[$index+1];
				$temp_unit3u = $unitu[$index+2];
				$temp_unit3d = $unitd[$index+2];
				$temp_name1u = $nameu[$index+0];
				$temp_name1d = $named[$index+0];
				$temp_name2u = $nameu[$index+1];
				$temp_name2d = $named[$index+1];
				$temp_name3u = $nameu[$index+2];
				$temp_name3d = $named[$index+2];
				mysql_query("INSERT INTO GAMEPOSITION (USERNO, GAMENO, POSITION, PLAYERNO, UNIT, NAME) VALUES ('$account', '$gameno', $index+1, '1', '$temp_unit1u', '$temp_name1u')");
				mysql_query("INSERT INTO GAMEPOSITION (USERNO, GAMENO, POSITION, PLAYERNO, UNIT, NAME) VALUES ('$account', '$gameno', $index+1, '2', '$temp_unit1d', '$temp_name1d')");
				mysql_query("INSERT INTO GAMEPOSITION (USERNO, GAMENO, POSITION, PLAYERNO, UNIT, NAME) VALUES ('$account', '$gameno', $index+2, '1', '$temp_unit2u', '$temp_name2u')");
				mysql_query("INSERT INTO GAMEPOSITION (USERNO, GAMENO, POSITION, PLAYERNO, UNIT, NAME) VALUES ('$account', '$gameno', $index+2, '2', '$temp_unit2d', '$temp_name2d')");
				mysql_query("INSERT INTO GAMEPOSITION (USERNO, GAMENO, POSITION, PLAYERNO, UNIT, NAME) VALUES ('$account', '$gameno', $index+3, '1', '$temp_unit3u', '$temp_name3u')");
				mysql_query("INSERT INTO GAMEPOSITION (USERNO, GAMENO, POSITION, PLAYERNO, UNIT, NAME) VALUES ('$account', '$gameno', $index+3, '2', '$temp_unit3d', '$temp_name3d')");
			}
			elseif ($playtype == 'C') {
				$temp_unit1 = $unit[$index+0];
				$temp_unit2 = $unit[$index+1];
				$temp_unit3 = $unit[$index+2];
				mysql_query("INSERT INTO GAMEPOSITION (USERNO, GAMENO, POSITION, UNIT) VALUES ('$account', '$gameno', $index+1, '$temp_unit1')");
				mysql_query("INSERT INTO GAMEPOSITION (USERNO, GAMENO, POSITION, UNIT) VALUES ('$account', '$gameno', $index+2, '$temp_unit2')");
				mysql_query("INSERT INTO GAMEPOSITION (USERNO, GAMENO, POSITION, UNIT) VALUES ('$account', '$gameno', $index+3, '$temp_unit3')");
			}
			mysql_query("INSERT INTO GAMESTATE (USERNO, GAMENO, PLAYNO, SYSTEMPLAYNO, ABOVE, BELOW) VALUES ('$account', '$gameno', $game, $game, $index+1, $index+2)");
			mysql_query("INSERT INTO GAMESTATE (USERNO, GAMENO, PLAYNO, SYSTEMPLAYNO, ABOVE, BELOW) VALUES ('$account', '$gameno', $gap+$game, $gap+$game, $index+1, $index+3)");
			mysql_query("INSERT INTO GAMESTATE (USERNO, GAMENO, PLAYNO, SYSTEMPLAYNO, ABOVE, BELOW) VALUES ('$account', '$gameno', $gap+$gap+$game, $gap+$gap+$game, $index+2, $index+3)");
			$index += 3;
			$game++;
		}
		for ($i = 1; $i <= $distribute['round']; $i++) {
			mysql_query("INSERT INTO GAMESTATE (USERNO, GAMENO, PLAYNO, SYSTEMPLAYNO) VALUES ('$account', '$gameno', 3*$gap+$i, 3*$gap+$i)");
		}
		makePublic($account, $gameno);
		makeEdit($account, $gameno);
		echo json_encode(array('message' => 'Success', 'host' => $account, 'gameno' => $gameno));
		unlink($account.'/'.$gameno."/assign.html");
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