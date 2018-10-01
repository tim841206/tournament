<?php
$mysql = mysqli_connect("localhost", "root", "");
mysqli_query($mysql, "SET NAMES utf8");
mysqli_select_db($mysql, "tournament");