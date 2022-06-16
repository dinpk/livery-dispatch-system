<?php 
include('php/_code.php');
if (isset($_GET['customerinvoiceid'])) {
	$record_id = trim($_GET['customerinvoiceid']);
	if (!is_numeric($record_id)) die('Invalid record id.');
	$results = mysqli_query($dbcon, "SELECT * FROM customer_invoices WHERE key_customer_invoices = $record_id");
	if ($row = mysqli_fetch_assoc($results)) {
		$key_customer_passengers = $row['key_customer_passengers'];
		$start_date = $row['start_date'];
		$end_date = $row['end_date'];
		$amount = $row['amount'];
		$amount_paid = $row['amount_paid'];
		$payment_method = $row['payment_method'];
		$due_date = $row['due_date'];
		$issue_date = $row['issue_date'];
		$notes = $row['notes'];
	} else {
		$message = "<div class='failure-result'>Record not found</div>";
	}
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>CUSTOMER INVOICES</title>
    <?php include('php/_head.php'); ?>
</head>
<body id='page-view'>
    <?php if (isset($message)) print $message; ?>
    <main>
        <table class='record-table'>
            <tr>
                <td class='label-cell'>Start date</td>
                <td class='value-cell'><?php if (isset($start_date)) print $start_date; ?></td>
            </tr>
            <tr>
                <td class='label-cell'>End date</td>
                <td class='value-cell'><?php if (isset($end_date)) print $end_date; ?></td>
            </tr>
            <tr>
                <td class='label-cell'>Amount</td>
                <td class='value-cell'><?php if (isset($amount)) print $amount; ?></td>
            </tr>
            <tr>
                <td class='label-cell'>Amount paid</td>
                <td class='value-cell'><?php if (isset($amount_paid)) print $amount_paid; ?></td>
            </tr>
            <tr>
                <td class='label-cell'>Payment method</td>
                <td class='value-cell'><?php if (isset($payment_method)) print $payment_method; ?></td>
            </tr>
            <tr>
                <td class='label-cell'>Due date</td>
                <td class='value-cell'><?php if (isset($due_date)) print $due_date; ?></td>
            </tr>
            <tr>
                <td class='label-cell'>Issue date</td>
                <td class='value-cell'><?php if (isset($issue_date)) print $issue_date; ?></td>
            </tr>
            <tr>
                <td class='label-cell'>Notes</td>
                <td class='value-cell'><?php if (isset($notes)) print $notes; ?></td>
            </tr>
        </table>
    </main>
    <?php include('php/_footer.php'); ?>
</body>
</html>