<?php 
include('php/_code.php');
if (isset($_GET['settingspaymentmethodid'])) {
	$record_id = trim($_GET['settingspaymentmethodid']);
	if (!is_numeric($record_id)) die('Invalid record id.');
	$results = mysqli_query($dbcon, "SELECT * FROM settings_payment_method_values WHERE key_settings_payment_method_values = $record_id");
	if ($row = mysqli_fetch_assoc($results)) {
		$payment_method = $row['payment_method'];
	} else {
		$message = "<div class='failure-result'>Record not found</div>";
	}
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>SETTINGS - PAYMENT METHOD</title>
    <?php include('php/_head.php'); ?>
</head>
<body id='page-view'>
    <?php if (isset($message)) print $message; ?>
    <main>
        <table class='record-table'>
            <tr>
                <td class='label-cell'>Payment method</td>
                <td class='value-cell'><?php if (isset($payment_method)) print $payment_method; ?></td>
            </tr>
        </table>
    </main>
    <?php include('php/_footer.php'); ?>
</body>
</html>