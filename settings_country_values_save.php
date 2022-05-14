<?php 
include('php/_code.php');
$show_form = true;
$focus_field = 'country';
// id passed for update
if (isset($_GET['settings_country_valuesid'])) {
	$record_id = trim($_GET['settings_country_valuesid']);
	if (!is_numeric($record_id)) exit;
	if (!isset($_POST['save_submit'])) {
		$results = mysqli_query($dbcon, "SELECT * FROM settings_country_values WHERE key_settings_country_values = $record_id");
		if ($row = mysqli_fetch_assoc($results)) {
			$country = $row['country'];
			$country_code = $row['country_code'];
		} else {
			$message = "<div class='failure-result'>Record not found</div>";
			$show_form = false;
		}
	}
}
// 'Save' button clicked
if (isset($_POST['save_submit'])) {
	$error = 0;
	$country_code = trim($_POST['country_code']);
	if (strlen($country_code) > 10) {
		$msg_country_code = "<div class='message-error'>Provide a valid value of length 0-10</div>";
		$focus_field = 'country_code';
		$error = 1;
	}
	$country = trim($_POST['country']);
	if (strlen($country) < 3 || strlen($country) > 50) {
		$msg_country = "<div class='message-error'>Provide a valid value of length 3-50</div>";
		$focus_field = 'country';
		$error = 1;
	}
	// no validation error
	if ($error == 0) {
		if (isset($record_id) && $error != 1) { // update
			$results = mysqli_query($dbcon, "UPDATE settings_country_values SET 
			country = '" . sd($dbcon, $country) . "',
			country_code = '" . sd($dbcon, $country_code) . "'
				WHERE key_settings_country_values = $record_id");
			if ($results) {
				$message = "<script>parent.location.reload(false);</script>";
			} else {
				//print mysqli_error($dbcon);
				die('Unable to update, please contact your system administrator.');
			}
		} else if ($error != 1) { // insert
			$results = mysqli_query($dbcon, "INSERT INTO settings_country_values (
			country,
			country_code
			) 
			VALUES (
			'" . sd($dbcon, $country) . "',
			'" . sd($dbcon, $country_code) . "'
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
	<title>SETTINGS COUNTRY VALUES</title>
	<?php include('php/_head.php'); ?>
</head>
<body id='page-save' class='page_save page_settings_country_values_save'>
	<section id='sub-menu'>
		<div class='left-block'></div>
		<div class='right-block'>
		</div>
	</section>
	<?php if (isset($message)) print $message; ?>
	<main>
	<?php if (isset($show_form) && $show_form) { ?>
	<form method='post'>
		<fieldset>
         <div>
             <label for='country'>Country</label> <span class='red'> *</span>             <?php if(isset($msg_country)) print $msg_country; ?>
             <input <?php if ($focus_field == 'country') print 'autofocus'; ?> id='country' name='country' type='text' value='<?php if (isset($country)) {print $country;} else { print '';} ?>' required><br>
         </div>
         <div>
             <label for='country_code'>Country code</label>             <?php if(isset($msg_country_code)) print $msg_country_code; ?>
             <input <?php if ($focus_field == 'country_code') print 'autofocus'; ?> id='country_code' name='country_code' type='text' value='<?php if (isset($country_code)) {print $country_code;} else { print '';} ?>'><br>
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
