<?php
$gameno = $_POST['gameno'];
$amount = $_POST['amount'];
if (!is_validAmount($amount)) {
	echo json_encode(array('message' => 'Invalid player amount'));
}
else {
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
	$start = '<!DOCTYPE html><html lang="en"><head><meta charset="utf-8"><meta name="viewport" content="width=device-width, initial-scale=1"><title>電子化賽程系統</title><link rel="stylesheet" type="text/css" href="../resource/custom.css"><script src="../resource/custom.js"></script></head><body>';
	$end = '';
	$content = '<table><tr><td>單位</td><td>名稱</td></tr>';
	if ($amount > 8 && $amount <= 16) {
		for ($i = 1; $i <= 16; $i++) {
			if (in_array($i, $arrange[$amount])) {
				$content .= '<tr><td></td><td>Bye</td><td id="p'.($i*2-1).'_1"></td><td id="p'.($i*2-1).'_2"></td><td id="p'.($i*2-1).'_3"></td><td id="p'.($i*2-1).'_4"></td><td id="p'.($i*2-1).'_5"></td></tr><tr><td></td><td></td><td id="p'.($i*2).'_1"></td><td id="p'.($i*2).'_2"></td><td id="p'.($i*2).'_3"></td><td id="p'.($i*2).'_4"></td><td id="p'.($i*2).'_5"></td></tr>';
			}
			else {
				$content .= '<tr><td><input type="text" id="unit'.$i.'"></td><td><input type="text" id="name'.$i.'"></td><td id="p'.($i*2-1).'_1"></td><td id="p'.($i*2-1).'_2"></td><td id="p'.($i*2-1).'_3"></td><td id="p'.($i*2-1).'_4"></td><td id="p'.($i*2-1).'_5"></td></tr><tr><td></td><td></td><td id="p'.($i*2).'_1"></td><td id="p'.($i*2).'_2"></td><td id="p'.($i*2).'_3"></td><td id="p'.($i*2).'_4"></td><td id="p'.($i*2).'_5"></td></tr>';
			}
		}
		$end = '</body><script src="../resource/16.js"></script></html>';
	}
	elseif ($amount > 16 && $amount <= 32) {
		for ($i = 1; $i <= 32; $i++) {
			if (in_array($i, $arrange[$amount])) {
				$content .= '<tr><td></td><td>Bye</td><td id="p'.($i*2-1).'_1"></td><td id="p'.($i*2-1).'_2"></td><td id="p'.($i*2-1).'_3"></td><td id="p'.($i*2-1).'_4"></td><td id="p'.($i*2-1).'_5"></td></tr><tr><td></td><td></td><td id="p'.($i*2).'_1"></td><td id="p'.($i*2).'_2"></td><td id="p'.($i*2).'_3"></td><td id="p'.($i*2).'_4"></td><td id="p'.($i*2).'_5"></td></tr>';
			}
			else {
				$content .= '<tr><td><input type="text" id="unit'.$i.'"></td><td><input type="text" id="name'.$i.'"></td><td id="p'.($i*2-1).'_1"></td><td id="p'.($i*2-1).'_2"></td><td id="p'.($i*2-1).'_3"></td><td id="p'.($i*2-1).'_4"></td><td id="p'.($i*2-1).'_5"></td></tr><tr><td></td><td></td><td id="p'.($i*2).'_1"></td><td id="p'.($i*2).'_2"></td><td id="p'.($i*2).'_3"></td><td id="p'.($i*2).'_4"></td><td id="p'.($i*2).'_5"></td></tr>';
			}
		}
		$end = '</body><script src="../resource/32.js"></script></html>';
	}
	elseif ($amount > 32 && $amount <= 64) {
		for ($i = 1; $i <= 64; $i++) {
			if (in_array($i, $arrange[$amount])) {
				$content .= '<tr><td></td><td>Bye</td><td id="p'.($i*2-1).'_1"></td><td id="p'.($i*2-1).'_2"></td><td id="p'.($i*2-1).'_3"></td><td id="p'.($i*2-1).'_4"></td><td id="p'.($i*2-1).'_5"></td></tr><tr><td></td><td></td><td id="p'.($i*2).'_1"></td><td id="p'.($i*2).'_2"></td><td id="p'.($i*2).'_3"></td><td id="p'.($i*2).'_4"></td><td id="p'.($i*2).'_5"></td></tr>';
			}
			else {
				$content .= '<tr><td><input type="text" id="unit'.$i.'"></td><td><input type="text" id="name'.$i.'"></td><td id="p'.($i*2-1).'_1"></td><td id="p'.($i*2-1).'_2"></td><td id="p'.($i*2-1).'_3"></td><td id="p'.($i*2-1).'_4"></td><td id="p'.($i*2-1).'_5"></td></tr><tr><td></td><td></td><td id="p'.($i*2).'_1"></td><td id="p'.($i*2).'_2"></td><td id="p'.($i*2).'_3"></td><td id="p'.($i*2).'_4"></td><td id="p'.($i*2).'_5"></td></tr>';
			}
		}
		$end = '</body><script src="../resource/64.js"></script></html>';
	}
	$content .= '</table><button onclick="public('.$amount.', \''.$gameno.'\')">確定輸出</button>';
	mkdir($gameno);
	$file = fopen($gameno . "/assign.html", "w");
	fwrite($file, $start.$content.$end);
	fclose($file);
	echo json_encode(array('message' => 'Success'));
}

function is_validAmount($amount) {
	if ((ceil($amount) == floor($amount)) && $amount >= 9 && $amount <= 64) {
		return true;
	}
	else {
		return false;
	}
}