<?php 
include('php/_code.php');
$show_form = true;
$focus_field = 'vehicle_model';
// id passed for update
if (isset($_GET['settings_vehicle_model_valuesid'])) {
	$record_id = trim($_GET['settings_vehicle_model_valuesid']);
	if (!is_numeric($record_id)) exit;
	if (!isset($_POST['save_submit'])) {
		$results = mysqli_query($dbcon, "SELECT * FROM settings_vehicle_model_values WHERE key_settings_vehicle_model_values = $record_id");
		if ($row = mysqli_fetch_assoc($results)) {
			$vehicle_model = $row['vehicle_model'];
		} else {
			$message = "<div class='failure-result'>Record not found</div>";
			$show_form = false;
		}
	}
}
// 'Save' button clicked
if (isset($_POST['save_submit'])) {
	$error = 0;
	$vehicle_model = trim($_POST['vehicle_model']);
	if (strlen($vehicle_model) < 3 || strlen($vehicle_model) > 50) {
		$msg_vehicle_model = "<div class='message-error'>Provide a valid value of length 3-50</div>";
		$focus_field = 'vehicle_model';
		$error = 1;
	}
	// no validation error
	if ($error == 0) {
		if (isset($record_id) && $error != 1) { // update
			$results = mysqli_query($dbcon, "UPDATE settings_vehicle_model_values SET 
			vehicle_model = '" . sd($dbcon, $vehicle_model) . "'
				WHERE key_settings_vehicle_model_values = $record_id");
			if ($results) {
				$message = "<script>parent.location.reload(false);</script>";
			} else {
				//print mysqli_error($dbcon);
				die('Unable to update, please contact your system administrator.');
			}
		} else if ($error != 1) { // insert
			$results = mysqli_query($dbcon, "INSERT INTO settings_vehicle_model_values (vehicle_model) VALUES ('" . sd($dbcon, $vehicle_model) . "')");
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
	<title>SETTINGS VEHICLE MODEL VALUES</title>
	<?php include('php/_head.php'); ?>
</head>
<body id='page-save' class='page_save page_settings_vehicle_model_values_save'>

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
             <label for='vehicle_model'>Model</label> <span class='red'> *</span>             <?php if(isset($msg_vehicle_model)) print $msg_vehicle_model; ?>
             <input <?php if ($focus_field == 'vehicle_model') print 'autofocus'; ?> id='vehicle_model' name='vehicle_model' type='text' value='<?php if (isset($vehicle_model)) {print $vehicle_model;} else { print '';} ?>' required><br>
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
