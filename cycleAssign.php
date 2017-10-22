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
elseif (mysql_num_rows($sql) != 0) {
	echo json_encode(array('message' => 'Used game index'));
}
else {
	$label = array(' ', 'A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z', 'AA', 'AB', 'AC', 'AD', 'AE', 'AF', 'AG', 'AH', 'AI', 'AJ', 'AK', 'AL', 'AM', 'AN', 'AO', 'AP', 'AQ', 'AR', 'AS', 'AT', 'AU', 'AV', 'AW', 'AX', 'AY', 'AZ');
	$start = '<!DOCTYPE html><html lang="en"><head><meta charset="utf-8"><meta name="viewport" content="width=device-width, initial-scale=1"><title>電子化賽程系統</title><link rel="stylesheet" type="text/css" href="resource/custom.css"><link rel="stylesheet" type="text/css" href="resource/tournament.css"><script src="resource/custom.js"></script></head><body>';
	$content = '<br><table>';
	$distribute = distribute($amount);
	$gap = 2 * ($distribute['4_1'] + $distribute['4_2']) + $distribute['3_1'] + $distribute['3_2'];
	$total = 1;
	$game = 1;
	$pos = 1;
	$rank1 = array();
	$rank2 = array();
	$rank3 = array();
	for ($i = 1; $i <= $distribute['4_2']; $i++) {
		if ($playtype == 'A') {
			$square = file_get_contents("resource/single_square_assign.html");
		}
		elseif ($playtype == 'B') {
			$square = file_get_contents("resource/double_square_assign.html");
		}
		elseif ($playtype == 'C') {
			$square = file_get_contents("resource/group_square_assign.html");
		}
		$square = str_replace('[label]', $label[$total], $square);
		$square = str_replace('[game1]', $game, $square);
		$square = str_replace('[game2]', $game+1, $square);
		$square = str_replace('[game3]', $gap + $game, $square);
		$square = str_replace('[game4]', $gap + $game+1, $square);
		$square = str_replace('[game5]', 2*$gap + $game, $square);
		$square = str_replace('[game6]', 2*$gap + $game+1, $square);
		$square = str_replace('[pos1]', $pos, $square);
		$square = str_replace('[pos2]', $pos+1, $square);
		$square = str_replace('[pos3]', $pos+2, $square);
		$square = str_replace('[pos4]', $pos+3, $square);
		$content .= $square;
		array_push($rank1, $label[$total].'冠');
		array_push($rank3, $label[$total].'亞');
		$total++;
		$game += 2;
		$pos += 4;
	}
	for ($i = 1; $i <= $distribute['4_1']; $i++) {
		if ($playtype == 'A') {
			$square = file_get_contents("resource/single_square_assign.html");
		}
		elseif ($playtype == 'B') {
			$square = file_get_contents("resource/double_square_assign.html");
		}
		elseif ($playtype == 'C') {
			$square = file_get_contents("resource/group_square_assign.html");
		}
		$square = str_replace('[label]', $label[$total], $square);
		$square = str_replace('[game1]', $game, $square);
		$square = str_replace('[game2]', $game+1, $square);
		$square = str_replace('[game3]', $gap + $game, $square);
		$square = str_replace('[game4]', $gap + $game+1, $square);
		$square = str_replace('[game5]', 2*$gap + $game, $square);
		$square = str_replace('[game6]', 2*$gap + $game+1, $square);
		$square = str_replace('[pos1]', $pos, $square);
		$square = str_replace('[pos2]', $pos+1, $square);
		$square = str_replace('[pos3]', $pos+2, $square);
		$square = str_replace('[pos4]', $pos+3, $square);
		$content .= $square;
		array_push($rank1, $label[$total].'冠');
		$total++;
		$game += 2;
		$pos += 4;
	}
	for ($i = 1; $i <= $distribute['3_1']; $i++) {
		if ($playtype == 'A') {
			$triangle = file_get_contents("resource/single_triangle_assign.html");
		}
		elseif ($playtype == 'B') {
			$triangle = file_get_contents("resource/double_triangle_assign.html");
		}
		elseif ($playtype == 'C') {
			$triangle = file_get_contents("resource/group_triangle_assign.html");
		}
		$triangle = str_replace('[label]', $label[$total], $triangle);
		$triangle = str_replace('[game1]', $game, $triangle);
		$triangle = str_replace('[game2]', $gap + $game, $triangle);
		$triangle = str_replace('[game3]', 2*$gap + $game, $triangle);
		$triangle = str_replace('[pos1]', $pos, $triangle);
		$triangle = str_replace('[pos2]', $pos+1, $triangle);
		$triangle = str_replace('[pos3]', $pos+2, $triangle);
		$content .= $triangle;
		array_push($rank2, $label[$total].'冠');
		$total++;
		$game++;
		$pos += 3;
	}
	for ($i = 1; $i <= $distribute['3_2']; $i++) {
		if ($playtype == 'A') {
			$triangle = file_get_contents("resource/single_triangle_assign.html");
		}
		elseif ($playtype == 'B') {
			$triangle = file_get_contents("resource/double_triangle_assign.html");
		}
		elseif ($playtype == 'C') {
			$triangle = file_get_contents("resource/group_triangle_assign.html");
		}
		$triangle = str_replace('[label]', $label[$total], $triangle);
		$triangle = str_replace('[game1]', $game, $triangle);
		$triangle = str_replace('[game2]', $gap + $game, $triangle);
		$triangle = str_replace('[game3]', 2*$gap + $game, $triangle);
		$triangle = str_replace('[pos1]', $pos, $triangle);
		$triangle = str_replace('[pos2]', $pos+1, $triangle);
		$triangle = str_replace('[pos3]', $pos+2, $triangle);
		$content .= $triangle;
		array_push($rank2, $label[$total].'冠');
		array_push($rank3, $label[$total].'亞');
		$total++;
		$game++;
		$pos += 3;
	}
	$up = arrange($rank1, $rank2, $rank3);
	for ($i = 1; $i <= $distribute['round']; $i++) {
		$content .= '<tr><td id="unit'.$i.'">'.array_pop($up).'</td><td id="p'.($i*2-1).'_1"></td><td id="p'.($i*2-1).'_2"></td><td id="p'.($i*2-1).'_3"></td><td id="p'.($i*2-1).'_4"></td><td id="p'.($i*2-1).'_5"></td><td id="p'.($i*2-1).'_6"></td><td id="p'.($i*2-1).'_7"></td><td id="p'.($i*2-1).'_8"></td></tr><tr><td></td><td id="p'.($i*2).'_1"></td><td id="p'.($i*2).'_2"></td><td id="p'.($i*2).'_3"></td><td id="p'.($i*2).'_4"></td><td id="p'.($i*2).'_5"></td><td id="p'.($i*2).'_6"></td><td id="p'.($i*2).'_7"></td><td id="p'.($i*2).'_8"></td></tr>';
	}
	$content .= '</table><button onclick="cyclePublic('.$amount.', \''.$gameno.'\', \''.$gamenm.'\', \''.$playtype.'\')">確定輸出</button>';
	$end = '</body><script src="resource/'.$distribute['round'].'.js"></script></html>';
	if (is_dir($account.'/'.$gameno)) {
		if (is_file($account.'/'.$gameno."/cycleAssign.html")) {
			unlink($account.'/'.$gameno."/cycleAssign.html");
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
	if ((ceil($amount) == floor($amount)) && $amount >= 12 && $amount <= 512) {
		return true;
	}
	else {
		return false;
	}
}