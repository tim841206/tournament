<?php
include_once("resource/database.php");
include_once("resource/custom.php");

$mode = $_POST['mode'];
$amount = $_POST['amount'];
$gameno = $_POST['gameno'];
$gamenm = $_POST['gamenm'];
$unit = explode(',', $_POST['unit']);
$name = explode(',', $_POST['name']);
$sql = mysql_query("SELECT * FROM GAMEMAIN WHERE GAMENO='$gameno'");
$fetch = mysql_num_rows($sql);
if (empty($gameno)) {
	echo json_encode(array('message' => 'Empty game index'));
}
elseif (empty($gamenm)) {
	echo json_encode(array('message' => 'Empty game name'));
}
elseif (!is_validAmount($amount)) {
	echo json_encode(array('message' => 'Invalid player amount'));
}
elseif ($fetch != 0) {
	echo json_encode(array('message' => 'Occupied game index'));
}
else {
	date_default_timezone_set('Asia/Taipei');
	$date = date("Y-m-d H:i:s");
	mysql_query("INSERT INTO GAMEMAIN (GAMENO, GAMENM, AMOUNT, CREATEDATE, UPDATEDATE) VALUES ('$gameno', '$gamenm', '$amount', '$date', '$date')");
	$roundAmount = pow(2, ceil(log($amount, 2)));
	if ($mode == 'auto') {
		$rand = array();
		for ($i = 0; $i < $amount; $i++) {
			array_push($rand, $i);
		}
		shuffle($rand);
		$arrange = array();
		if ($roundAmount == 16) {
			$order16 = [8,9,1,16,5,12,4,13];
			$arrange = array_slice($order16, 0, $roundAmount-$amount);
		}
		elseif ($roundAmount == 32) {
			$order32 = [16,17,1,31,9,24,8,25,13,20,4,29,12,21,5,28];
			$arrange = array_slice($order32, 0, $roundAmount-$amount);
		}
		elseif ($roundAmount == 64) {
			$order64 = [32,33,1,64,17,48,16,49,25,40,8,57,24,41,9,56,29,36,4,61,20,45,13,52,28,37,5,60,21,44,12,53];
			$arrange = array_slice($order64, 0, $roundAmount-$amount);
		}
		elseif ($roundAmount == 128) {
			$order128 = [64,65,1,128,33,96,32,97,49,80,16,113,48,81,17,112,57,72,8,121,40,89,25,104,56,73,9,120,41,88,24,105,61,68,4,125,36,93,29,100,53,76,12,117,44,85,21,108,60,69,5,124,37,92,28,101,52,77,13,116,45,84,20,109];
			$arrange = array_slice($order128, 0, $roundAmount-$amount);
		}
		for ($i = 1; $i <= $roundAmount; $i++) {
			if (in_array($i, $arrange)) {
				mysql_query("INSERT INTO GAMEPOSITION (GAMENO, POSITION, UNIT, NAME) VALUES ('$gameno', '$i', 'none', 'none')");
			}
			else {
				$temp = array_pop($rand);
				$temp_unit = $unit[$temp];
				$temp_name = $name[$temp];
				mysql_query("INSERT INTO GAMEPOSITION (GAMENO, POSITION, UNIT, NAME) VALUES ('$gameno', '$i', '$temp_unit', '$temp_name')");
			}
		}
		// process chart
		if (!is_dir($gameno)) {
			mkdir($gameno);
		}
		if ($amount > 8 && $amount <= 16) {
			createGameState(16, $gameno);
			$index = 1;
			for ($i = 1; $i <= 8; $i++) {
				$single = queryPosition($gameno, $i*2-1);
				$double = queryPosition($gameno, $i*2);
				if ($single['unit'] != 'none' && $double['unit'] != 'none') {
					mysql_query("UPDATE GAMESTATE SET PLAYNO='$index' WHERE GAMENO='$gameno' AND SYSTEMPLAYNO=$i");
					$index++;
				}
			}
			for ($i = 9; $i <= 15; $i++) {
				mysql_query("UPDATE GAMESTATE SET PLAYNO='$index' WHERE GAMENO='$gameno' AND SYSTEMPLAYNO=$i");
				$index++;
			}
			makePublic($gameno);
			makeEdit($gameno);
			clearBye($gameno);
			echo json_encode(array('message' => 'Success', 'gameno' => $gameno));
		}
		elseif ($amount > 16 && $amount <= 32) {
			createGameState(32, $gameno);
			$index = 1;
			for ($i = 1; $i <= 16; $i++) {
				$single = queryPosition($gameno, $i*2-1);
				$double = queryPosition($gameno, $i*2);
				if ($single['unit'] != 'none' && $double['unit'] != 'none') {
					mysql_query("UPDATE GAMESTATE SET PLAYNO='$index' WHERE GAMENO='$gameno' AND SYSTEMPLAYNO=$i");
					$index++;
				}
			}
			for ($i = 17; $i <= 31; $i++) {
				mysql_query("UPDATE GAMESTATE SET PLAYNO='$index' WHERE GAMENO='$gameno' AND SYSTEMPLAYNO=$i");
				$index++;
			}
			makePublic($gameno);
			makeEdit($gameno);
			clearBye($gameno);
			echo json_encode(array('message' => 'Success', 'gameno' => $gameno));
		}
		elseif ($amount > 32 && $amount <= 64) {
			createGameState(64, $gameno);
			$index = 1;
			for ($i = 1; $i <= 32; $i++) {
				$single = queryPosition($gameno, $i*2-1);
				$double = queryPosition($gameno, $i*2);
				if ($single['unit'] != 'none' && $double['unit'] != 'none') {
					mysql_query("UPDATE GAMESTATE SET PLAYNO='$index' WHERE GAMENO='$gameno' AND SYSTEMPLAYNO=$i");
					$index++;
				}
			}
			for ($i = 33; $i <= 63; $i++) {
				mysql_query("UPDATE GAMESTATE SET PLAYNO='$index' WHERE GAMENO='$gameno' AND SYSTEMPLAYNO=$i");
				$index++;
			}
			makePublic($gameno);
			makeEdit($gameno);
			clearBye($gameno);
			echo json_encode(array('message' => 'Success', 'gameno' => $gameno));
		}
		elseif ($amount > 64 && $amount <= 128) {
			createGameState(128, $gameno);
			$index = 1;
			for ($i = 1; $i <= 64; $i++) {
				$single = queryPosition($gameno, $i*2-1);
				$double = queryPosition($gameno, $i*2);
				if ($single['unit'] != 'none' && $double['unit'] != 'none') {
					mysql_query("UPDATE GAMESTATE SET PLAYNO='$index' WHERE GAMENO='$gameno' AND SYSTEMPLAYNO=$i");
					$index++;
				}
			}
			for ($i = 65; $i <= 127; $i++) {
				mysql_query("UPDATE GAMESTATE SET PLAYNO='$index' WHERE GAMENO='$gameno' AND SYSTEMPLAYNO=$i");
				$index++;
			}
			makePublic($gameno);
			makeEdit($gameno);
			clearBye($gameno);
			echo json_encode(array('message' => 'Success', 'gameno' => $gameno));
		}
	}
	elseif ($mode == 'enter') {
		for ($i = 1; $i <= $roundAmount; $i++) {
			$temp_unit = $unit[$i-1];
			$temp_name = $name[$i-1];
			mysql_query("INSERT INTO GAMEPOSITION (GAMENO, POSITION, UNIT, NAME) VALUES ('$gameno', '$i', '$temp_unit', '$temp_name')");
		}
		// process chart
		if ($amount > 8 && $amount <= 16) {
			createGameState(16, $gameno);
			$index = 1;
			for ($i = 1; $i <= 8; $i++) {
				$single = queryPosition($gameno, $i*2-1);
				$double = queryPosition($gameno, $i*2);
				if ($single['unit'] != 'none' && $double['unit'] != 'none') {
					mysql_query("UPDATE GAMESTATE SET PLAYNO='$index' WHERE GAMENO='$gameno' AND SYSTEMPLAYNO=$i");
					$index++;
				}
			}
			for ($i = 9; $i <= 15; $i++) {
				mysql_query("UPDATE GAMESTATE SET PLAYNO='$index' WHERE GAMENO='$gameno' AND SYSTEMPLAYNO=$i");
				$index++;
			}
			makePublic($gameno);
			makeEdit($gameno);
			clearBye($gameno);
			echo json_encode(array('message' => 'Success', 'gameno' => $gameno));
		}
		elseif ($amount > 16 && $amount <= 32) {
			createGameState(32, $gameno);
			$index = 1;
			for ($i = 1; $i <= 16; $i++) {
				$single = queryPosition($gameno, $i*2-1);
				$double = queryPosition($gameno, $i*2);
				if ($single['unit'] != 'none' && $double['unit'] != 'none') {
					mysql_query("UPDATE GAMESTATE SET PLAYNO='$index' WHERE GAMENO='$gameno' AND SYSTEMPLAYNO=$i");
					$index++;
				}
			}
			for ($i = 17; $i <= 31; $i++) {
				mysql_query("UPDATE GAMESTATE SET PLAYNO='$index' WHERE GAMENO='$gameno' AND SYSTEMPLAYNO=$i");
				$index++;
			}
			makePublic($gameno);
			makeEdit($gameno);
			clearBye($gameno);
			echo json_encode(array('message' => 'Success', 'gameno' => $gameno));
		}
		elseif ($amount > 32 && $amount <= 64) {
			createGameState(64, $gameno);
			$index = 1;
			for ($i = 1; $i <= 32; $i++) {
				$single = queryPosition($gameno, $i*2-1);
				$double = queryPosition($gameno, $i*2);
				if ($single['unit'] != 'none' && $double['unit'] != 'none') {
					mysql_query("UPDATE GAMESTATE SET PLAYNO='$index' WHERE GAMENO='$gameno' AND SYSTEMPLAYNO=$i");
					$index++;
				}
			}
			for ($i = 33; $i <= 63; $i++) {
				mysql_query("UPDATE GAMESTATE SET PLAYNO='$index' WHERE GAMENO='$gameno' AND SYSTEMPLAYNO=$i");
				$index++;
			}
			makePublic($gameno);
			makeEdit($gameno);
			clearBye($gameno);
			echo json_encode(array('message' => 'Success', 'gameno' => $gameno));
		}
		elseif ($amount > 64 && $amount <= 128) {
			createGameState(128, $gameno);
			$index = 1;
			for ($i = 1; $i <= 64; $i++) {
				$single = queryPosition($gameno, $i*2-1);
				$double = queryPosition($gameno, $i*2);
				if ($single['unit'] != 'none' && $double['unit'] != 'none') {
					mysql_query("UPDATE GAMESTATE SET PLAYNO='$index' WHERE GAMENO='$gameno' AND SYSTEMPLAYNO=$i");
					$index++;
				}
			}
			for ($i = 65; $i <= 127; $i++) {
				mysql_query("UPDATE GAMESTATE SET PLAYNO='$index' WHERE GAMENO='$gameno' AND SYSTEMPLAYNO=$i");
				$index++;
			}
			makePublic($gameno);
			makeEdit($gameno);
			clearBye($gameno);
			echo json_encode(array('message' => 'Success', 'gameno' => $gameno));
		}
		unlink($gameno . "/assign.html");
	}
}

function is_validAmount($amount) {
	if ((ceil($amount) == floor($amount)) && $amount >= 9 && $amount <= 64) {
		return true;
	}
	else {
		return false;
	}
}