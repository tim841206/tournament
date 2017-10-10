<?php
include_once("resource/database.php");
include_once("resource/custom.php");

$type = $_GET['type'];
if ($type == 'view') {
	$content = '<table align="center"><tr><th>競賽管理者</th><th>競賽名稱</th><th>競賽種類</th><th>參與隊數</th><th>競賽建立時間</th><th>競賽最後更新時間</th></tr>';
	$sql = mysql_query("SELECT * FROM GAMEMAIN ORDER BY UPDATEDATE DESC");
	while ($fetch = mysql_fetch_array($sql)) {
		$content .= '<tr><td>'.$fetch['USERNO'].'</td><td>'.$fetch['GAMENM'].'</td><td>'.translatePlaytype($fetch['PLAYTYPE']).'</td><td>'.$fetch['AMOUNT'].'</td><td>'.$fetch['CREATEDATE'].'</td><td>'.$fetch['UPDATEDATE'].'</td><td><button onclick="location.assign(\'index.php?host='.$fetch['USERNO'].'&gameno='.$fetch['GAMENO'].'\')">查看</button></td></tr>';
	}
	$content .= '</table>';
	echo json_encode(array('message' => 'Success', 'content' => $content));
}
elseif ($type == 'update') {
	$account = $_GET['account'];
	$gameno = $_GET['gameno'];
	$content = '<table><tr><th>場次</th><th>單位</th><th>名稱</th><th>單位</th><th>名稱</th><th>勝者</th></tr>';
	$sql = mysql_query("SELECT * FROM GAMESTATE WHERE USERNO='$account' AND GAMENO='$gameno' ORDER BY SYSTEMPLAYNO ASC");
	while ($fetch = mysql_fetch_array($sql)) {
		if (!empty($fetch['PLAYNO'])) {
			$playType = getPlaytype($account, $gameno);
			if ($playType == 'A') {
				$above = queryContentSingle($account, $gameno, $fetch['ABOVE']);
				$below = queryContentSingle($account, $gameno, $fetch['BELOW']);
				if (!empty($fetch['WINNER'])) {
					$winner = queryContentSingle($account, $gameno, $fetch['WINNER']);
					$content .= '<tr><td>'.$fetch['PLAYNO'].'</td><td>'.$above['unit'].'</td><td>'.$above['name'].'</td><td>'.$below['unit'].'</td><td>'.$below['name'].'</td><td>'.$winner['name'].'</td></tr>';
				}
				else {
					$content .= '<tr><td>'.$fetch['PLAYNO'].'</td><td>'.$above['unit'].'</td><td>'.$above['name'].'</td><td>'.$below['unit'].'</td><td>'.$below['name'].'</td></tr>';
				}
			}
			elseif ($playType == 'B') {
				$above = queryContentDouble($account, $gameno, $fetch['ABOVE']);
				$below = queryContentDouble($account, $gameno, $fetch['BELOW']);
				if (!empty($fetch['WINNER'])) {
					$winner = queryContentDouble($account, $gameno, $fetch['WINNER']);
					$content .= '<tr><td>'.$fetch['PLAYNO'].'</td><td>'.$above['unitu'].'<br>'.$above['unitd'].'</td><td>'.$above['nameu'].'<br>'.$above['named'].'</td><td>'.$below['unitu'].'<br>'.$below['unitd'].'</td><td>'.$below['nameu'].'<br>'.$below['named'].'</td><td>'.$winner['nameu'].'<br>'.$winner['named'].'</td></tr>';
				}
				else {
					$content .= '<tr><td>'.$fetch['PLAYNO'].'</td><td>'.$above['unitu'].'<br>'.$above['unitd'].'</td><td>'.$above['nameu'].'<br>'.$above['named'].'</td><td>'.$below['unitu'].'<br>'.$below['unitd'].'</td><td>'.$below['nameu'].'<br>'.$below['named'].'</td></tr>';
				}
			}
			elseif ($playType == 'C') {
				$above = queryContentGroup($account, $gameno, $fetch['ABOVE']);
				$below = queryContentGroup($account, $gameno, $fetch['BELOW']);
				if (!empty($fetch['WINNER'])) {
					$winner = queryContentGroup($account, $gameno, $fetch['WINNER']);
					$content .= '<tr><td>'.$fetch['PLAYNO'].'</td><td>'.$above.'</td><td></td><td>'.$below.'</td><td></td><td>'.$winner.'</td></tr>';
				}
				else {
					$content .= '<tr><td>'.$fetch['PLAYNO'].'</td><td>'.$above.'</td><td></td><td>'.$below.'</td><td></td></tr>';
				}
			}
				
		}
	}
	$content .= '</table>';
	echo json_encode(array('message' => 'Success', 'content' => $content));
}