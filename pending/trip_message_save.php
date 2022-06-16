<?php 
include('php/_code.php');
$show_form = true;
$focus_field = 'message';
// id passed for update
if (isset($_GET['trips_messagesid'])) {
	$record_id = trim($_GET['trips_messagesid']);
	if (!is_numeric($record_id)) exit;
	if (!isset($_POST['save_submit'])) {
		$results = mysqli_query($dbcon, "SELECT * FROM trips_messages WHERE key_trips_messages = $record_id");
		if ($row = mysqli_fetch_assoc($results)) {
			$key_trips = $row['key_trips'];
			$key_drivers = $row['key_drivers'];
			$key_staff = $row['key_staff'];
			$date_time = $row['date_time'];
			$message = $row['message'];
		} else {
			$message = "<div class='failure-result'>Record not found</div>";
			$show_form = false;
		}
	}
}
// save button clicked
if (isset($_POST['save_submit'])) {
	$error = 0;
	$message = trim($_POST['message']);
	if (strlen($message) > 1000) {
		$msg_message = "<div class='message-error'>Provide a valid value of length 0-1000</div>";
		$focus_field = 'message';
		$error = 1;
	}
	$date_time = trim($_POST['date_time']);
	if (empty($date_time)) {
		$date_time = '1970-01-01';
	} else if (!is_date($date_time)) {
		$msg_date_time = "<div class='message-error'>Acceptable date format is 'yyyy-mm-dd'</div>";
		$focus_field = 'date_time';
		$error = 1;
	}
	$key_staff = trim($_POST['key_staff']);
	if (strlen($key_staff) > 100 || !is_numeric($key_staff)) {
		$msg_key_staff = "<div class='message-error'>Provide a valid value of length 0-100</div>";
		$focus_field = 'key_staff';
		$error = 1;
	}
	$key_drivers = trim($_POST['key_drivers']);
	if (strlen($key_drivers) > 100 || !is_numeric($key_drivers)) {
		$msg_key_drivers = "<div class='message-error'>Provide a valid value of length 0-100</div>";
		$focus_field = 'key_drivers';
		$error = 1;
	}
	$key_trips = trim($_POST['key_trips']);
	if (strlen($key_trips) > 100 || !is_numeric($key_trips)) {
		$msg_key_trips = "<div class='message-error'>Provide a valid value of length 0-100</div>";
		$focus_field = 'key_trips';
		$error = 1;
	}
	// no validation error
	if ($error == 0) {
		if (isset($record_id) && $error != 1) { // update
			$results = mysqli_query($dbcon, "UPDATE trips_messages SET 
			key_trips = '" . sd($dbcon, $key_trips) . "',
			key_drivers = '" . sd($dbcon, $key_drivers) . "',
			key_staff = '" . sd($dbcon, $key_staff) . "',
			date_time = '" . sd($dbcon, $date_time) . "',
			message = '" . sd($dbcon, $message) . "'
			WHERE key_trips_messages = $record_id");
			if ($results) {
				$message = "<script>parent.location.reload(false);</script>";
			} else {
				//print mysqli_error($dbcon);
				die('Unable to update, please contact your system administrator.');
			}
		} else if ($error != 1) { // insert
			$results = mysqli_query($dbcon, "INSERT INTO trips_messages (
			key_trips,
			key_drivers,
			key_staff,
			date_time,
			message
			) 
			VALUES (
			'" . sd($dbcon, $key_trips) . "',
			'" . sd($dbcon, $key_drivers) . "',
			'" . sd($dbcon, $key_staff) . "',
			'" . sd($dbcon, $date_time) . "',
			'" . sd($dbcon, $message) . "'
			)");
			if ($results) {
				$message = "<script>parent.location.reload(false);</script>";
			} else {
				if (strpos(mysqli_error($dbcon), "Duplicate") > -1) {
					$message = "<div class='failure-result'>" . mysqli_error($dbcon) . "</div>";
					$error = 1;
				} else {
					die('Unable to add, please contact your system administrator.');
				}
			}
		}	
	}
	if ($error == 0) $show_form = false;
}
?>
<!DOCTYPE html>
<html>
<head>
	<title>TRIPS MESSAGES</title>
	<?php include('php/_head.php'); ?>
</head>
<body id='page-save' class='page_save page_trips_messages_save'>

	<section id='sub-menu'>
		<div class='left-block'>trips messages</div>
		<div class='right-block'>

		</div>
	</section>

	<?php if (isset($message)) print $message; ?>
	
	<main>

	<?php if (isset($show_form) && $show_form) { ?>
	<form method='post'>
		<fieldset>

         <input id='key_trips' name='key_trips' type='hidden' value='<?php if (isset($key_trips)) {print $key_trips;} else {print '0';} ?>'>


         <input id='key_drivers' name='key_drivers' type='hidden' value='<?php if (isset($key_drivers)) {print $key_drivers;} else {print '0';} ?>'>


         <input id='key_staff' name='key_staff' type='hidden' value='<?php if (isset($key_staff)) {print $key_staff;} else {print '0';} ?>'>


         <div>
             <label for='date_time'>Date time</label><br>
             <?php if(isset($msg_date_time)) print $msg_date_time; ?>
             <input id='date_time' name='date_time' type='date' placeholder='yyyy-mm-dd' value='<?php if (isset($date_time)) {print $date_time;} ?>'><br>
         </div>

         <div>
             <label for='message'>Message</label>
			 <?php if(isset($msg_message)) print $msg_message; ?>
             <textarea id='message' name='message'><?php if (isset($message)) print $message; ?></textarea><br>
         </div>

		</fieldset>		<input id='save_submit' name='save_submit' type='submit' value='Save'>		
	</form>
	<?php } ?>

	</main>
	<?php include('php/_footer.php'); ?>

</body>
</html>
