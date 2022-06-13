<?php 
include('php/_code.php');
$show_form = true;
$focus_field = 'offtime_type';
// id passed for update
if (isset($_GET['settings_offtime_type_valuesid'])) {
	$record_id = trim($_GET['settings_offtime_type_valuesid']);
	if (!is_numeric($record_id)) exit;
	if (!isset($_POST['save_submit'])) {
		$results = mysqli_query($dbcon, "SELECT * FROM settings_offtime_type_values WHERE key_settings_offtime_type_values = $record_id");
		if ($row = mysqli_fetch_assoc($results)) {
			$offtime_type = $row['offtime_type'];
		} else {
			$message = "<div class='failure-result'>Record not found</div>";
			$show_form = false;
		}
	}
}
// 'Save' button clicked
if (isset($_POST['save_submit'])) {
	$error = 0;
	$offtime_type = trim($_POST['offtime_type']);
	if (strlen($offtime_type) < 3 || strlen($offtime_type) > 50) {
		$msg_offtime_type = "<div class='message-error'>Provide a valid value of length 3-50</div>";
		$focus_field = 'offtime_type';
		$error = 1;
	}
	// no validation error
	if ($error == 0) {
		if (isset($record_id) && $error != 1) { // update
			$results = mysqli_query($dbcon, "UPDATE settings_offtime_type_values 
				SET offtime_type = '" . sd($dbcon, $offtime_type) . "'
				WHERE key_settings_offtime_type_values = $record_id");
			if ($results) {
				$message = "<script>parent.location.reload(false);</script>";
			} else {
				//print mysqli_error($dbcon);
				die('Unable to update, please contact your system administrator.');
			}
		} else if ($error != 1) { // insert
			$results = mysqli_query($dbcon, "INSERT INTO settings_offtime_type_values (offtime_type) VALUES ('" . sd($dbcon, $offtime_type) . "')");
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
	<title>SETTINGS OFFTIME TYPE VALUES</title>
	<?php include('php/_head.php'); ?>
</head>
<body id='page-save' class='page_save page_settings_offtime_type_values_save'>

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
             <label for='offtime_type'>Off-time type</label> <span class='red'> *</span>             <?php if(isset($msg_offtime_type)) print $msg_offtime_type; ?>
             <input id='offtime_type' name='offtime_type' type='text' value='<?php if (isset($offtime_type)) {print $offtime_type;} else { print '';} ?>' required><br>
         </div>

		</fieldset>
		
		<input id='save_submit' name='save_submit' type='submit' value='Save'>
		
		
	</form>
	<?php } ?>

	</main>
	<?php include('php/_footer.php'); ?>

</body>
</html>
