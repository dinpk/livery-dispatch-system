<?php 
include('php/_code.php');
$show_form = true;
$focus_field = 'payment_method';
// id passed for update
if (isset($_GET['settingspaymentmethodid'])) {
	$record_id = trim($_GET['settingspaymentmethodid']);
	if (!is_numeric($record_id)) exit;
	if (!isset($_POST['save_submit'])) {
		$results = mysqli_query($dbcon, "SELECT * FROM settings_payment_method_values WHERE key_settings_payment_method_values = $record_id");
		if ($row = mysqli_fetch_assoc($results)) {
			$payment_method = $row['payment_method'];
		} else {
			$message = "<div class='failure-result'>Record not found</div>";
			$show_form = false;
		}
	}
}
// save button clicked
if (isset($_POST['save_submit'])) {
	$error = 0;
	$payment_method = trim($_POST['payment_method']);
	if (strlen($payment_method) < 3 || strlen($payment_method) > 50) {
		$msg_payment_method = "<div class='message-error'>Provide a valid value of length 3-50</div>";
		$focus_field = 'payment_method';
		$error = 1;
	}
	// no validation error
	if ($error == 0) {
		if (isset($record_id) && $error != 1) { // update
			$results = mysqli_query($dbcon, "UPDATE settings_payment_method_values 
				SET payment_method = '" . sd($dbcon, $payment_method) . "'
				WHERE key_settings_payment_method_values = $record_id");
			if ($results) {
				$message = "<script>parent.location.reload(false);</script>";
			} else {
				//print mysqli_error($dbcon);
				die('Unable to update, please contact your system administrator.');
			}
		} else if ($error != 1) { // insert
			$results = mysqli_query($dbcon, "INSERT INTO settings_payment_method_values (payment_method) VALUES ('" . sd($dbcon, $payment_method) . "')");
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
    <title>SETTINGS - PAYMENT METHOD</title>
    <?php include('php/_head.php'); ?>
</head>
<body id='page-save'>
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
                    <label for='payment_method'>Payment method</label> <span class='red'> *</span>
                    <?php if(isset($msg_payment_method)) print $msg_payment_method; ?>
                    <input id='payment_method' name='payment_method' type='text'
                        value='<?php if (isset($payment_method)) {print $payment_method;} else { print '';} ?>'
                        required><br>
                </div>
            </fieldset>
			<input id='save_submit' name='save_submit' type='submit' value='Save'>
        </form>
        <?php } ?>
    </main>
    <?php include('php/_footer.php'); ?>
</body>
</html>