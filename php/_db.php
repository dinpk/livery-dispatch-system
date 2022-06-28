<?php

$db_host = "localhost";
$db_name = "liverydispatchsystem";
$db_user = "root";
$db_password = "asdf";

function db_connection() {
	$dbcon = mysqli_connect($GLOBALS['db_host'], $GLOBALS['db_user'], $GLOBALS['db_password'], $GLOBALS['db_name']);
	if (mysqli_connect_errno()) die("Could not connect to the database, please contact your system administrator.");
	mysqli_query($dbcon, "SET NAMES 'utf8'");
	return $dbcon;
}
$dbcon = db_connection();
?>

