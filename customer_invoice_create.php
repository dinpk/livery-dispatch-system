<?php 
include('php/_code.php'); 
$error = 0;
$show_dates_form = true;
$show_listing = '';
if (isset($_GET['date_from']) && isset($_GET['date_to'])) {
	if (isset($_GET['show_listing'])) $show_listing = 'on';
	$date_from = $_GET['date_from'];
	$date_to = $_GET['date_to'];
	$issue_date = date("Y-m-d");
	$due_date = $_POST['due_date'];
	
	if (!is_date($date_from) || !is_date($date_to)) {
		$message = "<div class='failure-result'>Invalid date</div>";
		$error = 1;
	} else if (strtotime($date_to) < strtotime($date_from)) {
		$message = "<div class='failure-result'>Invalid date range</div>";
		$error = 1;
	} else {
		$sql_where_date = "WHERE (pickup_datetime BETWEEN '$date_from' AND '$date_to') ";
	}
	if ($error == 0) {
		$dates_display = date('F d, Y', strtotime($date_from)) . " — " . date('F d, Y', strtotime($date_to));
		
		if (isset($_POST['confirm_create'])) {
			$results = mysqli_query($dbcon, "SELECT key_customer_passengers, sum(total_trip_amount) as service_charges FROM trips $sql_where_date AND key_customer_passengers != 0 AND key_customer_invoices = 0 GROUP BY key_customer_passengers");
			while ($row = mysqli_fetch_assoc($results)) {
				$group_key = $row['key_customer_passengers'];
				$service_charges = $row['service_charges'];
				mysqli_query($dbcon, "INSERT INTO customer_invoices (key_customer_passengers, start_date, end_date, issue_date, due_date, amount, amount_paid, notes) 
										VALUES ($group_key, '$date_from', '$date_to', '$issue_date', '$due_date', $service_charges, 0, '')");
				print mysqli_error($dbcon);
				$last_inserted_key = mysqli_insert_id($dbcon);
				mysqli_query($dbcon, "UPDATE trips SET key_customer_invoices = $last_inserted_key $sql_where_date AND key_customer_passengers = $group_key");
				print mysqli_error($dbcon);
			}
			$message = "
				<div class='success-result'>Successfully created</div>
				<br>
				<div class='center'><input type='button' onclick='parent.location.reload(false);' value='Close'></div>
			";
			$show_dates_form = false;
		} else {
			if ($show_listing == 'on') {
				$results = mysqli_query($dbcon, "SELECT reference_number,passenger_name,pickup_datetime,vehicle,zone_from,zone_to,reserved_by,total_trip_amount,key_customer_invoices,key_trips FROM trips $sql_where_date ORDER BY pickup_datetime");
				if ($results) {
					$table_rows = '';
					while ($row = mysqli_fetch_assoc($results)) {
						$record_id = $row['key_trips'];
						$table_rows = $table_rows . '<tr>
							<td>' . $row['reference_number'] . '</td>
							<td>' . $row['passenger_name'] . '</td>
							<td>' . date('M d, Y - h:ia', strtotime($row['pickup_datetime'])) . '</td>
							<td>' . $row['vehicle'] . '</td>
							<td>' . $row['zone_from'] . '</td>
							<td>' . $row['zone_to'] . '</td>
							<td>' . $row['reserved_by'] . '</td>
							<td>' . $row['total_trip_amount'] . '</td>
							<td>' . ($row['key_customer_invoices'] == 0 ? "<span class='red'>Pending" : "<span class='green'>Created") . '</td>' .
						'</tr>';
					}
					$listing_html = "
							<table class='listing-table'>
							<tr>
							<th>Ref #</th>
							<th>Passenger</th>
							<th>Date</th>
							<th>Time</th>
							<th>Vehicle</th>
							<th>From</th>
							<th>To</th>
							<th>Reserved&nbsp;By</th>
							<th>Charges</th>
							<th>Status</th>
							</tr>
								$table_rows
							</table>";
					if (mysqli_num_rows($results) == 0) {
						$message = "<div class='failure-result'>No record found</div>";
					}
				} else {
					//print mysqli_error($dbcon);
					die('Unable to get records, please contact your system administrator.');
				}
			}
			$count_results = mysqli_query($dbcon, "SELECT COUNT(*) AS total_no_foreign_key FROM trips $sql_where_date AND key_customer_passengers = 0");
			if ($count_results && $count_row = mysqli_fetch_assoc($count_results)) {
				$total_no_foreign_key = $count_row['total_no_foreign_key'];
			}
			$count_results = mysqli_query($dbcon, "SELECT COUNT(*) AS no_amount_set FROM trips $sql_where_date AND total_trip_amount = 0");
			if ($count_results && $count_row = mysqli_fetch_assoc($count_results)) {
				$no_amount_set = $count_row['no_amount_set'];
			}
			$count_results = mysqli_query($dbcon, "SELECT COUNT(DISTINCT key_customer_passengers) AS total_useable_records FROM trips $sql_where_date AND key_customer_passengers != 0 AND key_customer_invoices = 0");
			if ($count_results && $count_row = mysqli_fetch_assoc($count_results)) {
				$total_useable_records = $count_row['total_useable_records'];
			}
		}
	}
}
?>
<!DOCTYPE html>
<html>
<head>
	<title>CUSTOMER INVOICES</title>
	<?php include('php/_head.php'); ?>
</head>
<body id='page-listing' class='page_create page_customer_invoices_create'>

	<section id='sub-menu'>
		<div class='left-block'>customer invoices</div>
		<div class='right-block'>
		</div>
	</section>

	<?php if (isset($message)) print $message; ?>

	<main>
		
		<?php 

		if ($show_dates_form) {
			print "
				<form id='dates_form' method='get' class='center'>
					<fieldset>
						Trips 
						<input name='date_from' type='date' value='" . (isset($date_from) ? $date_from : date('Y-m-d')) . "'> to 
						<input name='date_to' type='date' value='" . (isset($date_to) ? $date_to : date('Y-m-d')) . "'> 
						<input name='show_listing' type='checkbox' " . ($show_listing == 'on' ? 'checked' : '') . "> Show records &nbsp;
						<input type='submit' value='Get'>
					</fieldset>
				</form>
			";
		}
		
		if (isset($total_useable_records)) {
			print "
				<h3 class='center'>$dates_display</h3>
				<p class='center'>No 'customer passengers' set for <span class='red'>$total_no_foreign_key</span> 'trips'.</p>
				<p class='center'>No amount set for <span class='red'>$no_amount_set</span> 'trips'.</p>
				<p class='center'>Total <span class='green'>$total_useable_records</span> 'customer invoices' will be created.</p>
				";
			if ($total_useable_records > 0) {
				print "
					<form method='post'>
						<p class='center'>
							Due date <input type='date' name='due_date'> 
							<input type='submit' name='confirm_create' value='Create'>
						</p>
					</form>";
			}
		}
		
		if (isset($listing_html)) print $listing_html;
		?>
	</main>
	<?php include('php/_footer.php'); ?>
</body>
</html>
