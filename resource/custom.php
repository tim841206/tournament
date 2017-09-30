<?php
include_once("database.php");

function makePublic($account, $gameno) {
	$type = getGametype($account, $gameno);
	$start = ($type == 'A') ? '<!DOCTYPE html><html lang="en"><head><meta charset="utf-8"><meta name="viewport" content="width=device-width, initial-scale=1"><title>電子化賽程系統</title><link rel="stylesheet" type="text/css" href="../../resource/custom.css"></head><body>' : '<!DOCTYPE html><html lang="en"><head><meta charset="utf-8"><meta name="viewport" content="width=device-width, initial-scale=1"><title>電子化賽程系統</title><link rel="stylesheet" type="text/css" href="../../resource/tournament.css"><link rel="stylesheet" type="text/css" href="../../resource/custom.css"></head><body>';
	$content = ($type == 'A') ? publicContent($account, $gameno) : cyclePublicContent($account, $gameno);
	$amount = getAmount($account, $gameno);
	$distribute = distribute($amount);
	$roundAmount = ($type == 'A') ? pow(2, ceil(log($amount, 2))) : $distribute['round'];
	$end = '</body><script src="../../resource/'.$roundAmount.'.js"></script></html>';
	$file = fopen($account.'/'.$gameno."/public.html", "w");
	fwrite($file, $start.$content.$end);
	fclose($file);
}

function makeEdit($account, $gameno) {
	$type = getGametype($account, $gameno);
	$start = ($type == 'A') ? '<!DOCTYPE html><html lang="en"><head><meta charset="utf-8"><meta name="viewport" content="width=device-width, initial-scale=1"><title>電子化賽程系統</title><link rel="stylesheet" type="text/css" href="../../resource/custom.css"></head><body>' : '<!DOCTYPE html><html lang="en"><head><meta charset="utf-8"><meta name="viewport" content="width=device-width, initial-scale=1"><title>電子化賽程系統</title><link rel="stylesheet" type="text/css" href="../../resource/tournament.css"><link rel="stylesheet" type="text/css" href="../../resource/custom.css"></head><body>';
	$content = ($type == 'A') ? editContent($account, $gameno) : cycleEditContent($account, $gameno);
	$amount = getAmount($account, $gameno);
	$distribute = distribute($amount);
	$roundAmount = ($type == 'A') ? pow(2, ceil(log($amount, 2))) : $distribute['round'];
	$end = '</body><script src="../../resource/'.$roundAmount.'.js"></script></html>';
	$file = fopen($account.'/'.$gameno . "/edit.html", "w");
	fwrite($file, $start.$content.$end);
	fclose($file);
}

function publicContent($account, $gameno) {
	$amount = getAmount($account, $gameno);
	$content = '<table><tr><td>單位</td><td>名稱</td></tr>';
	for ($i = 1; $i <= pow(2, ceil(log($amount, 2))); $i++) {
		$query = queryPosition($account, $gameno, $i);
		$content .= '<tr><td>'.processUnit($query['unit']).'</td><td>'.processName($query['name']).'</td><td id="p'.($i*2-1).'_1"></td><td id="p'.($i*2-1).'_2"></td><td id="p'.($i*2-1).'_3"></td><td id="p'.($i*2-1).'_4"></td><td id="p'.($i*2-1).'_5"></td><td id="p'.($i*2-1).'_6"></td><td id="p'.($i*2-1).'_7"></td><td id="p'.($i*2-1).'_8"></td></tr><tr><td></td><td></td><td id="p'.($i*2).'_1"></td><td id="p'.($i*2).'_2"></td><td id="p'.($i*2).'_3"></td><td id="p'.($i*2).'_4"></td><td id="p'.($i*2).'_5"></td><td id="p'.($i*2).'_6"></td><td id="p'.($i*2).'_7"></td><td id="p'.($i*2).'_8"></td></tr>';
	}
	$content = setPlayNo($account, $gameno, $content, $amount);
	$content .= '</table><button onclick="window.open(\'game.html\')">賽程表</button>';
	return $content;
}

function editContent($account, $gameno) {
	$amount = getAmount($account, $gameno);
	$content = '<script src="../resource/custom.js"></script><table><tr><td>單位</td><td>名稱</td></tr>';
	for ($i = 1; $i <= pow(2, ceil(log($amount, 2))); $i++) {
		$query = queryPosition($account, $account, $gameno, $i);
		$content .= '<tr><td>'.processUnit($query['unit']).'</td><td>'.processName($query['name']).'</td><td id="p'.($i*2-1).'_1"></td><td id="p'.($i*2-1).'_2"></td><td id="p'.($i*2-1).'_3"></td><td id="p'.($i*2-1).'_4"></td><td id="p'.($i*2-1).'_5"></td><td id="p'.($i*2-1).'_6"></td><td id="p'.($i*2-1).'_7"></td><td id="p'.($i*2-1).'_8"></td></tr><tr><td></td><td></td><td id="p'.($i*2).'_1"></td><td id="p'.($i*2).'_2"></td><td id="p'.($i*2).'_3"></td><td id="p'.($i*2).'_4"></td><td id="p'.($i*2).'_5"></td><td id="p'.($i*2).'_6"></td><td id="p'.($i*2).'_7"></td><td id="p'.($i*2).'_8"></td></tr>';
	}
	$content = setPlayNo($account, $gameno, $content, $amount);
	$content = setScoreInput($account, $gameno, $content, $amount);
	$content .= '</table><button onclick="update(\''.$gameno.'\')">確定更新</button><button onclick="window.open(\'game.html\')">賽程表</button>';
	return $content;
}

function cyclePublicContent($account, $gameno) {
	$amount = getAmount($account, $gameno);
	$distribute = distribute($amount);
	$gap = 2 * ($distribute['4_1'] + $distribute['4_2']) + $distribute['3_1'] + $distribute['3_2'];
	$label = array(' ', 'A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z', 'AA', 'AB', 'AC', 'AD', 'AE', 'AF', 'AG', 'AH', 'AI', 'AJ', 'AK', 'AL', 'AM', 'AN', 'AO', 'AP', 'AQ', 'AR', 'AS', 'AT', 'AU', 'AV', 'AW', 'AX', 'AY', 'AZ');
	$content = '';
	$total = 1;
	$game = 1;
	$pos = 1;
	$up = array();
	for ($i = 1; $i <= $distribute['4_2']; $i++) {
		$query1 = queryPosition($account, $gameno, $pos);
		$query2 = queryPosition($account, $gameno, $pos+1);
		$query3 = queryPosition($account, $gameno, $pos+2);
		$query4 = queryPosition($account, $gameno, $pos+3);
		$square = file_get_contents("resource/square_view.html");
		$square = str_replace('[label]', $label[$total], $square);
		$square = str_replace('[game1]', $game, $square);
		$square = str_replace('[game2]', $gap + $game, $square);
		$square = str_replace('[game3]', 2*$gap + $game, $square);
		$square = str_replace('[game4]', 2*$gap + $game+1, $square);
		$square = str_replace('[game5]', $gap + $game+1, $square);
		$square = str_replace('[game6]', $game+1, $square);
		$square = str_replace('[pos1]', $pos, $square);
		$square = str_replace('[pos2]', $pos+1, $square);
		$square = str_replace('[pos3]', $pos+2, $square);
		$square = str_replace('[pos4]', $pos+3, $square);
		$square = str_replace('[unit'.$pos.']', $query1['unit'], $square);
		$square = str_replace('[name'.$pos.']', $query1['name'], $square);
		$square = str_replace('[unit'.($pos+1).']', $query2['unit'], $square);
		$square = str_replace('[name'.($pos+1).']', $query2['name'], $square);
		$square = str_replace('[unit'.($pos+2).']', $query3['unit'], $square);
		$square = str_replace('[name'.($pos+2).']', $query3['name'], $square);
		$square = str_replace('[unit'.($pos+3).']', $query4['unit'], $square);
		$square = str_replace('[name'.($pos+3).']', $query4['name'], $square);
		$content .= $square;
		array_push($up, $label[$total].'冠');
		array_push($up, $label[$total].'亞');
		$total++;
		$game += 6;
		$pos += 4;
	}
	for ($i = 1; $i <= $distribute['4_1']; $i++) {
		$query1 = queryPosition($account, $gameno, $pos);
		$query2 = queryPosition($account, $gameno, $pos+1);
		$query3 = queryPosition($account, $gameno, $pos+2);
		$query4 = queryPosition($account, $gameno, $pos+3);
		$square = file_get_contents("resource/square_view.html");
		$square = str_replace('[label]', $label[$total], $square);
		$square = str_replace('[game1]', $game, $square);
		$square = str_replace('[game2]', $gap + $game, $square);
		$square = str_replace('[game3]', 2*$gap + $game, $square);
		$square = str_replace('[game4]', 2*$gap + $game+1, $square);
		$square = str_replace('[game5]', $gap + $game+1, $square);
		$square = str_replace('[game6]', $game+1, $square);
		$square = str_replace('[pos1]', $pos, $square);
		$square = str_replace('[pos2]', $pos+1, $square);
		$square = str_replace('[pos3]', $pos+2, $square);
		$square = str_replace('[pos4]', $pos+3, $square);
		$square = str_replace('[unit'.$pos.']', $query1['unit'], $square);
		$square = str_replace('[name'.$pos.']', $query1['name'], $square);
		$square = str_replace('[unit'.($pos+1).']', $query2['unit'], $square);
		$square = str_replace('[name'.($pos+1).']', $query2['name'], $square);
		$square = str_replace('[unit'.($pos+2).']', $query3['unit'], $square);
		$square = str_replace('[name'.($pos+2).']', $query3['name'], $square);
		$square = str_replace('[unit'.($pos+3).']', $query4['unit'], $square);
		$square = str_replace('[name'.($pos+3).']', $query4['name'], $square);
		$content .= $square;
		array_push($up, $label[$total].'冠');
		$total++;
		$game += 6;
		$pos += 4;
	}
	for ($i = 1; $i <= $distribute['3_1']; $i++) {
		$query1 = queryPosition($account, $gameno, $pos);
		$query2 = queryPosition($account, $gameno, $pos+1);
		$query3 = queryPosition($account, $gameno, $pos+2);
		$triangle = file_get_contents("resource/triangle_view.html");
		$triangle = str_replace('[label]', $label[$total], $triangle);
		$triangle = str_replace('[game1]', $game, $triangle);
		$triangle = str_replace('[game2]', $gap + $game, $triangle);
		$triangle = str_replace('[game3]', 2*$gap + $game, $triangle);
		$triangle = str_replace('[pos1]', $pos, $triangle);
		$triangle = str_replace('[pos2]', $pos+1, $triangle);
		$triangle = str_replace('[pos3]', $pos+2, $triangle);
		$triangle = str_replace('[unit'.$pos.']', $query1['unit'], $triangle);
		$triangle = str_replace('[name'.$pos.']', $query1['name'], $triangle);
		$triangle = str_replace('[unit'.($pos+1).']', $query2['unit'], $triangle);
		$triangle = str_replace('[name'.($pos+1).']', $query2['name'], $triangle);
		$triangle = str_replace('[unit'.($pos+2).']', $query3['unit'], $triangle);
		$triangle = str_replace('[name'.($pos+2).']', $query3['name'], $triangle);
		$content .= $triangle;
		array_push($up, $label[$total].'冠');
		$total++;
		$game += 3;
		$pos += 3;
	}
	for ($i = 1; $i <= $distribute['3_2']; $i++) {
		$query1 = queryPosition($account, $gameno, $pos);
		$query2 = queryPosition($account, $gameno, $pos+1);
		$query3 = queryPosition($account, $gameno, $pos+2);
		$triangle = file_get_contents("resource/triangle_view.html");
		$triangle = str_replace('[label]', $label[$total], $triangle);
		$triangle = str_replace('[game1]', $game, $triangle);
		$triangle = str_replace('[game2]', $gap + $game, $triangle);
		$triangle = str_replace('[game3]', 2*$gap + $game, $triangle);
		$triangle = str_replace('[pos1]', $pos, $triangle);
		$triangle = str_replace('[pos2]', $pos+1, $triangle);
		$triangle = str_replace('[pos3]', $pos+2, $triangle);
		$triangle = str_replace('[unit'.$pos.']', $query1['unit'], $triangle);
		$triangle = str_replace('[name'.$pos.']', $query1['name'], $triangle);
		$triangle = str_replace('[unit'.($pos+1).']', $query2['unit'], $triangle);
		$triangle = str_replace('[name'.($pos+1).']', $query2['name'], $triangle);
		$triangle = str_replace('[unit'.($pos+2).']', $query3['unit'], $triangle);
		$triangle = str_replace('[name'.($pos+2).']', $query3['name'], $triangle);
		$content .= $triangle;
		array_push($up, $label[$total].'冠');
		array_push($up, $label[$total].'亞');
		$total++;
		$game += 3;
		$pos += 3;
	}
	shuffle($up);
	for ($i = 1; $i <= $distribute['round']; $i++) {
		$content .= '<tr><td id="unit'.$i.'">'.array_pop($up).'</td><td id="p'.($i*2-1).'_1"></td><td id="p'.($i*2-1).'_2"></td><td id="p'.($i*2-1).'_3"></td><td id="p'.($i*2-1).'_4"></td><td id="p'.($i*2-1).'_5"></td><td id="p'.($i*2-1).'_6"></td><td id="p'.($i*2-1).'_7"></td><td id="p'.($i*2-1).'_8"></td></tr><tr><td></td><td id="p'.($i*2).'_1"></td><td id="p'.($i*2).'_2"></td><td id="p'.($i*2).'_3"></td><td id="p'.($i*2).'_4"></td><td id="p'.($i*2).'_5"></td><td id="p'.($i*2).'_6"></td><td id="p'.($i*2).'_7"></td><td id="p'.($i*2).'_8"></td></tr>';
	}
	// $content = setPlayNo($account, $gameno, $content, $distribute['round']);
	$content .= '</table><button onclick="window.open(\'game.html\')">賽程表</button>';
	return $content;
}

function cycleEditContent($account, $gameno) {
	$amount = getAmount($account, $gameno);
	$distribute = distribute($amount);
	$gap = 2 * ($distribute['4_1'] + $distribute['4_2']) + $distribute['3_1'] + $distribute['3_2'];
	$label = array(' ', 'A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z', 'AA', 'AB', 'AC', 'AD', 'AE', 'AF', 'AG', 'AH', 'AI', 'AJ', 'AK', 'AL', 'AM', 'AN', 'AO', 'AP', 'AQ', 'AR', 'AS', 'AT', 'AU', 'AV', 'AW', 'AX', 'AY', 'AZ');
	$content = '';
	$total = 1;
	$game = 1;
	$pos = 1;
	$up = array();
	for ($i = 1; $i <= $distribute['4_2']; $i++) {
		$query1 = queryPosition($account, $gameno, $pos);
		$query2 = queryPosition($account, $gameno, $pos+1);
		$query3 = queryPosition($account, $gameno, $pos+2);
		$query4 = queryPosition($account, $gameno, $pos+3);
		$square = file_get_contents("resource/square_edit.html");
		$square = str_replace('[label]', $label[$total], $square);
		$square = str_replace('[game1]', $game, $square);
		$square = str_replace('[game2]', $gap + $game, $square);
		$square = str_replace('[game3]', 2*$gap + $game, $square);
		$square = str_replace('[game4]', 2*$gap + $game+1, $square);
		$square = str_replace('[game5]', $gap + $game+1, $square);
		$square = str_replace('[game6]', $game+1, $square);
		$square = str_replace('[pos1]', $pos, $square);
		$square = str_replace('[pos2]', $pos+1, $square);
		$square = str_replace('[pos3]', $pos+2, $square);
		$square = str_replace('[pos4]', $pos+3, $square);
		$square = str_replace('[unit'.$pos.']', $query1['unit'], $square);
		$square = str_replace('[name'.$pos.']', $query1['name'], $square);
		$square = str_replace('[unit'.($pos+1).']', $query2['unit'], $square);
		$square = str_replace('[name'.($pos+1).']', $query2['name'], $square);
		$square = str_replace('[unit'.($pos+2).']', $query3['unit'], $square);
		$square = str_replace('[name'.($pos+2).']', $query3['name'], $square);
		$square = str_replace('[unit'.($pos+3).']', $query4['unit'], $square);
		$square = str_replace('[name'.($pos+3).']', $query4['name'], $square);
		$content .= $square;
		array_push($up, $label[$total].'冠');
		array_push($up, $label[$total].'亞');
		$total++;
		$game += 2;
		$pos += 4;
	}
	for ($i = 1; $i <= $distribute['4_1']; $i++) {
		$query1 = queryPosition($account, $gameno, $pos);
		$query2 = queryPosition($account, $gameno, $pos+1);
		$query3 = queryPosition($account, $gameno, $pos+2);
		$query4 = queryPosition($account, $gameno, $pos+3);
		$square = file_get_contents("resource/square_edit.html");
		$square = str_replace('[label]', $label[$total], $square);
		$square = str_replace('[game1]', $game, $square);
		$square = str_replace('[game2]', $gap + $game, $square);
		$square = str_replace('[game3]', 2*$gap + $game, $square);
		$square = str_replace('[game4]', 2*$gap + $game+1, $square);
		$square = str_replace('[game5]', $gap + $game+1, $square);
		$square = str_replace('[game6]', $game+1, $square);
		$square = str_replace('[pos1]', $pos, $square);
		$square = str_replace('[pos2]', $pos+1, $square);
		$square = str_replace('[pos3]', $pos+2, $square);
		$square = str_replace('[pos4]', $pos+3, $square);
		$square = str_replace('[unit'.$pos.']', $query1['unit'], $square);
		$square = str_replace('[name'.$pos.']', $query1['name'], $square);
		$square = str_replace('[unit'.($pos+1).']', $query2['unit'], $square);
		$square = str_replace('[name'.($pos+1).']', $query2['name'], $square);
		$square = str_replace('[unit'.($pos+2).']', $query3['unit'], $square);
		$square = str_replace('[name'.($pos+2).']', $query3['name'], $square);
		$square = str_replace('[unit'.($pos+3).']', $query4['unit'], $square);
		$square = str_replace('[name'.($pos+3).']', $query4['name'], $square);
		$content .= $square;
		array_push($up, $label[$total].'冠');
		$total++;
		$game += 2;
		$pos += 4;
	}
	for ($i = 1; $i <= $distribute['3_1']; $i++) {
		$query1 = queryPosition($account, $gameno, $pos);
		$query2 = queryPosition($account, $gameno, $pos+1);
		$query3 = queryPosition($account, $gameno, $pos+2);
		$triangle = file_get_contents("resource/triangle_edit.html");
		$triangle = str_replace('[label]', $label[$total], $triangle);
		$triangle = str_replace('[game1]', $game, $triangle);
		$triangle = str_replace('[game2]', $gap + $game, $triangle);
		$triangle = str_replace('[game3]', 2*$gap + $game, $triangle);
		$triangle = str_replace('[pos1]', $pos, $triangle);
		$triangle = str_replace('[pos2]', $pos+1, $triangle);
		$triangle = str_replace('[pos3]', $pos+2, $triangle);
		$triangle = str_replace('[unit'.$pos.']', $query1['unit'], $triangle);
		$triangle = str_replace('[name'.$pos.']', $query1['name'], $triangle);
		$triangle = str_replace('[unit'.($pos+1).']', $query2['unit'], $triangle);
		$triangle = str_replace('[name'.($pos+1).']', $query2['name'], $triangle);
		$triangle = str_replace('[unit'.($pos+2).']', $query3['unit'], $triangle);
		$triangle = str_replace('[name'.($pos+2).']', $query3['name'], $triangle);
		$content .= $triangle;
		array_push($up, $label[$total].'冠');
		$total++;
		$game++;
		$pos += 3;
	}
	for ($i = 1; $i <= $distribute['3_2']; $i++) {
		$query1 = queryPosition($account, $gameno, $pos);
		$query2 = queryPosition($account, $gameno, $pos+1);
		$query3 = queryPosition($account, $gameno, $pos+2);
		$triangle = file_get_contents("resource/triangle_edit.html");
		$triangle = str_replace('[label]', $label[$total], $triangle);
		$triangle = str_replace('[game1]', $game, $triangle);
		$triangle = str_replace('[game2]', $gap + $game, $triangle);
		$triangle = str_replace('[game3]', 2*$gap + $game, $triangle);
		$triangle = str_replace('[pos1]', $pos, $triangle);
		$triangle = str_replace('[pos2]', $pos+1, $triangle);
		$triangle = str_replace('[pos3]', $pos+2, $triangle);
		$triangle = str_replace('[unit'.$pos.']', $query1['unit'], $triangle);
		$triangle = str_replace('[name'.$pos.']', $query1['name'], $triangle);
		$triangle = str_replace('[unit'.($pos+1).']', $query2['unit'], $triangle);
		$triangle = str_replace('[name'.($pos+1).']', $query2['name'], $triangle);
		$triangle = str_replace('[unit'.($pos+2).']', $query3['unit'], $triangle);
		$triangle = str_replace('[name'.($pos+2).']', $query3['name'], $triangle);
		$content .= $triangle;
		array_push($up, $label[$total].'冠');
		array_push($up, $label[$total].'亞');
		$total++;
		$game++;
		$pos += 3;
	}
	shuffle($up);
	for ($i = 1; $i <= $distribute['round']; $i++) {
		$content .= '<tr><td id="unit'.$i.'">'.array_pop($up).'</td><td id="p'.($i*2-1).'_1"></td><td id="p'.($i*2-1).'_2"></td><td id="p'.($i*2-1).'_3"></td><td id="p'.($i*2-1).'_4"></td><td id="p'.($i*2-1).'_5"></td><td id="p'.($i*2-1).'_6"></td><td id="p'.($i*2-1).'_7"></td><td id="p'.($i*2-1).'_8"></td></tr><tr><td></td><td id="p'.($i*2).'_1"></td><td id="p'.($i*2).'_2"></td><td id="p'.($i*2).'_3"></td><td id="p'.($i*2).'_4"></td><td id="p'.($i*2).'_5"></td><td id="p'.($i*2).'_6"></td><td id="p'.($i*2).'_7"></td><td id="p'.($i*2).'_8"></td></tr>';
	}
	// $content = setPlayNo($account, $gameno, $content, $distribute['round']);
	// $content = setScoreInput($account, $gameno, $content, $distribute['round']);
	$content .= '</table><button onclick="update(\''.$gameno.'\')">確定更新</button><button onclick="window.open(\'game.html\')">賽程表</button>';
	return $content;
}

function processUnit($unit) {
	if ($unit == 'none') {
		return '';
	}
	else {
		return $unit;
	}
}

function processName($name) {
	if ($name == 'none') {
		return 'Bye';
	}
	else {
		return $name;
	}
}

function setPlayNo($account, $gameno, $content, $amount) {
	$sql = mysql_query("SELECT * FROM GAMESTATE WHERE USERNO='$account' AND GAMENO='$gameno'");
	while ($fetch = mysql_fetch_array($sql)) {
		$position = playNoPosition($fetch['SYSTEMPLAYNO'], $amount);
		$content = str_replace('<td id="p'.$position.'">', '<td id="p'.$position.'" align="right">'.$fetch['PLAYNO'], $content);
	}
	return $content;
}

function playNoPosition($playno, $amount) {
	$bound = pow(2, ceil(log($amount, 2))-1);
	$layer = 1;
	$times = 4;
	while ($playno > $bound) {
		$playno -= $bound;
		$bound /= 2;
		$times *= 2;
		$layer += 1;
	}
	$pos = $playno * $times - $times / 2;
	return $pos.'_'.$layer;
}

function setScoreInput($account, $gameno, $content, $amount) {
	$sql = mysql_query("SELECT * FROM GAMESTATE WHERE USERNO='$account' AND GAMENO='$gameno'");
	while ($fetch = mysql_fetch_array($sql)) {
		$scoreInput = scoreInputPosition($fetch['SYSTEMPLAYNO'], $amount);
		if (!empty($fetch['PLAYNO'])) {
			$content = str_replace('<td id="p'.$scoreInput['above'].'">', '<td id="p'.$scoreInput['above'].'"><input type="text" id="'.$fetch['PLAYNO'].'_above">', $content);
			$content = str_replace('<td id="p'.$scoreInput['below'].'">', '<td id="p'.$scoreInput['below'].'"><input type="text" id="'.$fetch['PLAYNO'].'_below">', $content);
		}
	}
	return $content;
}

function scoreInputPosition($playno, $amount) {
	$bound = pow(2, ceil(log($amount, 2))-1);
	$layer = 2;
	$times = 4;
	while ($playno > $bound) {
		$playno -= $bound;
		$bound /= 2;
		$times *= 2;
		$layer += 1;
	}
	$pos = $playno*$times - $times/2;
	$abovePos = $pos.'_'.$layer;
	$belowPos = ($pos+1).'_'.$layer;
	return array('above' => $abovePos, 'below' => $belowPos);
}

function getAmount($account, $gameno) {
	$sql = mysql_query("SELECT AMOUNT FROM GAMEMAIN WHERE USERNO='$account' AND GAMENO='$gameno'");
	$fetch = mysql_fetch_row($sql);
	return $fetch[0];
}

function getGametype($account, $gameno) {
	$sql = mysql_query("SELECT GAMETYPE FROM GAMEMAIN WHERE USERNO='$account' AND GAMENO='$gameno'");
	$fetch = mysql_fetch_row($sql);
	return $fetch[0];
}

function queryPosition($account, $gameno, $position) {
	$sql = mysql_query("SELECT * FROM GAMEPOSITION WHERE USERNO='$account' AND GAMENO='$gameno' AND POSITION='$position'");
	$fetch = mysql_fetch_array($sql);
	return array('unit' => $fetch['UNIT'], 'name' => $fetch['NAME']);
}

function queryState($account, $gameno, $playno) {
	$sql = mysql_query("SELECT * FROM GAMESTATE WHERE USERNO='$account' AND GAMENO='$gameno' AND PLAYNO='$playno'");
	$fetch = mysql_fetch_array($sql);
	return array('playno' => $fetch['PLAYNO'], 'above' => $fetch['ABOVE'], 'below' => $fetch['BELOW'], 'aboveScore' => $fetch['ABOVESCORE'], 'belowScore' => $fetch['BELOWSCORE'], 'winner' => $fetch['WINNER']);
}

function createGameState($account, $gameno, $amount) {
	for ($i = 1; $i < $amount; $i++) {
		if ($i <= $amount/2) {
			mysql_query("INSERT INTO GAMESTATE (USERNO, GAMENO, SYSTEMPLAYNO, ABOVE, BELOW) VALUES ('$account', '$gameno', $i, $i*2-1, $i*2)");
		}
		else {
			mysql_query("INSERT INTO GAMESTATE (USERNO, GAMENO, SYSTEMPLAYNO) VALUES ('$account', '$gameno', $i)");
		}
	}
}

function updateAbovePosition($playno, $amount) {
	$bound = pow(2, ceil(log($amount, 2))-1);
	$layer = 1;
	$times = 4;
	while ($playno > $bound) {
		$playno -= $bound;
		$bound /= 2;
		$times *= 2;
		$layer += 1;
	}
	$pos = $playno*$times - $times/2;
	$temp = array();
	array_push($temp, $pos.'_'.$layer);
	$aboveLength = $times/4 - 1;
	for ($i = 1; $i <= $aboveLength; $i++) {
		array_push($temp, ($pos-$i).'_'.$layer);
	}
	return array('t-r' => array_pop($temp), 'r' => $temp);
}

function updateBelowPosition($playno, $amount) {
	$bound = pow(2, ceil(log($amount, 2))-1);
	$layer = 1;
	$times = 4;
	while ($playno > $bound) {
		$playno -= $bound;
		$bound /= 2;
		$times *= 2;
		$layer += 1;
	}
	$pos = $playno*$times - $times/2 + 1;
	$temp = array();
	array_push($temp, $pos.'_'.$layer);
	$aboveLength = $times/4 - 1;
	for ($i = 1; $i <= $aboveLength; $i++) {
		array_push($temp, ($pos+$i).'_'.$layer);
	}
	return array('b-r' => array_pop($temp), 'r' => $temp);
}

function updateAbove($playno, $publicContent, $editContent, $amount) {
	$updateAbovePosition = updateAbovePosition($playno, $amount);
	$publicContent = str_replace('<td id="p'.$updateAbovePosition['t-r'].'"', '<td id="p'.$updateAbovePosition['t-r'].'" class="t-r_red"', $publicContent);
	$editContent = str_replace('<td id="p'.$updateAbovePosition['t-r'].'"', '<td id="p'.$updateAbovePosition['t-r'].'" class="t-r_red"', $editContent);
	while ($pos = array_pop($updateAbovePosition['r'])) {
		$publicContent = str_replace('<td id="p'.$pos.'"', '<td id="p'.$pos.'" class="r_red"', $publicContent);
		$editContent = str_replace('<td id="p'.$pos.'"', '<td id="p'.$pos.'" class="r_red"', $editContent);
	}
	return array('public' => $publicContent, 'edit' => $editContent);
}

function updateBelow($playno, $publicContent, $editContent, $amount) {
	$updateBelowPosition = updateBelowPosition($playno, $amount);
	$publicContent = str_replace('<td id="p'.$updateBelowPosition['b-r'].'"', '<td id="p'.$updateBelowPosition['b-r'].'" class="b-r_red"', $publicContent);
	$editContent = str_replace('<td id="p'.$updateBelowPosition['b-r'].'"', '<td id="p'.$updateBelowPosition['b-r'].'" class="b-r_red"', $editContent);
	while ($pos = array_pop($updateBelowPosition['r'])) {
		$publicContent = str_replace('<td id="p'.$pos.'"', '<td id="p'.$pos.'" class="r_red"', $publicContent);
		$editContent = str_replace('<td id="p'.$pos.'"', '<td id="p'.$pos.'" class="r_red"', $editContent);
	}
	return array('public' => $publicContent, 'edit' => $editContent);
}

function updateGameChart($account, $gameno) {
	updateGameState($account, $gameno);
	$publicContent = publicContent($account, $gameno);
	$editContent = editContent($account, $gameno);
	$amount = getAmount($account, $gameno);
	$roundAmount = pow(2, ceil(log($amount, 2)));
	for ($i = 1; $i < $roundAmount; $i++) {
		$state = queryState($account, $gameno, $i);
		if (!empty($state['aboveScore']) && !empty($state['belowScore'])) {
			$scoreInput = scoreInputPosition($i, $amount);
			$publicContent = str_replace('<td id="p'.$scoreInput['above'].'">', '<td id="p'.$scoreInput['above'].'">'.$state['aboveScore'], $publicContent);
			$publicContent = str_replace('<td id="p'.$scoreInput['below'].'">', '<td id="p'.$scoreInput['below'].'">'.$state['belowScore'], $publicContent);
			$editContent = str_replace('<input type="text" id="'.$state['playno'].'_above">', '<input type="text" id="'.$state['playno'].'_above" value="'.$state['aboveScore'].'">', $editContent);
			$editContent = str_replace('<input type="text" id="'.$state['playno'].'_below">', '<input type="text" id="'.$state['playno'].'_below" value="'.$state['belowScore'].'">', $editContent);
		}
		if (!empty($state['winner']) && ($state['winner'] == $state['above'])) {
			$return = updateAbove($i, $publicContent, $editContent, $amount);
			$publicContent = $return['public'];
			$editContent = $return['edit'];
		}
		elseif (!empty($state['winner']) && ($state['winner'] == $state['below'])) {
			$return = updateBelow($i, $publicContent, $editContent, $amount);
			$publicContent = $return['public'];
			$editContent = $return['edit'];
		}
	}
	unlink($account.'/'.$gameno."/public.html");
	unlink($account.'/'.$gameno."/edit.html");
	$start = '<!DOCTYPE html><html lang="en"><head><meta charset="utf-8"><meta name="viewport" content="width=device-width, initial-scale=1"><title>電子化賽程系統</title><link rel="stylesheet" type="text/css" href="../resource/custom.css"></head><body>';
	$end = '</body><script src="../resource/'.$roundAmount.'.js"></script></html>';
	$file = fopen($account.'/'.$gameno."/public.html", "w");
	fwrite($file, $start.$publicContent.$end);
	fclose($file);
	$file = fopen($account.'/'.$gameno."/edit.html", "w");
	fwrite($file, $start.$editContent.$end);
	fclose($file);
}

function updateGameState($account, $gameno) {
	$amount = getAmount($account, $gameno);
	$roundAmount = pow(2, ceil(log($amount, 2)));
	$start = 1;
	$next = 2;
	$middle = $roundAmount / 2 + 1;
	while ($middle < $roundAmount) {
		$sql1 = mysql_query("SELECT WINNER FROM GAMESTATE WHERE USERNO='$account' AND GAMENO='$gameno' AND SYSTEMPLAYNO='$start'");
		$fetch1 = mysql_fetch_array($sql1);
		$above = $fetch1['WINNER'];
		$sql2 = mysql_query("SELECT WINNER FROM GAMESTATE WHERE USERNO='$account' AND GAMENO='$gameno' AND SYSTEMPLAYNO='$next'");
		$fetch2 = mysql_fetch_array($sql2);
		$below = $fetch2['WINNER'];
		mysql_query("UPDATE GAMESTATE SET ABOVE='$above', BELOW='$below' WHERE USERNO='$account' AND GAMENO='$gameno' AND SYSTEMPLAYNO='$middle'");
		$start += 2;
		$next += 2;
		$middle += 1;
	}
}

function clearBye($account, $gameno) {
	$amount = getAmount($account, $gameno);
	$roundAmount = pow(2, ceil(log($amount, 2)));
	$single = 1;
	$double = 2;
	while ($single < $roundAmount) {
		$querySingle = queryPosition($account, $gameno, $single);
		$queryDouble = queryPosition($account, $gameno, $double);
		if ($querySingle['unit'] == 'none') {
			mysql_query("UPDATE GAMESTATE SET WINNER='$double' WHERE USERNO='$account' AND GAMENO='$gameno'");
		}
		elseif ($queryDouble['unit'] == 'none') {
			mysql_query("UPDATE GAMESTATE SET WINNER='$single' WHERE USERNO='$account' AND GAMENO='$gameno'");
		}
		$single += 2;
		$double += 2;
	}
}

function makeGame($account, $gameno) {
	$start = '<!DOCTYPE html><html lang="en"><head><meta charset="utf-8"><meta name="viewport" content="width=device-width, initial-scale=1"><title>電子化賽程系統</title><script src="../../resource/custom.js"></script></head><body>';
	$content = '<p id="gameState"></p>';
	$end = '</body><script>updateGame(\''.$account.'\', \''.$gameno.'\')</script></html>';
	$file = fopen($account.'/'.$gameno."/game.html", "w");
	fwrite($file, $start.$content.$end);
	fclose($file);
}

function distribute($amount) {
	$small = $amount/4;
	$big = $amount/3;
	$temp_a = 0;
	$temp_b = 0;
	$temp_r = 0;
	$temp_m = 0;
	$_3_1 = 0;
	$_3_2 = 0;
	$_4_1 = 0;
	$_4_2 = 0;
	$temp_diff = 999;
	for ($i = ceil($small); $i <= $big; $i++) {
		$m = pow(2, ceil(log($i, 2)));
		$b = $m - $i;
		$a = $m - 2 * $b;
		$r = $amount - 3 * $a - 3 * $b;
		$diff = abs($b - $r);
		if ($b == 0) {
			$temp_a = $a;
			$temp_b = $b;
			$temp_r = $r;
			$temp_m = $m;
			break;
		}
		elseif ($diff < $temp_diff) {
			$temp_diff = $diff;
			$temp_a = $a;
			$temp_b = $b;
			$temp_r = $r;
			$temp_m = $m;
		}
	}

	if ($temp_r > $temp_b) {
		$_3_1 = $temp_a + $temp_b - $temp_r;
		$_3_2 = 0;
		$_4_1 = $temp_r - $temp_b;
		$_4_2 = $temp_b;
	}
	else {
		$_3_1 = $temp_a;
		$_3_2 = $temp_b - $temp_r;
		$_4_1 = 0;
		$_4_2 = $temp_r;
	}
	return array('3_1' => $_3_1, '3_2' => $_3_2, '4_1' => $_4_1, '4_2' => $_4_2, 'round' => $temp_m);
}

function curl_post($post) {
	$ch = curl_init();
	$protocol = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == "on") ? "https" : "http";
	curl_setopt($ch, CURLOPT_URL, $protocol.'://'.$_SERVER['HTTP_HOST'].dirname($_SERVER['SCRIPT_NAME']).'/resource/custom.php');
	curl_setopt($ch, CURLOPT_POST, true);
	curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
	curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	$result = curl_exec($ch);
	curl_close($ch);
	return $result;
}

function login($account, $password) {
	$sql1 = mysql_query("SELECT * FROM USERMAS WHERE USERNO='$account'");
	$fetch1 = mysql_fetch_array($sql1);
	if (empty($account)) {
		return '請輸入帳號';
	}
	elseif (empty($password)) {
		return '請輸入密碼';
	}
	elseif (mysql_num_rows($sql1) == 0) {
		return '未註冊的帳號';
	}
	elseif ($password != $fetch1['PASSWORD']) {
		return '密碼錯誤';
	}
	else {
		$token = get_token();
		$encrypted_token = md5($account.$token);
		$sql2 = "UPDATE USERMAS SET TOKEN='$encrypted_token' WHERE USERNO='$account'";
		if (mysql_query($sql2)) {
			return array('message' => 'Success', 'token' => $token);
		}
		else {
			return 'Database operation error';
		}
	}
}

function logon($account, $password) {
	$sql1 = mysql_query("SELECT * FROM USERMAS WHERE USERNO='$account'");
	$fetch1 = mysql_fetch_array($sql1);
	if (empty($account)) {
		return '請輸入帳號';
	}
	elseif (empty($password)) {
		return '請輸入密碼';
	}
	elseif (mysql_num_rows($sql1) != 0) {
		return '此帳號已被註冊';
	}
	else {
		date_default_timezone_set('Asia/Taipei');
		$date = date("Y-m-d H:i:s");
		$token = get_token();
		$encrypted_token = md5($account.$token);
		$sql2 = "INSERT INTO USERMAS (USERNO, TOKEN, PASSWORD, CREATEDATE, LOGINDATE, AUTHDATE) VALUES ('$account', '$token', '$password', '$date', '$date', '$date')";
		if (mysql_query($sql2)) {
			return array('message' => 'Success', 'token' => $token);
		}
		else {
			return 'Database operation error';
		}
	}
}

function get_token() {
	$str = "0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ";
	$code = '';
	for ($i = 0; $i < 12; $i++) {
		$code .= $str[mt_rand(0, strlen($str)-1)];
	}
	return $code;
}