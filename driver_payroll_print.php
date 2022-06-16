<?php 
include('php/_code.php');
$report_title = 'Driver payroll';
$report_data = '';
$show_form = true;
$process_results = false;
if (isset($_POST['get_button'])) {
	$date_from = sd($dbcon, $_POST['date_from']);
	$date_to = sd($dbcon, $_POST['date_to']);
	$status = sd($dbcon, $_POST['status']);
	$sql_where = '';
	if ($status == 'Unpaid') {
		$sql_where = ' AND amount_paid = 0 ';
	} else if ($status == 'Full paid') {
		$sql_where = ' AND amount = amount_paid ';
	} else if ($status == 'Less paid') {
		$sql_where = ' AND amount_paid < amount AND amount_paid != 0';
	} else if ($status == 'Over paid') {
		$sql_where = ' AND amount_paid > amount ';
	}
	$results = mysqli_query($dbcon, "SELECT * FROM driver_payroll WHERE (end_date BETWEEN '$date_from' AND '$date_to') $sql_where");
	$process_results = true;
} else if (isset($_GET['driverpayrollid'])) {
	$record_id = trim($_GET['driverpayrollid']);
	if (!is_numeric($record_id)) die('Invalid record id.');
	$results = mysqli_query($dbcon, "SELECT * FROM driver_payroll WHERE key_driver_payroll = $record_id");
	$show_form = false;
	$process_results = true;
}
if ($process_results) {
	if ($results) {
		while ($row = mysqli_fetch_assoc($results)) {
			$group_key = $row['key_drivers'];
			$report_key = $row['key_driver_payroll'];
			$report_date_from = date('M d, Y', strtotime($row['start_date']));
			$report_date_to = date('M d, Y', strtotime($row['end_date']));
			$total_amount = $row['amount'];
			$paid_amount = $row['amount_paid'];
			$balance_amount = round($total_amount - $paid_amount, 2);
			$issue_date = date('M d, Y', strtotime($row['issue_date']));
			$due_date = date('M d, Y', strtotime($row['due_date']));
			$description = $row['notes'];
			$results_group = mysqli_query($dbcon, "SELECT first_name,last_name,email,contract_type FROM drivers WHERE key_drivers = $group_key");
			if ($row_group = mysqli_fetch_assoc($results_group)) {
				$group_info = '';
				$group_info .= $row_group['first_name'] . '<br>';
				$group_info .= $row_group['last_name'] . '<br>';
				$group_info .= $row_group['email'] . '<br>';
				$group_info .= $row_group['contract_type'] . '<br>';
			}
			$amount_total = 0;
			$single_report = '';
			$results_data = mysqli_query($dbcon, "SELECT passenger_name,vehicle,pickup_datetime,zone_from,zone_to,pay_total_driver_amount FROM trips WHERE key_driver_payroll = $report_key ORDER BY pickup_datetime");
			while ($row_data = mysqli_fetch_assoc($results_data)) {
				$single_report .= "
				<tr>
				<td>" . $row_data['passenger_name'] . "</td>
				<td>" . $row_data['vehicle'] . "</td>
				<td>" . date('M d, Y - h:ia', strtotime($row['pickup_datetime'])) . "</td>
				<td>" . $row_data['zone_from'] . "</td>
				<td>" . $row_data['zone_to'] . "</td>
				<td>" . $row_data['pay_total_driver_amount'] . "</td>
				</tr>
				";
			}
			if ($total_amount == 0 || $total_amount == $paid_amount) {
				$balance_amount = "<td class='paid to-right'>$balance_amount</td>";
			} else if ($paid_amount == 0) {
				$balance_amount = "<td class='unpaid to-right'>$balance_amount</td>";
			} else if ($total_amount > $paid_amount) {
				$balance_amount= "<td class='partially-paid to-right'>$balance_amount</td>";
			} else {
				$balance_amount = "<td class='over-paid to-right'>$balance_amount</td>";
			}			$report_data .= "
				<h2>$report_title # $report_key</h2>
				<table>
				<tr>
				<td style='width:40%'>
				$group_info
				</td>
				<td style='width:40%'>
				<table class='to-right-block'>
				<tr>
				<td><b>Period:</b></td>
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
				<td><b>Issued:</b></td>
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
			$single_report = "
			<div class='single-report'>
				<table class='data-table'>
				<tr>
				<th>Passenger</th>
				<th>Vehicle</th>
				<th>Date Time</th>
				<th>From</th>
				<th>To</th>
				<th>Driver Charges</th>
				</tr>
				$single_report
				</table>
				<p>$description</p>
			</div>
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
<body id='page-report' class='driver_payroll_print'>
    <?php if ($show_form) { ?>
    <form method='post'>
        <p class='to-center'>
            Ending between
            <input id='date_from' name='date_from' type='date'
                value='<?php if (isset($date_from)) {print $date_from;} else {print date('Y-m-d');} ?>'>
            and
            <input id='date_to' name='date_to' type='date'
                value='<?php if (isset($date_to)) {print $date_to;} else {print date('Y-m-d');} ?>'>
            <select id='status' name='status'>
                <?php
					print "
						<option" . (($status == 'All') ? " selected='selected'" : '') .  ">All</option>
						<option" . (($status == 'Unpaid') ? " selected='selected'" : '') .  ">Unpaid</option>
						<option" . (($status == 'Full paid') ? " selected='selected'" : '') .  ">Full paid</option>
						<option" . (($status == 'Less paid') ? " selected='selected'" : '') .  ">Less paid</option>
						<option" . (($status == 'Over paid') ? " selected='selected'" : '') .  ">Over paid</option>
					";
					?>
            </select>
            <input name='get_button' type='submit' value='Get'>
        </p>
    </form>
    <?php if (isset($message)) print $message; ?>
    <?php	} // show form ?>
    <main>
        <?php print $report_data; ?>
    </main>
</body>
</html>