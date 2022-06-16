<?php 
include('php/_code.php');
$report_title = 'Trip Sheet';
$report_data = '';
$show_email_form = false;
if (isset($_GET['pickup_date'])) {
	$pickup_date = sd($dbcon, $_GET['pickup_date']);
	$full_report = '';
	$results_data = mysqli_query($dbcon, "SELECT * FROM trips WHERE DATE(pickup_datetime) = '$pickup_date' ORDER BY pickup_datetime");
	while ($row_data = mysqli_fetch_assoc($results_data)) {
		$key_trips = $row_data['key_trips'];
		$single_trip = "<div>";
		if (!empty($row_data['key_trips'])) $single_trip .= "<div><b>Trip#: </b>" . $row_data['key_trips'] . "</div>";
		if (!empty($row_data['reference_number'])) $single_trip .= "<div>" . $row_data['reference_number'] . "</div>";
		$single_trip .= "<div><b>Passenger:</b> " . $row_data['passenger_name'] . "</div>";
		$single_trip .= "<div><b>Date-Time:</b> " . date("M d, Y - h:ia", strtotime($row_data['pickup_datetime'])) . "</div>";
		if (!empty($row_data['reserved_by'])) $single_trip .= "<div><b>Reserved by: </b>" . $row_data['reserved_by'] . "</div>";
		if (!empty($row_data['trip_type'])) $single_trip .= "<div><b>Trip type: </b>" . $row_data['trip_type'] . "</div>";
		if (!empty($row_data['trip_status'])) $single_trip .= "<div><b>Trip status: </b>" . $row_data['trip_status'] . "</div>";
		$single_trip .= "</div>";
		$single_trip .= "<div style='padding:0 10px 0 10px;'>";
		$single_trip .= "<div><b>From:</b> " . $row_data['routing_from'] . "</div>";
		$single_trip .= "<div><b>To:</b> " . $row_data['routing_to'] . "</div>";
		if (!empty($row_data['airline'])) $single_trip .= "<div><b>Flight: </b>" . $row_data['airline'] . " " . $row_data['flight_number'] . "</div>";
		$single_trip .= "<div><b>Driver:</b> " . $row_data['driver_name'] . "</div>";
		$single_trip .= "<div><b>Vehicle:</b> " . $row_data['vehicle'] . "</div>";
		$single_trip .= "</div>";		$single_trip .= "<div style='margin:0 0 0 auto;'>";
		$single_trip .= "<table>";
		if ($row_data['rate_type'] == 'Flat') {
			$single_trip .= "<tr><td><b>Flat charges</b>&nbsp;</td><td style='text-align:right;border:1px solid #000;'>" . $row_data['total_trip_amount'] . "</td></tr>";
		} else {
			if ($row_data['rate_type'] == 'Zone') {
				$single_trip .= "<tr><td><b>Zone base amount</b>&nbsp;</td><td style='text-align:right;border:1px solid #000;'>" . $row_data['base_amount'] . "</td></tr>";
			} else if ($row_data['rate_type'] == 'Hourly') {
				if ($row_data['hourly_regular_amount'] != '0') $single_trip .= "<tr><td><b>Hourly</b> (regular)&nbsp;</td><td style='text-align:right;'>" . $row_data['regular_hours'] . ":" . $row_data['regular_minutes'] . " @ " . $row_data['hourly_regular_rate']  . " = " . $row_data['hourly_regular_amount'] . "</td></tr>";
				if ($row_data['hourly_wait_amount'] != '0') $single_trip .= "<tr><td><b>Hourly</b> (wait)&nbsp;</td><td style='text-align:right;'>" . $row_data['wait_hours'] . ":" . $row_data['wait_minutes'] . " @ " . $row_data['hourly_wait_rate']  . " = " . $row_data['hourly_wait_amount'] . "</td></tr>";
				if ($row_data['hourly_overtime_amount'] != '0') $single_trip .= "<tr><td><b>Hourly</b> (overtime)&nbsp;</td><td style='text-align:right;'>" . $row_data['overtime_hours'] . ":" . $row_data['overtime_minutes'] . " @ " . $row_data['hourly_overtime_rate']  . " = " . $row_data['hourly_overtime_amount'] . "</td></tr>";
				$single_trip .= "<tr><td><b>Hourly base amount</b>&nbsp;</td><td style='text-align:right;border:1px solid #000;'>" . $row_data['base_amount'] . "</td></tr>";
			}
			if ($row_data['discount_amount'] != '0') $single_trip .= "<tr><td><b>Discount</b> (" . $row_data['discount_percent'] . "%) </td><td style='text-align:right;'>" . $row_data['discount_amount'] . "</td></tr>";
			if ($row_data['offtime_amount'] != '0') $single_trip .= "<tr><td><b>Off-time</b> (" . $row_data['offtime_type'] . ") </td><td style='text-align:right;'>" . $row_data['offtime_amount'] . "</td></tr>";
			if ($row_data['extra_stops_amount'] != '0') $single_trip .= "<tr><td><b>Stops</b> (" . $row_data['extra_stops'] . ") </td><td style='text-align:right;'>" . $row_data['extra_stops_amount'] . "</td></tr>";
			if ($row_data['tolls_amount'] != '0') $single_trip .= "<tr><td><b>Tolls</b> (" . $row_data['toll_type'] . ") </td><td style='text-align:right;'>" . $row_data['tolls_amount'] . "</td></tr>";
			if ($row_data['parking_amount'] != '0') $single_trip .= "<tr><td><b>Parking</b></td><td style='text-align:right;'>" . $row_data['parking_amount'] . "</td></tr>";
			if ($row_data['gratuity_amount'] != '0') $single_trip .= "<tr><td><b>Gratuity</b> (" . $row_data['gratuity_percent'] . "%) </td><td style='text-align:right;'>" . $row_data['gratuity_amount'] . "</td></tr>";
			if ($row_data['gas_surcharge_amount'] != '0') $single_trip .= "<tr><td><b>Gas surcharge</b> (" . $row_data['gas_surcharge_percent'] . "%) </td><td style='text-align:right;'>" . $row_data['gas_surcharge_amount'] . "</td></tr>";
			if ($row_data['admin_fee_amount'] != '0') $single_trip .= "<tr><td><b>Admin fee</b> (" . $row_data['admin_fee_percent'] . "%) </td><td style='text-align:right;'>" . $row_data['admin_fee_amount'] . "</td></tr>";
			$results_charges = mysqli_query($dbcon, "SELECT category, amount FROM trip_extra_charges WHERE key_trips = $key_trips");
			while ($row_charges = mysqli_fetch_assoc($results_charges)) {
				$single_trip .= "<tr><td><b>" . $row_charges['category'] . "</b> </td><td style='text-align:right;'>" . $row_charges['amount'] . "</td></tr>";
			}
			if ($row_data['tax_amount'] != '0') $single_trip .= "<tr><td><b>Tax</b> (" . $row_data['tax_percent'] . "%) </td><td style='text-align:right;'>" . $row_data['tax_amount'] . "</td></tr>";
			$single_trip .= "<tr><td><b>Total charges</b></td><td style='text-align:right;border:1px solid #000;'>" . $row_data['total_trip_amount'] . "</td></tr>";
			
		}
		$single_trip .= "</table>";
		$single_trip .= "</div>";
		$single_trip = "
		<div style='margin-top:10px;padding:5px;border:1px solid #000;display:flex;justify-content:space-between;'>
			$single_trip
			<p>$description</p>
		</div>
		";
		$full_report .= $single_trip;
	}
	
	if (!empty($full_report)) $show_email_form = true;
	$full_report = "<h1 class='to-center'>Trip Sheet</h1><h3 class='to-center'>" . date("M d, Y - h:ia") .  "</h3>" . $full_report;
}
if (isset($_POST['email'])) {
	$email = (isset($_POST['email']) ? trim($_POST['email']) : '');
	$subject = "Trip Sheet " . date("M d, Y - h:ia");
	if (strlen($email) < 0 || strlen($email) > 100) {
		$msg_email = "<div class='message-error'>Provide a valid value of length 0-100</div>";
		$focus_field = 'email';
	} else {
		if (send_email($email, $subject, $full_report)) {
			$message = "<p class='success-result'>Email has been sent</p>";
		} else {
			$message = "<p class='failure-result'>Could not send email, please try again later</p>";
		}		
	}
}
?>
<!DOCTYPE html>
<html>
<head>
    <title><?php print $report_title; ?></title>
    <link rel='stylesheet' href='css/styles_report.css'>
    <meta charset='utf-8'>
</head>
<body id='page-report' class='customer_invoices_print'>
    <form class='to-center'>
        <input id='pickup_date' name='pickup_date' type='date'
            value='<?php if (isset($pickup_date)) {print $pickup_date;} else {print date('Y-m-d');} ?>'>
        <input type='submit' value='Get'>
    </form>
    <?php if (isset($message)) print $message; ?>
    <main>
        <?php
			if ($show_email_form) {
				print "
				<form method='post' class='to-center'>
					<label for='email'>Email</label> " 
					. ((isset($msg_email)) ? $msg_email : '') . 
					"<input id='email' name='email' type='email' autofocus required> 
					<input id='email_button' type='submit' value='Send'>
				</form>
				";
			}
			print $full_report;
		?>
    </main>
</body>
</html>