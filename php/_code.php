<?php

include('php/_authenticate.php');
include('php/_db.php');

$app_icon = "";
$sender_email = "";
$receiver_email = "";
$time_zone = "America/New_York";
$print_errors = true;
$email_errors = false;

date_default_timezone_set($time_zone);

error_reporting(E_ALL & ~E_NOTICE);
function error_catcher($error_level, $error_message, $error_file, $error_line, $error_context) {
	$error_details = "
	<b>Level: </b>$error_level<br>
	<b>Message: </b>$error_message<br>
	<b>File: </b> $error_file<br>
	<b>Line: </b>$error_line<br>
	<b>URL: </b>" . $_SERVER['REQUEST_URI'] . "<br>";
	$subject = $GLOBALS['app_name'] . ": Error in $error_file";
	$from = $GLOBALS['app_email'];
	$to = $GLOBALS['admin_email'];
	$headers  = "From: $from\r\n";
	$headers .= "Content-type: text/html\r\n"; 
	if ($GLOBALS['email_errors']) mail($to, $subject, $error_details, $headers);
	if ($GLOBALS['print_errors']) print $error_details;
}
set_error_handler("error_catcher");

function sd($dbcon, $value) {return mysqli_real_escape_string($dbcon, strip_tags($value));}
function cd($dbcon, $value) {return mysqli_real_escape_string($dbcon, $value);}
function is_date($value) {return preg_match("/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/", $value);}
function is_time($value) {return preg_match("/(2[0-3]|[01][0-9]):([0-5][0-9])/", $value);}
function is_email($email) {
	$pattern = '/^(?!(?:(?:\\x22?\\x5C[\\x00-\\x7E]\\x22?)|(?:\\x22?[^\\x5C\\x22]\\x22?)){255,})(?!(?:(?:\\x22?\\x5C[\\x00-\\x7E]\\x22?)|(?:\\x22?[^\\x5C\\x22]\\x22?)){65,}@)(?:(?:[\\x21\\x23-\\x27\\x2A\\x2B\\x2D\\x2F-\\x39\\x3D\\x3F\\x5E-\\x7E]+)|(?:\\x22(?:[\\x01-\\x08\\x0B\\x0C\\x0E-\\x1F\\x21\\x23-\\x5B\\x5D-\\x7F]|(?:\\x5C[\\x00-\\x7F]))*\\x22))(?:\\.(?:(?:[\\x21\\x23-\\x27\\x2A\\x2B\\x2D\\x2F-\\x39\\x3D\\x3F\\x5E-\\x7E]+)|(?:\\x22(?:[\\x01-\\x08\\x0B\\x0C\\x0E-\\x1F\\x21\\x23-\\x5B\\x5D-\\x7F]|(?:\\x5C[\\x00-\\x7F]))*\\x22)))*@(?:(?:(?!.*[^.]{64,})(?:(?:(?:xn--)?[a-z0-9]+(?:-+[a-z0-9]+)*\\.){1,126}){1,}(?:(?:[a-z][a-z0-9]*)|(?:(?:xn--)[a-z0-9]+))(?:-+[a-z0-9]+)*)|(?:\\[(?:(?:IPv6:(?:(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){7})|(?:(?!(?:.*[a-f0-9][:\\]]){7,})(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){0,5})?::(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){0,5})?)))|(?:(?:IPv6:(?:(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){5}:)|(?:(?!(?:.*[a-f0-9]:){5,})(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){0,3})?::(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){0,3}:)?)))?(?:(?:25[0-5])|(?:2[0-4][0-9])|(?:1[0-9]{2})|(?:[1-9]?[0-9]))(?:\\.(?:(?:25[0-5])|(?:2[0-4][0-9])|(?:1[0-9]{2})|(?:[1-9]?[0-9]))){3}))\\]))$/iD';
	return (preg_match($pattern, $email) === 1);
}

function send_email($email, $subject, $body) {
	if (!is_email($email)) return false;
	$sender_name = "Livery Dispatch System";
	$sender_email = "sender@gmail.com";
	$header  = 'MIME-Version: 1.0' . "\r\n";
	$header .= 'Content-type: text/html; charset=utf-8' . "\r\n";
	$header .= "From: ". $sender_name . " <" . $sender_email . ">\r\n";
	return mail($email, $subject, $body, $header);
}


function pager($url, $total_items, $page_offset, $items_per_page) {
	$pager = "";
	if ($total_items > $page_offset) {
		$prev_page_offset = $page_offset - $items_per_page;
		$next_page_offset = $page_offset + $items_per_page;
		$last_page_offset = ((int)($total_items / $items_per_page) * $items_per_page);
		$pager = '';
		if ($next_page_offset != $items_per_page) {
			$pager .= "<td class='pager-first'><a href=$url" . "page=0> « </a></td>";
		}
		if ($prev_page_offset >= 0) {
			$pager .= "<td class='pager-prev'><a href=$url" . "page=$prev_page_offset> ◄ </a></td></td>";
		}
		$pager .= "<td class='pager-info'>" . ($page_offset + 1) . "-" . ($next_page_offset < $total_items ? $next_page_offset : $total_items) . " (" . $total_items . ")</td>";
		if ($next_page_offset < $total_items) {
			$pager .= "<td class='pager-next'><a href=$url" . "page=$next_page_offset> ► </a></td>";
		}
		if ($next_page_offset <= $last_page_offset) {
			$pager .= "<td class='pager-last'><a href=$url" . "page=" . $last_page_offset . "> » </a></td>";
		}
		$pager = "<table id='pager'><tr>$pager</tr></table>";
	}
	return $pager;
}

?>

