<?php 
include('php/_code.php');
$show_form = true;
$focus_field = 'toll_type';
// id passed for update
if (isset($_GET['settings_toll_type_valuesid'])) {
	$record_id = trim($_GET['settings_toll_type_valuesid']);
	if (!is_numeric($record_id)) exit;
	if (!isset($_POST['save_submit'])) {
		$results = mysqli_query($dbcon, "SELECT * FROM settings_toll_type_values WHERE key_settings_toll_type_values = $record_id");
		if ($row = mysqli_fetch_assoc($results)) {
			$toll_type = $row['toll_type'];
		} else {
			$message = "<div class='failure-result'>Record not found</div>";
			$show_form = false;
		}
	}
}
// 'Save' button clicked
if (isset($_POST['save_submit'])) {
	$error = 0;
	$toll_type = trim($_POST['toll_type']);
	if (strlen($toll_type) < 3 || strlen($toll_type) > 50) {
		$msg_toll_type = "<div class='message-error'>Provide a valid value of length 3-50</div>";
		$focus_field = 'toll_type';
		$error = 1;
	}
	// no validation error
	if ($error == 0) {
		if (isset($record_id) && $error != 1) { // update
			$results = mysqli_query($dbcon, "UPDATE settings_toll_type_values SET 
			toll_type = '" . sd($dbcon, $toll_type) . "'
				WHERE key_settings_toll_type_values = $record_id");
			if ($results) {
				$message = "<script>parent.location.reload(false);</script>";
			} else {
				//print mysqli_error($dbcon);
				die('Unable to update, please contact your system administrator.');
			}
		} else if ($error != 1) { // insert
			$results = mysqli_query($dbcon, "INSERT INTO settings_toll_type_values (toll_type) VALUES ('" . sd($dbcon, $toll_type) . "')");
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
	<title>SETTINGS TOLL TYPE VALUES</title>
	<?php include('php/_head.php'); ?>
</head>
<body id='page-save' class='page_save page_settings_toll_type_values_save'>

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
             <label for='toll_type'>Toll type</label> <span class='red'> *</span>             <?php if(isset($msg_toll_type)) print $msg_toll_type; ?>
             <input <?php if ($focus_field == 'toll_type') print 'autofocus'; ?> id='toll_type' name='toll_type' type='text' value='<?php if (isset($toll_type)) {print $toll_type;} else { print '';} ?>' required><br>
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
