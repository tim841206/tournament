<?php
include_once("database.php");

function makePublic($gameno) {
	$start = '<!DOCTYPE html><html lang="en"><head><meta charset="utf-8"><meta name="viewport" content="width=device-width, initial-scale=1"><title>電子化賽程系統</title><link rel="stylesheet" type="text/css" href="../resource/custom.css"></head><body>';
	$content = publicContent($gameno);
	$amount = getAmount($gameno);
	$roundAmount = pow(2, ceil(log($amount, 2)));
	$end = '</body><script src="../resource/'.$roundAmount.'.js"></script></html>';
	$file = fopen($gameno . "/public.html", "w");
	fwrite($file, $start.$content.$end);
	fclose($file);
}

function makeEdit($gameno) {
	$start = '<!DOCTYPE html><html lang="en"><head><meta charset="utf-8"><meta name="viewport" content="width=device-width, initial-scale=1"><title>電子化賽程系統</title><link rel="stylesheet" type="text/css" href="../resource/custom.css"></head><body>';
	$content = editContent($gameno);
	$amount = getAmount($gameno);
	$roundAmount = pow(2, ceil(log($amount, 2)));
	$end = '</body><script src="../resource/'.$roundAmount.'.js"></script></html>';
	$file = fopen($gameno . "/edit.html", "w");
	fwrite($file, $start.$content.$end);
	fclose($file);
}

function publicContent($gameno) {
	$amount = getAmount($gameno);
	$content = '<table><tr><td>單位</td><td>名稱</td></tr>';
	for ($i = 1; $i <= pow(2, ceil(log($amount, 2))); $i++) {
		$query = queryPosition($gameno, $i);
		$content .= '<tr><td>'.processUnit($query['unit']).'</td><td>'.processName($query['name']).'</td><td id="p'.($i*2-1).'_1"></td><td id="p'.($i*2-1).'_2"></td><td id="p'.($i*2-1).'_3"></td><td id="p'.($i*2-1).'_4"></td><td id="p'.($i*2-1).'_5"></td><td id="p'.($i*2-1).'_6"></td><td id="p'.($i*2-1).'_7"></td><td id="p'.($i*2-1).'_8"></td></tr><tr><td></td><td></td><td id="p'.($i*2).'_1"></td><td id="p'.($i*2).'_2"></td><td id="p'.($i*2).'_3"></td><td id="p'.($i*2).'_4"></td><td id="p'.($i*2).'_5"></td><td id="p'.($i*2).'_6"></td><td id="p'.($i*2).'_7"></td><td id="p'.($i*2).'_8"></td></tr>';
	}
	$content = setPlayNo($gameno, $content, $amount);
	$content .= '</table>';
	return $content;
}

function editContent($gameno) {
	$amount = getAmount($gameno);
	$content = '<script src="../resource/custom.js"></script><table><tr><td>單位</td><td>名稱</td></tr>';
	for ($i = 1; $i <= pow(2, ceil(log($amount, 2))); $i++) {
		$query = queryPosition($gameno, $i);
		$content .= '<tr><td>'.processUnit($query['unit']).'</td><td>'.processName($query['name']).'</td><td id="p'.($i*2-1).'_1"></td><td id="p'.($i*2-1).'_2"></td><td id="p'.($i*2-1).'_3"></td><td id="p'.($i*2-1).'_4"></td><td id="p'.($i*2-1).'_5"></td><td id="p'.($i*2-1).'_6"></td><td id="p'.($i*2-1).'_7"></td><td id="p'.($i*2-1).'_8"></td></tr><tr><td></td><td></td><td id="p'.($i*2).'_1"></td><td id="p'.($i*2).'_2"></td><td id="p'.($i*2).'_3"></td><td id="p'.($i*2).'_4"></td><td id="p'.($i*2).'_5"></td><td id="p'.($i*2).'_6"></td><td id="p'.($i*2).'_7"></td><td id="p'.($i*2).'_8"></td></tr>';
	}
	$content = setPlayNo($gameno, $content, $amount);
	$content = setScoreInput($gameno, $content, $amount);
	$content .= '</table><button onclick="update(\''.$gameno.'\')">確定更新</button>';
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

function setPlayNo($gameno, $content, $amount) {
	$sql = mysql_query("SELECT * FROM GAMESTATE WHERE GAMENO='$gameno'");
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

function setScoreInput($gameno, $content, $amount) {
	$sql = mysql_query("SELECT * FROM GAMESTATE WHERE GAMENO='$gameno'");
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

function getAmount($gameno) {
	$sql = mysql_query("SELECT AMOUNT FROM GAMEMAIN WHERE GAMENO='$gameno'");
	$fetch = mysql_fetch_row($sql);
	return $fetch[0];
}

function queryPosition($gameno, $position) {
	$sql = mysql_query("SELECT * FROM GAMEPOSITION WHERE GAMENO='$gameno' AND POSITION='$position'");
	$fetch = mysql_fetch_array($sql);
	return array('unit' => $fetch['UNIT'], 'name' => $fetch['NAME']);
}

function queryState($gameno, $playno) {
	$sql = mysql_query("SELECT * FROM GAMESTATE WHERE GAMENO='$gameno' AND PLAYNO='$playno'");
	$fetch = mysql_fetch_array($sql);
	return array('playno' => $fetch['PLAYNO'], 'above' => $fetch['ABOVE'], 'below' => $fetch['BELOW'], 'aboveScore' => $fetch['ABOVESCORE'], 'belowScore' => $fetch['BELOWSCORE'], 'winner' => $fetch['WINNER']);
}

function createGameState($amount, $gameno) {
	for ($i = 1; $i < $amount; $i++) {
		if ($i <= $amount/2) {
			mysql_query("INSERT INTO GAMESTATE (GAMENO, SYSTEMPLAYNO, ABOVE, BELOW) VALUES ('$gameno', $i, $i*2-1, $i*2)");
		}
		else {
			mysql_query("INSERT INTO GAMESTATE (GAMENO, SYSTEMPLAYNO) VALUES ('$gameno', $i)");
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

function updateGameChart($gameno) {
	updateGameState($gameno);
	$publicContent = publicContent($gameno);
	$editContent = editContent($gameno);
	$amount = getAmount($gameno);
	$roundAmount = pow(2, ceil(log($amount, 2)));
	for ($i = 1; $i < $roundAmount; $i++) {
		$state = queryState($gameno, $i);
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
	unlink($gameno . "/public.html");
	unlink($gameno . "/edit.html");
	$start = '<!DOCTYPE html><html lang="en"><head><meta charset="utf-8"><meta name="viewport" content="width=device-width, initial-scale=1"><title>電子化賽程系統</title><link rel="stylesheet" type="text/css" href="../resource/custom.css"></head><body>';
	$end = '</body><script src="../resource/'.$roundAmount.'.js"></script></html>';
	$file = fopen($gameno . "/public.html", "w");
	fwrite($file, $start.$publicContent.$end);
	fclose($file);
	$file = fopen($gameno . "/edit.html", "w");
	fwrite($file, $start.$editContent.$end);
	fclose($file);
}

function updateGameState($gameno) {
	$amount = getAmount($gameno);
	$roundAmount = pow(2, ceil(log($amount, 2)));
	$start = 1;
	$next = 2;
	$middle = $roundAmount / 2 + 1;
	while ($middle < $roundAmount) {
		$sql1 = mysql_query("SELECT WINNER FROM GAMESTATE WHERE GAMENO='$gameno' AND SYSTEMPLAYNO='$start'");
		$fetch1 = mysql_fetch_array($sql1);
		$above = $fetch1['WINNER'];
		$sql2 = mysql_query("SELECT WINNER FROM GAMESTATE WHERE GAMENO='$gameno' AND SYSTEMPLAYNO='$next'");
		$fetch2 = mysql_fetch_array($sql2);
		$below = $fetch2['WINNER'];
		mysql_query("UPDATE GAMESTATE SET ABOVE='$above', BELOW='$below' WHERE GAMENO='$gameno' AND SYSTEMPLAYNO='$middle'");
		$start += 2;
		$next += 2;
		$middle += 1;
	}
}

function clearBye($gameno) {
	$amount = getAmount($gameno);
	$roundAmount = pow(2, ceil(log($amount, 2)));
	$single = 1;
	$double = 2;
	while ($single < $roundAmount) {
		$querySingle = queryPosition($gameno, $single);
		$queryDouble = queryPosition($gameno, $double);
		if ($querySingle['unit'] == 'none') {
			mysql_query("UPDATE GAMESTATE SET WINNER='$double' WHERE GAMENO='$gameno'");
		}
		elseif ($queryDouble['unit'] == 'none') {
			mysql_query("UPDATE GAMESTATE SET WINNER='$single' WHERE GAMENO='$gameno'");
		}
		$single += 2;
		$double += 2;
	}
}

function makeGame($gameno) {
	$start = '<!DOCTYPE html><html lang="en"><head><meta charset="utf-8"><meta name="viewport" content="width=device-width, initial-scale=1"><title>電子化賽程系統</title><script src="../resource/custom.js"></script></head><body>';
	$content = '<p id="gameState"></p>';
	$end = '</body><script>updateGame(\''.$gameno.'\')</script></html>';
	$file = fopen($gameno . "/game.html", "w");
	fwrite($file, $start.$content.$end);
	fclose($file);
}