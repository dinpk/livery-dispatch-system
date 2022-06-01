<?php 
include('php/_code.php');
$show_form = true;
$focus_field = 'state';
// id passed for update
if (isset($_GET['settings_state_valuesid'])) {
	$record_id = trim($_GET['settings_state_valuesid']);
	if (!is_numeric($record_id)) exit;
	if (!isset($_POST['save_submit'])) {
		$results = mysqli_query($dbcon, "SELECT * FROM settings_state_values WHERE key_settings_state_values = $record_id");
		if ($row = mysqli_fetch_assoc($results)) {
			$state = $row['state'];
			$state_code = $row['state_code'];
		} else {
			$message = "<div class='failure-result'>Record not found</div>";
			$show_form = false;
		}
	}
}
// 'Save' button clicked
if (isset($_POST['save_submit'])) {
	$error = 0;
	$state_code = trim($_POST['state_code']);
	if (strlen($state_code) > 10) {
		$msg_state_code = "<div class='message-error'>Provide a valid value of length 0-10</div>";
		$focus_field = 'state_code';
		$error = 1;
	}
	$state = trim($_POST['state']);
	if (strlen($state) > 50) {
		$msg_state = "<div class='message-error'>Provide a valid value of length 0-50</div>";
		$focus_field = 'state';
		$error = 1;
	}
	// no validation error
	if ($error == 0) {
		if (isset($record_id) && $error != 1) { // update
			$results = mysqli_query($dbcon, "UPDATE settings_state_values SET 
				state = '" . sd($dbcon, $state) . "',
				state_code = '" . sd($dbcon, $state_code) . "'
				WHERE key_settings_state_values = $record_id");
			if ($results) {
				$message = "<script>parent.location.reload(false);</script>";
			} else {
				//print mysqli_error($dbcon);
				die('Unable to update, please contact your system administrator.');
			}
		} else if ($error != 1) { // insert
			$results = mysqli_query($dbcon, "INSERT INTO settings_state_values (
			state,
			state_code
			) 
			VALUES (
			'" . sd($dbcon, $state) . "',
			'" . sd($dbcon, $state_code) . "'
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
	<title>SETTINGS STATE VALUES</title>
	<?php include('php/_head.php'); ?>
</head>
<body id='page-save' class='page_save page_settings_state_values_save'>

	<section id='sub-menu'>
		<div class='left-block'> </div>
		<div class='right-block'> </div>
	</section>

	<?php if (isset($message)) print $message; ?>
	
	<main>

	<?php if (isset($show_form) && $show_form) { ?>
	<form method='post'>
		<fieldset>

         <div>
             <label for='state'>State</label>
			 <?php if(isset($msg_state)) print $msg_state; ?>
             <input id='state' name='state' type='text' value='<?php if (isset($state)) {print $state;} else { print '';} ?>'><br>
         </div>

         <div>
             <label for='state_code'>State code</label>
			 <?php if(isset($msg_state_code)) print $msg_state_code; ?>
             <input id='state_code' name='state_code' type='text' value='<?php if (isset($state_code)) {print $state_code;} else { print '';} ?>'><br>
         </div>

		</fieldset>
		
		<input id='save_submit' name='save_submit' type='submit' value='Save'>
		
		
	</form>
	<?php } ?>

	</main>
	<?php include('php/_footer.php'); ?>

</body>
</html>
