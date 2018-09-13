<?php
include_once("resource/database.php");
include_once("resource/custom.php");

$type = isset($_POST['type']) ? $_POST['type'] : $_GET['type'];
if ($type == 'view') {
	$content = '<table align="center"><tr><th>競賽管理者</th><th>競賽名稱</th><th>競賽種類</th><th>參與隊數</th><th>競賽建立時間</th><th>競賽最後更新時間</th></tr>';
	$sql = mysqli_query($mysql, "SELECT * FROM GAMEMAIN ORDER BY UPDATEDATE DESC");
	while ($fetch = mysqli_fetch_array($sql)) {
		$content .= '<tr><td>'.$fetch['USERNO'].'</td><td>'.$fetch['GAMENM'].'</td><td>'.translatePlaytype($fetch['PLAYTYPE']).'</td><td>'.$fetch['AMOUNT'].'</td><td>'.$fetch['CREATEDATE'].'</td><td>'.$fetch['UPDATEDATE'].'</td><td><button onclick="location.assign(\'index.php?host='.$fetch['USERNO'].'&gameno='.$fetch['GAMENO'].'\')">查看</button></td></tr>';
	}
	$content .= '</table>';
	echo json_encode(array('message' => 'Success', 'content' => $content));
}
elseif ($type == 'updateGame') {
	$account = $_GET['account'];
	$gameno = $_GET['gameno'];
	$content = '<table><tr><th>場次</th><th>時間</th><th>單位</th><th>名稱</th><th>單位</th><th>名稱</th><th>勝者</th></tr>';
	$sql = mysqli_query($mysql, "SELECT * FROM GAMESTATE WHERE USERNO='$account' AND GAMENO='$gameno' ORDER BY SYSTEMPLAYNO ASC");
	while ($fetch = mysqli_fetch_array($sql)) {
		if (!empty($fetch['PLAYNO'])) {
			$playType = getPlaytype($account, $gameno);
			if ($playType == 'A') {
				$above = queryContentSingle($account, $gameno, $fetch['ABOVE']);
				$below = queryContentSingle($account, $gameno, $fetch['BELOW']);
				if (!empty($fetch['WINNER'])) {
					$winner = queryContentSingle($account, $gameno, $fetch['WINNER']);
					$content .= '<tr><td>'.$fetch['PLAYNO'].'</td><td>'.$fetch['PLAYTIME'].'</td><td>'.$above['unit'].'</td><td>'.$above['name'].'</td><td>'.$below['unit'].'</td><td>'.$below['name'].'</td><td>'.$winner['name'].'</td></tr>';
				}
				else {
					$content .= '<tr><td>'.$fetch['PLAYNO'].'</td><td>'.$fetch['PLAYTIME'].'</td><td>'.$above['unit'].'</td><td>'.$above['name'].'</td><td>'.$below['unit'].'</td><td>'.$below['name'].'</td></tr>';
				}
			}
			elseif ($playType == 'B') {
				$above = queryContentDouble($account, $gameno, $fetch['ABOVE']);
				$below = queryContentDouble($account, $gameno, $fetch['BELOW']);
				if (!empty($fetch['WINNER'])) {
					$winner = queryContentDouble($account, $gameno, $fetch['WINNER']);
					$content .= '<tr><td>'.$fetch['PLAYNO'].'</td><td>'.$fetch['PLAYTIME'].'</td><td>'.$above['unitu'].'<br>'.$above['unitd'].'</td><td>'.$above['nameu'].'<br>'.$above['named'].'</td><td>'.$below['unitu'].'<br>'.$below['unitd'].'</td><td>'.$below['nameu'].'<br>'.$below['named'].'</td><td>'.$winner['nameu'].'<br>'.$winner['named'].'</td></tr>';
				}
				else {
					$content .= '<tr><td>'.$fetch['PLAYNO'].'</td><td>'.$fetch['PLAYTIME'].'</td><td>'.$above['unitu'].'<br>'.$above['unitd'].'</td><td>'.$above['nameu'].'<br>'.$above['named'].'</td><td>'.$below['unitu'].'<br>'.$below['unitd'].'</td><td>'.$below['nameu'].'<br>'.$below['named'].'</td></tr>';
				}
			}
			elseif ($playType == 'C') {
				$above = queryContentGroup($account, $gameno, $fetch['ABOVE']);
				$below = queryContentGroup($account, $gameno, $fetch['BELOW']);
				if (!empty($fetch['WINNER'])) {
					$winner = queryContentGroup($account, $gameno, $fetch['WINNER']);
					$content .= '<tr><td>'.$fetch['PLAYNO'].'</td><td>'.$fetch['PLAYTIME'].'</td><td>'.$above.'</td><td></td><td>'.$below.'</td><td></td><td>'.$winner.'</td></tr>';
				}
				else {
					$content .= '<tr><td>'.$fetch['PLAYNO'].'</td><td>'.$fetch['PLAYTIME'].'</td><td>'.$above.'</td><td></td><td>'.$below.'</td><td></td></tr>';
				}
			}
				
		}
	}
	$content .= '</table>';
	echo json_encode(array('message' => 'Success', 'content' => $content));
}
elseif ($type == 'updateFunction') {
	$account = $_GET['account'];
	$gameno = $_GET['gameno'];
	$sql = mysqli_query($mysql, "SELECT * FROM USERMAS WHERE USERNO='$account'");
	$fetch = mysqli_fetch_array($sql);
	if (!isset($_COOKIE['account']) || $_COOKIE['account'] != $account) {
		echo json_encode(array('message' => 'No authority'));
	}
	elseif (!isset($_COOKIE['token']) || $_COOKIE['token'] != $fetch['TOKEN']) {
		echo json_encode(array('message' => 'No authority'));
	}
	else {
		$content = '<table><tr><th>場次</th><th>時間</th><th>單位</th><th>名稱</th><th>單位</th><th>名稱</th><th>勝者</th></tr>';
		$sql = mysqli_query($mysql, "SELECT * FROM GAMESTATE WHERE USERNO='$account' AND GAMENO='$gameno' ORDER BY SYSTEMPLAYNO ASC");
		while ($fetch = mysqli_fetch_array($sql)) {
			if (!empty($fetch['PLAYNO'])) {
				$playType = getPlaytype($account, $gameno);
				if ($playType == 'A') {
					$above = queryContentSingle($account, $gameno, $fetch['ABOVE']);
					$below = queryContentSingle($account, $gameno, $fetch['BELOW']);
					if (!empty($fetch['WINNER'])) {
						$winner = queryContentSingle($account, $gameno, $fetch['WINNER']);
						$content .= '<tr><td>'.$fetch['PLAYNO'].'</td><td><input type="text" id="'.$fetch['PLAYNO'].'_time" value="'.$fetch['PLAYTIME'].'"></td><td>'.$above['unit'].'</td><td>'.$above['name'].'</td><td>'.$below['unit'].'</td><td>'.$below['name'].'</td><td>'.$winner['name'].'</td></tr>';
					}
					else {
						$content .= '<tr><td>'.$fetch['PLAYNO'].'</td><td><input type="text" id="'.$fetch['PLAYNO'].'_time" value="'.$fetch['PLAYTIME'].'"></td><td>'.$above['unit'].'</td><td>'.$above['name'].'</td><td>'.$below['unit'].'</td><td>'.$below['name'].'</td></tr>';
					}
				}
				elseif ($playType == 'B') {
					$above = queryContentDouble($account, $gameno, $fetch['ABOVE']);
					$below = queryContentDouble($account, $gameno, $fetch['BELOW']);
					if (!empty($fetch['WINNER'])) {
						$winner = queryContentDouble($account, $gameno, $fetch['WINNER']);
						$content .= '<tr><td>'.$fetch['PLAYNO'].'</td><td><input type="text" id="'.$fetch['PLAYNO'].'_time" value="'.$fetch['PLAYTIME'].'"></td><td>'.$above['unitu'].'<br>'.$above['unitd'].'</td><td>'.$above['nameu'].'<br>'.$above['named'].'</td><td>'.$below['unitu'].'<br>'.$below['unitd'].'</td><td>'.$below['nameu'].'<br>'.$below['named'].'</td><td>'.$winner['nameu'].'<br>'.$winner['named'].'</td></tr>';
					}
					else {
						$content .= '<tr><td>'.$fetch['PLAYNO'].'</td><td><input type="text" id="'.$fetch['PLAYNO'].'_time" value="'.$fetch['PLAYTIME'].'"></td><td>'.$above['unitu'].'<br>'.$above['unitd'].'</td><td>'.$above['nameu'].'<br>'.$above['named'].'</td><td>'.$below['unitu'].'<br>'.$below['unitd'].'</td><td>'.$below['nameu'].'<br>'.$below['named'].'</td></tr>';
					}
				}
				elseif ($playType == 'C') {
					$above = queryContentGroup($account, $gameno, $fetch['ABOVE']);
					$below = queryContentGroup($account, $gameno, $fetch['BELOW']);
					if (!empty($fetch['WINNER'])) {
						$winner = queryContentGroup($account, $gameno, $fetch['WINNER']);
						$content .= '<tr><td>'.$fetch['PLAYNO'].'</td><td><input type="text" id="'.$fetch['PLAYNO'].'_time" value="'.$fetch['PLAYTIME'].'"></td><td>'.$above.'</td><td></td><td>'.$below.'</td><td></td><td>'.$winner.'</td></tr>';
					}
					else {
						$content .= '<tr><td>'.$fetch['PLAYNO'].'</td><td><input type="text" id="'.$fetch['PLAYNO'].'_time" value="'.$fetch['PLAYTIME'].'"></td><td>'.$above.'</td><td></td><td>'.$below.'</td><td></td></tr>';
					}
				}
					
			}
		}
		$content .= '</table><button onclick="updateTime(\''.$account.'\', \''.$gameno.'\')">更新時間</button>';
		echo json_encode(array('message' => 'Success', 'content' => $content));
	}
}
elseif ($type == 'updateTime') {
	$account = $_POST['account'];
	$gameno = $_POST['gameno'];
	$times = explode(',', $_POST['times']);
	$sql = mysqli_query($mysql, "SELECT * FROM USERMAS WHERE USERNO='$account'");
	$fetch = mysqli_fetch_array($sql);
	if (!isset($_COOKIE['account']) || $_COOKIE['account'] != $account) {
		echo json_encode(array('message' => 'No authority'));
	}
	elseif (!isset($_COOKIE['token']) || $_COOKIE['token'] != $fetch['TOKEN']) {
		echo json_encode(array('message' => 'No authority'));
	}
	else {
		$count = 0;
		while (count($times)) {
			$count++;
			$time = array_shift($times);
			mysqli_query($mysql, "UPDATE GAMESTATE SET PLAYTIME='$time' WHERE USERNO='$account' AND GAMENO='$gameno' AND PLAYNO='$count'");
		}
		echo json_encode(array('message' => 'Success'));
	}
}