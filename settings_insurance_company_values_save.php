<?php 
include('php/_code.php');
$show_form = true;
$focus_field = 'insurance_company';
// id passed for update
if (isset($_GET['settings_insurance_company_valuesid'])) {
	
	$record_id = trim($_GET['settings_insurance_company_valuesid']);
	if (!is_numeric($record_id)) exit;
	if (!isset($_POST['save_submit'])) {
		$results = mysqli_query($dbcon, "SELECT * FROM settings_insurance_company_values WHERE key_settings_insurance_company_values = $record_id");
		if ($row = mysqli_fetch_assoc($results)) {
			$insurance_company = $row['insurance_company'];
		} else {
			$message = "<div class='failure-result'>Record not found</div>";
			$show_form = false;
		}
	}
}
// 'Save' button clicked
if (isset($_POST['save_submit'])) {
	$error = 0;
	$insurance_company = trim($_POST['insurance_company']);
	if (strlen($insurance_company) < 3 || strlen($insurance_company) > 50) {
		$msg_insurance_company = "<div class='message-error'>Provide a valid value of length 3-50</div>";
		$focus_field = 'insurance_company';
		$error = 1;
	}
	// no validation error
	if ($error == 0) {
		if (isset($record_id) && $error != 1) { // update
			$results = mysqli_query($dbcon, "UPDATE settings_insurance_company_values SET 
			insurance_company = '" . sd($dbcon, $insurance_company) . "'
				WHERE key_settings_insurance_company_values = $record_id");
			if ($results) {
				$message = "<script>parent.location.reload(false);</script>";
			} else {
				//print mysqli_error($dbcon);
				die('Unable to update, please contact your system administrator.');
			}
		} else if ($error != 1) { // insert
			$results = mysqli_query($dbcon, "INSERT INTO settings_insurance_company_values (insurance_company) VALUES ('" . sd($dbcon, $insurance_company) . "')");
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
	<title>SETTINGS INSURANCE COMPANY VALUES</title>
	<?php include('php/_head.php'); ?>
</head>
<body id='page-save' class='page_save page_settings_insurance_company_values_save'>

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
             <label for='insurance_company'>Insurance company</label> <span class='red'> *</span>             <?php if(isset($msg_insurance_company)) print $msg_insurance_company; ?>
             <input <?php if ($focus_field == 'insurance_company') print 'autofocus'; ?> id='insurance_company' name='insurance_company' type='text' value='<?php if (isset($insurance_company)) {print $insurance_company;} else { print '';} ?>' required><br>
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
