<?php 
include('php/_code.php');
$show_form = true;
$focus_field = 'vehicle_make';
// id passed for update
if (isset($_GET['settings_vehicle_make_valuesid'])) {
	$record_id = trim($_GET['settings_vehicle_make_valuesid']);
	if (!is_numeric($record_id)) exit;
	if (!isset($_POST['save_submit'])) {
		$results = mysqli_query($dbcon, "SELECT * FROM settings_vehicle_make_values WHERE key_settings_vehicle_make_values = $record_id");
		if ($row = mysqli_fetch_assoc($results)) {
			$vehicle_make = $row['vehicle_make'];
		} else {
			$message = "<div class='failure-result'>Record not found</div>";
			$show_form = false;
		}
	}
}
// 'Save' button clicked
if (isset($_POST['save_submit'])) {
	$error = 0;
	$vehicle_make = trim($_POST['vehicle_make']);
	if (strlen($vehicle_make) < 3 || strlen($vehicle_make) > 50) {
		$msg_vehicle_make = "<div class='message-error'>Provide a valid value of length 3-50</div>";
		$focus_field = 'vehicle_make';
		$error = 1;
	}
	// no validation error
	if ($error == 0) {
		if (isset($record_id) && $error != 1) { // update
			$results = mysqli_query($dbcon, "UPDATE settings_vehicle_make_values SET 
			vehicle_make = '" . sd($dbcon, $vehicle_make) . "'
				WHERE key_settings_vehicle_make_values = $record_id");
			if ($results) {
				$message = "<script>parent.location.reload(false);</script>";
			} else {
				//print mysqli_error($dbcon);
				die('Unable to update, please contact your system administrator.');
			}
		} else if ($error != 1) { // insert
			$results = mysqli_query($dbcon, "INSERT INTO settings_vehicle_make_values (vehicle_make) VALUES ('" . sd($dbcon, $vehicle_make) . "')");
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
	<title>SETTINGS VEHICLE MAKE VALUES</title>
	<?php include('php/_head.php'); ?>
</head>
<body id='page-save' class='page_save page_settings_vehicle_make_values_save'>

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
             <label for='vehicle_make'>Make</label> <span class='red'> *</span>             <?php if(isset($msg_vehicle_make)) print $msg_vehicle_make; ?>
             <input id='vehicle_make' name='vehicle_make' type='text' value='<?php if (isset($vehicle_make)) {print $vehicle_make;} else { print '';} ?>' required><br>
         </div>

		</fieldset>
		
		<input id='save_submit' name='save_submit' type='submit' value='Save'>
		
		
	</form>
	<?php } ?>

	</main>
	<?php include('php/_footer.php'); ?>

</body>
</html>
