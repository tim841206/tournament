<?php
include_once("resource/database.php");
include_once("resource/custom.php");

if (isset($_POST['event'])) {
	if ($_POST['event'] == 'login') {
		$return = login($_POST['account'], $_POST['password']);
		if (is_array($return) && $return['message'] == 'Success') {
			setcookie('account', $_POST['account']);
			setcookie('token', $return['token']);
			echo json_encode(array('message' => $return['message']));
		}
		else {
			echo json_encode(array('message' => $return));
		}
	}
	elseif ($_POST['event'] == 'logon') {
		$return = logon($_POST['account'], $_POST['password']);
		if (is_array($return) && $return['message'] == 'Success') {
			setcookie('account', $_POST['account']);
			setcookie('token', $return['token']);
			mkdir($_POST['account']);
			echo json_encode(array('message' => $return['message']));
		}
		else {
			echo json_encode(array('message' => $return));
		}
	}
	elseif ($_POST['event'] == 'logout') {
		$return = logout($_COOKIE['account']);
		if ($return == 'Success') {
			setcookie("account", "", time() - 3600);
			setcookie("token", "", time() - 3600);
		}
		echo json_encode(array('message' => $return));
	}
	else {
		echo 'Invalid event called';
	}
}

elseif (isset($_GET['host']) && isset($_GET['gameno'])) {
	$host = $_GET['host'];
	$gameno = $_GET['gameno'];
	$sql = mysqli_query($mysql, "SELECT * FROM USERMAS WHERE USERNO='$host'");
	$fetch = mysqli_fetch_array($sql);
	if (isset($_COOKIE['account']) && isset($_COOKIE['token']) && $_COOKIE['account'] == $host && $_COOKIE['token'] == $fetch['TOKEN']) {
		if (isset($_GET['type']) && $_GET['type'] == 'assign') {
			$content = file_get_contents($host."/".$gameno."/assign.html");
			echo $content;
		}
		elseif (isset($_GET['type']) && $_GET['type'] == 'game') {
			$content = file_get_contents($host."/".$gameno."/function.html");
			echo $content;
		}
		else {
			$content = file_get_contents($host."/".$gameno."/edit.html");
			echo $content;
		}
	}
	else {
		if (isset($_GET['type']) && $_GET['type'] == 'game') {
			$content = file_get_contents($host."/".$gameno."/game.html");
			echo $content;
		}
		else {
			$content = file_get_contents($host."/".$gameno."/public.html");
			echo $content;
		}
	}
}

elseif (isset($_COOKIE['account']) && isset($_COOKIE['token'])) {
	$content = file_get_contents("resource/index_member.html");
	$content = str_replace('[memberArea]', $_COOKIE['account'], $content);
	echo $content;
}

else {
	$content = file_get_contents("resource/index_customer.html");
	echo $content;
}