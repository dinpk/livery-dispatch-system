<?php 
include('php/_code.php');
if (isset($_GET['tripsid'])) {
	$record_id = trim($_GET['tripsid']);
	if (!is_numeric($record_id)) die('Invalid record id.');
	$results = mysqli_query($dbcon, "SELECT * FROM trips WHERE key_trips = $record_id");
	if ($row = mysqli_fetch_assoc($results)) {
		$key_trips = $row['key_trips'];
		$key_customer_invoices = $row['key_customer_invoices'];
		$key_customer_passengers = $row['key_customer_passengers'];
		$key_trips = $row['key_trips'];
		$passenger_name = $row['passenger_name'];
		$reserved_by = $row['reserved_by'];
		$total_passengers = $row['total_passengers'];
		$pickup_datetime = date('M d, Y - h:ia', strtotime($row['pickup_datetime']));
		$invoice_start_date = date('Y-m-d', strtotime($row['pickup_datetime']));
		$invoice_end_date = date('Y-m-d', strtotime($row['pickup_datetime']));
		$invoice_issue_date = date('Y-m-d');
		$airline = $row['airline'];
		$flight_number = $row['flight_number'];
		$routing_from = $row['routing_from'];
		$routing_to = $row['routing_to'];
		$total_trip_amount = $row['total_trip_amount'];
		$concluded_checkbox = $row['concluded_checkbox'];
		$settled_checkbox = $row['settled_checkbox'];
	} else {
		$message = "<div class='failure-result'>Record not found</div>";
	}
	$results = mysqli_query($dbcon, "SELECT first_name, last_name, email FROM customer_passengers WHERE key_customer_passengers = $key_customer_passengers");
	if ($row = mysqli_fetch_assoc($results)) {
		$passenger_email = $row['email'];
	}
	/* ----------------- CREAT INVOICE ------------------- */
	if (isset($_POST['create_invoice'])) {
		$error = 0;
		$due_date = (isset($_POST['due_date']) ? trim($_POST['due_date']) : '');
		if (!is_date($due_date)) {
			$msg_due_date = "<div class='message-error'>Acceptable date format is 'yyyy-mm-dd'</div>";
			$focus_field = 'due_date';
			$error = 1;
		}
		if ($error == 0) {
			mysqli_query($dbcon, "INSERT INTO customer_invoices (key_customer_passengers, start_date, end_date, issue_date, due_date, amount, amount_paid, notes) 
										VALUES ($key_customer_passengers, '$invoice_start_date', '$invoice_end_date', '$invoice_issue_date', '$due_date', $total_trip_amount, 0, '')");
			$key_customer_invoices = mysqli_insert_id($dbcon);
			mysqli_query($dbcon, "UPDATE trips SET key_customer_invoices = $key_customer_invoices WHERE key_trips = $key_trips");
			// print mysqli_error($dbcon);
			$message = "<div class='success-result'>Invoice created successfully.</div>";
		}
	}
	/* ----------------- SEND INVOICE ------------------- */
	if (isset($_POST['send_invoice'])) {
		
		$results = mysqli_query($dbcon, "SELECT * FROM customer_invoices WHERE key_customer_invoices = $key_customer_invoices");
		if ($row = mysqli_fetch_assoc($results)) {
			$key_customer_passengers = $row['key_customer_passengers'];
			$start_date = date('M d, Y', strtotime($row['start_date']));
			$end_date = date('M d, Y', strtotime($row['end_date']));
			$amount = $row['amount'];
			$amount_paid = $row['amount_paid'];
			$balance = round($amount - $amount_paid, 2);
			$payment_method = $row['payment_method'];
			$due_date = date('M d, Y', strtotime($row['due_date']));
			$issue_date = date('M d, Y', strtotime($row['issue_date']));
		}

		$subject = "Invoice # " . $key_customer_invoices;
		$email_body = "
			<div class='center' style='line-height:80%'>
				<h1 style='line-height:110%'>Invoice # $key_customer_invoices</h1>
				<div>$passenger_name</div>
				<table style='margin:20px auto 20px auto;border-collapse:collapse;text-align:left;' border='1' cellspacing='0' cellpadding='5'>
					<tr><td><b>Period</b></td><td>$start_date — $end_date</td></tr>
					<tr><td><b>Amount</b></td><td style='text-align:right;'>$amount</td></tr>
					<tr><td><b>Paid</b></td><td style='text-align:right;'>$amount_paid</td></tr>
					<tr><td><b>Balance</b></td><td style='text-align:right;'>$balance</td></tr>
					<tr><td><b>Payment method</b></td><td>$payment_method</td></tr>
					<tr><td><b>Issued on</b></td><td>$issue_date</td></tr>
					<tr><td><b>Due date</b></td><td>$due_date</td></tr>
				</table>
			</div>
		";

		$sent = send_email($passenger_email, $subject, $email_body);

		if ($sent) {
			$message = "<div class='success-result'>Email has been sent.</div>";
		} else {
			$message = "<div class='failure-result'>Could not send email, please try again later.</div>";
		}		
	} // send_invoice
}
?>
<!DOCTYPE html>
<html>
<head>
	<title>TRIP INVOICE</title>
	<?php include('php/_head.php'); ?>
</head>
<body id='page-view' class='page_view page_trips_view'>

	<?php if (isset($message)) print $message; ?>
	
	<main>
	<?php 

		print "
			<div class='center'>
			<h1>Invoice</h1>
			<h2>$passenger_name</h2>
			<p>$passenger_email</p>
			</div>";

		if ($concluded_checkbox != 'on') {
			print "<h3 class='center'><a href='trip_conclude_save.php?tripsid=$key_trips' target='overlay-iframe2' onclick='overlayOpen2();'>Conclude trip # $key_trips</a></h3>";
		} else if ($settled_checkbox != 'on') {
			print "<h3 class='center'><a href='trip_payroll_settlement_save.php?tripsid=$key_trips' target='overlay-iframe2' onclick='overlayOpen2();'>Settle trip # $key_trips</a></h3>";
		} else if ($key_customer_invoices == '0') {
			print "
			<form class='center' method='post'>
				<p>Due date <input type='date' name='due_date' value='" . date("Y-m-d") . "'></p>
				<p><input type='submit' name='create_invoice' id='view_submit' value='Create invoice'></p>
			</form>
			<br>";
		} else {
			print "
			<form class='center' method='post'>
				<p><a href='customer_invoice_print_single.php?customer_invoicesid=$key_customer_invoices' target='_blank'>View Invoice # $key_customer_invoices</a></p>
				<p><input type='submit' name='send_invoice' id='view_submit' value='Send invoice'></p>
			</form>
			<br>";
		}
	?>

     <table class='record-table'>
         <tr>
         <td class='label-cell'>Trip #</td>
         <td class='value-cell'><?php print $key_trips; ?></td>
         </tr>

         <tr>
         <td class='label-cell'>Passenger name</td>
         <td class='value-cell'><?php print $passenger_name; ?></td>
         </tr>

         <tr>
         <td class='label-cell'>Total passengers</td>
         <td class='value-cell'><?php print $total_passengers; ?></td>
         </tr>

         <tr>
         <td class='label-cell'>Reserved by</td>
         <td class='value-cell'><?php print $reserved_by; ?></td>
         </tr>

         <tr>
         <td class='label-cell'>Date Time</td>
         <td class='value-cell'><?php print $pickup_datetime; ?></td>
         </tr>

         <tr>
         <td class='label-cell'>Flight</td>
         <td class='value-cell'><?php print $airline . ' ' . $flight_number; ?></td>
         </tr>

         <tr>
         <td class='label-cell'>From</td>
         <td class='value-cell'><?php print $routing_from; ?></td>
         </tr>

         <tr>
         <td class='label-cell'>To</td>
         <td class='value-cell'><?php print $routing_to; ?></td>
         </tr>
		 
         <tr>
         <td class='label-cell'>Charges</td>
         <td class='value-cell'><?php print $total_trip_amount; ?></td>
         </tr>

     </table>

	</main>
	<?php include('php/_footer.php'); ?>
</body>
</html>
