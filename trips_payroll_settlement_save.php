<?php 
include('php/_code.php');
$show_form = true;
$focus_field = 'zone_rate';
// id passed for update
if (isset($_GET['tripsid'])) {
	$record_id = trim($_GET['tripsid']);
	if (!is_numeric($record_id)) exit;
	if (!isset($_POST['save_submit'])) {
		$results = mysqli_query($dbcon, "SELECT * FROM trips WHERE key_trips = $record_id");
		if ($row = mysqli_fetch_assoc($results)) {
			$key_drivers = $row['key_drivers'];
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
			$trip_extra_charges = $row['trip_extra_charges'];
			$flat_amount = $row['flat_amount'];
			$total_trip_amount = $row['total_trip_amount'];
			$pay_base_amount_percent = $row['pay_base_amount_percent'];
			$pay_driver_base_amount = $row['pay_driver_base_amount'];
			$pay_offtime_percent = $row['pay_offtime_percent'];
			$pay_offtime_amount = $row['pay_offtime_amount'];
			$pay_extra_stops_percent = $row['pay_extra_stops_percent'];
			$pay_extra_stops_amount = $row['pay_extra_stops_amount'];
			$pay_tolls_percent = $row['pay_tolls_percent'];
			$pay_tolls_amount = $row['pay_tolls_amount'];
			$pay_parking_percent = $row['pay_parking_percent'];
			$pay_parking_amount = $row['pay_parking_amount'];
			$pay_gratuity_percent = $row['pay_gratuity_percent'];
			$pay_gratuity_amount = $row['pay_gratuity_amount'];
			$pay_gas_surcharge_percent = $row['pay_gas_surcharge_percent'];
			$pay_gas_surcharge_amount = $row['pay_gas_surcharge_amount'];
			$pay_commission_percent = $row['pay_commission_percent'];
			$pay_commission_amount = $row['pay_commission_amount'];
			$pay_flat_amount = $row['pay_flat_amount'];
			$pay_total_driver_amount = $row['pay_total_driver_amount'];
			$pay_notes = $row['pay_notes'];
			$settled_checkbox = $row['settled_checkbox'];
		} else {
			$message = "<div class='failure-result'>Record not found</div>";
			$show_form = false;
		}
		if (isset($_POST['map_driver_profile_button']) || $pay_total_driver_amount == 0) {
			$results = mysqli_query($dbcon, "SELECT * FROM drivers WHERE key_drivers = $key_drivers");
			if ($row = mysqli_fetch_assoc($results)) {
				$pay_base_amount_percent = $row['base_amount_percent'];
				$pay_gratuity_percent = ($row['pay_gratuity_checkbox'] == "on") ? $row['gratuity_percent'] : 0;
				$pay_commission_checkbox = ($row['pay_commission_checkbox'] == "on") ? $row['commission_percent'] : 0;
				$pay_extra_stops_checkbox = ($row['pay_extra_stops_checkbox'] == "on") ? $row['extra_stops_percent'] : 0;
				$pay_offtime_checkbox = ($row['pay_offtime_checkbox'] == "on") ? $row['offtime_percent'] : 0;
				$pay_tolls_checkbox = ($row['pay_tolls_checkbox'] == "on") ? $row['tolls_percent'] : 0;
				$pay_parking_checkbox = ($row['pay_parking_checkbox'] == "on") ? $row['parking_percent'] : 0;
				$pay_gas_surcharge_checkbox = ($row['pay_gas_surcharge_checkbox'] == "on") ? $row['gas_surcharge_percent'] : 0;
				$pay_extra_charges_checkbox = ($row['pay_extra_charges_checkbox'] == "on") ? $row['extra_charges_percent'] : 0;
			} else {
				$message = "<div class='failure-result'>Record not found</div>";
				$show_form = false;
			}
		}
	}
}
// 'Save' button clicked
if (isset($_POST['save_submit'])) {
	$error = 0;
	$settled_checkbox = trim($_POST['settled_checkbox']);
	if (strlen($settled_checkbox) > 5) {
		$msg_settled_checkbox = "<div class='message-error'>Provide a valid value of length 0-5</div>";
		$focus_field = 'settled_checkbox';
		$error = 1;
	}
	trim($_POST['pay_notes']);
	if (strlen($pay_notes) > 2000) {
		$msg_pay_notes = "<div class='message-error'>Provide a valid value of length 0-2000</div>";
		$focus_field = 'pay_notes';
		$error = 1;
	}
	$pay_total_driver_amount = trim($_POST['pay_total_driver_amount']);
	if (strlen($pay_total_driver_amount) > 10 || !is_numeric($pay_total_driver_amount)) {
		$msg_pay_total_driver_amount = "<div class='message-error'>Provide a valid value of length 0-10</div>";
		$focus_field = 'pay_total_driver_amount';
		$error = 1;
	}
	$pay_flat_amount = trim($_POST['pay_flat_amount']);
	if (strlen($pay_flat_amount) > 10 || !is_numeric($pay_flat_amount)) {
		$msg_pay_flat_amount = "<div class='message-error'>Provide a valid value of length 0-10</div>";
		$focus_field = 'pay_flat_amount';
		$error = 1;
	}
	$pay_commission_amount = trim($_POST['pay_commission_amount']);
	if (strlen($pay_commission_amount) > 10 || !is_numeric($pay_commission_amount)) {
		$msg_pay_commission_amount = "<div class='message-error'>Provide a valid value of length 0-10</div>";
		$focus_field = 'pay_commission_amount';
		$error = 1;
	}
	$pay_commission_percent = trim($_POST['pay_commission_percent']);
	if (strlen($pay_commission_percent) > 10 || !is_numeric($pay_commission_percent)) {
		$msg_pay_commission_percent = "<div class='message-error'>Provide a valid value of length 0-10</div>";
		$focus_field = 'pay_commission_percent';
		$error = 1;
	}
	$pay_gas_surcharge_amount = trim($_POST['pay_gas_surcharge_amount']);
	if (strlen($pay_gas_surcharge_amount) > 10 || !is_numeric($pay_gas_surcharge_amount)) {
		$msg_pay_gas_surcharge_amount = "<div class='message-error'>Provide a valid value of length 0-10</div>";
		$focus_field = 'pay_gas_surcharge_amount';
		$error = 1;
	}
	$pay_gas_surcharge_percent = trim($_POST['pay_gas_surcharge_percent']);
	if (strlen($pay_gas_surcharge_percent) > 10 || !is_numeric($pay_gas_surcharge_percent)) {
		$msg_pay_gas_surcharge_percent = "<div class='message-error'>Provide a valid value of length 0-10</div>";
		$focus_field = 'pay_gas_surcharge_percent';
		$error = 1;
	}
	$pay_gratuity_amount = trim($_POST['pay_gratuity_amount']);
	if (strlen($pay_gratuity_amount) > 10 || !is_numeric($pay_gratuity_amount)) {
		$msg_pay_gratuity_amount = "<div class='message-error'>Provide a valid value of length 0-10</div>";
		$focus_field = 'pay_gratuity_amount';
		$error = 1;
	}
	$pay_gratuity_percent = trim($_POST['pay_gratuity_percent']);
	if (strlen($pay_gratuity_percent) > 10 || !is_numeric($pay_gratuity_percent)) {
		$msg_pay_gratuity_percent = "<div class='message-error'>Provide a valid value of length 0-10</div>";
		$focus_field = 'pay_gratuity_percent';
		$error = 1;
	}
	$pay_parking_amount = trim($_POST['pay_parking_amount']);
	if (strlen($pay_parking_amount) > 10 || !is_numeric($pay_parking_amount)) {
		$msg_pay_parking_amount = "<div class='message-error'>Provide a valid value of length 0-10</div>";
		$focus_field = 'pay_parking_amount';
		$error = 1;
	}
	$pay_parking_percent = trim($_POST['pay_parking_percent']);
	if (strlen($pay_parking_percent) > 10 || !is_numeric($pay_parking_percent)) {
		$msg_pay_parking_percent = "<div class='message-error'>Provide a valid value of length 0-10</div>";
		$focus_field = 'pay_parking_percent';
		$error = 1;
	}
	$pay_tolls_amount = trim($_POST['pay_tolls_amount']);
	if (strlen($pay_tolls_amount) > 10 || !is_numeric($pay_tolls_amount)) {
		$msg_pay_tolls_amount = "<div class='message-error'>Provide a valid value of length 0-10</div>";
		$focus_field = 'pay_tolls_amount';
		$error = 1;
	}
	$pay_tolls_percent = trim($_POST['pay_tolls_percent']);
	if (strlen($pay_tolls_percent) > 10 || !is_numeric($pay_tolls_percent)) {
		$msg_pay_tolls_percent = "<div class='message-error'>Provide a valid value of length 0-10</div>";
		$focus_field = 'pay_tolls_percent';
		$error = 1;
	}
	$pay_extra_stops_amount = trim($_POST['pay_extra_stops_amount']);
	if (strlen($pay_extra_stops_amount) > 10 || !is_numeric($pay_extra_stops_amount)) {
		$msg_pay_extra_stops_amount = "<div class='message-error'>Provide a valid value of length 0-10</div>";
		$focus_field = 'pay_extra_stops_amount';
		$error = 1;
	}
	$pay_extra_stops_percent = trim($_POST['pay_extra_stops_percent']);
	if (strlen($pay_extra_stops_percent) > 10 || !is_numeric($pay_extra_stops_percent)) {
		$msg_pay_extra_stops_percent = "<div class='message-error'>Provide a valid value of length 0-10</div>";
		$focus_field = 'pay_extra_stops_percent';
		$error = 1;
	}
	$pay_offtime_amount = trim($_POST['pay_offtime_amount']);
	if (strlen($pay_offtime_amount) > 10 || !is_numeric($pay_offtime_amount)) {
		$msg_pay_offtime_amount = "<div class='message-error'>Provide a valid value of length 0-10</div>";
		$focus_field = 'pay_offtime_amount';
		$error = 1;
	}
	$pay_offtime_percent = trim($_POST['pay_offtime_percent']);
	if (strlen($pay_offtime_percent) > 10 || !is_numeric($pay_offtime_percent)) {
		$msg_pay_offtime_percent = "<div class='message-error'>Provide a valid value of length 0-10</div>";
		$focus_field = 'pay_offtime_percent';
		$error = 1;
	}
	$pay_driver_base_amount = trim($_POST['pay_driver_base_amount']);
	if (strlen($pay_driver_base_amount) > 10 || !is_numeric($pay_driver_base_amount)) {
		$msg_pay_driver_base_amount = "<div class='message-error'>Provide a valid value of length 0-10</div>";
		$focus_field = 'pay_driver_base_amount';
		$error = 1;
	}
	$pay_base_amount_percent = trim($_POST['pay_base_amount_percent']);
	if (strlen($pay_base_amount_percent) > 10 || !is_numeric($pay_base_amount_percent)) {
		$msg_pay_base_amount_percent = "<div class='message-error'>Provide a valid value of length 0-10</div>";
		$focus_field = 'pay_base_amount_percent';
		$error = 1;
	}
	// no validation error
	if ($error == 0) {
		if (isset($record_id) && $error != 1) { // update
			$results = mysqli_query($dbcon, "UPDATE trips SET 
			pay_base_amount_percent = '" . sd($dbcon, $pay_base_amount_percent) . "',
			pay_driver_base_amount = '" . sd($dbcon, $pay_driver_base_amount) . "',
			pay_offtime_percent = '" . sd($dbcon, $pay_offtime_percent) . "',
			pay_offtime_amount = '" . sd($dbcon, $pay_offtime_amount) . "',
			pay_extra_stops_percent = '" . sd($dbcon, $pay_extra_stops_percent) . "',
			pay_extra_stops_amount = '" . sd($dbcon, $pay_extra_stops_amount) . "',
			pay_tolls_percent = '" . sd($dbcon, $pay_tolls_percent) . "',
			pay_tolls_amount = '" . sd($dbcon, $pay_tolls_amount) . "',
			pay_parking_percent = '" . sd($dbcon, $pay_parking_percent) . "',
			pay_parking_amount = '" . sd($dbcon, $pay_parking_amount) . "',
			pay_gratuity_percent = '" . sd($dbcon, $pay_gratuity_percent) . "',
			pay_gratuity_amount = '" . sd($dbcon, $pay_gratuity_amount) . "',
			pay_gas_surcharge_percent = '" . sd($dbcon, $pay_gas_surcharge_percent) . "',
			pay_gas_surcharge_amount = '" . sd($dbcon, $pay_gas_surcharge_amount) . "',
			pay_commission_percent = '" . sd($dbcon, $pay_commission_percent) . "',
			pay_commission_amount = '" . sd($dbcon, $pay_commission_amount) . "',
			pay_flat_amount = '" . sd($dbcon, $pay_flat_amount) . "',
			pay_total_driver_amount = '" . sd($dbcon, $pay_total_driver_amount) . "',
			pay_notes = '" . sd($dbcon, $pay_notes) . "',
			settled_checkbox = '" . sd($dbcon, $settled_checkbox) . "'
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
	<title>TRIP SETTLE</title>
	<?php include('php/_head.php'); ?>
	<script>

		function calc() {
			let pay_flat_amount = parseFloat(document.getElementById("pay_flat_amount").value);
				if (pay_flat_amount > 0) {
				document.getElementById("pay_total_driver_amount").value = pay_flat_amount.toFixed(2);
				return;
			}

			let base_amount = parseFloat(document.getElementById("base_amount").value);
			let pay_base_amount_percent = parseFloat(document.getElementById("pay_base_amount_percent").value);
			let pay_driver_base_amount = base_amount * pay_base_amount_percent / 100;
			document.getElementById("pay_driver_base_amount").value = pay_driver_base_amount.toFixed(2);
			let offtime_amount = parseFloat(document.getElementById("offtime_amount").value);
			let pay_offtime_percent = parseFloat(document.getElementById("pay_offtime_percent").value);
			let pay_offtime_amount = offtime_amount * pay_offtime_percent / 100;
			document.getElementById("pay_offtime_amount").value = pay_offtime_amount.toFixed(2);
			let extra_stops_amount = parseFloat(document.getElementById("extra_stops_amount").value);
			let pay_extra_stops_percent = parseFloat(document.getElementById("pay_extra_stops_percent").value);
			let pay_extra_stops_amount = extra_stops_amount * pay_extra_stops_percent / 100;
			document.getElementById("pay_extra_stops_amount").value = pay_extra_stops_amount.toFixed(2);
			let tolls_amount = parseFloat(document.getElementById("tolls_amount").value);
			let pay_tolls_percent = parseFloat(document.getElementById("pay_tolls_percent").value);
			let pay_tolls_amount = tolls_amount * pay_tolls_percent / 100;
			document.getElementById("pay_tolls_amount").value = pay_tolls_amount.toFixed(2);
			let parking_amount = parseFloat(document.getElementById("parking_amount").value);
			let pay_parking_percent = parseFloat(document.getElementById("pay_parking_percent").value);
			let pay_parking_amount = parking_amount * pay_parking_percent / 100;
			document.getElementById("pay_parking_amount").value = pay_parking_amount.toFixed(2);
			let gratuity_amount = parseFloat(document.getElementById("gratuity_amount").value);
			let pay_gratuity_percent = parseFloat(document.getElementById("pay_gratuity_percent").value);
			let pay_gratuity_amount = gratuity_amount * pay_gratuity_percent / 100;
			document.getElementById("pay_gratuity_amount").value = pay_gratuity_amount.toFixed(2);
			let gas_surcharge_amount = parseFloat(document.getElementById("gas_surcharge_amount").value);
			let pay_gas_surcharge_percent = parseFloat(document.getElementById("pay_gas_surcharge_percent").value);
			let pay_gas_surcharge_amount = gas_surcharge_amount * pay_gas_surcharge_percent / 100;
			document.getElementById("pay_gas_surcharge_amount").value = pay_gas_surcharge_amount.toFixed(2);
			let pay_commission_percent = parseFloat(document.getElementById("pay_commission_percent").value);
			let pay_commission_amount = base_amount * pay_commission_percent / 100;
			document.getElementById("pay_commission_amount").value = pay_commission_amount.toFixed(2);
			let pay_total_driver_amount = pay_driver_base_amount + pay_offtime_amount + pay_extra_stops_amount + pay_tolls_amount + pay_parking_amount + pay_gratuity_amount + pay_gas_surcharge_amount + pay_commission_amount;
			document.getElementById("pay_total_driver_amount").value = pay_total_driver_amount.toFixed(2);
		}

	</script>
</head>
<body id='page-save' class='page_save page_trips_save'>

	<section id='sub-menu'>
		<div class='left-block'>trip settle — <?php print $driver_name; ?></div>
		<div class='right-block'>
		</div>
	</section>

	<?php if (isset($message)) print $message; ?>
	
	<main>

	<?php if (isset($show_form) && $show_form) { ?>

	<form method="post" style="margin-top:-12px;">
		<p><input type='submit' value='Map with driver profile' name='map_driver_profile_button'></p>
	</form>

	<form method='post'>
		
		<input id='key_drivers' name='key_drivers' type='hidden' value='<?php if (isset($key_drivers)) {print $key_drivers;} else {print '0';} ?>'>
		
		<fieldset>
			<table cellpadding='4' cellspacing='0'>
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
			 </table>

		</fieldset>
		
		<fieldset>

			 <div>
				 <span>Rate type:</span> 
				 <b><?php print $rate_type; ?></b>
			 </div>

			 <div>
				 <span>Zone rate</span> 
				 <input class='input_number_small' id='zone_rate' type='number' value='<?php print $zone_rate; ?>' readonly>
			 </div>

			 <div>
				 <div>Regular (rate,hours,minutes,amount)</div>
				 <input class='input_number_small' id='hourly_regular_rate' type='number' value='<?php print $hourly_regular_rate; ?>' readonly> 
				 <input class='input_number_small' id='regular_hours' type='number' value='<?php print $regular_hours; ?>' readonly> 
				 <input class='input_number_small' id='regular_minutes' type='number' value='<?php print $regular_minutes; ?>' readonly> 
				 <input class='input_number_small' id='hourly_regular_amount' type='number' value='<?php print $hourly_regular_amount; ?>' readonly>
			 </div>

			 <div>
				 <div>Wait (rate,hours,minutes,amount)</div>
				 <input class='input_number_small' id='hourly_wait_rate' type='number' value='<?php print $hourly_wait_rate; ?>' readonly> 
				 <input class='input_number_small' id='wait_hours' type='number' value='<?php print $wait_hours; ?>' readonly> 
				 <input class='input_number_small' id='wait_minutes' type='number' value='<?php print $wait_minutes; ?>' readonly> 
				 <input class='input_number_small' id='hourly_wait_amount' type='number' value='<?php print $hourly_wait_amount; ?>' readonly>
			 </div>

			 <div>
				 <div>Overtime (rate,hours,minutes,amount)</div>
				 <input class='input_number_small' id='hourly_overtime_rate' type='number' value='<?php print $hourly_overtime_rate; ?>' readonly> 
				 <input class='input_number_small' id='overtime_hours' type='number' value='<?php print $overtime_hours; ?>' readonly> 
				 <input class='input_number_small' id='overtime_minutes' type='number' value='<?php print $overtime_minutes; ?>' readonly> 
				 <input class='input_number_small' id='hourly_overtime_amount' type='number' value='<?php print $hourly_overtime_amount; ?>' readonly>
			 </div>

			 <div>
				 <span>Base amount: </span>
				 <input id='base_amount' type='number' value='<?php print $base_amount; ?>' readonly>
			 </div>

			 <div>
				 <div>Flat amount</div>
				 <input id='flat_amount' type='number' value='<?php print $flat_amount; ?>' readonly>
			 </div>
			 
			 
			 <table>
				<tr>
					<td>Off-time</td>
					<td>
						 &nbsp;&nbsp;&nbsp;<input class='select_small' id='offtime_type' type='text' value='<?php print $offtime_type; ?>' readonly>
						 <input class='input_number_small' id='offtime_amount' type='number' value='<?php print $offtime_amount; ?>' readonly>
					</td>
				</tr>
				<tr>
					<td>Extra stops</td>
					<td>
						 &nbsp;#<input class='input_number_small' id='extra_stops' type='number' value='<?php print $extra_stops; ?>' readonly> 
						 $<input class='input_number_small' id='extra_stops_amount' type='number' value='<?php print $extra_stops_amount; ?>' readonly> 
					</td>
				</tr>
				<tr>
					<td>Tolls</td>
					<td>
						 &nbsp;&nbsp;&nbsp;<input class='select_small' id='toll_type' type='text' value='<?php print $toll_type; ?>' readonly>
						 <input class='input_number_small' id='tolls_amount' type='number' value='<?php print $tolls_amount; ?>' readonly>
					</td>
				</tr>
				<tr>
					<td>Parking</td>
					<td>
						&nbsp;&nbsp;&nbsp;<input class='input_number_small' id='parking_amount' type='number' value='<?php print $parking_amount; ?>' readonly>
					</td>
				</tr>
				<tr>
					<td>Gratuity</td>
					<td>
						 %<input class='input_number_small' id='gratuity_percent' type='number' value='<?php print $gratuity_percent; ?>' readonly> 
						 $<input class='input_number_small' id='gratuity_amount' type='number' value='<?php print $gratuity_amount; ?>' readonly> 
					</td>
				</tr>
				<tr>
					<td>Gas surcharge</td>
					<td>
						 %<input class='input_number_small' id='gas_surcharge_percent' type='number' value='<?php print $gas_surcharge_percent; ?>' readonly> 
						 $<input class='input_number_small' id='gas_surcharge_amount' type='number' value='<?php print $gas_surcharge_amount; ?>' readonly>
					</td>
				</tr>
			 </table>

			<div>
				 <span>Extra charges</span>
				 <input id='trip_extra_charges' type='trip_extra_charges' value='<?php print $trip_extra_charges; ?>' readonly> 
			</div>

			 <div>
				 <span>Total trip amount</span>
				 <input id='total_trip_amount' type='number' value='<?php print $total_trip_amount; ?>' readonly>
			 </div>

		</fieldset>

		<fieldset>

			<?php 
			if(isset($msg_pay_base_amount_percent)) print $msg_pay_base_amount_percent;
			if(isset($msg_pay_driver_base_amount)) print $msg_pay_driver_base_amount;
			if(isset($msg_pay_offtime_percent)) print $msg_pay_offtime_percent; 
			if(isset($msg_pay_offtime_amount)) print $msg_pay_offtime_amount; 
			if(isset($msg_pay_extra_stops_percent)) print $msg_pay_extra_stops_percent; 
			if(isset($msg_pay_extra_stops_amount)) print $msg_pay_extra_stops_amount; 
			if(isset($msg_pay_tolls_percent)) print $msg_pay_tolls_percent; 
			if(isset($msg_pay_tolls_amount)) print $msg_pay_tolls_amount; 
			if(isset($msg_pay_parking_percent)) print $msg_pay_parking_percent; 
			if(isset($msg_pay_parking_amount)) print $msg_pay_parking_amount; 
			if(isset($msg_pay_gratuity_percent)) print $msg_pay_gratuity_percent; 
			if(isset($msg_pay_gratuity_amount)) print $msg_pay_gratuity_amount; 
			if(isset($msg_pay_gas_surcharge_percent)) print $msg_pay_gas_surcharge_percent; 
			if(isset($msg_pay_gas_surcharge_amount)) print $msg_pay_gas_surcharge_amount; 
			if(isset($msg_pay_commission_percent)) print $msg_pay_commission_percent; 
			if(isset($msg_pay_commission_amount)) print $msg_pay_commission_amount; 
			?>
			<table>
				<tr>
					<td><label for='pay_base_amount_percent'>Base amount </label></td>
					<td>
						%<input class='input_number_small' id='pay_base_amount_percent' name='pay_base_amount_percent' type='number' step='0.1' onchange='calc();' value='<?php if (isset($pay_base_amount_percent)) {print $pay_base_amount_percent;} else {print '0';} ?>' required> 
						$<input class='input_number_small' id='pay_driver_base_amount' name='pay_driver_base_amount' type='number' step='0.1' value='<?php if (isset($pay_driver_base_amount)) {print $pay_driver_base_amount;} else {print '0';} ?>' readonly>
					</td>
				</tr>
				<tr>
					<td><label for='pay_offtime_percent'>Off-time</label> </td>
					<td>
						%<input class='input_number_small' id='pay_offtime_percent' name='pay_offtime_percent' type='number' step='0.1' onchange='calc();' value='<?php if (isset($pay_offtime_percent)) {print $pay_offtime_percent;} else {print '0';} ?>' required>								$<input class='input_number_small' id='pay_offtime_amount' name='pay_offtime_amount' type='number' step='0.1' value='<?php if (isset($pay_offtime_amount)) {print $pay_offtime_amount;} else {print '0';} ?>' readonly>
					</td>
				</tr>
				<tr>
					<td><label for='pay_extra_stops_percent'>Extra stops</label> </td>
					<td>
						%<input class='input_number_small' id='pay_extra_stops_percent' name='pay_extra_stops_percent' type='number' step='0.1' onchange='calc();' value='<?php if (isset($pay_extra_stops_percent)) {print $pay_extra_stops_percent;} else {print '0';} ?>' required>
						$<input class='input_number_small' id='pay_extra_stops_amount' name='pay_extra_stops_amount' type='number' step='0.1' value='<?php if (isset($pay_extra_stops_amount)) {print $pay_extra_stops_amount;} else {print '0';} ?>' readonly>
					</td>
				</tr>
				<tr>
					<td><label for='pay_tolls_percent'>Tolls</label></td>
					<td>
						%<input class='input_number_small' id='pay_tolls_percent' name='pay_tolls_percent' type='number' step='0.1' onchange='calc();' value='<?php if (isset($pay_tolls_percent)) {print $pay_tolls_percent;} else {print '0';} ?>' required>
						$<input class='input_number_small' id='pay_tolls_amount' name='pay_tolls_amount' type='number' step='0.1' value='<?php if (isset($pay_tolls_amount)) {print $pay_tolls_amount;} else {print '0';} ?>' readonly>
					</td>
				</tr>
				<tr>
					<td><label for='pay_parking_percent'>Parking</label></td>
					<td>
						%<input class='input_number_small' id='pay_parking_percent' name='pay_parking_percent' type='number' step='0.1' onchange='calc();' value='<?php if (isset($pay_parking_percent)) {print $pay_parking_percent;} else {print '0';} ?>' required>
						$<input class='input_number_small' id='pay_parking_amount' name='pay_parking_amount' type='number' step='0.1' value='<?php if (isset($pay_parking_amount)) {print $pay_parking_amount;} else {print '0';} ?>' readonly>
					</td>
				</tr>
				<tr>
					<td><label for='pay_gratuity_percent'>Gratuity</label></td>
					<td>
						%<input class='input_number_small' id='pay_gratuity_percent' name='pay_gratuity_percent' type='number' step='0.1' onchange='calc();' value='<?php if (isset($pay_gratuity_percent)) {print $pay_gratuity_percent;} else {print '0';} ?>' required>
						$<input class='input_number_small' id='pay_gratuity_amount' name='pay_gratuity_amount' type='number' step='0.1' value='<?php if (isset($pay_gratuity_amount)) {print $pay_gratuity_amount;} else {print '0';} ?>' readonly>
					</td>
				</tr>
				<tr>
					<td><label for='pay_gas_surcharge_percent'>Gas surcharge</label></td>
					<td>
						%<input class='input_number_small' id='pay_gas_surcharge_percent' name='pay_gas_surcharge_percent' type='number' step='0.1' onchange='calc();' value='<?php if (isset($pay_gas_surcharge_percent)) {print $pay_gas_surcharge_percent;} else {print '0';} ?>' required>
						$<input class='input_number_small' id='pay_gas_surcharge_amount' name='pay_gas_surcharge_amount' type='number' step='0.1' value='<?php if (isset($pay_gas_surcharge_amount)) {print $pay_gas_surcharge_amount;} else {print '0';} ?>' readonly>
					</td>
				</tr>
				<tr>
					<td><label for='pay_commission_percent'>Commission</label></td>
					<td>
						%<input class='input_number_small' id='pay_commission_percent' name='pay_commission_percent' type='number' step='0.1' onchange='calc();' value='<?php if (isset($pay_commission_percent)) {print $pay_commission_percent;} else {print '0';} ?>' required>
						$<input class='input_number_small' id='pay_commission_amount' name='pay_commission_amount' type='number' step='0.1' value='<?php if (isset($pay_commission_amount)) {print $pay_commission_amount;} else {print '0';} ?>' readonly>
					</td>
				</tr>
			</table>
			<br>
			<div>
				<label for='pay_flat_amount'>Flat amount</label>
				<?php if(isset($msg_pay_flat_amount)) print $msg_pay_flat_amount; ?>
				<input id='pay_flat_amount' name='pay_flat_amount' type='number' step='0.1' onchange='calc();' value='<?php if (isset($pay_flat_amount)) {print $pay_flat_amount;} else {print '0';} ?>' required>
			</div>

			<div>
				<label for='pay_total_driver_amount'>Total driver amount</label> 
				<?php if(isset($msg_pay_total_driver_amount)) print $msg_pay_total_driver_amount; ?>
				<input id='pay_total_driver_amount' name='pay_total_driver_amount' type='number' step='0.1' value='<?php if (isset($pay_total_driver_amount)) {print $pay_total_driver_amount;} else {print '0';} ?>' readonly>
			</div>

			<br>
			<label for='pay_notes'>Notes</label>
			<?php if(isset($msg_pay_notes)) print $msg_pay_notes; ?>
			<textarea id='pay_notes' name='pay_notes'><?php if (isset($pay_notes)) print $pay_notes; ?></textarea><br>

		</fieldset>
		

		<fieldset>
			 <div>
				 <?php if(isset($msg_settled_checkbox)) print $msg_settled_checkbox; ?>
				 <input <?php if (!isset($settled_checkbox) || $settled_checkbox=='on') {print "checked='checked'";} ?> type='checkbox' id='settled_checkbox' name='settled_checkbox'> <label for='settled_checkbox'>Settled</label><br>
			 </div>
		</fieldset>
		
		
		<input id='save_submit' name='save_submit' type='submit' value='Save'>
		
		</form>


	<?php } ?>

	</main>
	<?php include('php/_footer.php'); ?>

	<script>calc();</script>
</body>
</html>
