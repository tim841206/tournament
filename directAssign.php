<?php
include_once("resource/custom.php");

$account = $_COOKIE['account'];
$gameno = $_POST['gameno'];
$gamenm = $_POST['gamenm'];
$amount = $_POST['amount'];
$playtype = $_POST['playtype'];
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
elseif ($sql != false) {
	echo json_encode(array('message' => 'Used game index'));
}
else {
	$arrange = array();
	$roundAmount = pow(2, ceil(log($amount, 2)));
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
	$start = '<!DOCTYPE html><html lang="en"><head><meta charset="utf-8"><meta name="viewport" content="width=device-width, initial-scale=1"><title>電子化賽程系統</title><link rel="stylesheet" type="text/css" href="resource/custom.css"><script src="resource/custom.js"></script></head><body>';
	$content = '<table><tr><td>單位</td><td>名稱</td></tr>';
	for ($i = 1; $i <= $roundAmount; $i++) {
		if (in_array($i, $arrange)) {
			$content .= getTreeTable($i, 2, array('', 'Bye'), array('', ''));
		}
		else {
			if ($playtype == 'A') {
				$content .= getTreeTable($i, 2, array('<input type="text" id="unit'.$i.'">', '<input type="text" id="name'.$i.'">'), array('', ''));
			}
			elseif ($playtype == 'B') {
				$content .= getTreeTable($i, 2, array('<input type="text" id="unit'.$i.'u">', '<input type="text" id="name'.$i.'u">'), array('<input type="text" id="unit'.$i.'d">', '<input type="text" id="name'.$i.'d">'));
			}
			elseif ($playtype == 'C') {
				$content .= getTreeTable($i, 2, array('<input type="text" id="unit'.$i.'">', ''), array('', ''));
			}
		}
	}
	$content .= '</table><button onclick="public('.$amount.', \''.$gameno.'\', \''.$gamenm.'\', \''.$playtype.'\')">確定輸出</button>';
	$end = '</body><script src="resource/'.$roundAmount.'.js"></script></html>';
	if (is_dir($account.'/'.$gameno)) {
		if (is_file($account.'/'.$gameno."/assign.html")) {
			unlink($account.'/'.$gameno."/assign.html");
		}
	}
	else {
		mkdir($account.'/'.$gameno);
	}
	$file = fopen($account.'/'.$gameno."/assign.html", "w");
	fwrite($file, $start.$content.$end);
	fclose($file);
	echo json_encode(array('message' => 'Success', 'host' => $account, 'gameno' => $gameno, 'type' => 'assign'));
}

function is_validAmount($amount) {
	if ((ceil($amount) == floor($amount)) && $amount >= 4 && $amount <= 128) {
		return true;
	}
	else {
		return false;
	}
}