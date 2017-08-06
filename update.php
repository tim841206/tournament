<?php
include_once("resource/database.php");
include_once("resource/custom.php");

$gameno = $_POST['gameno'];
$above = explode(',', $_POST['above']);
$below = explode(',', $_POST['below']);
for ($i = 1; $i < count($above); $i++) {
	$temp_above = $above[$i];
	$temp_below = $below[$i];
	mysql_query("UPDATE GAMESTATE SET ABOVESCORE='$temp_above', BELOWSCORE='$temp_below' WHERE GAMENO='$gameno' AND PLAYNO='$i'");
}
updateGameChart($gameno);
echo json_encode(array('message' => 'Success'));