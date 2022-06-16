<?php 
include('php/_code.php');
if (isset($_GET['settingspaymentcardtypeid'])) {
	$record_id = trim($_GET['settingspaymentcardtypeid']);
	if (!is_numeric($record_id)) die('Invalid record id.');
	$results = mysqli_query($dbcon, "SELECT * FROM settings_payment_card_type_values WHERE key_settings_payment_card_type_values = $record_id");
	if ($row = mysqli_fetch_assoc($results)) {
		$payment_card_type = $row['payment_card_type'];
	} else {
		$message = "<div class='failure-result'>Record not found</div>";
	}
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>SETTINGS PAYMENT CARD TYPE</title>
    <?php include('php/_head.php'); ?>
</head>
<body id='page-view'>
    <?php if (isset($message)) print $message; ?>
    <main>
        <table class='record-table'>
            <tr>
                <td class='label-cell'>Payment card type</td>
                <td class='value-cell'><?php if (isset($payment_card_type)) print $payment_card_type; ?></td>
            </tr>
        </table>
    </main>
    <?php include('php/_footer.php'); ?>
</body>
</html>