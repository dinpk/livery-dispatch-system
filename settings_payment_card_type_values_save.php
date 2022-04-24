<?php 
include('php/_code.php');
$show_form = true;
$focus_field = 'payment_card_type';
// id passed for update
if (isset($_GET['settings_payment_card_type_valuesid'])) {
	$record_id = trim($_GET['settings_payment_card_type_valuesid']);
	if (!is_numeric($record_id)) exit;
	if (!isset($_POST['save_submit'])) {
		$results = mysqli_query($dbcon, "SELECT * FROM settings_payment_card_type_values WHERE key_settings_payment_card_type_values = $record_id");
		if ($row = mysqli_fetch_assoc($results)) {
			$payment_card_type = $row['payment_card_type'];
		} else {
			$message = "<div class='failure-result'>Record not found</div>";
			$show_form = false;
		}
	}
}
// 'Save' button clicked
if (isset($_POST['save_submit'])) {
	$error = 0;
	$payment_card_type = (isset($_POST['payment_card_type']) ? trim($_POST['payment_card_type']) : '');
	if (strlen($payment_card_type) < 3 || strlen($payment_card_type) > 50) {
		$msg_payment_card_type = "<div class='message-error'>Provide a valid value of length 3-50</div>";
		$focus_field = 'payment_card_type';
		$error = 1;
	}
	// no validation error
	if ($error == 0) {
		if (isset($record_id) && $error != 1) { // update
			$results = mysqli_query($dbcon, "UPDATE settings_payment_card_type_values SET 
			payment_card_type = '" . sd($dbcon, $payment_card_type) . "'
				WHERE key_settings_payment_card_type_values = $record_id");
			if ($results) {
				$message = "<script>parent.location.reload(false);</script>";
			} else {
				//print mysqli_error($dbcon);
				die('Unable to update, please contact your system administrator.');
			}
		} else if ($error != 1) { // insert
			$results = mysqli_query($dbcon, "INSERT INTO settings_payment_card_type_values (payment_card_type) VALUES ('" . sd($dbcon, $payment_card_type) . "')");
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
	<title>SETTINGS PAYMENT CARD TYPE VALUES</title>
	<?php include('php/_head.php'); ?>
</head>
<body id='page-save' class='page_save page_settings_payment_card_type_values_save'>

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
             <label for='payment_card_type'>Payment card type</label> <span class='red'> *</span>             <?php if(isset($msg_payment_card_type)) print $msg_payment_card_type; ?>
             <input <?php if ($focus_field == 'payment_card_type') print 'autofocus'; ?> id='payment_card_type' name='payment_card_type' type='text' value='<?php if (isset($payment_card_type)) {print $payment_card_type;} else { print '';} ?>' required><br>
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
