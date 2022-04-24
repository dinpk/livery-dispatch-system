<?php

$restore_file  = $_SERVER['DOCUMENT_ROOT'] . "/applimo/backup/20220421_limopath.sql";
$server_name   = "localhost";
$username      = "root";
$password      = "asdf";
$database_name = "limopath";

$connect = mysqli_connect($server_name, $username, $password, $database_name);
if (mysqli_connect_errno()) die("Could not connect to the database, please contact your system administrator.");
mysqli_query($connect, "SET NAMES 'utf8'");

// DROP EXISTING TABLES
    $query_disable_checks = 'SET foreign_key_checks = 0';
    $query_result = mysqli_query($connect, $query_disable_checks);
    // Get the first table
    $show_query = 'Show tables';
    $query_result = mysqli_query($connect, $show_query);
    $row = mysqli_fetch_array($query_result);
    while ($row) {
        $query = 'DROP TABLE IF EXISTS ' . $row[0];
        $query_result = mysqli_query($connect, $query);
        // Getting the next table
        $show_query = 'Show tables';
        $query_result = mysqli_query($connect, $show_query);
        $row = mysqli_fetch_array($query_result);
    }

// RESTORE

    $cmd = "mysql -h {$server_name} -u {$username} -p{$password} {$database_name} < $restore_file";
    exec($cmd);
?>