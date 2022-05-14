<?php 
include('php/_code.php');
$show_form = true;
$focus_field = 'log_type';
// id passed for update
if (isset($_GET['logsid'])) {
	$record_id = trim($_GET['logsid']);
	if (!is_numeric($record_id)) exit;
	if (!isset($_POST['save_submit'])) {
		$results = mysqli_query($dbcon, "SELECT * FROM logs WHERE key_logs = $record_id");
		if ($row = mysqli_fetch_assoc($results)) {
			$log_type = $row['log_type'];
			$log_datetime = $row['log_datetime'];
			$action_performed = $row['action_performed'];
		} else {
			$message = "<div class='failure-result'>Record not found</div>";
			$show_form = false;
		}
	}
}
// 'Save' button clicked
if (isset($_POST['save_submit'])) {
	$error = 0;
	$action_performed = trim($_POST['action_performed']);
	if (strlen($action_performed) > 100) {
		$msg_action_performed = "<div class='message-error'>Provide a valid value of length 0-100</div>";
		$focus_field = 'action_performed';
		$error = 1;
	}
	$log_datetime = trim($_POST['log_datetime']);
	if (empty($log_datetime)) {
		$log_datetime = '1970-01-01';
	} else if (!is_date($log_datetime)) {
		$msg_log_datetime = "<div class='message-error'>Acceptable date format is 'yyyy-mm-dd'</div>";
		$focus_field = 'log_datetime';
		$error = 1;
	}
	$log_type = trim($_POST['log_type']);
	if (strlen($log_type) < 3 || strlen($log_type) > 100) {
		$msg_log_type = "<div class='message-error'>Provide a valid value of length 3-100</div>";
		$focus_field = 'log_type';
		$error = 1;
	}
	// no validation error
	if ($error == 0) {
		
		if (isset($record_id) && $error != 1) { // update
			$results = mysqli_query($dbcon, "UPDATE logs SET 
			log_type = '" . sd($dbcon, $log_type) . "',
			log_datetime = '" . sd($dbcon, $log_datetime) . "',
			action_performed = '" . sd($dbcon, $action_performed) . "'
				WHERE key_logs = $record_id");
			if ($results) {
				$message = "<script>parent.location.reload(false);</script>";
			} else {
				//print mysqli_error($dbcon);
				die('Unable to update, please contact your system administrator.');
			}
		} else if ($error != 1) { // insert
			$results = mysqli_query($dbcon, "INSERT INTO logs (
			log_type,
			log_datetime,
			action_performed
			) 
			VALUES (
			'" . sd($dbcon, $log_type) . "',
			'" . sd($dbcon, $log_datetime) . "',
			'" . sd($dbcon, $action_performed) . "'
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
	<title>LOGS</title>
	<?php include('php/_head.php'); ?>
</head>
<body id='page-save' class='page_save page_logs_save'>

	<section id='sub-menu'>
		<div class='left-block'>logs</div>
		<div class='right-block'>

		</div>
	</section>

	<?php if (isset($message)) print $message; ?>
	
	<main>

	<?php if (isset($show_form) && $show_form) { ?>
	<form method='post'>
		<fieldset>


         <div>
             <label for='log_type'>Log type</label> <span class='red'> *</span>             <?php if(isset($msg_log_type)) print $msg_log_type; ?>
             <input <?php if ($focus_field == 'log_type') print 'autofocus'; ?> id='log_type' name='log_type' type='text' value='<?php if (isset($log_type)) {print $log_type;} else { print '';} ?>' required><br>
         </div>

         <div>
             <label for='log_datetime'>Log date time</label><br>
             <?php if(isset($msg_log_datetime)) print $msg_log_datetime; ?>
             <input id='log_datetime' name='log_datetime' type='date' placeholder='yyyy-mm-dd' value='<?php if (isset($log_datetime)) {print $log_datetime;} ?>'><br>
         </div>

         <div>
             <label for='action_performed'>Action performed</label><br>
             <?php if(isset($msg_action_performed)) print $msg_action_performed; ?>
             <select id='action_performed' name='action_performed'>
                 <?php
                 if (!isset($action_performed)) $action_performed = '';
                 print "
                 <option" . (($action_performed == '') ? " selected='selected'" : '') .  "></option>
                 <option" . (($action_performed == '') ? " selected='selected'" : '') .  "></option>
                 ";
                 ?>
             </select>
         </div>

		</fieldset>
		<div class='clear-fix'>
		<input id='save_submit' name='save_submit' type='submit' value='Save'>
		</div>
		
	</form>
	<?php } ?>

	</main>
	<?php include('php/_footer.php'); ?>

</body>
</html>
