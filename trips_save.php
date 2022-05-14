<?php 
include('php/_code.php');
$show_form = true;
$focus_field = 'reference_number';
if (isset($_GET['duplicate'])) $extra_title = " &nbsp;>&nbsp; <span class='red'>Duplicate</span>";
// used by customer_passengers_listing
if (isset($_GET['id']) && isset($_GET['passenger'])) {
	$key_customer_passengers = trim($_GET['id']);
	$passenger_name = trim($_GET['passenger']);
	if (!is_numeric($key_customer_passengers)) exit;
}
// id passed for update
if (isset($_GET['tripsid'])) {
	$record_id = trim($_GET['tripsid']);
	if (!is_numeric($record_id)) exit;
	if (!isset($_POST['save_submit'])) {
		$results = mysqli_query($dbcon, "SELECT * FROM trips WHERE key_trips = $record_id");
		if ($row = mysqli_fetch_assoc($results)) {
			$key_customer_passengers = $row['key_customer_passengers'];
			$key_customer_contacts = $row['key_customer_contacts'];
			$key_drivers = $row['key_drivers'];
			$key_vehicles = $row['key_vehicles'];
			$key_settings_airline_values = $row['key_settings_airline_values'];
			$key_rates_zones = $row['key_rates_zones'];
			$key_trips = $row['key_trips'];
			$reference_number = $row['reference_number'];
			$passenger_name = $row['passenger_name'];
			$total_passengers = $row['total_passengers'];
			$reserved_by = $row['reserved_by'];
			$pickup_date = date("Y-m-d", strtotime($row['pickup_datetime']));
			$pickup_time = date("H:i", strtotime($row['pickup_datetime']));
			$dropoff_date = date("Y-m-d", strtotime($row['dropoff_datetime']));
			$dropoff_time = date("H:i", strtotime($row['dropoff_datetime']));
			$trip_type = $row['trip_type'];
			$trip_status = $row['trip_status'];
			$driver_name = $row['driver_name'];
			$vehicle = $row['vehicle'];
			$airline = $row['airline'];
			$flight_number = $row['flight_number'];
			$zone_from = $row['zone_from'];
			$zone_to = $row['zone_to'];
			$routing_from = $row['routing_from'];
			$routing_to = $row['routing_to'];
			$routing_notes = $row['routing_notes'];
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
			$trip_extra_charges = $row['trip_extra_charges'];
			$total_trip_amount = $row['total_trip_amount'];
		} else {
			$message = "<div class='failure-result'>Record not found</div>";
			$show_form = false;
		}
	}
}
// 'Save' button clicked
if (isset($_POST['save_submit'])) {
	$error = 0;
	$total_trip_amount = trim($_POST['total_trip_amount']);
	if (strlen($total_trip_amount) > 10 || !is_numeric($total_trip_amount)) {
		$msg_total_trip_amount = "<div class='message-error'>Invalid value of 'trip total amount'</div>";
		$focus_field = 'total_trip_amount';
		$error = 1;
	}
	$flat_amount = trim($_POST['flat_amount']);
	if (strlen($flat_amount) > 10 || !is_numeric($flat_amount)) {
		$msg_flat_amount = "<div class='message-error'>Invalid value of 'flat amount'</div>";
		$focus_field = 'flat_amount';
		$error = 1;
	}
	$trip_extra_charges = trim($_POST['trip_extra_charges']);
	if (strlen($trip_extra_charges) > 10 || !is_numeric($trip_extra_charges)) {
		$msg_trip_extra_charges = "<div class='message-error'>Invalid value of 'trip extra charges'</div>";
		$focus_field = 'trip_extra_charges';
		$error = 1;
	}
	$tax_amount = trim($_POST['tax_amount']);
	if (strlen($tax_amount) > 10 || !is_numeric($tax_amount)) {
		$msg_tax_amount = "<div class='message-error'>Invalid value of 'tax amount'</div>";
		$focus_field = 'tax_amount';
		$error = 1;
	}
	$tax_percent = trim($_POST['tax_percent']);
	if (strlen($tax_percent) > 10 || !is_numeric($tax_percent)) {
		$msg_tax_percent = "<div class='message-error'>Invalid value of 'tax percent'</div>";
		$focus_field = 'tax_percent';
		$error = 1;
	}
	$discount_amount = trim($_POST['discount_amount']);
	if (strlen($discount_amount) > 10 || !is_numeric($discount_amount)) {
		$msg_discount_amount = "<div class='message-error'>Invalid value of 'discount amount'</div>";
		$focus_field = 'discount_amount';
		$error = 1;
	}
	$discount_percent = trim($_POST['discount_percent']);
	if (strlen($discount_percent) > 10 || !is_numeric($discount_percent)) {
		$msg_discount_percent = "<div class='message-error'>Invalid value of 'discount percent'</div>";
		$focus_field = 'discount_percent';
		$error = 1;
	}
	$admin_fee_amount = trim($_POST['admin_fee_amount']);
	if (strlen($admin_fee_amount) > 10 || !is_numeric($admin_fee_amount)) {
		$msg_admin_fee_amount = "<div class='message-error'>Invalid value of 'admin fee amount'</div>";
		$focus_field = 'admin_fee_amount';
		$error = 1;
	}
	$admin_fee_percent = trim($_POST['admin_fee_percent']);
	if (strlen($admin_fee_percent) > 10 || !is_numeric($admin_fee_percent)) {
		$msg_admin_fee_percent = "<div class='message-error'>Invalid value of 'admin fee percent'</div>";
		$focus_field = 'admin_fee_percent';
		$error = 1;
	}
	$gas_surcharge_amount = trim($_POST['gas_surcharge_amount']);
	if (strlen($gas_surcharge_amount) > 10 || !is_numeric($gas_surcharge_amount)) {
		$msg_gas_surcharge_amount = "<div class='message-error'>Invalid value of 'gas surcharge amount'</div>";
		$focus_field = 'gas_surcharge_amount';
		$error = 1;
	}
	$gas_surcharge_percent = trim($_POST['gas_surcharge_percent']);
	if (strlen($gas_surcharge_percent) > 10 || !is_numeric($gas_surcharge_percent)) {
		$msg_gas_surcharge_percent = "<div class='message-error'>Invalid value of 'gas surcharge percent'</div>";
		$focus_field = 'gas_surcharge_percent';
		$error = 1;
	}
	$gratuity_amount = trim($_POST['gratuity_amount']);
	if (strlen($gratuity_amount) > 10 || !is_numeric($gratuity_amount)) {
		$msg_gratuity_amount = "<div class='message-error'>Invalid value of 'gratuity amount'</div>";
		$focus_field = 'gratuity_amount';
		$error = 1;
	}
	$gratuity_percent = trim($_POST['gratuity_percent']);
	if (strlen($gratuity_percent) > 10 || !is_numeric($gratuity_percent)) {
		$msg_gratuity_percent = "<div class='message-error'>Invalid value of 'gratuity percent'</div>";
		$focus_field = 'gratuity_percent';
		$error = 1;
	}
	$parking_amount = trim($_POST['parking_amount']);
	if (strlen($parking_amount) > 10 || !is_numeric($parking_amount)) {
		$msg_parking_amount = "<div class='message-error'>Invalid value of 'parking amount'</div>";
		$focus_field = 'parking_amount';
		$error = 1;
	}
	$tolls_amount = trim($_POST['tolls_amount']);
	if (strlen($tolls_amount) > 10 || !is_numeric($tolls_amount)) {
		$msg_tolls_amount = "<div class='message-error'>Invalid value of 'tolls amount'</div>";
		$focus_field = 'tolls_amount';
		$error = 1;
	}
	$toll_type = trim($_POST['toll_type']);
	if (strlen($toll_type) > 50) {
		$msg_toll_type = "<div class='message-error'>Invalid value of 'toll type'</div>";
		$focus_field = 'toll_type';
		$error = 1;
	}
	$extra_stops_amount = trim($_POST['extra_stops_amount']);
	if (strlen($extra_stops_amount) > 10 || !is_numeric($extra_stops_amount)) {
		$msg_extra_stops_amount = "<div class='message-error'>Invalid value of 'extra stops amount'</div>";
		$focus_field = 'extra_stops_amount';
		$error = 1;
	}
	$extra_stops = trim($_POST['extra_stops']);
	if (strlen($extra_stops) > 5 || !is_numeric($extra_stops)) {
		$msg_extra_stops = "<div class='message-error'>Invalid value of 'extra stops'</div>";
		$focus_field = 'extra_stops';
		$error = 1;
	}
	$offtime_amount = trim($_POST['offtime_amount']);
	if (strlen($offtime_amount) > 10 || !is_numeric($offtime_amount)) {
		$msg_offtime_amount = "<div class='message-error'>Invalid value of 'offtime amount'</div>";
		$focus_field = 'offtime_amount';
		$error = 1;
	}
	$offtime_type = trim($_POST['offtime_type']);
	if (strlen($offtime_type) > 50) {
		$msg_offtime_type = "<div class='message-error'>Invalid value of 'offtime type'</div>";
		$focus_field = 'offtime_type';
		$error = 1;
	}
	$base_amount = trim($_POST['base_amount']);
	if (strlen($base_amount) > 10 || !is_numeric($base_amount)) {
		$msg_base_amount = "<div class='message-error'>Invalid value of 'base amount'</div>";
		$focus_field = 'base_amount';
		$error = 1;
	}
	$zone_rate = trim($_POST['zone_rate']);
	if (strlen($zone_rate) > 10 || !is_numeric($zone_rate)) {
		$msg_zone_rate = "<div class='message-error'>Invalid value of 'zone rate'</div>";
		$focus_field = 'zone_rate';
		$error = 1;
	}
	$hourly_overtime_amount = trim($_POST['hourly_overtime_amount']);
	if (strlen($hourly_overtime_amount) > 10 || !is_numeric($hourly_overtime_amount)) {
		$msg_hourly_overtime_amount = "<div class='message-error'>Invalid value of 'hourly overtime amount'</div>";
		$focus_field = 'hourly_overtime_amount';
		$error = 1;
	}
	$overtime_minutes = trim($_POST['overtime_minutes']);
	if (strlen($overtime_minutes) > 5 || !is_numeric($overtime_minutes)) {
		$msg_overtime_minutes = "<div class='message-error'>Invalid value of 'overtime minutes'</div>";
		$focus_field = 'overtime_minutes';
		$error = 1;
	}
	$overtime_hours = trim($_POST['overtime_hours']);
	if (strlen($overtime_hours) > 5 || !is_numeric($overtime_hours)) {
		$msg_overtime_hours = "<div class='message-error'>Invalid value of 'overtime hours'</div>";
		$focus_field = 'overtime_hours';
		$error = 1;
	}
	$hourly_overtime_rate = trim($_POST['hourly_overtime_rate']);
	if (strlen($hourly_overtime_rate) > 10 || !is_numeric($hourly_overtime_rate)) {
		$msg_hourly_overtime_rate = "<div class='message-error'>Invalid value of 'hourly overtime rate'</div>";
		$focus_field = 'hourly_overtime_rate';
		$error = 1;
	}
	$hourly_wait_amount = trim($_POST['hourly_wait_amount']);
	if (strlen($hourly_wait_amount) > 10 || !is_numeric($hourly_wait_amount)) {
		$msg_hourly_wait_amount = "<div class='message-error'>Invalid value of 'hourly wait amount'</div>";
		$focus_field = 'hourly_wait_amount';
		$error = 1;
	}
	$wait_minutes = trim($_POST['wait_minutes']);
	if (strlen($wait_minutes) > 5 || !is_numeric($wait_minutes)) {
		$msg_wait_minutes = "<div class='message-error'>Invalid value of 'wait minutes'</div>";
		$focus_field = 'wait_minutes';
		$error = 1;
	}
	$wait_hours = trim($_POST['wait_hours']);
	if (strlen($wait_hours) > 5 || !is_numeric($wait_hours)) {
		$msg_wait_hours = "<div class='message-error'>Invalid value of 'wait hours'</div>";
		$focus_field = 'wait_hours';
		$error = 1;
	}
	$hourly_wait_rate = trim($_POST['hourly_wait_rate']);
	if (strlen($hourly_wait_rate) > 10 || !is_numeric($hourly_wait_rate)) {
		$msg_hourly_wait_rate = "<div class='message-error'>Invalid value of 'hourly wait rate'</div>";
		$focus_field = 'hourly_wait_rate';
		$error = 1;
	}
	
	$hourly_regular_amount = trim($_POST['hourly_regular_amount']);
	if (strlen($hourly_regular_amount) > 10 || !is_numeric($hourly_regular_amount)) {
		$msg_hourly_regular_amount = "<div class='message-error'>Invalid value of 'hourly regular amount'</div>";
		$focus_field = 'hourly_regular_amount';
		$error = 1;
	}
	$regular_minutes = trim($_POST['regular_minutes']);
	if (strlen($regular_minutes) > 5 || !is_numeric($regular_minutes)) {
		$msg_regular_minutes = "<div class='message-error'>Invalid value of 'regular minutes'</div>";
		$focus_field = 'regular_minutes';
		$error = 1;
	}
	$regular_hours = trim($_POST['regular_hours']);
	if (strlen($regular_hours) > 5 || !is_numeric($regular_hours)) {
		$msg_regular_hours = "<div class='message-error'>Invalid value of 'regular hours'</div>";
		$focus_field = 'regular_hours';
		$error = 1;
	}
	$hourly_regular_rate = trim($_POST['hourly_regular_rate']);
	if (strlen($hourly_regular_rate) > 10 || !is_numeric($hourly_regular_rate)) {
		$msg_hourly_regular_rate = "<div class='message-error'>Invalid value of 'hourly regular rate'</div>";
		$focus_field = 'hourly_regular_rate';
		$error = 1;
	}
	$rate_type = trim($_POST['rate_type']);
	if (strlen($rate_type) > 50) {
		$msg_rate_type = "<div class='message-error'>Provide a valid value of length 0-50</div>";
		$focus_field = 'rate_type';
		$error = 1;
	}
	$dispatcher_notes = trim($_POST['dispatcher_notes']);
	if (strlen($dispatcher_notes) > 2000) {
		$msg_dispatcher_notes = "<div class='message-error'>Provide a valid value of length 0-2000</div>";
		$focus_field = 'dispatcher_notes';
		$error = 1;
	}
	
	$routing_notes = trim($_POST['routing_notes']);
	if (strlen($routing_notes) > 2000) {
		$msg_routing_notes = "<div class='message-error'>Provide a valid value of length 0-2000</div>";
		$focus_field = 'routing_notes';
		$error = 1;
	}
	$routing_to = trim($_POST['routing_to']);
	if (strlen($routing_to) < 3 || strlen($routing_to) > 3000) {
		$msg_routing_to = "<div class='message-error'>Provide a valid value of length 3-3000</div>";
		$focus_field = 'routing_to';
		$error = 1;
	}
	$routing_from = trim($_POST['routing_from']);
	if (strlen($routing_from) < 3 || strlen($routing_from) > 3000) {
		$msg_routing_from = "<div class='message-error'>Provide a valid value of length 3-3000</div>";
		$focus_field = 'routing_from';
		$error = 1;
	}
	$zone_to = trim($_POST['zone_to']);
	if (strlen($zone_to) > 100) {
		$msg_zone_to = "<div class='message-error'>Provide a valid value of length 0-100</div>";
		$focus_field = 'zone_to';
		$error = 1;
	}
	$zone_from = trim($_POST['zone_from']);
	if (strlen($zone_from) > 100) {
		$msg_zone_from = "<div class='message-error'>Provide a valid value of length 0-100</div>";
		$focus_field = 'zone_from';
		$error = 1;
	}
	$flight_number = trim($_POST['flight_number']);
	if (strlen($flight_number) > 100) {
		$msg_flight_number = "<div class='message-error'>Provide a valid value of length 0-100</div>";
		$focus_field = 'flight_number';
		$error = 1;
	}
	$airline = trim($_POST['airline']);
	if (strlen($airline) > 100) {
		$msg_airline = "<div class='message-error'>Provide a valid value of length 0-100</div>";
		$focus_field = 'airline';
		$error = 1;
	}
	$vehicle = trim($_POST['vehicle']);
	if (strlen($vehicle) > 50) {
		$msg_vehicle = "<div class='message-error'>Provide a valid value of length 0-50</div>";
		$focus_field = 'vehicle';
		$error = 1;
	}
	$driver_name = trim($_POST['driver_name']);
	if (strlen($driver_name) > 100) {
		$msg_driver_name = "<div class='message-error'>Provide a valid value of length 0-100</div>";
		$focus_field = 'driver_name';
		$error = 1;
	}
	$trip_status = trim($_POST['trip_status']);
	if (strlen($trip_status) > 50) {
		$msg_trip_status = "<div class='message-error'>Provide a valid value of length 0-50</div>";
		$focus_field = 'trip_status';
		$error = 1;
	}
	$trip_type = trim($_POST['trip_type']);
	if (strlen($trip_type) > 50) {
		$msg_trip_type = "<div class='message-error'>Provide a valid value of length 0-50</div>";
		$focus_field = 'trip_type';
		$error = 1;
	}
	$dropoff_time = trim($_POST['dropoff_time']);
	if (empty($dropoff_time)) {
		$dropoff_time = '01:00:00';
	} else if (!is_time($dropoff_time)) {
		$msg_dropoff_time = "<div class='message-error'>Acceptable time format is 'hr:mn' (24-hour)</div>";
		$focus_field = 'dropoff_time';
		$error = 1;
	}
	$dropoff_date = trim($_POST['dropoff_date']);
	if (empty($dropoff_date)) {
		$dropoff_date = date("Y-m'd");
	} else if (!is_date($dropoff_date)) {
		$msg_dropoff_date = "<div class='message-error'>Acceptable date format is 'yyyy-mm-dd'</div>";
		$focus_field = 'dropoff_date';
		$error = 1;
	}
	$dropoff_datetime = $dropoff_date . " " . $dropoff_time;
	$pickup_time = trim($_POST['pickup_time']);
	if (empty($pickup_time)) {
		$pickup_time = '01:00:00';
	} else if (!is_time($pickup_time)) {
		$msg_pickup_time = "<div class='message-error'>Acceptable time format is 'hr:mn' (24-hour)</div>";
		$focus_field = 'pickup_time';
		$error = 1;
	}
	$pickup_date = trim($_POST['pickup_date']);
	if (empty($pickup_date)) {
		$pickup_date = date("Y-m'd");
	} else if (!is_date($pickup_date)) {
		$msg_pickup_date = "<div class='message-error'>Acceptable date format is 'yyyy-mm-dd'</div>";
		$focus_field = 'pickup_date';
		$error = 1;
	}
	$pickup_datetime = $pickup_date . " " . $pickup_time;
	$reserved_by = trim($_POST['reserved_by']);
	if (strlen($reserved_by) > 100) {
		$msg_reserved_by = "<div class='message-error'>Provide a valid value of length 0-100</div>";
		$focus_field = 'reserved_by';
		$error = 1;
	}
	$total_passengers = trim($_POST['total_passengers']);
	if (strlen($total_passengers) > 5 || !is_numeric($total_passengers)) {
		$msg_total_passengers = "<div class='message-error'>Provide a valid value of length 0-5</div>";
		$focus_field = 'total_passengers';
		$error = 1;
	}
	$passenger_name = trim($_POST['passenger_name']);
	if (strlen($passenger_name) < 3 || strlen($passenger_name) > 100) {
		$msg_passenger_name = "<div class='message-error'>Provide a valid value of length 3-100</div>";
		$focus_field = 'passenger_name';
		$error = 1;
	}
	$reference_number = trim($_POST['reference_number']);
	if (strlen($reference_number) > 50) {
		$msg_reference_number = "<div class='message-error'>Provide a valid value of length 0-50</div>";
		$focus_field = 'reference_number';
		$error = 1;
	}
	$key_rates_zones = trim($_POST['key_rates_zones']);
	if (strlen($key_rates_zones) > 100 || !is_numeric($key_rates_zones)) {
		$msg_key_rates_zones = "<div class='message-error'>Provide a valid value of length 0-100</div>";
		$focus_field = 'key_rates_zones';
		$error = 1;
	}
	$key_settings_airline_values = trim($_POST['key_settings_airline_values']);
	if (strlen($key_settings_airline_values) > 100 || !is_numeric($key_settings_airline_values)) {
		$msg_key_settings_airline_values = "<div class='message-error'>Provide a valid value of length 0-100</div>";
		$focus_field = 'key_settings_airline_values';
		$error = 1;
	}
	$key_vehicles = trim($_POST['key_vehicles']);
	if (strlen($key_vehicles) > 100 || !is_numeric($key_vehicles)) {
		$msg_key_vehicles = "<div class='message-error'>Provide a valid value of length 0-100</div>";
		$focus_field = 'key_vehicles';
		$error = 1;
	}
	$key_drivers = trim($_POST['key_drivers']);
	if (strlen($key_drivers) > 100 || !is_numeric($key_drivers)) {
		$msg_key_drivers = "<div class='message-error'>Provide a valid value of length 0-100</div>";
		$focus_field = 'key_drivers';
		$error = 1;
	}
	$key_customer_contacts = trim($_POST['key_customer_contacts']);
	if (strlen($key_customer_contacts) > 100 || !is_numeric($key_customer_contacts)) {
		$msg_key_customer_contacts = "<div class='message-error'>Provide a valid value of length 0-100</div>";
		$focus_field = 'key_customer_contacts';
		$error = 1;
	}
	$key_customer_passengers = trim($_POST['key_customer_passengers']);
	if (strlen($key_customer_passengers) > 100 || !is_numeric($key_customer_passengers)) {
		$msg_key_customer_passengers = "<div class='message-error'>Provide a valid value of length 0-100</div>";
		$focus_field = 'key_customer_passengers';
		$error = 1;
	}
	// no validation error
	if ($error == 0) {
		// duplicate trip
		if (isset($_GET['duplicate'])) unset($record_id);
		if (isset($record_id) && $error != 1) { // update
			$results = mysqli_query($dbcon, "UPDATE trips SET 
			key_customer_passengers = '" . sd($dbcon, $key_customer_passengers) . "',
			key_customer_contacts = '" . sd($dbcon, $key_customer_contacts) . "',
			key_drivers = '" . sd($dbcon, $key_drivers) . "',
			key_vehicles = '" . sd($dbcon, $key_vehicles) . "',
			key_settings_airline_values = '" . sd($dbcon, $key_settings_airline_values) . "',
			key_rates_zones = '" . sd($dbcon, $key_rates_zones) . "',
			reference_number = '" . sd($dbcon, $reference_number) . "',
			passenger_name = '" . sd($dbcon, $passenger_name) . "',
			total_passengers = '" . sd($dbcon, $total_passengers) . "',
			reserved_by = '" . sd($dbcon, $reserved_by) . "',
			pickup_datetime = '" . sd($dbcon, $pickup_datetime) . "',
			dropoff_datetime = '" . sd($dbcon, $dropoff_datetime) . "',
			trip_type = '" . sd($dbcon, $trip_type) . "',
			trip_status = '" . sd($dbcon, $trip_status) . "',
			driver_name = '" . sd($dbcon, $driver_name) . "',
			vehicle = '" . sd($dbcon, $vehicle) . "',
			airline = '" . sd($dbcon, $airline) . "',
			flight_number = '" . sd($dbcon, $flight_number) . "',
			zone_from = '" . sd($dbcon, $zone_from) . "',
			zone_to = '" . sd($dbcon, $zone_to) . "',
			routing_from = '" . sd($dbcon, $routing_from) . "',
			routing_to = '" . sd($dbcon, $routing_to) . "',
			routing_notes = '" . sd($dbcon, $routing_notes) . "',
			dispatcher_notes = '" . sd($dbcon, $dispatcher_notes) . "',
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
			total_trip_amount = '" . sd($dbcon, $total_trip_amount) . "' 
			WHERE key_trips = $record_id");
			if ($results) {
				$message = "<script>parent.location.reload(false);</script>";
			} else {
				//print mysqli_error($dbcon);
				die('Unable to update, please contact your system administrator.');
			}
		} else if ($error != 1) { // insert
			$results = mysqli_query($dbcon, "INSERT INTO trips (
			key_customer_passengers,
			key_customer_contacts,
			key_drivers,
			key_vehicles,
			key_settings_airline_values,
			key_rates_zones,
			reference_number,
			passenger_name,
			total_passengers,
			reserved_by,
			pickup_datetime,
			dropoff_datetime,
			trip_type,
			trip_status,
			driver_name,
			vehicle,
			airline,
			flight_number,
			zone_from,
			zone_to,
			routing_from,
			routing_to,
			routing_notes,
			dispatcher_notes,
			rate_type,
			hourly_regular_rate,
			regular_hours,
			regular_minutes,
			hourly_regular_amount,
			hourly_wait_rate,
			wait_hours,
			wait_minutes,
			hourly_wait_amount,
			hourly_overtime_rate,
			overtime_hours,
			overtime_minutes,
			hourly_overtime_amount,
			zone_rate,
			base_amount,
			offtime_type,
			offtime_amount,
			extra_stops,
			extra_stops_amount,
			toll_type,
			tolls_amount,
			parking_amount,
			gratuity_percent,
			gratuity_amount,
			gas_surcharge_percent,
			gas_surcharge_amount,
			admin_fee_percent,
			admin_fee_amount,
			discount_percent,
			discount_amount,
			tax_percent,
			tax_amount,
			trip_extra_charges,
			flat_amount,
			total_trip_amount
			) 
			VALUES (
			'" . sd($dbcon, $key_customer_passengers) . "',
			'" . sd($dbcon, $key_customer_contacts) . "',
			'" . sd($dbcon, $key_drivers) . "',
			'" . sd($dbcon, $key_vehicles) . "',
			'" . sd($dbcon, $key_settings_airline_values) . "',
			'" . sd($dbcon, $key_rates_zones) . "',
			'" . sd($dbcon, $reference_number) . "',
			'" . sd($dbcon, $passenger_name) . "',
			'" . sd($dbcon, $total_passengers) . "',
			'" . sd($dbcon, $reserved_by) . "',
			'" . sd($dbcon, $pickup_datetime) . "',
			'" . sd($dbcon, $dropoff_datetime) . "',
			'" . sd($dbcon, $trip_type) . "',
			'" . sd($dbcon, $trip_status) . "',
			'" . sd($dbcon, $driver_name) . "',
			'" . sd($dbcon, $vehicle) . "',
			'" . sd($dbcon, $airline) . "',
			'" . sd($dbcon, $flight_number) . "',
			'" . sd($dbcon, $zone_from) . "',
			'" . sd($dbcon, $zone_to) . "',
			'" . sd($dbcon, $routing_from) . "',
			'" . sd($dbcon, $routing_to) . "',
			'" . sd($dbcon, $routing_notes) . "',
			'" . sd($dbcon, $dispatcher_notes) . "',
			'" . sd($dbcon, $rate_type) . "',
			'" . sd($dbcon, $hourly_regular_rate) . "',
			'" . sd($dbcon, $regular_hours) . "',
			'" . sd($dbcon, $regular_minutes) . "',
			'" . sd($dbcon, $hourly_regular_amount) . "',
			'" . sd($dbcon, $hourly_wait_rate) . "',
			'" . sd($dbcon, $wait_hours) . "',
			'" . sd($dbcon, $wait_minutes) . "',
			'" . sd($dbcon, $hourly_wait_amount) . "',
			'" . sd($dbcon, $hourly_overtime_rate) . "',
			'" . sd($dbcon, $overtime_hours) . "',
			'" . sd($dbcon, $overtime_minutes) . "',
			'" . sd($dbcon, $hourly_overtime_amount) . "',
			'" . sd($dbcon, $zone_rate) . "',
			'" . sd($dbcon, $base_amount) . "',
			'" . sd($dbcon, $offtime_type) . "',
			'" . sd($dbcon, $offtime_amount) . "',
			'" . sd($dbcon, $extra_stops) . "',
			'" . sd($dbcon, $extra_stops_amount) . "',
			'" . sd($dbcon, $toll_type) . "',
			'" . sd($dbcon, $tolls_amount) . "',
			'" . sd($dbcon, $parking_amount) . "',
			'" . sd($dbcon, $gratuity_percent) . "',
			'" . sd($dbcon, $gratuity_amount) . "',
			'" . sd($dbcon, $gas_surcharge_percent) . "',
			'" . sd($dbcon, $gas_surcharge_amount) . "',
			'" . sd($dbcon, $admin_fee_percent) . "',
			'" . sd($dbcon, $admin_fee_amount) . "',
			'" . sd($dbcon, $discount_percent) . "',
			'" . sd($dbcon, $discount_amount) . "',
			'" . sd($dbcon, $tax_percent) . "',
			'" . sd($dbcon, $tax_amount) . "',
			'" . sd($dbcon, $trip_extra_charges) . "',
			'" . sd($dbcon, $flat_amount) . "',
			'" . sd($dbcon, $total_trip_amount) . "'
			)");
			if ($results) {
				$last_inserted_key = mysqli_insert_id($dbcon);
				mysqli_query($dbcon, "UPDATE trips SET key_trips = '$last_inserted_key' WHERE key_trips = $last_inserted_key");
				
				$message = "<script>parent.location.reload(false);</script>";
			} else {
				if (strpos(mysqli_error($dbcon), "Duplicate") > -1) {
					$message = "<div class='failure-result'>" . mysqli_error($dbcon) . "</div>";
					$error = 1;
				} else {
					print mysqli_error($dbcon);
					die('Unable to add, please contact your system administrator.');
				}         
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
	<script>

		function set_passenger_id_for_select_address(recordid) { // called from (1) trips_select_customer_passengers (2) bottom of this page
			document.getElementById("select_customer_address_link").href = "trips_select_customer_address_book.php?recordid=" + recordid;
		}
		
	</script>
</head>
<body id='page-save' class='page_save page_trips_save'>

	<section id='sub-menu'>
		<div class='left-block'>trip <?php if (isset($key_trips)) print '#' . $key_trips; if (isset($extra_title)) print $extra_title; ?></div>
		<div class='right-block'>

		</div>
	</section>

	<?php if (isset($message)) print $message; ?>
	
	<main>

	<?php if (isset($show_form) && $show_form) { ?>
	<form method='post'>
		
		<fieldset id="trips_fieldset1">
		
			 <input id='key_customer_passengers' name='key_customer_passengers' type='hidden' value='<?php if (isset($key_customer_passengers)) {print $key_customer_passengers;} else {print '0';} ?>'>
			 <input id='key_customer_contacts' name='key_customer_contacts' type='hidden' value='<?php if (isset($key_customer_contacts)) {print $key_customer_contacts;} else {print '0';} ?>'>
			 <input id='key_drivers' name='key_drivers' type='hidden' value='<?php if (isset($key_drivers)) {print $key_drivers;} else {print '0';} ?>'>
			 <input id='key_vehicles' name='key_vehicles' type='hidden' value='<?php if (isset($key_vehicles)) {print $key_vehicles;} else {print '0';} ?>'>
			 <input id='key_settings_airline_values' name='key_settings_airline_values' type='hidden' value='<?php if (isset($key_settings_airline_values)) {print $key_settings_airline_values;} else {print '0';} ?>'>
			 <input id='key_rates_zones' name='key_rates_zones' type='hidden' value='<?php if (isset($key_rates_zones)) {print $key_rates_zones;} else {print '0';} ?>'>

			 <div>
				 <label for='reference_number'>Reference #</label>             <?php if(isset($msg_reference_number)) print $msg_reference_number; ?>
				 <input <?php if ($focus_field == 'reference_number') print 'autofocus'; ?> id='reference_number' name='reference_number' type='text' value='<?php if (isset($reference_number)) {print $reference_number;} else { print '';} ?>'><br>
			 </div>

			 <div>
				 <label for='passenger_name'>Passenger name</label> <span class='red'> *</span>
				 <small>
						 <a href='trips_select_customer_passengers.php' target='overlay-iframe2' onclick='overlayOpen2();'>Select</a> &nbsp;
						 <a href='#' onclick='unselectKeyValue("key_customer_passengers","passenger_name");return false;'>x</a>
				 </small><br>
				 <?php if(isset($msg_passenger_name)) print $msg_passenger_name; ?>
				 <input <?php if ($focus_field == 'passenger_name') print 'autofocus'; ?> id='passenger_name' name='passenger_name' type='text' value='<?php if (isset($passenger_name)) {print $passenger_name;} else { print '';} ?>' required readonly><br>
			 </div>

			 <div>
				 <label for='total_passengers'>Total passengers</label>             <?php if(isset($msg_total_passengers)) print $msg_total_passengers; ?>
				 <input <?php if ($focus_field == 'total_passengers') print 'autofocus'; ?> id='total_passengers' name='total_passengers' type='number' value='<?php if (isset($total_passengers)) {print $total_passengers;} else { print '1';} ?>'><br>
			 </div>

			 <div>
				 <label for='reserved_by'>Reserved by</label>
				 <small>
						 <a href='trips_select_customer_contacts.php' target='overlay-iframe2' onclick='overlayOpen2();'>Select</a> &nbsp;
						 <a href='#' onclick='unselectKeyValue("key_customer_contacts","reserved_by");return false;'>x</a>
				 </small><br>
				 <?php if(isset($msg_reserved_by)) print $msg_reserved_by; ?>
				 <input <?php if ($focus_field == 'reserved_by') print 'autofocus'; ?> id='reserved_by' name='reserved_by' type='text' value='<?php if (isset($reserved_by)) {print $reserved_by;} else { print '';} ?>' readonly><br>
			 </div>

			 <div>
				 <label for='pickup_date'>Pickup date</label><br>
				 <?php if(isset($msg_pickup_date)) print $msg_pickup_date; ?>
				 <input id='pickup_date' name='pickup_date' type='date' placeholder='yyyy-mm-dd' value='<?php if (isset($pickup_date)) {print $pickup_date;} ?>'><br>
			 </div>

			 <div>
				 <label for='pickup_time'>Pickup time</label><br>
				 <?php if(isset($msg_pickup_time)) print $msg_pickup_time; ?>
				 <input id='pickup_time' name='pickup_time' type='time' placeholder='hh:mm (24-hour)' value='<?php if (isset($pickup_time)) {print $pickup_time;} ?>'><br>
			 </div>

			 <div>
				 <label for='dropoff_date'>Dropoff date</label><br>
				 <?php if(isset($msg_dropoff_date)) print $msg_dropoff_date; ?>
				 <input id='dropoff_date' name='dropoff_date' type='date' placeholder='yyyy-mm-dd' value='<?php if (isset($dropoff_date)) {print $dropoff_date;} ?>'><br>
			 </div>

			 <div>
				 <label for='dropoff_time'>Dropoff time</label><br>
				 <?php if(isset($msg_dropoff_time)) print $msg_dropoff_time; ?>
				 <input id='dropoff_time' name='dropoff_time' type='time' placeholder='hh:mm (24-hour)' value='<?php if (isset($dropoff_time)) {print $dropoff_time;} ?>'><br>
			 </div>

			 <div>
				 <label for='trip_type'>Trip type</label><br>
				 <?php if(isset($msg_trip_type)) print $msg_trip_type; ?>
				 <select id='trip_type' name='trip_type'>
					 <?php 
					 $options = '';
					 $results = mysqli_query($dbcon, 'SELECT trip_type FROM settings_trip_type_values');
					 while ($row = mysqli_fetch_assoc($results)) {
						 $selection = '';
						 if ($row['trip_type'] == $trip_type) $selection = "selected='selected'";
							 $options .= "<option $selection>" . $row['trip_type'] . "</option>";
					 }
					 print $options; 
					 ?>
				 </select>
			 </div>

			 <div>
				 <label for='trip_status'>Trip status</label><br>
				 <?php if(isset($msg_trip_status)) print $msg_trip_status; ?>
				 <select id='trip_status' name='trip_status'>
					 <?php 
					 $options = '';
					 $results = mysqli_query($dbcon, 'SELECT trip_status FROM settings_trip_status_values');
					 while ($row = mysqli_fetch_assoc($results)) {
						 $selection = '';
						 if ($row['trip_status'] == $trip_status) $selection = "selected='selected'";
							 $options .= "<option $selection>" . $row['trip_status'] . "</option>";
					 }
					 print $options; 
					 ?>
				 </select>
			 </div>

		</fieldset>
		<fieldset id="trips_fieldset2">

			 <div>
				 <label for='driver_name'>Driver name</label>
				 <small>
						 <a href='trips_select_drivers.php' target='overlay-iframe2' onclick='overlayOpen2();'>Select</a> &nbsp;
						 <a href='#' onclick='unselectKeyValue("key_drivers","driver_name");return false;'>x</a>
				 </small><br>
				 <?php if(isset($msg_driver_name)) print $msg_driver_name; ?>
				 <input <?php if ($focus_field == 'driver_name') print 'autofocus'; ?> id='driver_name' name='driver_name' type='text' value='<?php if (isset($driver_name)) {print $driver_name;} else { print '';} ?>' readonly><br>
			 </div>

			 <div>
				 <label for='vehicle'>Vehicle</label>
				 <small>
						 <a href='trips_select_vehicles.php?rates_zonesid=<?php print $key_rates_zones; ?>' target='overlay-iframe2' onclick='overlayOpen2();'>Select</a> &nbsp;
						 <a href='#' onclick='unselectKeyValue("key_vehicles","vehicle");return false;'>x</a>
				 </small><br>
				 <?php if(isset($msg_vehicle)) print $msg_vehicle; ?>
				 <input <?php if ($focus_field == 'vehicle') print 'autofocus'; ?> id='vehicle' name='vehicle' type='text' value='<?php if (isset($vehicle)) {print $vehicle;} else { print '';} ?>' readonly><br>
			 </div>

			 <div>
				 <label for='airline'>Airline</label>
				 <small>
						 <a href='trips_select_settings_airline_values.php' target='overlay-iframe2' onclick='overlayOpen2();'>Select</a> &nbsp;
						 <a href='#' onclick='unselectKeyValue("key_settings_airline_values","airline");return false;'>x</a>
				 </small><br>
				 <?php if(isset($msg_airline)) print $msg_airline; ?>
				 <input <?php if ($focus_field == 'airline') print 'autofocus'; ?> id='airline' name='airline' type='text' value='<?php if (isset($airline)) {print $airline;} else { print '';} ?>' readonly><br>
			 </div>

			 <div>
				 <label for='flight_number'>Flight #</label>             <?php if(isset($msg_flight_number)) print $msg_flight_number; ?>
				 <input <?php if ($focus_field == 'flight_number') print 'autofocus'; ?> id='flight_number' name='flight_number' type='text' value='<?php if (isset($flight_number)) {print $flight_number;} else { print '';} ?>'><br>
			 </div>

			 <div>
				 <label for='zone_from'>Zone from</label>
				 <small>
						 <a href='trips_select_rates_zones.php' target='overlay-iframe2' onclick='overlayOpen2();'>Select</a> &nbsp;
						 <a href='#' onclick='unselectKeyValue("key_rates_zones","zone_from");unselectKeyValue("key_rates_zones","zone_to");return false;'>x</a>
				 </small><br>
				 <?php if(isset($msg_zone_from)) print $msg_zone_from; ?>
				 <input <?php if ($focus_field == 'zone_from') print 'autofocus'; ?> id='zone_from' name='zone_from' type='text' value='<?php if (isset($zone_from)) {print $zone_from;} else { print '';} ?>' readonly><br>
			 </div>

			 <div>
				 <label for='zone_to'>Zone to</label>             
				 <?php if(isset($msg_zone_to)) print $msg_zone_to; ?>
				 <input <?php if ($focus_field == 'zone_to') print 'autofocus'; ?> id='zone_to' name='zone_to' type='text' value='<?php if (isset($zone_to)) {print $zone_to;} else { print '';} ?>' readonly><br>
			 </div>

		</fieldset>
		
		<fieldset id="trips_fieldset3">

			 <div>
				 <p>
					<small>
					<a href='trips_select_landmarks.php' target='overlay-iframe2' onclick='overlayOpen2();'>Landmarks</a> &nbsp; 
					<!-- a function in <head> sets href for this link which is called from trips_select_customer_passengers.php -->
					<a id='select_customer_address_link' href='trips_select_customer_address_book.php' target='overlay-iframe2' onclick='overlayOpen2();'>Addressbook</a>
					</small>
				 </p>
				 <label for='routing_from'>Routing from</label> <span class='red'> *</span>
				 <?php if(isset($msg_routing_from)) print $msg_routing_from; ?>
				 <textarea <?php if ($focus_field == 'routing_from') print 'autofocus'; ?> id='routing_from' name='routing_from' required><?php if (isset($routing_from)) print $routing_from; ?></textarea><br>
			 </div>

			 <div>
				 <label for='routing_to'>Routing to</label> <span class='red'> *</span>
				 <?php if(isset($msg_routing_to)) print $msg_routing_to; ?>
				 <textarea <?php if ($focus_field == 'routing_to') print 'autofocus'; ?> id='routing_to' name='routing_to' required><?php if (isset($routing_to)) print $routing_to; ?></textarea><br>
			 </div>

			 <div>
				 <label for='routing_notes'>Routing notes</label>             <?php if(isset($msg_routing_notes)) print $msg_routing_notes; ?>
				 <textarea <?php if ($focus_field == 'routing_notes') print 'autofocus'; ?> id='routing_notes' name='routing_notes'><?php if (isset($routing_notes)) print $routing_notes; ?></textarea><br>
			 </div>

			 <div>
				 <label for='dispatcher_notes'>Dispatcher notes</label>             <?php if(isset($msg_dispatcher_notes)) print $msg_dispatcher_notes; ?>
				 <textarea <?php if ($focus_field == 'dispatcher_notes') print 'autofocus'; ?> id='dispatcher_notes' name='dispatcher_notes'><?php if (isset($dispatcher_notes)) print $dispatcher_notes; ?></textarea><br>
			 </div>

		</fieldset>
		
		<fieldset id="trips_fieldset4">

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
				 <div><label for='regular_hours'>Regular (rate, hours, minutes)</label></div>
				 <?php if(isset($msg_regular_hours)) print $msg_regular_hours; ?>
				 <?php if(isset($msg_regular_minutes)) print $msg_regular_minutes; ?>
				 <?php if(isset($msg_hourly_regular_amount)) print $msg_hourly_regular_amount; ?>
				 <input class='input_number_small' <?php if ($focus_field == 'hourly_regular_rate') print 'autofocus'; ?> id='hourly_regular_rate' name='hourly_regular_rate' type='number' onchange='calc();' value='<?php if (isset($hourly_regular_rate)) {print $hourly_regular_rate;} else { print '0';} ?>'> 
				 <input class='input_number_small' <?php if ($focus_field == 'regular_hours') print 'autofocus'; ?> id='regular_hours' name='regular_hours' type='number' onchange='calc();' value='<?php if (isset($regular_hours)) {print $regular_hours;} else { print '0';} ?>'> 
				 <input class='input_number_small' <?php if ($focus_field == 'regular_minutes') print 'autofocus'; ?> id='regular_minutes' name='regular_minutes' type='number' onchange='calc();' value='<?php if (isset($regular_minutes)) {print $regular_minutes;} else { print '0';} ?>'> 
				 <input class='input_number_small' <?php if ($focus_field == 'hourly_regular_amount') print 'autofocus'; ?> id='hourly_regular_amount' name='hourly_regular_amount' type='number' step='any' onchange='calc();' value='<?php if (isset($hourly_regular_amount)) {print $hourly_regular_amount;} else { print '0';} ?>' readonly>
			 </div>

			 <div>
				 <div><label for='wait_hours'>Wait (rate, hours, minutes)</label></div>
				 <?php if(isset($msg_wait_hours)) print $msg_wait_hours; ?>
				 <?php if(isset($msg_wait_minutes)) print $msg_wait_minutes; ?>
				 <?php if(isset($msg_hourly_wait_amount)) print $msg_hourly_wait_amount; ?>
				 <input class='input_number_small' <?php if ($focus_field == 'hourly_wait_rate') print 'autofocus'; ?> id='hourly_wait_rate' name='hourly_wait_rate' type='number' onchange='calc();' value='<?php if (isset($hourly_wait_rate)) {print $hourly_wait_rate;} else { print '0';} ?>'> 
				 <input class='input_number_small' <?php if ($focus_field == 'wait_hours') print 'autofocus'; ?> id='wait_hours' name='wait_hours' type='number' onchange='calc();' value='<?php if (isset($wait_hours)) {print $wait_hours;} else { print '0';} ?>'> 
				 <input class='input_number_small' <?php if ($focus_field == 'wait_minutes') print 'autofocus'; ?> id='wait_minutes' name='wait_minutes' type='number' onchange='calc();' value='<?php if (isset($wait_minutes)) {print $wait_minutes;} else { print '0';} ?>'> 
				 <input class='input_number_small' <?php if ($focus_field == 'hourly_wait_amount') print 'autofocus'; ?> id='hourly_wait_amount' name='hourly_wait_amount' type='number' step='any' onchange='calc();' value='<?php if (isset($hourly_wait_amount)) {print $hourly_wait_amount;} else { print '0';} ?>' readonly> 
			 </div>

			 <div>
				 <div><label for='overtime_hours'>Overtime (rate, hours, minutes)</label></div>
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

		<div class='clear-fix'>
		<input id='save_submit' name='save_submit' type='submit' value='Save'>
		</div>
		</form>


	<?php } ?>

	</main>
	<?php include('php/_footer.php'); ?>

	<script>
		calc();
		set_passenger_id_for_select_address(<?php print $key_customer_passengers; ?>);
	</script>
</body>
</html>
