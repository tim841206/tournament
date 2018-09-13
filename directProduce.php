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
$sql = mysqli_query($mysql, "SELECT * FROM GAMEMAIN WHERE USERNO='$account' AND GAMENO='$gameno'");
if (empty($gameno)) {
	echo json_encode(array('message' => 'Empty game index'));
}
elseif (empty($gamenm)) {
	echo json_encode(array('message' => 'Empty game name'));
}
elseif (!is_validAmount($amount)) {
	echo json_encode(array('message' => 'Invalid player amount'));
}
elseif (mysqli_num_rows($sql) != 0) {
	echo json_encode(array('message' => 'Used game index'));
}
elseif (!in_array($playtype, array('A', 'B', 'C'))) {
	echo json_encode(array('message' => 'Unknown play type'));
}
else {
	date_default_timezone_set('Asia/Taipei');
	$date = date("Y-m-d H:i:s");
	mysqli_query($mysql, "INSERT INTO GAMEMAIN (USERNO, GAMENO, GAMENM, GAMETYPE, PLAYTYPE, AMOUNT, CREATEDATE, UPDATEDATE) VALUES ('$account', '$gameno', '$gamenm', 'A', '$playtype', '$amount', '$date', '$date')");
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
				mysqli_query($mysql, "INSERT INTO GAMEPOSITION (USERNO, GAMENO, POSITION, UNIT, NAME) VALUES ('$account', '$gameno', '$i', 'none', 'none')");
			}
			else {
				$temp = array_pop($rand);
				if ($playtype == 'A') {
					$temp_unit = $unit[$temp];
					$temp_name = $name[$temp];
					mysqli_query($mysql, "INSERT INTO GAMEPOSITION (USERNO, GAMENO, POSITION, UNIT, NAME) VALUES ('$account', '$gameno', '$i', '$temp_unit', '$temp_name')");
				}
				elseif ($playtype == 'B') {
					$temp_unitu = $unitu[$temp];
					$temp_unitd = $unitd[$temp];
					$temp_nameu = $nameu[$temp];
					$temp_named = $named[$temp];
					mysqli_query($mysql, "INSERT INTO GAMEPOSITION (USERNO, GAMENO, POSITION, PLAYERNO, UNIT, NAME) VALUES ('$account', '$gameno', '$i', '1', '$temp_unitu', '$temp_nameu')");
					mysqli_query($mysql, "INSERT INTO GAMEPOSITION (USERNO, GAMENO, POSITION, PLAYERNO, UNIT, NAME) VALUES ('$account', '$gameno', '$i', '2', '$temp_unitd', '$temp_named')");
				}
				elseif ($playtype == 'C') {
					$temp_unit = $unit[$temp];
					mysqli_query($mysql, "INSERT INTO GAMEPOSITION (USERNO, GAMENO, POSITION, UNIT) VALUES ('$account', '$gameno', '$i', '$temp_unit')");
				}
			}
		}
		if (!is_dir($account.'/'.$gameno)) {
			mkdir($account.'/'.$gameno);
		}
		createGameState($account, $gameno, $roundAmount);
		$index = 1;
		for ($i = 1; $i <= $roundAmount/2; $i++) {
			if ($playtype == 'A') {
				$single = queryContentSingle($account, $gameno, $i*2-1);
				$double = queryContentSingle($account, $gameno, $i*2);
				if ($single['unit'] != 'none' && $double['unit'] != 'none') {
					mysqli_query($mysql, "UPDATE GAMESTATE SET PLAYNO='$index' WHERE USERNO='$account' AND GAMENO='$gameno' AND SYSTEMPLAYNO=$i");
					$index++;
				}
			}
			elseif ($playtype == 'B') {
				$single = queryContentDouble($account, $gameno, $i*2-1);
				$double = queryContentDouble($account, $gameno, $i*2);
				if ($single['unitu'] != 'none' && $double['unitu'] != 'none') {
					mysqli_query($mysql, "UPDATE GAMESTATE SET PLAYNO='$index' WHERE USERNO='$account' AND GAMENO='$gameno' AND SYSTEMPLAYNO=$i");
					$index++;
				}
			}
			elseif ($playtype == 'C') {
				$single = queryContentGroup($account, $gameno, $i*2-1);
				$double = queryContentGroup($account, $gameno, $i*2);
				if ($single != 'none' && $double != 'none') {
					mysqli_query($mysql, "UPDATE GAMESTATE SET PLAYNO='$index' WHERE USERNO='$account' AND GAMENO='$gameno' AND SYSTEMPLAYNO=$i");
					$index++;
				}
			}
		}
		for ($i = $roundAmount/2+1; $i <= $roundAmount; $i++) {
			mysqli_query($mysql, "UPDATE GAMESTATE SET PLAYNO='$index' WHERE USERNO='$account' AND GAMENO='$gameno' AND SYSTEMPLAYNO=$i");
			$index++;
		}
		makePublic($account, $gameno);
		makeEdit($account, $gameno);
		clearBye($account, $gameno);
		echo json_encode(array('message' => 'Success', 'host' => $account, 'gameno' => $gameno));
		makeGame($account, $gameno);
	}
	elseif ($mode == 'enter') {
		for ($i = 1; $i <= $roundAmount; $i++) {
			if ($playtype == 'A') {
				$temp_unit = $unit[$i-1];
				$temp_name = $name[$i-1];
				mysqli_query($mysql, "INSERT INTO GAMEPOSITION (USERNO, GAMENO, POSITION, UNIT, NAME) VALUES ('$account', '$gameno', '$i', '$temp_unit', '$temp_name')");
			}
			elseif ($playtype == 'B') {
				$temp_unitu = $unitu[$i-1];
				$temp_nameu = $nameu[$i-1];
				$temp_unitd = $unitd[$i-1];
				$temp_named = $named[$i-1];
				mysqli_query($mysql, "INSERT INTO GAMEPOSITION (USERNO, GAMENO, POSITION, PLAYERNO, UNIT, NAME) VALUES ('$account', '$gameno', '$i', '1', '$temp_unitu', '$temp_nameu')");
				mysqli_query($mysql, "INSERT INTO GAMEPOSITION (USERNO, GAMENO, POSITION, PLAYERNO, UNIT, NAME) VALUES ('$account', '$gameno', '$i', '2', '$temp_unitd', '$temp_named')");
			}
			elseif ($playtype == 'C') {
				$temp_unit = $unit[$i-1];
				mysqli_query($mysql, "INSERT INTO GAMEPOSITION (USERNO, GAMENO, POSITION, UNIT) VALUES ('$account', '$gameno', '$i', '$temp_unit')");
			}
		}
		createGameState($account, $gameno, $roundAmount);
		$index = 1;
		for ($i = 1; $i <= $roundAmount/2; $i++) {
			if ($playtype == 'A') {
				$single = queryContentSingle($account, $gameno, $i*2-1);
				$double = queryContentSingle($account, $gameno, $i*2);
				if ($single['unit'] != 'none' && $double['unit'] != 'none') {
					mysqli_query($mysql, "UPDATE GAMESTATE SET PLAYNO='$index' WHERE USERNO='$account' AND GAMENO='$gameno' AND SYSTEMPLAYNO=$i");
					$index++;
				}
			}
			elseif ($playtype == 'B') {
				$single = queryContentDouble($account, $gameno, $i*2-1);
				$double = queryContentDouble($account, $gameno, $i*2);
				if ($single['unitu'] != 'none' && $double['unitu'] != 'none') {
					mysqli_query($mysql, "UPDATE GAMESTATE SET PLAYNO='$index' WHERE USERNO='$account' AND GAMENO='$gameno' AND SYSTEMPLAYNO=$i");
					$index++;
				}
			}
			elseif ($playtype == 'C') {
				$single = queryContentGroup($account, $gameno, $i*2-1);
				$double = queryContentGroup($account, $gameno, $i*2);
				if ($single != 'none' && $double != 'none') {
					mysqli_query($mysql, "UPDATE GAMESTATE SET PLAYNO='$index' WHERE USERNO='$account' AND GAMENO='$gameno' AND SYSTEMPLAYNO=$i");
					$index++;
				}
			}
		}
		for ($i = $roundAmount/2+1; $i <= $roundAmount; $i++) {
			mysqli_query($mysql, "UPDATE GAMESTATE SET PLAYNO='$index' WHERE USERNO='$account' AND GAMENO='$gameno' AND SYSTEMPLAYNO=$i");
			$index++;
		}
		makePublic($account, $gameno);
		makeEdit($account, $gameno);
		clearBye($account, $gameno);
		echo json_encode(array('message' => 'Success', 'host' => $account, 'gameno' => $gameno));
		unlink($account.'/'.$gameno."/assign.html");
		makeGame($account, $gameno);
	}
}

function is_validAmount($amount) {
	if ((ceil($amount) == floor($amount)) && $amount >= 4 && $amount <= 128) {
		return true;
	}
	else {
		return false;
	}
}