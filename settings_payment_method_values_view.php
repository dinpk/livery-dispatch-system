<?php 
include('php/_code.php');
if (isset($_GET['settings_payment_method_valuesid'])) {
	$record_id = trim($_GET['settings_payment_method_valuesid']);
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
	<title>SETTINGS PAYMENT METHOD VALUES</title>
	<?php include('php/_head.php'); ?>
</head>
<body id='page-view' class='page_view page_settings_payment_method_values_view'>

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
