<?php 
include('php/_code.php');
$report_title = 'Customer invoice';
$report_data = '';
if (isset($_GET['customerinvoiceid'])) {
	$record_id = trim($_GET['customerinvoiceid']);
	if (!is_numeric($record_id)) die('Invalid record id.');
	$results = mysqli_query($dbcon, "SELECT * FROM customer_invoices WHERE key_customer_invoices = $record_id");
	if ($results) {
		if ($row = mysqli_fetch_assoc($results)) {
			$group_key = $row['key_customer_passengers'];
			$report_key = $row['key_customer_invoices'];
			$report_date_from = date('M d, Y', strtotime($row['start_date']));
			$report_date_to = date('M d, Y', strtotime($row['end_date']));
			$total_amount = $row['amount'];
			$paid_amount = $row['amount_paid'];
			$balance_amount = round($total_amount - $paid_amount, 2);
			$issue_date = date('M d, Y', strtotime($row['issue_date']));
			$due_date = date('M d, Y', strtotime($row['due_date']));
			$description = $row['notes'];
			$results_group = mysqli_query($dbcon, "SELECT first_name,last_name,company_name,email FROM customer_passengers WHERE key_customer_passengers = $group_key");
			if ($row_group = mysqli_fetch_assoc($results_group)) {
				$group_info = '';
				$group_info .= $row_group['first_name'] . ' ' . $row_group['last_name'] . '<br>';
				$group_info .= $row_group['company_name'] . '<br>';
				$group_info .= $row_group['email'] . '<br>';
			}
			$amount_total = 0;
			$single_report = '';
			$results_data = mysqli_query($dbcon, "SELECT * FROM trips WHERE key_customer_invoices = $report_key ORDER BY pickup_datetime");
			while ($row_data = mysqli_fetch_assoc($results_data)) {
				$key_trips = $row_data['key_trips'];
				$single_report .= "<div>";
				if (!empty($row_data['key_trips'])) $single_report .= "<div><b>Trip#: </b>" . $row_data['key_trips'] . "</div>";
				if (!empty($row_data['reference_number'])) $single_report .= "<div>" . $row_data['reference_number'] . "</div>";
				$single_report .= "<div><b>Passenger:</b> " . $row_data['passenger_name'] . "</div>";
				$single_report .= "<div><b>Date-Time:</b> " . date("M d, Y - h:ia", strtotime($row_data['pickup_datetime'])) . "</div>";
				if (!empty($row_data['reserved_by'])) $single_report .= "<div><b>Reserved by: </b>" . $row_data['reserved_by'] . "</div>";
				if (!empty($row_data['trip_type'])) $single_report .= "<div><b>Trip type: </b>" . $row_data['trip_type'] . "</div>";
				if (!empty($row_data['trip_status'])) $single_report .= "<div><b>Trip status: </b>" . $row_data['trip_status'] . "</div>";
				$single_report .= "</div>";
				$single_report .= "<div style='padding:0 10px 0 10px;'>";
				$single_report .= "<div><b>From:</b> " . $row_data['routing_from'] . "</div>";
				$single_report .= "<div><b>To:</b> " . $row_data['routing_to'] . "</div>";
				if (!empty($row_data['airline'])) $single_report .= "<div><b>Flight: </b>" . $row_data['airline'] . " " . $row_data['flight_number'] . "</div>";
				$single_report .= "<div><b>Driver:</b> " . $row_data['driver_name'] . "</div>";
				$single_report .= "<div><b>Vehicle:</b> " . $row_data['vehicle'] . "</div>";
				$single_report .= "</div>";
				
				$single_report .= "<div style='margin:0 0 0 auto;'>";
				$single_report .= "<table>";
				if ($row_data['rate_type'] == 'Flat') {
					$single_report .= "<tr><td><b>Flat charges</b>&nbsp;</td><td style='text-align:right;border:1px solid #000;'>" . $row_data['total_trip_amount'] . "</td></tr>";
				} else {
					if ($row_data['rate_type'] == 'Zone') {
						$single_report .= "<tr><td><b>Zone base amount</b>&nbsp;</td><td style='text-align:right;border:1px solid #000;'>" . $row_data['base_amount'] . "</td></tr>";
					} else if ($row_data['rate_type'] == 'Hourly') {
						if ($row_data['hourly_regular_amount'] != '0') $single_report .= "<tr><td><b>Hourly</b> (regular)&nbsp;</td><td style='text-align:right;'>" . $row_data['regular_hours'] . ":" . $row_data['regular_minutes'] . " @ " . $row_data['hourly_regular_rate']  . " = " . $row_data['hourly_regular_amount'] . "</td></tr>";
						if ($row_data['hourly_wait_amount'] != '0') $single_report .= "<tr><td><b>Hourly</b> (wait)&nbsp;</td><td style='text-align:right;'>" . $row_data['wait_hours'] . ":" . $row_data['wait_minutes'] . " @ " . $row_data['hourly_wait_rate']  . " = " . $row_data['hourly_wait_amount'] . "</td></tr>";
						if ($row_data['hourly_overtime_amount'] != '0') $single_report .= "<tr><td><b>Hourly</b> (overtime)&nbsp;</td><td style='text-align:right;'>" . $row_data['overtime_hours'] . ":" . $row_data['overtime_minutes'] . " @ " . $row_data['hourly_overtime_rate']  . " = " . $row_data['hourly_overtime_amount'] . "</td></tr>";
						$single_report .= "<tr><td><b>Hourly base amount</b>&nbsp;</td><td style='text-align:right;border:1px solid #000;'>" . $row_data['base_amount'] . "</td></tr>";
					}
					if ($row_data['discount_amount'] != '0') $single_report .= "<tr><td><b>Discount</b> (" . $row_data['discount_percent'] . "%) </td><td style='text-align:right;'>" . $row_data['discount_amount'] . "</td></tr>";
					if ($row_data['offtime_amount'] != '0') $single_report .= "<tr><td><b>Off-time</b> (" . $row_data['offtime_type'] . ") </td><td style='text-align:right;'>" . $row_data['offtime_amount'] . "</td></tr>";
					if ($row_data['extra_stops_amount'] != '0') $single_report .= "<tr><td><b>Stops</b> (" . $row_data['extra_stops'] . ") </td><td style='text-align:right;'>" . $row_data['extra_stops_amount'] . "</td></tr>";
					if ($row_data['tolls_amount'] != '0') $single_report .= "<tr><td><b>Tolls</b> (" . $row_data['toll_type'] . ") </td><td style='text-align:right;'>" . $row_data['tolls_amount'] . "</td></tr>";
					if ($row_data['parking_amount'] != '0') $single_report .= "<tr><td><b>Parking</b></td><td style='text-align:right;'>" . $row_data['parking_amount'] . "</td></tr>";
					if ($row_data['gratuity_amount'] != '0') $single_report .= "<tr><td><b>Gratuity</b> (" . $row_data['gratuity_percent'] . "%) </td><td style='text-align:right;'>" . $row_data['gratuity_amount'] . "</td></tr>";
					if ($row_data['gas_surcharge_amount'] != '0') $single_report .= "<tr><td><b>Gas surcharge</b> (" . $row_data['gas_surcharge_percent'] . "%) </td><td style='text-align:right;'>" . $row_data['gas_surcharge_amount'] . "</td></tr>";
					if ($row_data['admin_fee_amount'] != '0') $single_report .= "<tr><td><b>Admin fee</b> (" . $row_data['admin_fee_percent'] . "%) </td><td style='text-align:right;'>" . $row_data['admin_fee_amount'] . "</td></tr>";
					$results_charges = mysqli_query($dbcon, "SELECT category, amount FROM trip_extra_charges WHERE key_trips = $key_trips");
					while ($row_charges = mysqli_fetch_assoc($results_charges)) {
						$single_report .= "<tr><td><b>" . $row_charges['category'] . "</b> </td><td style='text-align:right;'>" . $row_charges['amount'] . "</td></tr>";
					}
					if ($row_data['tax_amount'] != '0') $single_report .= "<tr><td><b>Tax</b> (" . $row_data['tax_percent'] . "%) </td><td style='text-align:right;'>" . $row_data['tax_amount'] . "</td></tr>";
					$single_report .= "<tr><td><b>Total charges</b></td><td style='text-align:right;border:1px solid #000;'>" . $row_data['total_trip_amount'] . "</td></tr>";
					
				}
				$single_report .= "</table>";
				$single_report .= "</div>";
				
			}
			$single_report = "
			<div style='margin-top:10px;padding:5px;border:1px solid #000;display:flex;justify-content:space-between;'>
				$single_report
				<p>$description</p>
			</div>
			";
			if ($total_amount == 0 || $total_amount == $paid_amount) {
				$balance_amount = "<td class='paid to-right'>$balance_amount</td>";
			} else if ($paid_amount == 0) {
				$balance_amount = "<td class='unpaid to-right'>$balance_amount</td>";
			} else if ($total_amount > $paid_amount) {
				$balance_amount= "<td class='partially-paid to-right'>$balance_amount</td>";
			} else {
				$balance_amount = "<td class='over-paid to-right'>$balance_amount</td>";
			}
			$report_data .= "
				<h2>$report_title # $report_key</h2>
				<table>
				<tr>
				<td style='width:40%'>
				$group_info
				</td>
				<td style='width:40%'>
				<table class='to-right-block'>
				<tr>
				<td><b>Period</b></td>
				<td>$report_date_from &nbsp;-&nbsp; $report_date_to</td>
				</tr>
				<tr>
				<td><b>Total</b></td>
				<td class='to-right'>$total_amount</td>
				</tr>
				<tr>
				<td><b>Paid</b></td>
				<td class='to-right'>$paid_amount</td>
				</tr>
				<tr>
				<td><b>Balance</b></td>
				$balance_amount
				</tr>
				<tr>
				<td><b>issued</b></td>
				<td>$issue_date</td>
				</tr>
				<tr>
				<td><b>Due</b></td>
				<td>$due_date</td>
				</tr>
				</table>
				</td>
				</tr>
				</table>
			";
			$report_data .= $single_report;
		}
		if (mysqli_num_rows($results) == 0) {
			$message = "<div class='failure-result'>No record found</div>";
		}
	} else {
		// print mysqli_error($dbcon);
		die('Unable to get records, please contact your system administrator.');
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
    <main>
        <?php
			print $report_data;
		?>
    </main>
</body>
</html>