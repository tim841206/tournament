<?php
include_once("resource/custom.php");

if (isset($_POST['event'])) {
	if ($_POST['event'] == 'login') {
		$return = login($_POST['account'], $_POST['password']);
		if ($return['message'] == 'Success') {
			setcookie('account', $_POST['account']);
			setcookie('token', $return['token']);
		}
		echo json_encode(array('message' => $return['message']));
	}
	elseif ($_POST['event'] == 'logon') {
		$return = logon($_POST['account'], $_POST['password']);
		if ($return['message'] == 'Success') {
			setcookie('account', $_POST['account']);
			setcookie('token', $return['token']);
			mkdir($_POST['account']);
		}
		echo json_encode(array('message' => $return['message']));
	}
	else {
		echo 'Invalid event called';
	}
}

elseif (isset($_COOKIE['account']) && isset($_COOKIE['token'])) {
	$content = file_get_contents("index.html");
	$content = str_replace('[memberArea]', $_COOKIE['account'].'，你好', $content);
	echo $content;
}

else {
	$content = file_get_contents("index.html");
	$enter = '帳號：<input type="text" id="account"><br>密碼：<input type="password" id="password"><br><button onclick="login()">登入</button><button onclick="logon()">註冊</button>';
	$content = str_replace('[memberArea]', $enter, $content);
	echo $content;
}