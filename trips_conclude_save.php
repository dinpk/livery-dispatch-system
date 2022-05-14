<?php 
include('php/_code.php');
$show_form = true;
$focus_field = 'reference_number';
// id passed for update
if (isset($_GET['tripsid'])) {
	$record_id = trim($_GET['tripsid']);
	if (!is_numeric($record_id)) exit;
	if (!isset($_POST['save_submit'])) {
		$results = mysqli_query($dbcon, "SELECT * FROM trips WHERE key_trips = $record_id");
		if ($row = mysqli_fetch_assoc($results)) {
			$key_trips = $row['key_trips'];
			$reference_number = $row['reference_number'];
			$passenger_name = $row['passenger_name'];
			$total_passengers = $row['total_passengers'];
			$reserved_by = $row['reserved_by'];
			$pickup_datetime = date('M d, Y - h:ia', strtotime($row['pickup_datetime']));
			$trip_status = $row['trip_status'];
			$driver_name = $row['driver_name'];
			$vehicle = $row['vehicle'];
			$zone_from = $row['zone_from'];
			$zone_to = $row['zone_to'];
			$dispatcher_notes = $row['dispatcher_notes'];
			$rate_type = $row['rate_type'];
			$hourly_regular_rate = $row['hourly_regular_rate'];
			$regular_hours = $row['regular_hours'];
			$regular_minutes = $row['regular_minutes'];
			$hourly_regular_amount = $row['hourly_regular_amount'];
			$hourly_wait_rate = $row['hourly_wait_rate'];
			$wait_hours = $row['wait_hours'];
			$wait_minutes = $row['wait_minutes'];
			$hourly_wait_amount = $row['hourly_wait_amount'];
			$hourly_overtime_rate = $row['hourly_overtime_rate'];
			$overtime_hours = $row['overtime_hours'];
			$overtime_minutes = $row['overtime_minutes'];
			$hourly_overtime_amount = $row['hourly_overtime_amount'];
			$zone_rate = $row['zone_rate'];
			$base_amount = $row['base_amount'];
			$offtime_type = $row['offtime_type'];
			$offtime_amount = $row['offtime_amount'];
			$extra_stops = $row['extra_stops'];
			$extra_stops_amount = $row['extra_stops_amount'];
			$toll_type = $row['toll_type'];
			$tolls_amount = $row['tolls_amount'];
			$parking_amount = $row['parking_amount'];
			$gratuity_percent = $row['gratuity_percent'];
			$gratuity_amount = $row['gratuity_amount'];
			$gas_surcharge_percent = $row['gas_surcharge_percent'];
			$gas_surcharge_amount = $row['gas_surcharge_amount'];
			$admin_fee_percent = $row['admin_fee_percent'];
			$admin_fee_amount = $row['admin_fee_amount'];
			$discount_percent = $row['discount_percent'];
			$discount_amount = $row['discount_amount'];
			$tax_percent = $row['tax_percent'];
			$tax_amount = $row['tax_amount'];
			$flat_amount = $row['flat_amount'];
			$total_trip_amount = $row['total_trip_amount'];
			$concluded_checkbox = $row['concluded_checkbox'];
		} else {
			$message = "<div class='failure-result'>Record not found</div>";
			$show_form = false;
		}
		$extra_charges_rows = "";
		$results = mysqli_query($dbcon, "SELECT * FROM trip_extra_charges WHERE key_trips = $record_id");
		while ($row = mysqli_fetch_assoc($results)) {
			$key_trip_extra_charges = $row['key_trip_extra_charges'];
			$trip_extra_charges = $trip_extra_charges + $row['amount'];
			$extra_charges_rows .= "<tr>
				<td>" . $row['category'] . "</td>
				<td class='right'>" . $row['amount'] . "</td>
				<td><a href='trip_extra_charges_save.php?trip_extra_chargesid=$key_trip_extra_charges&tripsid=$record_id' target='overlay-iframe2' onclick='overlayOpen2();'>✎</a></td>
				</tr>";
		}
	}
}
// 'Save' button clicked
if (isset($_POST['save_submit'])) {
	$error = 0;
	$concluded_checkbox = trim($_POST['concluded_checkbox']);
	if (strlen($concluded_checkbox) > 5) {
		$msg_concluded_checkbox = "<div class='message-error'>Provide a valid value of length 0-5</div>";
		$focus_field = 'concluded_checkbox';
		$error = 1;
	}
	$total_trip_amount = trim($_POST['total_trip_amount']);
	if (strlen($total_trip_amount) > 10 || !is_numeric($total_trip_amount)) {
		$msg_total_trip_amount = "<div class='message-error'>Provide a valid value of length 0-10</div>";
		$focus_field = 'total_trip_amount';
		$error = 1;
	}
	$flat_amount = trim($_POST['flat_amount']);
	if (strlen($flat_amount) > 10 || !is_numeric($flat_amount)) {
		$msg_flat_amount = "<div class='message-error'>Provide a valid value of length 0-10</div>";
		$focus_field = 'flat_amount';
		$error = 1;
	}
	$trip_extra_charges = trim($_POST['trip_extra_charges']);
	if (strlen($trip_extra_charges) > 10 || !is_numeric($trip_extra_charges)) {
		$msg_trip_extra_charges = "<div class='message-error'>Provide a valid value of length 0-10</div>";
		$focus_field = 'trip_extra_charges';
		$error = 1;
	}
	$tax_amount = trim($_POST['tax_amount']);
	if (strlen($tax_amount) > 10 || !is_numeric($tax_amount)) {
		$msg_tax_amount = "<div class='message-error'>Provide a valid value of length 0-10</div>";
		$focus_field = 'tax_amount';
		$error = 1;
	}
	$tax_percent = trim($_POST['tax_percent']);
	if (strlen($tax_percent) > 10 || !is_numeric($tax_percent)) {
		$msg_tax_percent = "<div class='message-error'>Provide a valid value of length 0-10</div>";
		$focus_field = 'tax_percent';
		$error = 1;
	}
	$discount_amount = trim($_POST['discount_amount']);
	if (strlen($discount_amount) > 10 || !is_numeric($discount_amount)) {
		$msg_discount_amount = "<div class='message-error'>Provide a valid value of length 0-10</div>";
		$focus_field = 'discount_amount';
		$error = 1;
	}
	$discount_percent = trim($_POST['discount_percent']);
	if (strlen($discount_percent) > 10 || !is_numeric($discount_percent)) {
		$msg_discount_percent = "<div class='message-error'>Provide a valid value of length 0-10</div>";
		$focus_field = 'discount_percent';
		$error = 1;
	}
	$admin_fee_amount = trim($_POST['admin_fee_amount']);
	if (strlen($admin_fee_amount) > 10 || !is_numeric($admin_fee_amount)) {
		$msg_admin_fee_amount = "<div class='message-error'>Provide a valid value of length 0-10</div>";
		$focus_field = 'admin_fee_amount';
		$error = 1;
	}
	$admin_fee_percent = trim($_POST['admin_fee_percent']);
	if (strlen($admin_fee_percent) > 10 || !is_numeric($admin_fee_percent)) {
		$msg_admin_fee_percent = "<div class='message-error'>Provide a valid value of length 0-10</div>";
		$focus_field = 'admin_fee_percent';
		$error = 1;
	}
	$gas_surcharge_amount = trim($_POST['gas_surcharge_amount']);
	if (strlen($gas_surcharge_amount) > 10 || !is_numeric($gas_surcharge_amount)) {
		$msg_gas_surcharge_amount = "<div class='message-error'>Provide a valid value of length 0-10</div>";
		$focus_field = 'gas_surcharge_amount';
		$error = 1;
	}
	$gas_surcharge_percent = trim($_POST['gas_surcharge_percent']);
	if (strlen($gas_surcharge_percent) > 10 || !is_numeric($gas_surcharge_percent)) {
		$msg_gas_surcharge_percent = "<div class='message-error'>Provide a valid value of length 0-10</div>";
		$focus_field = 'gas_surcharge_percent';
		$error = 1;
	}
	$gratuity_amount = trim($_POST['gratuity_amount']);
	if (strlen($gratuity_amount) > 10 || !is_numeric($gratuity_amount)) {
		$msg_gratuity_amount = "<div class='message-error'>Provide a valid value of length 0-10</div>";
		$focus_field = 'gratuity_amount';
		$error = 1;
	}
	$gratuity_percent = trim($_POST['gratuity_percent']);
	if (strlen($gratuity_percent) > 10 || !is_numeric($gratuity_percent)) {
		$msg_gratuity_percent = "<div class='message-error'>Provide a valid value of length 0-10</div>";
		$focus_field = 'gratuity_percent';
		$error = 1;
	}
	$parking_amount = trim($_POST['parking_amount']);
	if (strlen($parking_amount) > 10 || !is_numeric($parking_amount)) {
		$msg_parking_amount = "<div class='message-error'>Provide a valid value of length 0-10</div>";
		$focus_field = 'parking_amount';
		$error = 1;
	}
	$tolls_amount = trim($_POST['tolls_amount']);
	if (strlen($tolls_amount) > 10 || !is_numeric($tolls_amount)) {
		$msg_tolls_amount = "<div class='message-error'>Provide a valid value of length 0-10</div>";
		$focus_field = 'tolls_amount';
		$error = 1;
	}
	$toll_type = trim($_POST['toll_type']);
	if (strlen($toll_type) > 50) {
		$msg_toll_type = "<div class='message-error'>Provide a valid value of length 0-50</div>";
		$focus_field = 'toll_type';
		$error = 1;
	}
	$extra_stops_amount = trim($_POST['extra_stops_amount']);
	if (strlen($extra_stops_amount) > 10 || !is_numeric($extra_stops_amount)) {
		$msg_extra_stops_amount = "<div class='message-error'>Provide a valid value of length 0-10</div>";
		$focus_field = 'extra_stops_amount';
		$error = 1;
	}
	$extra_stops = trim($_POST['extra_stops']);
	if (strlen($extra_stops) > 5 || !is_numeric($extra_stops)) {
		$msg_extra_stops = "<div class='message-error'>Provide a valid value of length 0-5</div>";
		$focus_field = 'extra_stops';
		$error = 1;
	}
	$offtime_amount = trim($_POST['offtime_amount']);
	if (strlen($offtime_amount) > 10 || !is_numeric($offtime_amount)) {
		$msg_offtime_amount = "<div class='message-error'>Provide a valid value of length 0-10</div>";
		$focus_field = 'offtime_amount';
		$error = 1;
	}
	$offtime_type = trim($_POST['offtime_type']);
	if (strlen($offtime_type) > 50) {
		$msg_offtime_type = "<div class='message-error'>Provide a valid value of length 0-50</div>";
		$focus_field = 'offtime_type';
		$error = 1;
	}
	$base_amount = trim($_POST['base_amount']);
	if (strlen($base_amount) > 10 || !is_numeric($base_amount)) {
		$msg_base_amount = "<div class='message-error'>Provide a valid value of length 0-10</div>";
		$focus_field = 'base_amount';
		$error = 1;
	}
	$zone_rate = trim($_POST['zone_rate']);
	if (strlen($zone_rate) > 10 || !is_numeric($zone_rate)) {
		$msg_zone_rate = "<div class='message-error'>Provide a valid value of length 0-10</div>";
		$focus_field = 'zone_rate';
		$error = 1;
	}
	$hourly_overtime_amount = trim($_POST['hourly_overtime_amount']);
	if (strlen($hourly_overtime_amount) > 10 || !is_numeric($hourly_overtime_amount)) {
		$msg_hourly_overtime_amount = "<div class='message-error'>Provide a valid value of length 0-10</div>";
		$focus_field = 'hourly_overtime_amount';
		$error = 1;
	}
	$overtime_minutes = trim($_POST['overtime_minutes']);
	if (strlen($overtime_minutes) > 5 || !is_numeric($overtime_minutes)) {
		$msg_overtime_minutes = "<div class='message-error'>Provide a valid value of length 0-5</div>";
		$focus_field = 'overtime_minutes';
		$error = 1;
	}
	$overtime_hours = trim($_POST['overtime_hours']);
	if (strlen($overtime_hours) > 5 || !is_numeric($overtime_hours)) {
		$msg_overtime_hours = "<div class='message-error'>Provide a valid value of length 0-5</div>";
		$focus_field = 'overtime_hours';
		$error = 1;
	}
	$hourly_overtime_rate = trim($_POST['hourly_overtime_rate']);
	if (strlen($hourly_overtime_rate) > 10 || !is_numeric($hourly_overtime_rate)) {
		$msg_hourly_overtime_rate = "<div class='message-error'>Provide a valid value of length 0-10</div>";
		$focus_field = 'hourly_overtime_rate';
		$error = 1;
	}
	$hourly_wait_amount = trim($_POST['hourly_wait_amount']);
	if (strlen($hourly_wait_amount) > 10 || !is_numeric($hourly_wait_amount)) {
		$msg_hourly_wait_amount = "<div class='message-error'>Provide a valid value of length 0-10</div>";
		$focus_field = 'hourly_wait_amount';
		$error = 1;
	}
	$wait_minutes = trim($_POST['wait_minutes']);
	if (strlen($wait_minutes) > 5 || !is_numeric($wait_minutes)) {
		$msg_wait_minutes = "<div class='message-error'>Provide a valid value of length 0-5</div>";
		$focus_field = 'wait_minutes';
		$error = 1;
	}
	$wait_hours = trim($_POST['wait_hours']);
	if (strlen($wait_hours) > 5 || !is_numeric($wait_hours)) {
		$msg_wait_hours = "<div class='message-error'>Provide a valid value of length 0-5</div>";
		$focus_field = 'wait_hours';
		$error = 1;
	}
	$hourly_wait_rate = trim($_POST['hourly_wait_rate']);
	if (strlen($hourly_wait_rate) > 10 || !is_numeric($hourly_wait_rate)) {
		$msg_hourly_wait_rate = "<div class='message-error'>Provide a valid value of length 0-10</div>";
		$focus_field = 'hourly_wait_rate';
		$error = 1;
	}
	$hourly_regular_amount = trim($_POST['hourly_regular_amount']);
	if (strlen($hourly_regular_amount) > 10 || !is_numeric($hourly_regular_amount)) {
		$msg_hourly_regular_amount = "<div class='message-error'>Provide a valid value of length 0-10</div>";
		$focus_field = 'hourly_regular_amount';
		$error = 1;
	}
	$regular_minutes = trim($_POST['regular_minutes']);
	if (strlen($regular_minutes) > 5 || !is_numeric($regular_minutes)) {
		$msg_regular_minutes = "<div class='message-error'>Provide a valid value of length 0-5</div>";
		$focus_field = 'regular_minutes';
		$error = 1;
	}
	$regular_hours = trim($_POST['regular_hours']);
	if (strlen($regular_hours) > 5 || !is_numeric($regular_hours)) {
		$msg_regular_hours = "<div class='message-error'>Provide a valid value of length 0-5</div>";
		$focus_field = 'regular_hours';
		$error = 1;
	}
	$hourly_regular_rate = trim($_POST['hourly_regular_rate']);
	if (strlen($hourly_regular_rate) > 10 || !is_numeric($hourly_regular_rate)) {
		$msg_hourly_regular_rate = "<div class='message-error'>Provide a valid value of length 0-10</div>";
		$focus_field = 'hourly_regular_rate';
		$error = 1;
	}
	$rate_type = trim($_POST['rate_type']);
	if (strlen($rate_type) > 50) {
		$msg_rate_type = "<div class='message-error'>Provide a valid value of length 0-50</div>";
		$focus_field = 'rate_type';
		$error = 1;
	}
	// no validation error
	if ($error == 0) {
		if (isset($record_id) && $error != 1) { // update
			$results = mysqli_query($dbcon, "UPDATE trips SET 
			rate_type = '" . sd($dbcon, $rate_type) . "',
			hourly_regular_rate = '" . sd($dbcon, $hourly_regular_rate) . "',
			regular_hours = '" . sd($dbcon, $regular_hours) . "',
			regular_minutes = '" . sd($dbcon, $regular_minutes) . "',
			hourly_regular_amount = '" . sd($dbcon, $hourly_regular_amount) . "',
			hourly_wait_rate = '" . sd($dbcon, $hourly_wait_rate) . "',
			wait_hours = '" . sd($dbcon, $wait_hours) . "',
			wait_minutes = '" . sd($dbcon, $wait_minutes) . "',
			hourly_wait_amount = '" . sd($dbcon, $hourly_wait_amount) . "',
			hourly_overtime_rate = '" . sd($dbcon, $hourly_overtime_rate) . "',
			overtime_hours = '" . sd($dbcon, $overtime_hours) . "',
			overtime_minutes = '" . sd($dbcon, $overtime_minutes) . "',
			hourly_overtime_amount = '" . sd($dbcon, $hourly_overtime_amount) . "',
			zone_rate = '" . sd($dbcon, $zone_rate) . "',
			base_amount = '" . sd($dbcon, $base_amount) . "',
			offtime_type = '" . sd($dbcon, $offtime_type) . "',
			offtime_amount = '" . sd($dbcon, $offtime_amount) . "',
			extra_stops = '" . sd($dbcon, $extra_stops) . "',
			extra_stops_amount = '" . sd($dbcon, $extra_stops_amount) . "',
			toll_type = '" . sd($dbcon, $toll_type) . "',
			tolls_amount = '" . sd($dbcon, $tolls_amount) . "',
			parking_amount = '" . sd($dbcon, $parking_amount) . "',
			gratuity_percent = '" . sd($dbcon, $gratuity_percent) . "',
			gratuity_amount = '" . sd($dbcon, $gratuity_amount) . "',
			gas_surcharge_percent = '" . sd($dbcon, $gas_surcharge_percent) . "',
			gas_surcharge_amount = '" . sd($dbcon, $gas_surcharge_amount) . "',
			admin_fee_percent = '" . sd($dbcon, $admin_fee_percent) . "',
			admin_fee_amount = '" . sd($dbcon, $admin_fee_amount) . "',
			discount_percent = '" . sd($dbcon, $discount_percent) . "',
			discount_amount = '" . sd($dbcon, $discount_amount) . "',
			tax_percent = '" . sd($dbcon, $tax_percent) . "',
			tax_amount = '" . sd($dbcon, $tax_amount) . "',
			trip_extra_charges = '" . sd($dbcon, $trip_extra_charges) . "',
			flat_amount = '" . sd($dbcon, $flat_amount) . "',
			total_trip_amount = '" . sd($dbcon, $total_trip_amount) . "',
			concluded_checkbox = '" . sd($dbcon, $concluded_checkbox) . "'
			WHERE key_trips = $record_id");
			if ($results) {
				$message = "<script>parent.location.reload(false);</script>";
			} else {
				//print mysqli_error($dbcon);
				die('Unable to update, please contact your system administrator.');
			}
		}
	}
	if ($error == 0) $show_form = false;
}
?>
<!DOCTYPE html>
<html>
<head>
	<title>TRIP</title>
	<?php include('php/_head.php'); ?>
</head>
<body id='page-save' class='page_save page_trips_conclude_save'>

	<section id='sub-menu'>
		<div class='left-block'>trip # <?php print $key_trips; ?></div>
		<div class='right-block'>

		</div>
	</section>

	<?php if (isset($message)) print $message; ?>
	

	<main>

	<?php if (isset($show_form) && $show_form) { ?>
	<form method='post'>
		
		<fieldset>

			<table cellpadding='5' cellspacing='0'>
			 <tr>
				 <td><h4>Trip #</h4></td>
				 <td><?php print $key_trips; ?></td>
			 </tr>

			 <tr>
				 <td><h4>Reference #</h4></td>
				 <td><?php print $reference_number; ?></td>
			 </tr>

			 <tr>
				<td><h4>Passenger name</h4></td>
				 <td><?php print $passenger_name; ?></td>
			 </tr>

			 <tr>
				 <td><h4>Total passengers</h4></td>
				 <td><?php print $total_passengers; ?></td>
			 </tr>

			 <tr>
				 <td><h4>Reserved by</h4></td>
				 <td><?php print $reserved_by; ?></td>
			 </tr>

			 <tr>
				 <td><h4>Pickup date time</h4></td>
				 <td><?php print $pickup_datetime; ?></td>
			 </tr>

			 <tr>
				 <td><h4>Trip status</h4></td>
				 <td><?php print $trip_status; ?></td>
			 </tr>

			 <tr>
				 <td><h4>Driver name</h4></td>
				 <td><?php print $driver_name; ?></td>
			 </tr>

			 <tr>
				 <td><h4>Vehicle</h4></td>
				 <td><?php print $vehicle; ?></td>
			 </tr>

			 <tr>
				 <td><h4>From</h4></td>
				 <td><?php print $zone_from; ?></td>
			 </tr>

			 <tr>
				 <td><h4>To</h4></td>
				 <td><?php print $zone_to; ?></td>
			 </tr>

			 <tr>
				 <td><h4>Dispatcher notes</h4></td>
				 <td></td>
			 </tr>			 
			 <tr>
				 <td colspan='2'><?php print $dispatcher_notes; ?></td>
			 </tr>
			 </table>

		</fieldset>
		
		<fieldset>
			<div>
				<a href='trip_extra_charges_save.php?tripsid=<?php print $record_id; ?>' target='overlay-iframe2' onclick='overlayOpen2();'> Add</a> 
			</div>
			<?php 
				$extra_charges_rows = "<table cellspacing='0' cellpadding='5' border='1' width='100%'><tr><th>Category</th><th>Amount</th><th></th>" . $extra_charges_rows . "</table>";
				print $extra_charges_rows;
	 		?>
		
		
		</fieldset>
		
		<fieldset>

			 <div>
				 <label for='rate_type'>Rate type</label><br>
				 <?php if(isset($msg_rate_type)) print $msg_rate_type; ?>
				 <select id='rate_type' name='rate_type' onchange='calc();'>
					 <?php
					 if (!isset($rate_type)) $rate_type = '';
					 print "
					 <option" . (($rate_type == 'Zone') ? " selected='selected'" : '') .  ">Zone</option>
					 <option" . (($rate_type == 'Hourly') ? " selected='selected'" : '') .  ">Hourly</option>
					 <option" . (($rate_type == 'Flat') ? " selected='selected'" : '') .  ">Flat</option>
					 ";
					 ?>
				 </select>
			 </div>

			 <div>
				 <label for='zone_rate'>Zone rate</label> <?php if(isset($msg_zone_rate)) print $msg_zone_rate; ?>
				 <input class='input_number_small' <?php if ($focus_field == 'zone_rate') print 'autofocus'; ?> id='zone_rate' name='zone_rate' type='number' step='any' onchange='calc();' value='<?php if (isset($zone_rate)) {print $zone_rate;} else { print '0';} ?>' readonly><br>
			 </div>

			 <div>
				 <div><label for='regular_hours'>Regular (rate,hours,minutes,amount)</label></div>
				 <?php if(isset($msg_regular_hours)) print $msg_regular_hours; ?>
				 <?php if(isset($msg_regular_minutes)) print $msg_regular_minutes; ?>
				 <?php if(isset($msg_hourly_regular_amount)) print $msg_hourly_regular_amount; ?>
				 <input class='input_number_small' <?php if ($focus_field == 'hourly_regular_rate') print 'autofocus'; ?> id='hourly_regular_rate' name='hourly_regular_rate' type='number' onchange='calc();' value='<?php if (isset($hourly_regular_rate)) {print $hourly_regular_rate;} else { print '0';} ?>'> 
				 <input class='input_number_small' <?php if ($focus_field == 'regular_hours') print 'autofocus'; ?> id='regular_hours' name='regular_hours' type='number' onchange='calc();' value='<?php if (isset($regular_hours)) {print $regular_hours;} else { print '0';} ?>'> 
				 <input class='input_number_small' <?php if ($focus_field == 'regular_minutes') print 'autofocus'; ?> id='regular_minutes' name='regular_minutes' type='number' onchange='calc();' value='<?php if (isset($regular_minutes)) {print $regular_minutes;} else { print '0';} ?>'> 
				 <input class='input_number_small' <?php if ($focus_field == 'hourly_regular_amount') print 'autofocus'; ?> id='hourly_regular_amount' name='hourly_regular_amount' type='number' step='any' onchange='calc();' value='<?php if (isset($hourly_regular_amount)) {print $hourly_regular_amount;} else { print '0';} ?>' readonly>
			 </div>

			 <div>
				 <div><label for='wait_hours'>Wait (rate,hours,minutes,amount)</label></div>
				 <?php if(isset($msg_wait_hours)) print $msg_wait_hours; ?>
				 <?php if(isset($msg_wait_minutes)) print $msg_wait_minutes; ?>
				 <?php if(isset($msg_hourly_wait_amount)) print $msg_hourly_wait_amount; ?>
				 <input class='input_number_small' <?php if ($focus_field == 'hourly_wait_rate') print 'autofocus'; ?> id='hourly_wait_rate' name='hourly_wait_rate' type='number' onchange='calc();' value='<?php if (isset($hourly_wait_rate)) {print $hourly_wait_rate;} else { print '0';} ?>'> 
				 <input class='input_number_small' <?php if ($focus_field == 'wait_hours') print 'autofocus'; ?> id='wait_hours' name='wait_hours' type='number' onchange='calc();' value='<?php if (isset($wait_hours)) {print $wait_hours;} else { print '0';} ?>'> 
				 <input class='input_number_small' <?php if ($focus_field == 'wait_minutes') print 'autofocus'; ?> id='wait_minutes' name='wait_minutes' type='number' onchange='calc();' value='<?php if (isset($wait_minutes)) {print $wait_minutes;} else { print '0';} ?>'> 
				 <input class='input_number_small' <?php if ($focus_field == 'hourly_wait_amount') print 'autofocus'; ?> id='hourly_wait_amount' name='hourly_wait_amount' type='number' step='any' onchange='calc();' value='<?php if (isset($hourly_wait_amount)) {print $hourly_wait_amount;} else { print '0';} ?>' readonly> 
			 </div>

			 <div>
				 <div><label for='overtime_hours'>Overtime (rate,hours,minutes,amount)</label></div>
				 <?php if(isset($msg_overtime_hours)) print $msg_overtime_hours; ?>
				 <?php if(isset($msg_overtime_minutes)) print $msg_overtime_minutes; ?>
				 <?php if(isset($msg_hourly_overtime_amount)) print $msg_hourly_overtime_amount; ?>
				 <input class='input_number_small' <?php if ($focus_field == 'hourly_overtime_rate') print 'autofocus'; ?> id='hourly_overtime_rate' name='hourly_overtime_rate' type='number' onchange='calc();' value='<?php if (isset($hourly_overtime_rate)) {print $hourly_overtime_rate;} else { print '0';} ?>'> 
				 <input class='input_number_small' <?php if ($focus_field == 'overtime_hours') print 'autofocus'; ?> id='overtime_hours' name='overtime_hours' type='number' onchange='calc();' value='<?php if (isset($overtime_hours)) {print $overtime_hours;} else { print '0';} ?>'> 
				 <input class='input_number_small' <?php if ($focus_field == 'overtime_minutes') print 'autofocus'; ?> id='overtime_minutes' name='overtime_minutes' type='number' onchange='calc();' value='<?php if (isset($overtime_minutes)) {print $overtime_minutes;} else { print '0';} ?>'> 
				 <input class='input_number_small' <?php if ($focus_field == 'hourly_overtime_amount') print 'autofocus'; ?> id='hourly_overtime_amount' name='hourly_overtime_amount' type='number' step='any' onchange='calc();' value='<?php if (isset($hourly_overtime_amount)) {print $hourly_overtime_amount;} else { print '0';} ?>' readonly> 
			 </div>

			 <div>
				 <div><label for='base_amount'>Base amount</label></div>
				 <?php if(isset($msg_base_amount)) print $msg_base_amount; ?>
				 <input <?php if ($focus_field == 'base_amount') print 'autofocus'; ?> id='base_amount' name='base_amount' type='number' step='any' onchange='calc();' value='<?php if (isset($base_amount)) {print $base_amount;} else { print '0';} ?>' readonly><br>
			 </div>


			<?php 
			if(isset($msg_offtime_type)) print $msg_offtime_type; 
			if(isset($msg_offtime_amount)) print $msg_offtime_amount;
			if(isset($msg_extra_stops)) print $msg_extra_stops;
			if(isset($msg_extra_stops_amount)) print $msg_extra_stops_amount;
			if(isset($msg_toll_type)) print $msg_toll_type;
			if(isset($msg_tolls_amount)) print $msg_tolls_amount;
			if(isset($msg_parking_amount)) print $msg_parking_amount;
			if(isset($msg_gratuity_percent)) print $msg_gratuity_percent;
			if(isset($msg_gratuity_amount)) print $msg_gratuity_amount;
			if(isset($msg_gas_surcharge_percent)) print $msg_gas_surcharge_percent;
			if(isset($msg_gas_surcharge_amount)) print $msg_gas_surcharge_amount;
			if(isset($msg_admin_fee_percent)) print $msg_admin_fee_percent; 
			if(isset($msg_admin_fee_amount)) print $msg_admin_fee_amount; 
			if(isset($msg_discount_percent)) print $msg_discount_percent; 
			if(isset($msg_discount_amount)) print $msg_discount_amount;
			if(isset($msg_tax_percent)) print $msg_tax_percent;
			if(isset($msg_tax_amount)) print $msg_tax_amount;
			?>

			<table>
			<tr>
				<td><label for='offtime_type'>Off-time</label> </td>
				<td>
					&nbsp;&nbsp;<select class='select_small' id='offtime_type' name='offtime_type'>
						 <?php 
						 $options = '';
						 $results = mysqli_query($dbcon, 'SELECT offtime_type FROM settings_offtime_type_values');
						 while ($row = mysqli_fetch_assoc($results)) {
							 $selection = '';
							 if ($row['offtime_type'] == $offtime_type) $selection = "selected='selected'";
								 $options .= "<option $selection>" . $row['offtime_type'] . "</option>";
						 }
						 print $options; 
						 ?>
					 </select> 
					<input class='input_number_small' <?php if ($focus_field == 'offtime_amount') print 'autofocus'; ?> id='offtime_amount' name='offtime_amount' type='number' step='any' onchange='calc();' value='<?php if (isset($offtime_amount)) {print $offtime_amount;} else { print '0';} ?>'><br>
				</td>
			</tr>
			<tr>
				<td><label for='extra_stops'>Extra stops &nbsp; </label></td>
				<td>
					 #<input class='input_number_small' <?php if ($focus_field == 'extra_stops') print 'autofocus'; ?> id='extra_stops' name='extra_stops' type='number' onchange='calc();' value='<?php if (isset($extra_stops)) {print $extra_stops;} else { print '0';} ?>'> 
					 $<input class='input_number_small' <?php if ($focus_field == 'extra_stops_amount') print 'autofocus'; ?> id='extra_stops_amount' name='extra_stops_amount' type='number' step='any' onchange='calc();' value='<?php if (isset($extra_stops_amount)) {print $extra_stops_amount;} else { print '0';} ?>'>
				</td>
			</tr>
			<tr>
				<td><label for='toll_type'>Tolls</label></td>
				<td>
					&nbsp;&nbsp;<select class='select_small' id='toll_type' name='toll_type'>
						 <?php 
						 $options = '';
						 $results = mysqli_query($dbcon, 'SELECT toll_type FROM settings_toll_type_values');
						 while ($row = mysqli_fetch_assoc($results)) {
							 $selection = '';
							 if ($row['toll_type'] == $toll_type) $selection = "selected='selected'";
								 $options .= "<option $selection>" . $row['toll_type'] . "</option>";
						 }
						 print $options; 
						 ?>
					 </select> 
					 <input class='input_number_small' <?php if ($focus_field == 'tolls_amount') print 'autofocus'; ?> id='tolls_amount' name='tolls_amount' type='number' step='any' onchange='calc();' value='<?php if (isset($tolls_amount)) {print $tolls_amount;} else { print '0';} ?>'><br>
				</td>
			</tr>
			<tr>
				<td><label for='parking_amount'>Parking</label></td>
				<td>
					&nbsp;&nbsp;&nbsp;<input class='input_number_small' <?php if ($focus_field == 'parking_amount') print 'autofocus'; ?> id='parking_amount' name='parking_amount' type='number' step='any' onchange='calc();' value='<?php if (isset($parking_amount)) {print $parking_amount;} else { print '0';} ?>'><br>
				</td>
			</tr>
			<tr>
				<td><label for='gratuity_percent'>Gratuity &nbsp;</label></td>
				<td>
					 %<input class='input_number_small' <?php if ($focus_field == 'gratuity_percent') print 'autofocus'; ?> id='gratuity_percent' name='gratuity_percent' type='number' step='any' onchange='calc();' value='<?php if (isset($gratuity_percent)) {print $gratuity_percent;} else { print '0';} ?>'> 
					 $<input class='input_number_small' <?php if ($focus_field == 'gratuity_amount') print 'autofocus'; ?> id='gratuity_amount' name='gratuity_amount' type='number' step='any' onchange='calc();' value='<?php if (isset($gratuity_amount)) {print $gratuity_amount;} else { print '0';} ?>'> 
				</td>
			</tr>
			<tr>
				<td><label for='gas_surcharge_percent'>Gas surcharge &nbsp;</label></td>
				<td>
					 %<input class='input_number_small' <?php if ($focus_field == 'gas_surcharge_percent') print 'autofocus'; ?> id='gas_surcharge_percent' name='gas_surcharge_percent' type='number' step='any' onchange='calc();' value='<?php if (isset($gas_surcharge_percent)) {print $gas_surcharge_percent;} else { print '0';} ?>'> 
					 $<input class='input_number_small' <?php if ($focus_field == 'gas_surcharge_amount') print 'autofocus'; ?> id='gas_surcharge_amount' name='gas_surcharge_amount' type='number' step='any' onchange='calc();' value='<?php if (isset($gas_surcharge_amount)) {print $gas_surcharge_amount;} else { print '0';} ?>'>
				</td>
			</tr>
			<tr>
				<td><label for='admin_fee_percent'>Admin fee &nbsp;</label></td>
				<td>
					 %<input class='input_number_small' <?php if ($focus_field == 'admin_fee_percent') print 'autofocus'; ?> id='admin_fee_percent' name='admin_fee_percent' type='number' step='any' onchange='calc();' value='<?php if (isset($admin_fee_percent)) {print $admin_fee_percent;} else { print '0';} ?>'> 
					 $<input class='input_number_small' <?php if ($focus_field == 'admin_fee_amount') print 'autofocus'; ?> id='admin_fee_amount' name='admin_fee_amount' type='number' step='any' onchange='calc();' value='<?php if (isset($admin_fee_amount)) {print $admin_fee_amount;} else { print '0';} ?>'> 
				</td>
			</tr>
			<tr>
				<td><label for='discount_percent'>Discount</label></td>
				<td>
					 %<input class='input_number_small' <?php if ($focus_field == 'discount_percent') print 'autofocus'; ?> id='discount_percent' name='discount_percent' type='number' step='any' onchange='calc();' value='<?php if (isset($discount_percent)) {print $discount_percent;} else { print '0';} ?>'> 
					 $<input class='input_number_small' <?php if ($focus_field == 'discount_amount') print 'autofocus'; ?> id='discount_amount' name='discount_amount' type='number' step='any' onchange='calc();' value='<?php if (isset($discount_amount)) {print $discount_amount;} else { print '0';} ?>'>
				</td>
			</tr>
			<tr>
				<td><label for='tax_percent'>Tax</label></td>
				<td>
					 %<input class='input_number_small' <?php if ($focus_field == 'tax_percent') print 'autofocus'; ?> id='tax_percent' name='tax_percent' type='number' step='any' onchange='calc();' value='<?php if (isset($tax_percent)) {print $tax_percent;} else { print '0';} ?>'> 
					 $<input class='input_number_small' <?php if ($focus_field == 'tax_amount') print 'autofocus'; ?> id='tax_amount' name='tax_amount' type='number' step='any' onchange='calc();' value='<?php if (isset($tax_amount)) {print $tax_amount;} else { print '0';} ?>'> 
				</td>
			</tr>
			</table>

			<div>
				<div><label for='extra_charges'>Extra charges</label></div>
				<input id='trip_extra_charges' name='trip_extra_charges' type='number' onchange='calc();' value='<?php if (isset($trip_extra_charges)) {print $trip_extra_charges;} else { print '0';} ?>' readonly><br>
			</div>

			 <div>
				 <div><label for='flat_amount'>Flat amount</label></div>
				 <?php if(isset($msg_flat_amount)) print $msg_flat_amount; ?>
				 <input <?php if ($focus_field == 'flat_amount') print 'autofocus'; ?> id='flat_amount' name='flat_amount' type='number' step='any' onchange='calc();' value='<?php if (isset($flat_amount)) {print $flat_amount;} else { print '0';} ?>'><br>
			 </div>

			 <div>
				 <div><label for='total_trip_amount'>Total trip amount</label></div>
				 <?php if(isset($msg_total_trip_amount)) print $msg_total_trip_amount; ?>
				 <input <?php if ($focus_field == 'total_trip_amount') print 'autofocus'; ?> id='total_trip_amount' name='total_trip_amount' type='number' step='any' onchange='calc();' value='<?php if (isset($total_trip_amount)) {print $total_trip_amount;} else { print '0';} ?>' readonly><br>
			 </div>

		</fieldset>

		<fieldset>
			 <div>
				 <?php if(isset($msg_concluded_checkbox)) print $msg_concluded_checkbox; ?>
				 <input <?php if (!isset($concluded_checkbox) || $concluded_checkbox=='on') {print "checked='checked'";} ?> type='checkbox' id='concluded_checkbox' name='concluded_checkbox'> <label for='concluded_checkbox'>Concluded</label><br>
			 </div>
		</fieldset>

		<div class='clear-fix'>
		<input id='save_submit' name='save_submit' type='submit' value='Save'>
		</div>
		</form>


	<?php } ?>

	</main>
	<?php include('php/_footer.php'); ?>

	<script>calc();</script>
</body>
</html>
