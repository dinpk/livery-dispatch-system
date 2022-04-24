<?php 
include('php/_code.php');
$show_form = true;
$focus_field = 'ad_source';
// id passed for update
if (isset($_GET['settings_ad_source_valuesid'])) {
	$record_id = trim($_GET['settings_ad_source_valuesid']);
	if (!is_numeric($record_id)) exit;
	if (!isset($_POST['save_submit'])) {
		$results = mysqli_query($dbcon, "SELECT * FROM settings_ad_source_values WHERE key_settings_ad_source_values = $record_id");
		if ($row = mysqli_fetch_assoc($results)) {
			$ad_source = $row['ad_source'];
		} else {
			$message = "<div class='failure-result'>Record not found</div>";
			$show_form = false;
		}
	}
}
// 'Save' button clicked
if (isset($_POST['save_submit'])) {
	$error = 0;
	$ad_source = (isset($_POST['ad_source']) ? trim($_POST['ad_source']) : '');
	if (strlen($ad_source) < 3 || strlen($ad_source) > 50) {
		$msg_ad_source = "<div class='message-error'>Provide a valid value of length 3-50</div>";
		$focus_field = 'ad_source';
		$error = 1;
	}
	// no validation error
	if ($error == 0) {
		if (isset($record_id) && $error != 1) { // update
			$results = mysqli_query($dbcon, "UPDATE settings_ad_source_values SET 
			ad_source = '" . sd($dbcon, $ad_source) . "'
				WHERE key_settings_ad_source_values = $record_id");
			if ($results) {
				$message = "<script>parent.location.reload(false);</script>";
			} else {
				//print mysqli_error($dbcon);
				die('Unable to update, please contact your system administrator.');
			}
		} else if ($error != 1) { // insert
			$results = mysqli_query($dbcon, "INSERT INTO settings_ad_source_values (ad_source) VALUES ('" . sd($dbcon, $ad_source) . "')");
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
	<title>SETTINGS AD SOURCE VALUES</title>
	<?php include('php/_head.php'); ?>
</head>
<body id='page-save' class='page_save page_settings_ad_source_values_save'>

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
             <label for='ad_source'>Ad source</label> <span class='red'> *</span>             <?php if(isset($msg_ad_source)) print $msg_ad_source; ?>
             <input <?php if ($focus_field == 'ad_source') print 'autofocus'; ?> id='ad_source' name='ad_source' type='text' value='<?php if (isset($ad_source)) {print $ad_source;} else { print '';} ?>' required><br>
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
