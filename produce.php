<?php
include_once("resource/database.php");

$mode = $_POST['mode'];
$amount = $_POST['amount'];
$gameno = $_POST['gameno'];
$unit = explode(',', $_POST['unit']);
$name = explode(',', $_POST['name']);
if (!is_validAmount($amount)) {
	echo json_encode(array('message' => 'Invalid player amount'));
}
else {
	mysql_query("INSERT INTO GAMEMAIN (GAMENO, AMOUNT) VALUES ('$gameno', '$amount')");
	if ($mode == 'auto') {
		// process data
		$rand = array();
		for ($i = 0; $i < $amount; $i++) {
			array_push($rand, $i);
		}
		shuffle($rand);
		$arrange = array();
		$arrange['9'] = [1,4,5,8,9,12,16];
		$arrange['10'] = [1,5,8,9,12,16];
		$arrange['11'] = [1,5,8,9,16];
		$arrange['12'] = [1,8,9,16];
		$arrange['13'] = [1,8,9];
		$arrange['14'] = [8,9];
		$arrange['15'] = [8];
		$arrange['16'] = [];
		$arrange['17'] = [1,4,5,8,9,12,13,16,17,20,21,24,25,28,32];
		$arrange['18'] = [1,5,8,9,12,13,16,17,20,21,24,25,28,32];
		$arrange['19'] = [1,5,8,9,12,13,16,17,20,24,25,28,32];
		$arrange['20'] = [1,5,8,9,13,16,17,20,24,25,28,32];
		$arrange['21'] = [1,5,8,9,13,16,17,20,24,25,32];
		$arrange['22'] = [1,8,9,13,16,17,20,24,25,32];
		$arrange['23'] = [1,8,9,13,16,17,24,25,32];
		$arrange['24'] = [1,8,9,16,17,24,25,32];
		$arrange['25'] = [1,8,9,16,17,24,32];
		$arrange['26'] = [1,9,16,17,24,32];
		$arrange['27'] = [1,9,16,17,32];
		$arrange['28'] = [1,16,17,32];
		$arrange['29'] = [1,16,17];
		$arrange['30'] = [16,17];
		$arrange['31'] = [16];
		$arrange['32'] = [];
		$arrange['33'] = [1,4,5,8,9,12,13,16,17,20,21,24,25,28,29,32,33,36,37,40,41,44,45,48,49,52,56,57,60,61,64];
		$arrange['34'] = [1,4,5,8,9,13,16,17,20,21,24,25,28,29,32,33,36,37,40,41,44,45,48,49,52,56,57,60,61,64];
		$arrange['35'] = [1,4,5,8,9,13,16,17,20,21,24,25,28,29,32,33,36,37,40,41,44,48,49,52,56,57,60,61,64];
		$arrange['36'] = [1,4,5,8,9,13,16,17,21,24,25,28,29,32,33,36,37,40,41,44,48,49,52,56,57,60,61,64];
		$arrange['37'] = [1,4,5,8,9,13,16,17,21,24,25,28,29,32,33,36,37,40,41,44,48,49,52,56,57,60,64];
		$arrange['38'] = [1,5,8,9,13,16,17,21,24,25,28,29,32,33,36,37,40,41,44,48,49,52,56,57,60,64];
		$arrange['39'] = [1,5,8,9,13,16,17,21,24,25,28,29,32,33,36,40,41,44,48,49,52,56,57,60,64];
		$arrange['40'] = [1,5,8,9,13,16,17,21,24,25,29,32,33,36,40,41,44,48,49,52,56,57,60,64];
		$arrange['41'] = [1,5,8,9,13,16,17,21,24,25,29,32,33,36,40,41,44,48,49,56,57,60,64];
		$arrange['42'] = [1,5,8,9,16,17,21,24,25,29,32,33,36,40,41,44,48,49,56,57,60,64];
		$arrange['43'] = [1,5,8,9,16,17,21,24,25,29,32,33,36,40,41,48,49,56,57,60,64];
		$arrange['44'] = [1,5,8,9,16,17,24,25,29,32,33,36,40,41,48,49,56,57,60,64];
		$arrange['45'] = [1,5,8,9,16,17,24,25,29,32,33,36,40,41,48,49,56,57,64];
		$arrange['46'] = [1,8,9,16,17,24,25,29,32,33,36,40,41,48,49,56,57,64];
		$arrange['47'] = [1,8,9,16,17,24,25,29,32,33,40,41,48,49,56,57,64];
		$arrange['48'] = [1,8,9,16,17,24,25,32,33,40,41,48,49,56,57,64];
		$arrange['49'] = [1,8,9,16,17,24,25,32,33,40,41,48,49,56,64];
		$arrange['50'] = [1,9,16,17,24,25,32,33,40,41,48,49,56,64];
		$arrange['51'] = [1,9,16,17,24,25,32,33,40,48,49,56,64];
		$arrange['52'] = [1,9,16,17,25,32,33,40,48,49,56,64];
		$arrange['53'] = [1,9,16,17,25,32,33,40,48,49,64];
		$arrange['54'] = [1,16,17,25,32,33,40,48,49,64];
		$arrange['55'] = [1,16,17,25,32,33,48,49,64];
		$arrange['56'] = [1,16,17,32,33,48,49,64];
		$arrange['57'] = [1,16,17,32,33,48,64];
		$arrange['58'] = [1,17,32,33,48,64];
		$arrange['59'] = [1,17,32,33,64];
		$arrange['60'] = [1,32,33,64];
		$arrange['61'] = [1,32,33];
		$arrange['62'] = [32,33];
		$arrange['63'] = [32];
		$arrange['64'] = [];
		if ($amount > 8 && $amount <= 16) {
			for ($i = 1; $i <= 16; $i++) {
				if (in_array($i, $arrange[$amount])) {
					mysql_query("INSERT INTO GAMEPOSITION (GAMENO, POSITION, UNIT, NAME) VALUES ('$gameno', '$i', 'none', 'none')");
				}
				else {
					$temp = array_pop($rand);
					$temp_unit = $unit[$temp];
					$temp_name = $name[$temp];
					mysql_query("INSERT INTO GAMEPOSITION (GAMENO, POSITION, UNIT, NAME) VALUES ('$gameno', '$i', '$temp_unit', '$temp_name')");
				}
			}
		}
		elseif ($amount > 16 && $amount <= 32) {
			for ($i = 1; $i <= 32; $i++) {
				if (in_array($i, $arrange[$amount])) {
					mysql_query("INSERT INTO GAMEPOSITION (GAMENO, POSITION, UNIT, NAME) VALUES ('$gameno', '$i', 'none', 'none')");
				}
				else {
					$temp_unit = $unit[array_pop($rand)];
					$temp_name = $name[array_pop($rand)];
					mysql_query("INSERT INTO GAMEPOSITION (GAMENO, POSITION, UNIT, NAME) VALUES ('$gameno', '$i', '$temp_unit', '$temp_name')");
				}
			}
		}
		elseif ($amount > 32 && $amount <= 64) {
			for ($i = 1; $i <= 64; $i++) {
				if (in_array($i, $arrange[$amount])) {
					mysql_query("INSERT INTO GAMEPOSITION (GAMENO, POSITION, UNIT, NAME) VALUES ('$gameno', '$i', 'none', 'none')");
				}
				else {
					$temp_unit = $unit[array_pop($rand)];
					$temp_name = $name[array_pop($rand)];
					mysql_query("INSERT INTO GAMEPOSITION (GAMENO, POSITION, UNIT, NAME) VALUES ('$gameno', '$i', '$temp_unit', '$temp_name')");
				}
			}
		}
		// process public
		$start = '<!DOCTYPE html><html lang="en"><head><meta charset="utf-8"><meta name="viewport" content="width=device-width, initial-scale=1"><title>電子化賽程系統</title><link rel="stylesheet" type="text/css" href="../resource/custom.css"></head><body>';
		$public_content = '<table><tr><td>單位</td><td>名稱</td></tr>';
		$adjust_content = '<script src="../resource/custom.js"></script><table><tr><td>單位</td><td>名稱</td></tr>';
		if ($amount > 8 && $amount <= 16) {
			createGameState(16, $gameno);
			$index = 1;
			for ($i = 1; $i <= 8; $i++) {
				$single = query($gameno, $i*2-1);
				$double = query($gameno, $i*2);
				if ($single['unit'] == 'none') {
					$public_content .= '<tr><td></td><td>Bye</td><td id="p'.($i*4-3).'_1"></td><td id="p'.($i*4-3).'_2"></td><td id="p'.($i*4-3).'_3"></td><td id="p'.($i*4-3).'_4"></td><td id="p'.($i*4-3).'_5"></td></tr><tr><td></td><td></td><td id="p'.($i*4-2).'_1"></td><td id="p'.($i*4-2).'_2"></td><td id="p'.($i*4-2).'_3"></td><td id="p'.($i*4-2).'_4"></td><td id="p'.($i*4-2).'_5"></td></tr><tr><td>'.$double['unit'].'</td><td>'.$double['name'].'</td><td id="p'.($i*4-1).'_1"></td><td id="p'.($i*4-1).'_2"></td><td id="p'.($i*4-1).'_3"></td><td id="p'.($i*4-1).'_4"></td><td id="p'.($i*4-1).'_5"></td></tr><tr><td></td><td></td><td id="p'.($i*4).'_1"></td><td id="p'.($i*4).'_2"></td><td id="p'.($i*4).'_3"></td><td id="p'.($i*4).'_4"></td><td id="p'.($i*4).'_5"></td></tr>';
					$adjust_content .= '<tr><td></td><td>Bye</td><td id="p'.($i*4-3).'_1"></td><td id="p'.($i*4-3).'_2"></td><td id="p'.($i*4-3).'_3"></td><td id="p'.($i*4-3).'_4"></td><td id="p'.($i*4-3).'_5"></td></tr><tr><td></td><td></td><td id="p'.($i*4-2).'_1"></td><td id="p'.($i*4-2).'_2"></td><td id="p'.($i*4-2).'_3"></td><td id="p'.($i*4-2).'_4"></td><td id="p'.($i*4-2).'_5"></td></tr><tr><td>'.$double['unit'].'</td><td>'.$double['name'].'</td><td id="p'.($i*4-1).'_1"></td><td id="p'.($i*4-1).'_2"></td><td id="p'.($i*4-1).'_3"></td><td id="p'.($i*4-1).'_4"></td><td id="p'.($i*4-1).'_5"></td></tr><tr><td></td><td></td><td id="p'.($i*4).'_1"></td><td id="p'.($i*4).'_2"></td><td id="p'.($i*4).'_3"></td><td id="p'.($i*4).'_4"></td><td id="p'.($i*4).'_5"></td></tr>';
				}
				elseif ($double['unit'] == 'none') {
					$public_content .= '<tr><td>'.$single['unit'].'</td><td>'.$single['name'].'</td><td id="p'.($i*4-3).'_1"></td><td id="p'.($i*4-3).'_2"></td><td id="p'.($i*4-3).'_3"></td><td id="p'.($i*4-3).'_4"></td><td id="p'.($i*4-3).'_5"></td></tr><tr><td></td><td></td><td id="p'.($i*4-2).'_1"></td><td id="p'.($i*4-2).'_2"></td><td id="p'.($i*4-2).'_3"></td><td id="p'.($i*4-2).'_4"></td><td id="p'.($i*4-2).'_5"></td></tr><tr><td></td><td>Bye</td><td id="p'.($i*4-1).'_1"></td><td id="p'.($i*4-1).'_2"></td><td id="p'.($i*4-1).'_3"></td><td id="p'.($i*4-1).'_4"></td><td id="p'.($i*4-1).'_5"></td></tr><tr><td></td><td></td><td id="p'.($i*4).'_1"></td><td id="p'.($i*4).'_2"></td><td id="p'.($i*4).'_3"></td><td id="p'.($i*4).'_4"></td><td id="p'.($i*4).'_5"></td></tr>';
					$adjust_content .= '<tr><td>'.$single['unit'].'</td><td>'.$single['name'].'</td><td id="p'.($i*4-3).'_1"></td><td id="p'.($i*4-3).'_2"></td><td id="p'.($i*4-3).'_3"></td><td id="p'.($i*4-3).'_4"></td><td id="p'.($i*4-3).'_5"></td></tr><tr><td></td><td></td><td id="p'.($i*4-2).'_1"></td><td id="p'.($i*4-2).'_2"></td><td id="p'.($i*4-2).'_3"></td><td id="p'.($i*4-2).'_4"></td><td id="p'.($i*4-2).'_5"></td></tr><tr><td></td><td>Bye</td><td id="p'.($i*4-1).'_1"></td><td id="p'.($i*4-1).'_2"></td><td id="p'.($i*4-1).'_3"></td><td id="p'.($i*4-1).'_4"></td><td id="p'.($i*4-1).'_5"></td></tr><tr><td></td><td></td><td id="p'.($i*4).'_1"></td><td id="p'.($i*4).'_2"></td><td id="p'.($i*4).'_3"></td><td id="p'.($i*4).'_4"></td><td id="p'.($i*4).'_5"></td></tr>';
				}
				else {
					$public_content .= '<tr><td>'.$single['unit'].'</td><td>'.$single['name'].'</td><td id="p'.($i*4-3).'_1"></td><td id="p'.($i*4-3).'_2"></td><td id="p'.($i*4-3).'_3"></td><td id="p'.($i*4-3).'_4"></td><td id="p'.($i*4-3).'_5"></td></tr><tr><td></td><td></td><td id="p'.($i*4-2).'_1" align="right">'.$index.'</td><td id="p'.($i*4-2).'_2"></td><td id="p'.($i*4-2).'_3"></td><td id="p'.($i*4-2).'_4"></td><td id="p'.($i*4-2).'_5"></td></tr><tr><td>'.$double['unit'].'</td><td>'.$double['name'].'</td><td id="p'.($i*4-1).'_1"></td><td id="p'.($i*4-1).'_2"></td><td id="p'.($i*4-1).'_3"></td><td id="p'.($i*4-1).'_4"></td><td id="p'.($i*4-1).'_5"></td></tr><tr><td></td><td></td><td id="p'.($i*4).'_1"></td><td id="p'.($i*4).'_2"></td><td id="p'.($i*4).'_3"></td><td id="p'.($i*4).'_4"></td><td id="p'.($i*4).'_5"></td></tr>';
					$adjust_content .= '<tr><td>'.$single['unit'].'</td><td>'.$single['name'].'</td><td id="p'.($i*4-3).'_1"></td><td id="p'.($i*4-3).'_2"></td><td id="p'.($i*4-3).'_3"></td><td id="p'.($i*4-3).'_4"></td><td id="p'.($i*4-3).'_5"></td></tr><tr><td></td><td></td><td id="p'.($i*4-2).'_1" align="right">'.$index.'</td><td id="p'.($i*4-2).'_2"><input type="text" id="'.$index.'_above"></td><td id="p'.($i*4-2).'_3"></td><td id="p'.($i*4-2).'_4"></td><td id="p'.($i*4-2).'_5"></td></tr><tr><td>'.$double['unit'].'</td><td>'.$double['name'].'</td><td id="p'.($i*4-1).'_1"></td><td id="p'.($i*4-1).'_2"><input type="text" id="'.$index.'_below"></td><td id="p'.($i*4-1).'_3"></td><td id="p'.($i*4-1).'_4"></td><td id="p'.($i*4-1).'_5"></td></tr><tr><td></td><td></td><td id="p'.($i*4).'_1"></td><td id="p'.($i*4).'_2"></td><td id="p'.($i*4).'_3"></td><td id="p'.($i*4).'_4"></td><td id="p'.($i*4).'_5"></td></tr>';
					mysql_query("UPDATE GAMESTATE SET PLAYNO='$index' WHERE GAMENO='$gameno' AND SYSTEMPLAYNO=$i");
					$index++;
				}
			}
			for ($i = 1; $i <= 4; $i++) {
				$pos = $i*8-4;
				$public_content = str_replace('<td id="p'.$pos.'_2"></td>', '<td id="p'.$pos.'_2" align="right">'.$index.'</td>', $public_content);
				$adjust_content = str_replace('<td id="p'.$pos.'_2"></td>', '<td id="p'.$pos.'_2" align="right">'.$index.'</td>', $adjust_content);
				$adjust_content = str_replace('<td id="p'.$pos.'_3"></td>', '<td id="p'.$pos.'_3"><input type="text" id="'.$index.'_above"></td>', $adjust_content);
				$adjust_content = str_replace('<td id="p'.($pos+1).'_3"></td>', '<td id="p'.($pos+1).'_3"><input type="text" id="'.$index.'_below"></td>', $adjust_content);
				mysql_query("UPDATE GAMESTATE SET PLAYNO='$index' WHERE GAMENO='$gameno' AND SYSTEMPLAYNO=$i+8");
				$index++;
			}
			for ($i = 1; $i <= 2; $i++) {
				$pos = $i*16-8;
				$public_content = str_replace('<td id="p'.$pos.'_3"></td>', '<td id="p'.$pos.'_3" align="right">'.$index.'</td>', $public_content);
				$adjust_content = str_replace('<td id="p'.$pos.'_3"></td>', '<td id="p'.$pos.'_3" align="right">'.$index.'</td>', $adjust_content);
				$adjust_content = str_replace('<td id="p'.$pos.'_4"></td>', '<td id="p'.$pos.'_4"><input type="text" id="'.$index.'_above"></td>', $adjust_content);
				$adjust_content = str_replace('<td id="p'.($pos+1).'_4"></td>', '<td id="p'.($pos+1).'_4"><input type="text" id="'.$index.'_below"></td>', $adjust_content);
				mysql_query("UPDATE GAMESTATE SET PLAYNO='$index' WHERE GAMENO='$gameno' AND SYSTEMPLAYNO=$i+12");
				$index++;
			}
			$public_content = str_replace('<td id="p16_4"></td>', '<td id="p16_4" align="right">'.$index.'</td>', $public_content);
			$adjust_content = str_replace('<td id="p16_4"></td>', '<td id="p16_4" align="right">'.$index.'</td>', $adjust_content);
			$adjust_content = str_replace('<td id="p16_5"></td>', '<td id="p16_5"><input type="text" id="'.$index.'_above"></td>', $adjust_content);
			$adjust_content = str_replace('<td id="p17_5"></td>', '<td id="p17_5"><input type="text" id="'.$index.'_below"></td>', $adjust_content);
			mysql_query("UPDATE GAMESTATE SET PLAYNO='$index' WHERE GAMENO='$gameno' AND SYSTEMPLAYNO=15");
			$public_content .= '</table>';
			$adjust_content .= '</table><button onclick="update(\''.$gameno.'\')">確定更新</button>';
			$end = '</body><script src="../resource/16.js"></script></html>';
			$file = fopen("public/" . $gameno . ".html", "w");
			fwrite($file, $start.$public_content.$end);
			fclose($file);
			$file = fopen("adjust/" . $gameno . ".html", "w");
			fwrite($file, $start.$adjust_content.$end);
			fclose($file);
			echo json_encode(array('message' => 'Success', 'gameno' => $gameno));
		}
		elseif ($amount > 16 && $amount <= 32) {
			createGameState(32, $gameno);
			$index = 1;
			for ($i = 1; $i <= 16; $i++) {
				$single = query($gameno, $i*2-1);
				$double = query($gameno, $i*2);
				if ($single['unit'] == 'none') {
					$public_content .= '<tr><td></td><td>Bye</td><td id="p'.($i*4-3).'_1"></td><td id="p'.($i*4-3).'_2"></td><td id="p'.($i*4-3).'_3"></td><td id="p'.($i*4-3).'_4"></td><td id="p'.($i*4-3).'_5"></td></tr><tr><td></td><td></td><td id="p'.($i*4-2).'_1"></td><td id="p'.($i*4-2).'_2"></td><td id="p'.($i*4-2).'_3"></td><td id="p'.($i*4-2).'_4"></td><td id="p'.($i*4-2).'_5"></td></tr><tr><td>'.$double['unit'].'</td><td>'.$double['name'].'</td><td id="p'.($i*4-1).'_1"></td><td id="p'.($i*4-1).'_2"></td><td id="p'.($i*4-1).'_3"></td><td id="p'.($i*4-1).'_4"></td><td id="p'.($i*4-1).'_5"></td></tr><tr><td></td><td></td><td id="p'.($i*4).'_1"></td><td id="p'.($i*4).'_2"></td><td id="p'.($i*4).'_3"></td><td id="p'.($i*4).'_4"></td><td id="p'.($i*4).'_5"></td></tr>';
					$adjust_content .= '<tr><td></td><td>Bye</td><td id="p'.($i*4-3).'_1"></td><td id="p'.($i*4-3).'_2"></td><td id="p'.($i*4-3).'_3"></td><td id="p'.($i*4-3).'_4"></td><td id="p'.($i*4-3).'_5"></td></tr><tr><td></td><td></td><td id="p'.($i*4-2).'_1"></td><td id="p'.($i*4-2).'_2"></td><td id="p'.($i*4-2).'_3"></td><td id="p'.($i*4-2).'_4"></td><td id="p'.($i*4-2).'_5"></td></tr><tr><td>'.$double['unit'].'</td><td>'.$double['name'].'</td><td id="p'.($i*4-1).'_1"></td><td id="p'.($i*4-1).'_2"></td><td id="p'.($i*4-1).'_3"></td><td id="p'.($i*4-1).'_4"></td><td id="p'.($i*4-1).'_5"></td></tr><tr><td></td><td></td><td id="p'.($i*4).'_1"></td><td id="p'.($i*4).'_2"></td><td id="p'.($i*4).'_3"></td><td id="p'.($i*4).'_4"></td><td id="p'.($i*4).'_5"></td></tr>';
				}
				elseif ($double['unit'] == 'none') {
					$public_content .= '<tr><td>'.$single['unit'].'</td><td>'.$single['name'].'</td><td id="p'.($i*4-3).'_1"></td><td id="p'.($i*4-3).'_2"></td><td id="p'.($i*4-3).'_3"></td><td id="p'.($i*4-3).'_4"></td><td id="p'.($i*4-3).'_5"></td></tr><tr><td></td><td></td><td id="p'.($i*4-2).'_1"></td><td id="p'.($i*4-2).'_2"></td><td id="p'.($i*4-2).'_3"></td><td id="p'.($i*4-2).'_4"></td><td id="p'.($i*4-2).'_5"></td></tr><tr><td></td><td>Bye</td><td id="p'.($i*4-1).'_1"></td><td id="p'.($i*4-1).'_2"></td><td id="p'.($i*4-1).'_3"></td><td id="p'.($i*4-1).'_4"></td><td id="p'.($i*4-1).'_5"></td></tr><tr><td></td><td></td><td id="p'.($i*4).'_1"></td><td id="p'.($i*4).'_2"></td><td id="p'.($i*4).'_3"></td><td id="p'.($i*4).'_4"></td><td id="p'.($i*4).'_5"></td></tr>';
					$adjust_content .= '<tr><td>'.$single['unit'].'</td><td>'.$single['name'].'</td><td id="p'.($i*4-3).'_1"></td><td id="p'.($i*4-3).'_2"></td><td id="p'.($i*4-3).'_3"></td><td id="p'.($i*4-3).'_4"></td><td id="p'.($i*4-3).'_5"></td></tr><tr><td></td><td></td><td id="p'.($i*4-2).'_1"></td><td id="p'.($i*4-2).'_2"></td><td id="p'.($i*4-2).'_3"></td><td id="p'.($i*4-2).'_4"></td><td id="p'.($i*4-2).'_5"></td></tr><tr><td></td><td>Bye</td><td id="p'.($i*4-1).'_1"></td><td id="p'.($i*4-1).'_2"></td><td id="p'.($i*4-1).'_3"></td><td id="p'.($i*4-1).'_4"></td><td id="p'.($i*4-1).'_5"></td></tr><tr><td></td><td></td><td id="p'.($i*4).'_1"></td><td id="p'.($i*4).'_2"></td><td id="p'.($i*4).'_3"></td><td id="p'.($i*4).'_4"></td><td id="p'.($i*4).'_5"></td></tr>';
				}
				else {
					$public_content .= '<tr><td>'.$single['unit'].'</td><td>'.$single['name'].'</td><td id="p'.($i*4-3).'_1"></td><td id="p'.($i*4-3).'_2"></td><td id="p'.($i*4-3).'_3"></td><td id="p'.($i*4-3).'_4"></td><td id="p'.($i*4-3).'_5"></td></tr><tr><td></td><td></td><td id="p'.($i*4-2).'_1" align="right">'.$index.'</td><td id="p'.($i*4-2).'_2"></td><td id="p'.($i*4-2).'_3"></td><td id="p'.($i*4-2).'_4"></td><td id="p'.($i*4-2).'_5"></td></tr><tr><td>'.$double['unit'].'</td><td>'.$double['name'].'</td><td id="p'.($i*4-1).'_1"></td><td id="p'.($i*4-1).'_2"></td><td id="p'.($i*4-1).'_3"></td><td id="p'.($i*4-1).'_4"></td><td id="p'.($i*4-1).'_5"></td></tr><tr><td></td><td></td><td id="p'.($i*4).'_1"></td><td id="p'.($i*4).'_2"></td><td id="p'.($i*4).'_3"></td><td id="p'.($i*4).'_4"></td><td id="p'.($i*4).'_5"></td></tr>';
					$adjust_content .= '<tr><td>'.$single['unit'].'</td><td>'.$single['name'].'</td><td id="p'.($i*4-3).'_1"></td><td id="p'.($i*4-3).'_2"></td><td id="p'.($i*4-3).'_3"></td><td id="p'.($i*4-3).'_4"></td><td id="p'.($i*4-3).'_5"></td></tr><tr><td></td><td></td><td id="p'.($i*4-2).'_1" align="right">'.$index.'</td><td id="p'.($i*4-2).'_2"><input type="text" id="'.$index.'_above"></td><td id="p'.($i*4-2).'_3"></td><td id="p'.($i*4-2).'_4"></td><td id="p'.($i*4-2).'_5"></td></tr><tr><td>'.$double['unit'].'</td><td>'.$double['name'].'</td><td id="p'.($i*4-1).'_1"></td><td id="p'.($i*4-1).'_2"><input type="text" id="'.$index.'_below"></td><td id="p'.($i*4-1).'_3"></td><td id="p'.($i*4-1).'_4"></td><td id="p'.($i*4-1).'_5"></td></tr><tr><td></td><td></td><td id="p'.($i*4).'_1"></td><td id="p'.($i*4).'_2"></td><td id="p'.($i*4).'_3"></td><td id="p'.($i*4).'_4"></td><td id="p'.($i*4).'_5"></td></tr>';
					mysql_query("UPDATE GAMESTATE SET PLAYNO='$index' WHERE GAMENO='$gameno' AND SYSTEMPLAYNO=$i");
					$index++;
				}
			}
			for ($i = 1; $i <= 8; $i++) {
				$pos = $i*8-4;
				$public_content = str_replace('<td id="p'.$pos.'_2"></td>', '<td id="p'.$pos.'_2" align="right">'.$index.'</td>', $public_content);
				$adjust_content = str_replace('<td id="p'.$pos.'_2"></td>', '<td id="p'.$pos.'_2" align="right">'.$index.'</td>', $adjust_content);
				$adjust_content = str_replace('<td id="p'.$pos.'_3"></td>', '<td id="p'.$pos.'_3"><input type="text" id="'.$index.'_above"></td>', $adjust_content);
				$adjust_content = str_replace('<td id="p'.($pos+1).'_3"></td>', '<td id="p'.($pos+1).'_3"><input type="text" id="'.$index.'_below"></td>', $adjust_content);
				mysql_query("UPDATE GAMESTATE SET PLAYNO='$index' WHERE GAMENO='$gameno' AND SYSTEMPLAYNO=$i+16");
				$index++;
			}
			for ($i = 1; $i <= 4; $i++) {
				$pos = $i*16-8;
				$public_content = str_replace('<td id="p'.$pos.'_3"></td>', '<td id="p'.$pos.'_3" align="right">'.$index.'</td>', $public_content);
				$adjust_content = str_replace('<td id="p'.$pos.'_3"></td>', '<td id="p'.$pos.'_3" align="right">'.$index.'</td>', $adjust_content);
				$adjust_content = str_replace('<td id="p'.$pos.'_4"></td>', '<td id="p'.$pos.'_4"><input type="text" id="'.$index.'_above"></td>', $adjust_content);
				$adjust_content = str_replace('<td id="p'.($pos+1).'_4"></td>', '<td id="p'.($pos+1).'_4"><input type="text" id="'.$index.'_below"></td>', $adjust_content);
				mysql_query("UPDATE GAMESTATE SET PLAYNO='$index' WHERE GAMENO='$gameno' AND SYSTEMPLAYNO=$i+24");
				$index++;
			}
			for ($i = 1; $i <= 2; $i++) {
				$pos = $i*32-16;
				$public_content = str_replace('<td id="p'.$pos.'_4"></td>', '<td id="p'.$pos.'_4" align="right">'.$index.'</td>', $public_content);
				$adjust_content = str_replace('<td id="p'.$pos.'_4"></td>', '<td id="p'.$pos.'_4" align="right">'.$index.'</td>', $adjust_content);
				$adjust_content = str_replace('<td id="p'.$pos.'_5"></td>', '<td id="p'.$pos.'_5"><input type="text" id="'.$index.'_above"></td>', $adjust_content);
				$adjust_content = str_replace('<td id="p'.($pos+1).'_5"></td>', '<td id="p'.($pos+1).'_5"><input type="text" id="'.$index.'_below"></td>', $adjust_content);
				mysql_query("UPDATE GAMESTATE SET PLAYNO='$index' WHERE GAMENO='$gameno' AND SYSTEMPLAYNO=$i+28");
				$index++;
			}
			$public_content = str_replace('<td id="p32_4"></td>', '<td id="p32_4" align="right">'.$index.'</td>', $public_content);
			$adjust_content = str_replace('<td id="p32_4"></td>', '<td id="p32_4" align="right">'.$index.'</td>', $adjust_content);
			$adjust_content = str_replace('<td id="p32_5"></td>', '<td id="p32_5"><input type="text" id="'.$index.'_above"></td>', $adjust_content);
			$adjust_content = str_replace('<td id="p33_5"></td>', '<td id="p33_5"><input type="text" id="'.$index.'_below"></td>', $adjust_content);
			mysql_query("UPDATE GAMESTATE SET PLAYNO='$index' WHERE GAMENO='$gameno' AND SYSTEMPLAYNO=31");
			$public_content .= '</table>';
			$adjust_content .= '</table><button onclick="update(\''.$gameno.'\')">確定更新</button>';
			$end = '</body><script src="../resource/32.js"></script></html>';
			$file = fopen($gameno . "/public.html", "w");
			fwrite($file, $start.$public_content.$end);
			fclose($file);
			$file = fopen($gameno . "/edit.html", "w");
			fwrite($file, $start.$adjust_content.$end);
			fclose($file);
			echo json_encode(array('message' => 'Success', 'gameno' => $gameno));
		}
		elseif ($amount > 32 && $amount <= 64) {
			createGameState(64, $gameno);
			$index = 1;
			for ($i = 1; $i <= 32; $i++) {
				$single = query($gameno, $i*2-1);
				$double = query($gameno, $i*2);
				if ($single['unit'] == 'none') {
					$public_content .= '<tr><td></td><td>Bye</td><td id="p'.($i*4-3).'_1"></td><td id="p'.($i*4-3).'_2"></td><td id="p'.($i*4-3).'_3"></td><td id="p'.($i*4-3).'_4"></td><td id="p'.($i*4-3).'_5"></td></tr><tr><td></td><td></td><td id="p'.($i*4-2).'_1"></td><td id="p'.($i*4-2).'_2"></td><td id="p'.($i*4-2).'_3"></td><td id="p'.($i*4-2).'_4"></td><td id="p'.($i*4-2).'_5"></td></tr><tr><td>'.$double['unit'].'</td><td>'.$double['name'].'</td><td id="p'.($i*4-1).'_1"></td><td id="p'.($i*4-1).'_2"></td><td id="p'.($i*4-1).'_3"></td><td id="p'.($i*4-1).'_4"></td><td id="p'.($i*4-1).'_5"></td></tr><tr><td></td><td></td><td id="p'.($i*4).'_1"></td><td id="p'.($i*4).'_2"></td><td id="p'.($i*4).'_3"></td><td id="p'.($i*4).'_4"></td><td id="p'.($i*4).'_5"></td></tr>';
					$adjust_content .= '<tr><td></td><td>Bye</td><td id="p'.($i*4-3).'_1"></td><td id="p'.($i*4-3).'_2"></td><td id="p'.($i*4-3).'_3"></td><td id="p'.($i*4-3).'_4"></td><td id="p'.($i*4-3).'_5"></td></tr><tr><td></td><td></td><td id="p'.($i*4-2).'_1"></td><td id="p'.($i*4-2).'_2"></td><td id="p'.($i*4-2).'_3"></td><td id="p'.($i*4-2).'_4"></td><td id="p'.($i*4-2).'_5"></td></tr><tr><td>'.$double['unit'].'</td><td>'.$double['name'].'</td><td id="p'.($i*4-1).'_1"></td><td id="p'.($i*4-1).'_2"></td><td id="p'.($i*4-1).'_3"></td><td id="p'.($i*4-1).'_4"></td><td id="p'.($i*4-1).'_5"></td></tr><tr><td></td><td></td><td id="p'.($i*4).'_1"></td><td id="p'.($i*4).'_2"></td><td id="p'.($i*4).'_3"></td><td id="p'.($i*4).'_4"></td><td id="p'.($i*4).'_5"></td></tr>';
				}
				elseif ($double['unit'] == 'none') {
					$public_content .= '<tr><td>'.$single['unit'].'</td><td>'.$single['name'].'</td><td id="p'.($i*4-3).'_1"></td><td id="p'.($i*4-3).'_2"></td><td id="p'.($i*4-3).'_3"></td><td id="p'.($i*4-3).'_4"></td><td id="p'.($i*4-3).'_5"></td></tr><tr><td></td><td></td><td id="p'.($i*4-2).'_1"></td><td id="p'.($i*4-2).'_2"></td><td id="p'.($i*4-2).'_3"></td><td id="p'.($i*4-2).'_4"></td><td id="p'.($i*4-2).'_5"></td></tr><tr><td></td><td>Bye</td><td id="p'.($i*4-1).'_1"></td><td id="p'.($i*4-1).'_2"></td><td id="p'.($i*4-1).'_3"></td><td id="p'.($i*4-1).'_4"></td><td id="p'.($i*4-1).'_5"></td></tr><tr><td></td><td></td><td id="p'.($i*4).'_1"></td><td id="p'.($i*4).'_2"></td><td id="p'.($i*4).'_3"></td><td id="p'.($i*4).'_4"></td><td id="p'.($i*4).'_5"></td></tr>';
					$adjust_content .= '<tr><td>'.$single['unit'].'</td><td>'.$single['name'].'</td><td id="p'.($i*4-3).'_1"></td><td id="p'.($i*4-3).'_2"></td><td id="p'.($i*4-3).'_3"></td><td id="p'.($i*4-3).'_4"></td><td id="p'.($i*4-3).'_5"></td></tr><tr><td></td><td></td><td id="p'.($i*4-2).'_1"></td><td id="p'.($i*4-2).'_2"></td><td id="p'.($i*4-2).'_3"></td><td id="p'.($i*4-2).'_4"></td><td id="p'.($i*4-2).'_5"></td></tr><tr><td></td><td>Bye</td><td id="p'.($i*4-1).'_1"></td><td id="p'.($i*4-1).'_2"></td><td id="p'.($i*4-1).'_3"></td><td id="p'.($i*4-1).'_4"></td><td id="p'.($i*4-1).'_5"></td></tr><tr><td></td><td></td><td id="p'.($i*4).'_1"></td><td id="p'.($i*4).'_2"></td><td id="p'.($i*4).'_3"></td><td id="p'.($i*4).'_4"></td><td id="p'.($i*4).'_5"></td></tr>';
				}
				else {
					$public_content .= '<tr><td>'.$single['unit'].'</td><td>'.$single['name'].'</td><td id="p'.($i*4-3).'_1"></td><td id="p'.($i*4-3).'_2"></td><td id="p'.($i*4-3).'_3"></td><td id="p'.($i*4-3).'_4"></td><td id="p'.($i*4-3).'_5"></td></tr><tr><td></td><td></td><td id="p'.($i*4-2).'_1" align="right">'.$index.'</td><td id="p'.($i*4-2).'_2"></td><td id="p'.($i*4-2).'_3"></td><td id="p'.($i*4-2).'_4"></td><td id="p'.($i*4-2).'_5"></td></tr><tr><td>'.$double['unit'].'</td><td>'.$double['name'].'</td><td id="p'.($i*4-1).'_1"></td><td id="p'.($i*4-1).'_2"></td><td id="p'.($i*4-1).'_3"></td><td id="p'.($i*4-1).'_4"></td><td id="p'.($i*4-1).'_5"></td></tr><tr><td></td><td></td><td id="p'.($i*4).'_1"></td><td id="p'.($i*4).'_2"></td><td id="p'.($i*4).'_3"></td><td id="p'.($i*4).'_4"></td><td id="p'.($i*4).'_5"></td></tr>';
					$adjust_content .= '<tr><td>'.$single['unit'].'</td><td>'.$single['name'].'</td><td id="p'.($i*4-3).'_1"></td><td id="p'.($i*4-3).'_2"></td><td id="p'.($i*4-3).'_3"></td><td id="p'.($i*4-3).'_4"></td><td id="p'.($i*4-3).'_5"></td></tr><tr><td></td><td></td><td id="p'.($i*4-2).'_1" align="right">'.$index.'</td><td id="p'.($i*4-2).'_2"><input type="text" id="'.$index.'_above"></td><td id="p'.($i*4-2).'_3"></td><td id="p'.($i*4-2).'_4"></td><td id="p'.($i*4-2).'_5"></td></tr><tr><td>'.$double['unit'].'</td><td>'.$double['name'].'</td><td id="p'.($i*4-1).'_1"></td><td id="p'.($i*4-1).'_2"><input type="text" id="'.$index.'_below"></td><td id="p'.($i*4-1).'_3"></td><td id="p'.($i*4-1).'_4"></td><td id="p'.($i*4-1).'_5"></td></tr><tr><td></td><td></td><td id="p'.($i*4).'_1"></td><td id="p'.($i*4).'_2"></td><td id="p'.($i*4).'_3"></td><td id="p'.($i*4).'_4"></td><td id="p'.($i*4).'_5"></td></tr>';
					mysql_query("UPDATE GAMESTATE SET PLAYNO='$index' WHERE GAMENO='$gameno' AND SYSTEMPLAYNO=$i");
					$index++;
				}
			}
			for ($i = 1; $i <= 16; $i++) {
				$pos = $i*8-4;
				$public_content = str_replace('<td id="p'.$pos.'_2"></td>', '<td id="p'.$pos.'_2" align="right">'.$index.'</td>', $public_content);
				$adjust_content = str_replace('<td id="p'.$pos.'_2"></td>', '<td id="p'.$pos.'_2" align="right">'.$index.'</td>', $adjust_content);
				$adjust_content = str_replace('<td id="p'.$pos.'_3"></td>', '<td id="p'.$pos.'_3"><input type="text" id="'.$index.'_above"></td>', $adjust_content);
				$adjust_content = str_replace('<td id="p'.($pos+1).'_3"></td>', '<td id="p'.($pos+1).'_3"><input type="text" id="'.$index.'_below"></td>', $adjust_content);
				mysql_query("UPDATE GAMESTATE SET PLAYNO='$index' WHERE GAMENO='$gameno' AND SYSTEMPLAYNO=$i+32");
				$index++;
			}
			for ($i = 1; $i <= 8; $i++) {
				$pos = $i*16-8;
				$public_content = str_replace('<td id="p'.$pos.'_3"></td>', '<td id="p'.$pos.'_3" align="right">'.$index.'</td>', $public_content);
				$adjust_content = str_replace('<td id="p'.$pos.'_3"></td>', '<td id="p'.$pos.'_3" align="right">'.$index.'</td>', $adjust_content);
				$adjust_content = str_replace('<td id="p'.$pos.'_4"></td>', '<td id="p'.$pos.'_4"><input type="text" id="'.$index.'_above"></td>', $adjust_content);
				$adjust_content = str_replace('<td id="p'.($pos+1).'_4"></td>', '<td id="p'.($pos+1).'_4"><input type="text" id="'.$index.'_below"></td>', $adjust_content);
				mysql_query("UPDATE GAMESTATE SET PLAYNO='$index' WHERE GAMENO='$gameno' AND SYSTEMPLAYNO=$i+48");
				$index++;
			}
			for ($i = 1; $i <= 4; $i++) {
				$pos = $i*32-16;
				$public_content = str_replace('<td id="p'.$pos.'_4"></td>', '<td id="p'.$pos.'_4" align="right">'.$index.'</td>', $public_content);
				$adjust_content = str_replace('<td id="p'.$pos.'_4"></td>', '<td id="p'.$pos.'_4" align="right">'.$index.'</td>', $adjust_content);
				$adjust_content = str_replace('<td id="p'.$pos.'_5"></td>', '<td id="p'.$pos.'_5"><input type="text" id="'.$index.'_above"></td>', $adjust_content);
				$adjust_content = str_replace('<td id="p'.($pos+1).'_5"></td>', '<td id="p'.($pos+1).'_5"><input type="text" id="'.$index.'_below"></td>', $adjust_content);
				mysql_query("UPDATE GAMESTATE SET PLAYNO='$index' WHERE GAMENO='$gameno' AND SYSTEMPLAYNO=$i+56");
				$index++;
			}
			for ($i = 1; $i <= 2; $i++) {
				$pos = $i*64-32;
				$public_content = str_replace('<td id="p'.$pos.'_5"></td>', '<td id="p'.$pos.'_5" align="right">'.$index.'</td>', $public_content);
				$adjust_content = str_replace('<td id="p'.$pos.'_5"></td>', '<td id="p'.$pos.'_5" align="right">'.$index.'</td>', $adjust_content);
				$adjust_content = str_replace('<td id="p'.$pos.'_6"></td>', '<td id="p'.$pos.'_6"><input type="text" id="'.$index.'_above"></td>', $adjust_content);
				$adjust_content = str_replace('<td id="p'.($pos+1).'_6"></td>', '<td id="p'.($pos+1).'_6"><input type="text" id="'.$index.'_below"></td>', $adjust_content);
				mysql_query("UPDATE GAMESTATE SET PLAYNO='$index' WHERE GAMENO='$gameno' AND SYSTEMPLAYNO=$i+60");
				$index++;
			}
			$public_content = str_replace('<td id="p64_6"></td>', '<td id="p64_6" align="right>'.$index.'</td>', $public_content);
			$adjust_content = str_replace('<td id="p64_6"></td>', '<td id="p64_6" align="right>'.$index.'</td>', $adjust_content);
			$adjust_content = str_replace('<td id="p64_7"></td>', '<td id="p64_7"><input type="text" id="'.$index.'_above"></td>', $adjust_content);
			$adjust_content = str_replace('<td id="p64_7"></td>', '<td id="p64_7"><input type="text" id="'.$index.'_below"></td>', $adjust_content);
			mysql_query("UPDATE GAMESTATE SET PLAYNO='$index' WHERE GAMENO='$gameno' AND SYSTEMPLAYNO=63");
			$public_content .= '</table>';
			$adjust_content .= '</table><button onclick="update(\''.$gameno.'\')">確定更新</button>';
			$end = '</body><script src="../resource/64.js"></script></html>';
			$file = fopen($gameno . "/public.html", "w");
			fwrite($file, $start.$public_content.$end);
			fclose($file);
			$file = fopen($gameno . "/edit.html", "w");
			fwrite($file, $start.$adjust_content.$end);
			fclose($file);
			echo json_encode(array('message' => 'Success', 'gameno' => $gameno));
		}
	}
	elseif ($mode == 'enter') {
		if ($amount > 8 && $amount <= 16) {
			for ($i = 1; $i <= 16; $i++) {
				$temp_unit = $unit[$i-1];
				$temp_name = $name[$i-1];
				mysql_query("INSERT INTO GAMEPOSITION (GAMENO, POSITION, UNIT, NAME) VALUES ('$gameno', '$i', '$temp_unit', '$temp_name')");
			}
		}
		elseif ($amount > 16 && $amount <= 32) {
			for ($i = 1; $i <= 32; $i++) {
				$temp_unit = $unit[$i-1];
				$temp_name = $name[$i-1];
				mysql_query("INSERT INTO GAMEPOSITION (GAMENO, POSITION, UNIT, NAME) VALUES ('$gameno', '$i', '$temp_unit', '$temp_name')");
			}
		}
		elseif ($amount > 32 && $amount <= 64) {
			for ($i = 1; $i <= 64; $i++) {
				$temp_unit = $unit[$i-1];
				$temp_name = $name[$i-1];
				mysql_query("INSERT INTO GAMEPOSITION (GAMENO, POSITION, UNIT, NAME) VALUES ('$gameno', '$i', '$temp_unit', '$temp_name')");
			}
		}
		// process public
		$start = '<!DOCTYPE html><html lang="en"><head><meta charset="utf-8"><meta name="viewport" content="width=device-width, initial-scale=1"><title>電子化賽程系統</title><link rel="stylesheet" type="text/css" href="../resource/custom.css"></head><body>';
		$public_content = '<table><tr><td>單位</td><td>名稱</td></tr>';
		$adjust_content = '<script src="../resource/custom.js"></script><table><tr><td>單位</td><td>名稱</td></tr>';
		if ($amount > 8 && $amount <= 16) {
			createGameState(16, $gameno);
			$index = 1;
			for ($i = 1; $i <= 8; $i++) {
				$single = query($gameno, $i*2-1);
				$double = query($gameno, $i*2);
				if ($single['unit'] == 'none') {
					$public_content .= '<tr><td></td><td>Bye</td><td id="p'.($i*4-3).'_1"></td><td id="p'.($i*4-3).'_2"></td><td id="p'.($i*4-3).'_3"></td><td id="p'.($i*4-3).'_4"></td><td id="p'.($i*4-3).'_5"></td></tr><tr><td></td><td></td><td id="p'.($i*4-2).'_1"></td><td id="p'.($i*4-2).'_2"></td><td id="p'.($i*4-2).'_3"></td><td id="p'.($i*4-2).'_4"></td><td id="p'.($i*4-2).'_5"></td></tr><tr><td>'.$double['unit'].'</td><td>'.$double['name'].'</td><td id="p'.($i*4-1).'_1"></td><td id="p'.($i*4-1).'_2"></td><td id="p'.($i*4-1).'_3"></td><td id="p'.($i*4-1).'_4"></td><td id="p'.($i*4-1).'_5"></td></tr><tr><td></td><td></td><td id="p'.($i*4).'_1"></td><td id="p'.($i*4).'_2"></td><td id="p'.($i*4).'_3"></td><td id="p'.($i*4).'_4"></td><td id="p'.($i*4).'_5"></td></tr>';
					$adjust_content .= '<tr><td></td><td>Bye</td><td id="p'.($i*4-3).'_1"></td><td id="p'.($i*4-3).'_2"></td><td id="p'.($i*4-3).'_3"></td><td id="p'.($i*4-3).'_4"></td><td id="p'.($i*4-3).'_5"></td></tr><tr><td></td><td></td><td id="p'.($i*4-2).'_1"></td><td id="p'.($i*4-2).'_2"></td><td id="p'.($i*4-2).'_3"></td><td id="p'.($i*4-2).'_4"></td><td id="p'.($i*4-2).'_5"></td></tr><tr><td>'.$double['unit'].'</td><td>'.$double['name'].'</td><td id="p'.($i*4-1).'_1"></td><td id="p'.($i*4-1).'_2"></td><td id="p'.($i*4-1).'_3"></td><td id="p'.($i*4-1).'_4"></td><td id="p'.($i*4-1).'_5"></td></tr><tr><td></td><td></td><td id="p'.($i*4).'_1"></td><td id="p'.($i*4).'_2"></td><td id="p'.($i*4).'_3"></td><td id="p'.($i*4).'_4"></td><td id="p'.($i*4).'_5"></td></tr>';
				}
				elseif ($double['unit'] == 'none') {
					$public_content .= '<tr><td>'.$single['unit'].'</td><td>'.$single['name'].'</td><td id="p'.($i*4-3).'_1"></td><td id="p'.($i*4-3).'_2"></td><td id="p'.($i*4-3).'_3"></td><td id="p'.($i*4-3).'_4"></td><td id="p'.($i*4-3).'_5"></td></tr><tr><td></td><td></td><td id="p'.($i*4-2).'_1"></td><td id="p'.($i*4-2).'_2"></td><td id="p'.($i*4-2).'_3"></td><td id="p'.($i*4-2).'_4"></td><td id="p'.($i*4-2).'_5"></td></tr><tr><td></td><td>Bye</td><td id="p'.($i*4-1).'_1"></td><td id="p'.($i*4-1).'_2"></td><td id="p'.($i*4-1).'_3"></td><td id="p'.($i*4-1).'_4"></td><td id="p'.($i*4-1).'_5"></td></tr><tr><td></td><td></td><td id="p'.($i*4).'_1"></td><td id="p'.($i*4).'_2"></td><td id="p'.($i*4).'_3"></td><td id="p'.($i*4).'_4"></td><td id="p'.($i*4).'_5"></td></tr>';
					$adjust_content .= '<tr><td>'.$single['unit'].'</td><td>'.$single['name'].'</td><td id="p'.($i*4-3).'_1"></td><td id="p'.($i*4-3).'_2"></td><td id="p'.($i*4-3).'_3"></td><td id="p'.($i*4-3).'_4"></td><td id="p'.($i*4-3).'_5"></td></tr><tr><td></td><td></td><td id="p'.($i*4-2).'_1"></td><td id="p'.($i*4-2).'_2"></td><td id="p'.($i*4-2).'_3"></td><td id="p'.($i*4-2).'_4"></td><td id="p'.($i*4-2).'_5"></td></tr><tr><td></td><td>Bye</td><td id="p'.($i*4-1).'_1"></td><td id="p'.($i*4-1).'_2"></td><td id="p'.($i*4-1).'_3"></td><td id="p'.($i*4-1).'_4"></td><td id="p'.($i*4-1).'_5"></td></tr><tr><td></td><td></td><td id="p'.($i*4).'_1"></td><td id="p'.($i*4).'_2"></td><td id="p'.($i*4).'_3"></td><td id="p'.($i*4).'_4"></td><td id="p'.($i*4).'_5"></td></tr>';
				}
				else {
					$public_content .= '<tr><td>'.$single['unit'].'</td><td>'.$single['name'].'</td><td id="p'.($i*4-3).'_1"></td><td id="p'.($i*4-3).'_2"></td><td id="p'.($i*4-3).'_3"></td><td id="p'.($i*4-3).'_4"></td><td id="p'.($i*4-3).'_5"></td></tr><tr><td></td><td></td><td id="p'.($i*4-2).'_1" align="right">'.$index.'</td><td id="p'.($i*4-2).'_2"></td><td id="p'.($i*4-2).'_3"></td><td id="p'.($i*4-2).'_4"></td><td id="p'.($i*4-2).'_5"></td></tr><tr><td>'.$double['unit'].'</td><td>'.$double['name'].'</td><td id="p'.($i*4-1).'_1"></td><td id="p'.($i*4-1).'_2"></td><td id="p'.($i*4-1).'_3"></td><td id="p'.($i*4-1).'_4"></td><td id="p'.($i*4-1).'_5"></td></tr><tr><td></td><td></td><td id="p'.($i*4).'_1"></td><td id="p'.($i*4).'_2"></td><td id="p'.($i*4).'_3"></td><td id="p'.($i*4).'_4"></td><td id="p'.($i*4).'_5"></td></tr>';
					$adjust_content .= '<tr><td>'.$single['unit'].'</td><td>'.$single['name'].'</td><td id="p'.($i*4-3).'_1"></td><td id="p'.($i*4-3).'_2"></td><td id="p'.($i*4-3).'_3"></td><td id="p'.($i*4-3).'_4"></td><td id="p'.($i*4-3).'_5"></td></tr><tr><td></td><td></td><td id="p'.($i*4-2).'_1" align="right">'.$index.'</td><td id="p'.($i*4-2).'_2"><input type="text" id="'.$index.'_above"></td><td id="p'.($i*4-2).'_3"></td><td id="p'.($i*4-2).'_4"></td><td id="p'.($i*4-2).'_5"></td></tr><tr><td>'.$double['unit'].'</td><td>'.$double['name'].'</td><td id="p'.($i*4-1).'_1"></td><td id="p'.($i*4-1).'_2"><input type="text" id="'.$index.'_below"></td><td id="p'.($i*4-1).'_3"></td><td id="p'.($i*4-1).'_4"></td><td id="p'.($i*4-1).'_5"></td></tr><tr><td></td><td></td><td id="p'.($i*4).'_1"></td><td id="p'.($i*4).'_2"></td><td id="p'.($i*4).'_3"></td><td id="p'.($i*4).'_4"></td><td id="p'.($i*4).'_5"></td></tr>';
					mysql_query("UPDATE GAMESTATE SET PLAYNO='$index' WHERE GAMENO='$gameno' AND SYSTEMPLAYNO=$i");
					$index++;
				}
			}
			for ($i = 1; $i <= 4; $i++) {
				$pos = $i*8-4;
				$public_content = str_replace('<td id="p'.$pos.'_2"></td>', '<td id="p'.$pos.'_2" align="right">'.$index.'</td>', $public_content);
				$adjust_content = str_replace('<td id="p'.$pos.'_2"></td>', '<td id="p'.$pos.'_2" align="right">'.$index.'</td>', $adjust_content);
				$adjust_content = str_replace('<td id="p'.$pos.'_3"></td>', '<td id="p'.$pos.'_3"><input type="text" id="'.$index.'_above"></td>', $adjust_content);
				$adjust_content = str_replace('<td id="p'.($pos+1).'_3"></td>', '<td id="p'.($pos+1).'_3"><input type="text" id="'.$index.'_below"></td>', $adjust_content);
				mysql_query("UPDATE GAMESTATE SET PLAYNO='$index' WHERE GAMENO='$gameno' AND SYSTEMPLAYNO=$i+8");
				$index++;
			}
			for ($i = 1; $i <= 2; $i++) {
				$pos = $i*16-8;
				$public_content = str_replace('<td id="p'.$pos.'_3"></td>', '<td id="p'.$pos.'_3" align="right">'.$index.'</td>', $public_content);
				$adjust_content = str_replace('<td id="p'.$pos.'_3"></td>', '<td id="p'.$pos.'_3" align="right">'.$index.'</td>', $adjust_content);
				$adjust_content = str_replace('<td id="p'.$pos.'_4"></td>', '<td id="p'.$pos.'_4"><input type="text" id="'.$index.'_above"></td>', $adjust_content);
				$adjust_content = str_replace('<td id="p'.($pos+1).'_4"></td>', '<td id="p'.($pos+1).'_4"><input type="text" id="'.$index.'_below"></td>', $adjust_content);
				mysql_query("UPDATE GAMESTATE SET PLAYNO='$index' WHERE GAMENO='$gameno' AND SYSTEMPLAYNO=$i+12");
				$index++;
			}
			$public_content = str_replace('<td id="p16_4"></td>', '<td id="p16_4" align="right">'.$index.'</td>', $public_content);
			$adjust_content = str_replace('<td id="p16_4"></td>', '<td id="p16_4" align="right">'.$index.'</td>', $adjust_content);
			$adjust_content = str_replace('<td id="p16_5"></td>', '<td id="p16_5"><input type="text" id="'.$index.'_above"></td>', $adjust_content);
			$adjust_content = str_replace('<td id="p17_5"></td>', '<td id="p17_5"><input type="text" id="'.$index.'_below"></td>', $adjust_content);
			mysql_query("UPDATE GAMESTATE SET PLAYNO='$index' WHERE GAMENO='$gameno' AND SYSTEMPLAYNO=15");
			$public_content .= '</table>';
			$adjust_content .= '</table><button onclick="update(\''.$gameno.'\')">確定更新</button>';
			$end = '</body><script src="../resource/16.js"></script></html>';
			$file = fopen($gameno . "/public.html", "w");
			fwrite($file, $start.$public_content.$end);
			fclose($file);
			$file = fopen($gameno . "/edit.html", "w");
			fwrite($file, $start.$adjust_content.$end);
			fclose($file);
			echo json_encode(array('message' => 'Success', 'gameno' => $gameno));
		}
		elseif ($amount > 16 && $amount <= 32) {
			createGameState(32, $gameno);
			$index = 1;
			for ($i = 1; $i <= 16; $i++) {
				$single = query($gameno, $i*2-1);
				$double = query($gameno, $i*2);
				if ($single['unit'] == 'none') {
					$public_content .= '<tr><td></td><td>Bye</td><td id="p'.($i*4-3).'_1"></td><td id="p'.($i*4-3).'_2"></td><td id="p'.($i*4-3).'_3"></td><td id="p'.($i*4-3).'_4"></td><td id="p'.($i*4-3).'_5"></td></tr><tr><td></td><td></td><td id="p'.($i*4-2).'_1"></td><td id="p'.($i*4-2).'_2"></td><td id="p'.($i*4-2).'_3"></td><td id="p'.($i*4-2).'_4"></td><td id="p'.($i*4-2).'_5"></td></tr><tr><td>'.$double['unit'].'</td><td>'.$double['name'].'</td><td id="p'.($i*4-1).'_1"></td><td id="p'.($i*4-1).'_2"></td><td id="p'.($i*4-1).'_3"></td><td id="p'.($i*4-1).'_4"></td><td id="p'.($i*4-1).'_5"></td></tr><tr><td></td><td></td><td id="p'.($i*4).'_1"></td><td id="p'.($i*4).'_2"></td><td id="p'.($i*4).'_3"></td><td id="p'.($i*4).'_4"></td><td id="p'.($i*4).'_5"></td></tr>';
					$adjust_content .= '<tr><td></td><td>Bye</td><td id="p'.($i*4-3).'_1"></td><td id="p'.($i*4-3).'_2"></td><td id="p'.($i*4-3).'_3"></td><td id="p'.($i*4-3).'_4"></td><td id="p'.($i*4-3).'_5"></td></tr><tr><td></td><td></td><td id="p'.($i*4-2).'_1"></td><td id="p'.($i*4-2).'_2"></td><td id="p'.($i*4-2).'_3"></td><td id="p'.($i*4-2).'_4"></td><td id="p'.($i*4-2).'_5"></td></tr><tr><td>'.$double['unit'].'</td><td>'.$double['name'].'</td><td id="p'.($i*4-1).'_1"></td><td id="p'.($i*4-1).'_2"></td><td id="p'.($i*4-1).'_3"></td><td id="p'.($i*4-1).'_4"></td><td id="p'.($i*4-1).'_5"></td></tr><tr><td></td><td></td><td id="p'.($i*4).'_1"></td><td id="p'.($i*4).'_2"></td><td id="p'.($i*4).'_3"></td><td id="p'.($i*4).'_4"></td><td id="p'.($i*4).'_5"></td></tr>';
				}
				elseif ($double['unit'] == 'none') {
					$public_content .= '<tr><td>'.$single['unit'].'</td><td>'.$single['name'].'</td><td id="p'.($i*4-3).'_1"></td><td id="p'.($i*4-3).'_2"></td><td id="p'.($i*4-3).'_3"></td><td id="p'.($i*4-3).'_4"></td><td id="p'.($i*4-3).'_5"></td></tr><tr><td></td><td></td><td id="p'.($i*4-2).'_1"></td><td id="p'.($i*4-2).'_2"></td><td id="p'.($i*4-2).'_3"></td><td id="p'.($i*4-2).'_4"></td><td id="p'.($i*4-2).'_5"></td></tr><tr><td></td><td>Bye</td><td id="p'.($i*4-1).'_1"></td><td id="p'.($i*4-1).'_2"></td><td id="p'.($i*4-1).'_3"></td><td id="p'.($i*4-1).'_4"></td><td id="p'.($i*4-1).'_5"></td></tr><tr><td></td><td></td><td id="p'.($i*4).'_1"></td><td id="p'.($i*4).'_2"></td><td id="p'.($i*4).'_3"></td><td id="p'.($i*4).'_4"></td><td id="p'.($i*4).'_5"></td></tr>';
					$adjust_content .= '<tr><td>'.$single['unit'].'</td><td>'.$single['name'].'</td><td id="p'.($i*4-3).'_1"></td><td id="p'.($i*4-3).'_2"></td><td id="p'.($i*4-3).'_3"></td><td id="p'.($i*4-3).'_4"></td><td id="p'.($i*4-3).'_5"></td></tr><tr><td></td><td></td><td id="p'.($i*4-2).'_1"></td><td id="p'.($i*4-2).'_2"></td><td id="p'.($i*4-2).'_3"></td><td id="p'.($i*4-2).'_4"></td><td id="p'.($i*4-2).'_5"></td></tr><tr><td></td><td>Bye</td><td id="p'.($i*4-1).'_1"></td><td id="p'.($i*4-1).'_2"></td><td id="p'.($i*4-1).'_3"></td><td id="p'.($i*4-1).'_4"></td><td id="p'.($i*4-1).'_5"></td></tr><tr><td></td><td></td><td id="p'.($i*4).'_1"></td><td id="p'.($i*4).'_2"></td><td id="p'.($i*4).'_3"></td><td id="p'.($i*4).'_4"></td><td id="p'.($i*4).'_5"></td></tr>';
				}
				else {
					$public_content .= '<tr><td>'.$single['unit'].'</td><td>'.$single['name'].'</td><td id="p'.($i*4-3).'_1"></td><td id="p'.($i*4-3).'_2"></td><td id="p'.($i*4-3).'_3"></td><td id="p'.($i*4-3).'_4"></td><td id="p'.($i*4-3).'_5"></td></tr><tr><td></td><td></td><td id="p'.($i*4-2).'_1" align="right">'.$index.'</td><td id="p'.($i*4-2).'_2"></td><td id="p'.($i*4-2).'_3"></td><td id="p'.($i*4-2).'_4"></td><td id="p'.($i*4-2).'_5"></td></tr><tr><td>'.$double['unit'].'</td><td>'.$double['name'].'</td><td id="p'.($i*4-1).'_1"></td><td id="p'.($i*4-1).'_2"></td><td id="p'.($i*4-1).'_3"></td><td id="p'.($i*4-1).'_4"></td><td id="p'.($i*4-1).'_5"></td></tr><tr><td></td><td></td><td id="p'.($i*4).'_1"></td><td id="p'.($i*4).'_2"></td><td id="p'.($i*4).'_3"></td><td id="p'.($i*4).'_4"></td><td id="p'.($i*4).'_5"></td></tr>';
					$adjust_content .= '<tr><td>'.$single['unit'].'</td><td>'.$single['name'].'</td><td id="p'.($i*4-3).'_1"></td><td id="p'.($i*4-3).'_2"></td><td id="p'.($i*4-3).'_3"></td><td id="p'.($i*4-3).'_4"></td><td id="p'.($i*4-3).'_5"></td></tr><tr><td></td><td></td><td id="p'.($i*4-2).'_1" align="right">'.$index.'</td><td id="p'.($i*4-2).'_2"><input type="text" id="'.$index.'_above"></td><td id="p'.($i*4-2).'_3"></td><td id="p'.($i*4-2).'_4"></td><td id="p'.($i*4-2).'_5"></td></tr><tr><td>'.$double['unit'].'</td><td>'.$double['name'].'</td><td id="p'.($i*4-1).'_1"></td><td id="p'.($i*4-1).'_2"><input type="text" id="'.$index.'_below"></td><td id="p'.($i*4-1).'_3"></td><td id="p'.($i*4-1).'_4"></td><td id="p'.($i*4-1).'_5"></td></tr><tr><td></td><td></td><td id="p'.($i*4).'_1"></td><td id="p'.($i*4).'_2"></td><td id="p'.($i*4).'_3"></td><td id="p'.($i*4).'_4"></td><td id="p'.($i*4).'_5"></td></tr>';
					mysql_query("UPDATE GAMESTATE SET PLAYNO='$index' WHERE GAMENO='$gameno' AND SYSTEMPLAYNO=$i");
					$index++;
				}
			}
			for ($i = 1; $i <= 8; $i++) {
				$pos = $i*8-4;
				$public_content = str_replace('<td id="p'.$pos.'_2"></td>', '<td id="p'.$pos.'_2" align="right">'.$index.'</td>', $public_content);
				$adjust_content = str_replace('<td id="p'.$pos.'_2"></td>', '<td id="p'.$pos.'_2" align="right">'.$index.'</td>', $adjust_content);
				$adjust_content = str_replace('<td id="p'.$pos.'_3"></td>', '<td id="p'.$pos.'_3"><input type="text" id="'.$index.'_above"></td>', $adjust_content);
				$adjust_content = str_replace('<td id="p'.($pos+1).'_3"></td>', '<td id="p'.($pos+1).'_3"><input type="text" id="'.$index.'_below"></td>', $adjust_content);
				mysql_query("UPDATE GAMESTATE SET PLAYNO='$index' WHERE GAMENO='$gameno' AND SYSTEMPLAYNO=$i+16");
				$index++;
			}
			for ($i = 1; $i <= 4; $i++) {
				$pos = $i*16-8;
				$public_content = str_replace('<td id="p'.$pos.'_3"></td>', '<td id="p'.$pos.'_3" align="right">'.$index.'</td>', $public_content);
				$adjust_content = str_replace('<td id="p'.$pos.'_3"></td>', '<td id="p'.$pos.'_3" align="right">'.$index.'</td>', $adjust_content);
				$adjust_content = str_replace('<td id="p'.$pos.'_4"></td>', '<td id="p'.$pos.'_4"><input type="text" id="'.$index.'_above"></td>', $adjust_content);
				$adjust_content = str_replace('<td id="p'.($pos+1).'_4"></td>', '<td id="p'.($pos+1).'_4"><input type="text" id="'.$index.'_below"></td>', $adjust_content);
				mysql_query("UPDATE GAMESTATE SET PLAYNO='$index' WHERE GAMENO='$gameno' AND SYSTEMPLAYNO=$i+24");
				$index++;
			}
			for ($i = 1; $i <= 2; $i++) {
				$pos = $i*32-16;
				$public_content = str_replace('<td id="p'.$pos.'_4"></td>', '<td id="p'.$pos.'_4" align="right">'.$index.'</td>', $public_content);
				$adjust_content = str_replace('<td id="p'.$pos.'_4"></td>', '<td id="p'.$pos.'_4" align="right">'.$index.'</td>', $adjust_content);
				$adjust_content = str_replace('<td id="p'.$pos.'_5"></td>', '<td id="p'.$pos.'_5"><input type="text" id="'.$index.'_above"></td>', $adjust_content);
				$adjust_content = str_replace('<td id="p'.($pos+1).'_5"></td>', '<td id="p'.($pos+1).'_5"><input type="text" id="'.$index.'_below"></td>', $adjust_content);
				mysql_query("UPDATE GAMESTATE SET PLAYNO='$index' WHERE GAMENO='$gameno' AND SYSTEMPLAYNO=$i+28");
				$index++;
			}
			$public_content = str_replace('<td id="p32_4"></td>', '<td id="p32_4" align="right">'.$index.'</td>', $public_content);
			$adjust_content = str_replace('<td id="p32_4"></td>', '<td id="p32_4" align="right">'.$index.'</td>', $adjust_content);
			$adjust_content = str_replace('<td id="p32_5"></td>', '<td id="p32_5"><input type="text" id="'.$index.'_above"></td>', $adjust_content);
			$adjust_content = str_replace('<td id="p33_5"></td>', '<td id="p33_5"><input type="text" id="'.$index.'_below"></td>', $adjust_content);
			mysql_query("UPDATE GAMESTATE SET PLAYNO='$index' WHERE GAMENO='$gameno' AND SYSTEMPLAYNO=31");
			$public_content .= '</table>';
			$adjust_content .= '</table><button onclick="update(\''.$gameno.'\')">確定更新</button>';
			$end = '</body><script src="../resource/32.js"></script></html>';
			$file = fopen($gameno . "/public.html", "w");
			fwrite($file, $start.$public_content.$end);
			fclose($file);
			$file = fopen($gameno . "/edit.html", "w");
			fwrite($file, $start.$adjust_content.$end);
			fclose($file);
			echo json_encode(array('message' => 'Success', 'gameno' => $gameno));
		}
		elseif ($amount > 32 && $amount <= 64) {
			createGameState(64, $gameno);
			$index = 1;
			for ($i = 1; $i <= 32; $i++) {
				$single = query($gameno, $i*2-1);
				$double = query($gameno, $i*2);
				if ($single['unit'] == 'none') {
					$public_content .= '<tr><td></td><td>Bye</td><td id="p'.($i*4-3).'_1"></td><td id="p'.($i*4-3).'_2"></td><td id="p'.($i*4-3).'_3"></td><td id="p'.($i*4-3).'_4"></td><td id="p'.($i*4-3).'_5"></td></tr><tr><td></td><td></td><td id="p'.($i*4-2).'_1"></td><td id="p'.($i*4-2).'_2"></td><td id="p'.($i*4-2).'_3"></td><td id="p'.($i*4-2).'_4"></td><td id="p'.($i*4-2).'_5"></td></tr><tr><td>'.$double['unit'].'</td><td>'.$double['name'].'</td><td id="p'.($i*4-1).'_1"></td><td id="p'.($i*4-1).'_2"></td><td id="p'.($i*4-1).'_3"></td><td id="p'.($i*4-1).'_4"></td><td id="p'.($i*4-1).'_5"></td></tr><tr><td></td><td></td><td id="p'.($i*4).'_1"></td><td id="p'.($i*4).'_2"></td><td id="p'.($i*4).'_3"></td><td id="p'.($i*4).'_4"></td><td id="p'.($i*4).'_5"></td></tr>';
					$adjust_content .= '<tr><td></td><td>Bye</td><td id="p'.($i*4-3).'_1"></td><td id="p'.($i*4-3).'_2"></td><td id="p'.($i*4-3).'_3"></td><td id="p'.($i*4-3).'_4"></td><td id="p'.($i*4-3).'_5"></td></tr><tr><td></td><td></td><td id="p'.($i*4-2).'_1"></td><td id="p'.($i*4-2).'_2"></td><td id="p'.($i*4-2).'_3"></td><td id="p'.($i*4-2).'_4"></td><td id="p'.($i*4-2).'_5"></td></tr><tr><td>'.$double['unit'].'</td><td>'.$double['name'].'</td><td id="p'.($i*4-1).'_1"></td><td id="p'.($i*4-1).'_2"></td><td id="p'.($i*4-1).'_3"></td><td id="p'.($i*4-1).'_4"></td><td id="p'.($i*4-1).'_5"></td></tr><tr><td></td><td></td><td id="p'.($i*4).'_1"></td><td id="p'.($i*4).'_2"></td><td id="p'.($i*4).'_3"></td><td id="p'.($i*4).'_4"></td><td id="p'.($i*4).'_5"></td></tr>';
				}
				elseif ($double['unit'] == 'none') {
					$public_content .= '<tr><td>'.$single['unit'].'</td><td>'.$single['name'].'</td><td id="p'.($i*4-3).'_1"></td><td id="p'.($i*4-3).'_2"></td><td id="p'.($i*4-3).'_3"></td><td id="p'.($i*4-3).'_4"></td><td id="p'.($i*4-3).'_5"></td></tr><tr><td></td><td></td><td id="p'.($i*4-2).'_1"></td><td id="p'.($i*4-2).'_2"></td><td id="p'.($i*4-2).'_3"></td><td id="p'.($i*4-2).'_4"></td><td id="p'.($i*4-2).'_5"></td></tr><tr><td></td><td>Bye</td><td id="p'.($i*4-1).'_1"></td><td id="p'.($i*4-1).'_2"></td><td id="p'.($i*4-1).'_3"></td><td id="p'.($i*4-1).'_4"></td><td id="p'.($i*4-1).'_5"></td></tr><tr><td></td><td></td><td id="p'.($i*4).'_1"></td><td id="p'.($i*4).'_2"></td><td id="p'.($i*4).'_3"></td><td id="p'.($i*4).'_4"></td><td id="p'.($i*4).'_5"></td></tr>';
					$adjust_content .= '<tr><td>'.$single['unit'].'</td><td>'.$single['name'].'</td><td id="p'.($i*4-3).'_1"></td><td id="p'.($i*4-3).'_2"></td><td id="p'.($i*4-3).'_3"></td><td id="p'.($i*4-3).'_4"></td><td id="p'.($i*4-3).'_5"></td></tr><tr><td></td><td></td><td id="p'.($i*4-2).'_1"></td><td id="p'.($i*4-2).'_2"></td><td id="p'.($i*4-2).'_3"></td><td id="p'.($i*4-2).'_4"></td><td id="p'.($i*4-2).'_5"></td></tr><tr><td></td><td>Bye</td><td id="p'.($i*4-1).'_1"></td><td id="p'.($i*4-1).'_2"></td><td id="p'.($i*4-1).'_3"></td><td id="p'.($i*4-1).'_4"></td><td id="p'.($i*4-1).'_5"></td></tr><tr><td></td><td></td><td id="p'.($i*4).'_1"></td><td id="p'.($i*4).'_2"></td><td id="p'.($i*4).'_3"></td><td id="p'.($i*4).'_4"></td><td id="p'.($i*4).'_5"></td></tr>';
				}
				else {
					$public_content .= '<tr><td>'.$single['unit'].'</td><td>'.$single['name'].'</td><td id="p'.($i*4-3).'_1"></td><td id="p'.($i*4-3).'_2"></td><td id="p'.($i*4-3).'_3"></td><td id="p'.($i*4-3).'_4"></td><td id="p'.($i*4-3).'_5"></td></tr><tr><td></td><td></td><td id="p'.($i*4-2).'_1" align="right">'.$index.'</td><td id="p'.($i*4-2).'_2"></td><td id="p'.($i*4-2).'_3"></td><td id="p'.($i*4-2).'_4"></td><td id="p'.($i*4-2).'_5"></td></tr><tr><td>'.$double['unit'].'</td><td>'.$double['name'].'</td><td id="p'.($i*4-1).'_1"></td><td id="p'.($i*4-1).'_2"></td><td id="p'.($i*4-1).'_3"></td><td id="p'.($i*4-1).'_4"></td><td id="p'.($i*4-1).'_5"></td></tr><tr><td></td><td></td><td id="p'.($i*4).'_1"></td><td id="p'.($i*4).'_2"></td><td id="p'.($i*4).'_3"></td><td id="p'.($i*4).'_4"></td><td id="p'.($i*4).'_5"></td></tr>';
					$adjust_content .= '<tr><td>'.$single['unit'].'</td><td>'.$single['name'].'</td><td id="p'.($i*4-3).'_1"></td><td id="p'.($i*4-3).'_2"></td><td id="p'.($i*4-3).'_3"></td><td id="p'.($i*4-3).'_4"></td><td id="p'.($i*4-3).'_5"></td></tr><tr><td></td><td></td><td id="p'.($i*4-2).'_1" align="right">'.$index.'</td><td id="p'.($i*4-2).'_2"><input type="text" id="'.$index.'_above"></td><td id="p'.($i*4-2).'_3"></td><td id="p'.($i*4-2).'_4"></td><td id="p'.($i*4-2).'_5"></td></tr><tr><td>'.$double['unit'].'</td><td>'.$double['name'].'</td><td id="p'.($i*4-1).'_1"></td><td id="p'.($i*4-1).'_2"><input type="text" id="'.$index.'_below"></td><td id="p'.($i*4-1).'_3"></td><td id="p'.($i*4-1).'_4"></td><td id="p'.($i*4-1).'_5"></td></tr><tr><td></td><td></td><td id="p'.($i*4).'_1"></td><td id="p'.($i*4).'_2"></td><td id="p'.($i*4).'_3"></td><td id="p'.($i*4).'_4"></td><td id="p'.($i*4).'_5"></td></tr>';
					mysql_query("UPDATE GAMESTATE SET PLAYNO='$index' WHERE GAMENO='$gameno' AND SYSTEMPLAYNO=$i");
					$index++;
				}
			}
			for ($i = 1; $i <= 16; $i++) {
				$pos = $i*8-4;
				$public_content = str_replace('<td id="p'.$pos.'_2"></td>', '<td id="p'.$pos.'_2" align="right">'.$index.'</td>', $public_content);
				$adjust_content = str_replace('<td id="p'.$pos.'_2"></td>', '<td id="p'.$pos.'_2" align="right">'.$index.'</td>', $adjust_content);
				$adjust_content = str_replace('<td id="p'.$pos.'_3"></td>', '<td id="p'.$pos.'_3"><input type="text" id="'.$index.'_above"></td>', $adjust_content);
				$adjust_content = str_replace('<td id="p'.($pos+1).'_3"></td>', '<td id="p'.($pos+1).'_3"><input type="text" id="'.$index.'_below"></td>', $adjust_content);
				mysql_query("UPDATE GAMESTATE SET PLAYNO='$index' WHERE GAMENO='$gameno' AND SYSTEMPLAYNO=$i+32");
				$index++;
			}
			for ($i = 1; $i <= 8; $i++) {
				$pos = $i*16-8;
				$public_content = str_replace('<td id="p'.$pos.'_3"></td>', '<td id="p'.$pos.'_3" align="right">'.$index.'</td>', $public_content);
				$adjust_content = str_replace('<td id="p'.$pos.'_3"></td>', '<td id="p'.$pos.'_3" align="right">'.$index.'</td>', $adjust_content);
				$adjust_content = str_replace('<td id="p'.$pos.'_4"></td>', '<td id="p'.$pos.'_4"><input type="text" id="'.$index.'_above"></td>', $adjust_content);
				$adjust_content = str_replace('<td id="p'.($pos+1).'_4"></td>', '<td id="p'.($pos+1).'_4"><input type="text" id="'.$index.'_below"></td>', $adjust_content);
				mysql_query("UPDATE GAMESTATE SET PLAYNO='$index' WHERE GAMENO='$gameno' AND SYSTEMPLAYNO=$i+48");
				$index++;
			}
			for ($i = 1; $i <= 4; $i++) {
				$pos = $i*32-16;
				$public_content = str_replace('<td id="p'.$pos.'_4"></td>', '<td id="p'.$pos.'_4" align="right">'.$index.'</td>', $public_content);
				$adjust_content = str_replace('<td id="p'.$pos.'_4"></td>', '<td id="p'.$pos.'_4" align="right">'.$index.'</td>', $adjust_content);
				$adjust_content = str_replace('<td id="p'.$pos.'_5"></td>', '<td id="p'.$pos.'_5"><input type="text" id="'.$index.'_above"></td>', $adjust_content);
				$adjust_content = str_replace('<td id="p'.($pos+1).'_5"></td>', '<td id="p'.($pos+1).'_5"><input type="text" id="'.$index.'_below"></td>', $adjust_content);
				mysql_query("UPDATE GAMESTATE SET PLAYNO='$index' WHERE GAMENO='$gameno' AND SYSTEMPLAYNO=$i+56");
				$index++;
			}
			for ($i = 1; $i <= 2; $i++) {
				$pos = $i*64-32;
				$public_content = str_replace('<td id="p'.$pos.'_5"></td>', '<td id="p'.$pos.'_5" align="right">'.$index.'</td>', $public_content);
				$adjust_content = str_replace('<td id="p'.$pos.'_5"></td>', '<td id="p'.$pos.'_5" align="right">'.$index.'</td>', $adjust_content);
				$adjust_content = str_replace('<td id="p'.$pos.'_6"></td>', '<td id="p'.$pos.'_6"><input type="text" id="'.$index.'_above"></td>', $adjust_content);
				$adjust_content = str_replace('<td id="p'.($pos+1).'_6"></td>', '<td id="p'.($pos+1).'_6"><input type="text" id="'.$index.'_below"></td>', $adjust_content);
				mysql_query("UPDATE GAMESTATE SET PLAYNO='$index' WHERE GAMENO='$gameno' AND SYSTEMPLAYNO=$i+60");
				$index++;
			}
			$public_content = str_replace('<td id="p64_6"></td>', '<td id="p64_6" align="right>'.$index.'</td>', $public_content);
			$adjust_content = str_replace('<td id="p64_6"></td>', '<td id="p64_6" align="right>'.$index.'</td>', $adjust_content);
			$adjust_content = str_replace('<td id="p64_7"></td>', '<td id="p64_7"><input type="text" id="'.$index.'_above"></td>', $adjust_content);
			$adjust_content = str_replace('<td id="p65_7"></td>', '<td id="p65_7"><input type="text" id="'.$index.'_below"></td>', $adjust_content);
			mysql_query("UPDATE GAMESTATE SET PLAYNO='$index' WHERE GAMENO='$gameno' AND SYSTEMPLAYNO=63");
			$public_content .= '</table>';
			$adjust_content .= '</table><button onclick="update(\''.$gameno.'\')">確定更新</button>';
			$end = '</body><script src="../resource/64.js"></script></html>';
			$file = fopen($gameno . "/public.html", "w");
			fwrite($file, $start.$public_content.$end);
			fclose($file);
			$file = fopen($gameno . "/edit.html", "w");
			fwrite($file, $start.$adjust_content.$end);
			fclose($file);
			echo json_encode(array('message' => 'Success', 'gameno' => $gameno));
		}
		unlink($gameno . "/assign.html");
	}
}

function is_validAmount($amount) {
	if ((ceil($amount) == floor($amount)) && $amount >= 9 && $amount <=64) {
		return true;
	}
	else {
		return false;
	}
}

function query($gameno, $index) {
	$sql = mysql_query("SELECT * FROM GAMEPOSITION WHERE GAMENO='$gameno' AND POSITION='$index'");
	$fetch = mysql_fetch_array($sql);
	return array('unit' => $fetch['UNIT'], 'name' => $fetch['NAME']);
}

function createGameState($amount, $gameno) {
	if (in_array($amount, array(16,32,64))) {
		for ($i = 1; $i < $amount; $i++) {
			if ($i <= $amount/2) {
				mysql_query("INSERT INTO GAMESTATE (GAMENO, SYSTEMPLAYNO, ABOVE, BELOW) VALUES ('$gameno', $i, $i*2-1, $i*2)");
			}
			else {
				mysql_query("INSERT INTO GAMESTATE (GAMENO, SYSTEMPLAYNO) VALUES ('$gameno', $i)");
			}
		}
	}
}