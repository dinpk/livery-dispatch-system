<?php

session_start();

$url = $_SERVER["REQUEST_URI"];
$base_file_name = basename(substr($url, 0, strpos($url, ".")));

if (!isset($_SESSION["loggedin"])) {
	header("location: login.php");
} else if ($_SESSION["username"] != "admin") {
	if (!in_array($base_file_name, $_SESSION["permission_items"])) {
		print("You do not have access to this page.");
		exit;
	}
}

?>
