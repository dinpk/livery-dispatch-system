<?php 
include('php/_code.php');
$show_form = true;
$focus_field = 'dispatch_area';
// id passed for update
if (isset($_GET['settings_dispatch_area_valuesid'])) {
	$record_id = trim($_GET['settings_dispatch_area_valuesid']);
	if (!is_numeric($record_id)) exit;
	if (!isset($_POST['save_submit'])) {
		$results = mysqli_query($dbcon, "SELECT * FROM settings_dispatch_area_values WHERE key_settings_dispatch_area_values = $record_id");
		if ($row = mysqli_fetch_assoc($results)) {
			$dispatch_area = $row['dispatch_area'];
		} else {
			$message = "<div class='failure-result'>Record not found</div>";
			$show_form = false;
		}
	}
}
// 'Save' button clicked
if (isset($_POST['save_submit'])) {
	$error = 0;
	$dispatch_area = trim($_POST['dispatch_area']);
	if (strlen($dispatch_area) < 3 || strlen($dispatch_area) > 50) {
		$msg_dispatch_area = "<div class='message-error'>Provide a valid value of length 3-50</div>";
		$focus_field = 'dispatch_area';
		$error = 1;
	}
	// no validation error
	if ($error == 0) {
		if (isset($record_id) && $error != 1) { // update
			$results = mysqli_query($dbcon, "UPDATE settings_dispatch_area_values SET 
			dispatch_area = '" . sd($dbcon, $dispatch_area) . "'
				WHERE key_settings_dispatch_area_values = $record_id");
			if ($results) {
				$message = "<script>parent.location.reload(false);</script>";
			} else {
				//print mysqli_error($dbcon);
				die('Unable to update, please contact your system administrator.');
			}
		} else if ($error != 1) { // insert
			$results = mysqli_query($dbcon, "INSERT INTO settings_dispatch_area_values (dispatch_area) VALUES ('" . sd($dbcon, $dispatch_area) . "')");
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
	<title>SETTINGS DISPATCH AREA VALUES</title>
	<?php include('php/_head.php'); ?>
</head>
<body id='page-save' class='page_save page_settings_dispatch_area_values_save'>

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
             <label for='dispatch_area'>Dispatch area</label> <span class='red'> *</span>             <?php if(isset($msg_dispatch_area)) print $msg_dispatch_area; ?>
             <input id='dispatch_area' name='dispatch_area' type='text' value='<?php if (isset($dispatch_area)) {print $dispatch_area;} else { print '';} ?>' required><br>
         </div>

		</fieldset>
		
		<input id='save_submit' name='save_submit' type='submit' value='Save'>
		
		
	</form>
	<?php } ?>

	</main>
	<?php include('php/_footer.php'); ?>

</body>
</html>
