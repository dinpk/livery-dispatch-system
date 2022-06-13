<?php
define("BACKUP_PATH", $_SERVER['DOCUMENT_ROOT'] . "/applimo/backup/");

$server_name   = "localhost";
$username      = "root";
$password      = "asdf";
$database_name = "limopath";
$date_string   = date("Ymd");

$cmd = "mysqldump --routines -h {$server_name} -u {$username} -p{$password} {$database_name} > " . BACKUP_PATH . "{$date_string}_{$database_name}.sql";

exec($cmd);
?>
