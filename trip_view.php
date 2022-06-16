<?php 
include('php/_code.php');
if (isset($_GET['tripid'])) {
	$record_id = trim($_GET['tripid']);
	if (!is_numeric($record_id)) die('Invalid record id.');
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
	}
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>TRIP - VIEW</title>
    <?php include('php/_head.php'); ?>
</head>
<body id='page-view'>
    <?php if (isset($message)) print $message; ?>
    <main>
        <div class="flex">
            <section>
                <div class="view_label">Trip #</div>
                <div class="view_h1"><?php print $key_trips; ?></div>
                <br>
                <?php
                    if (!empty($reference_number)) {
                        print "
                            <div class='view_label'>Reference #</div>
                            <div class='view_h3'>$reference_number</div><br>
                        ";
                    }
                ?>
                <div class="view_label">Passenger</div>
                <div class="view_h1"><?php print $passenger_name; ?></div>
                <div class="view_h3">(<?php print $total_passengers; ?>)</div>
                <br>
                <div class="view_label">Pickup</div>
                <div class="view_h1"><?php print date("M d, Y", strtotime($pickup_date)); ?></div>
                <div class="view_h2"><?php print $pickup_time; ?></div>
                <br>
                <div class="view_label">Status</div>
                <div class="view_h1"><?php print $trip_status; ?></div>
                <br>
                <hr>
                <br>
                <div class="view_label">Drop-off</div>
                <div class="view_h4"><?php print date("M d, Y", strtotime($dropoff_date)); ?>
                    (<?php print $dropoff_time; ?>)</div>
                <br>
                <?php
                    if (!empty($reserved_by)) {
                        print "
                            <div class='view_label'>Reserved by</div>
                            <div class='view_h3'>$reserved_by</div><br>
                        ";
                    }
                ?>
                <div class="view_label">Trip type</div>
                <div class="view_h3"><?php print $trip_type; ?></div>
            </section>
            <section style="max-width:40%;">
                <div class="view_label">Driver</div>
                <div class="view_h1"><?php print $driver_name; ?></div>
                <br>
                <div class="view_label">Vehicle</div>
                <div class="view_h3"><?php print $vehicle; ?></div>
                <br>
                <?php
                    if (!empty($flight_number)) {
                        print "
                            <div class='view_label'>Flight</div>
                            <div class='view_h3'>$flight_number — $airline</div><br>
                        ";
                    }
                ?>
                <div class="view_label">Zone</div>
                <div class="view_h3"><?php print $zone_from; ?> &nbsp;⇒&nbsp; <?php print $zone_to; ?></div>
                <br>
                <div class="view_label">From</div>
                <div class="view_h4"><?php print $routing_from; ?></div>
                <br>
                <div class="view_label">To</div>
                <div class="view_h4"><?php print $routing_to; ?></div>
                <br>
                <?php
                    if (!empty($routing_notes)) {
                        print "
                            <div class='view_label'>Notes</div>
                            <div class='view_h3'>$routing_notes</div><br>
                        ";
                    }
                ?>
            </section>
            <section>
                <table>
                    <tr>
                        <td colspan="2">Rate type</td>
                        <td><?php print $rate_type; ?></td>
                    </tr>
                    <tr>
                        <td colspan="3">
                            <hr>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2">Zone rate</td>
                        <td><?php print number_format($zone_rate, 2); ?></td>
                    </tr>
                    <tr>
                        <td colspan="3">
                            <hr>
                        </td>
                    </tr>
                    <?php if ($hourly_regular_amount > 0) { ?>
                    <tr>
                        <td colspan="2">Regular hourly rate</td>
                        <td><?php print number_format($hourly_regular_rate, 2); ?></td>
                    </tr>
                    <tr>
                        <td colspan="2">Regular hourly time</td>
                        <td><?php print $regular_hours . ":" . $regular_minutes; ?></td>
                    </tr>
                    <tr>
                        <td colspan="2">Regular hourly amount</td>
                        <td><?php print number_format($hourly_regular_amount, 2); ?></td>
                    </tr>
                    <tr>
                        <td colspan="3">
                            <hr>
                        </td>
                    </tr>
                    <?php } ?>
                    <?php if ($hourly_wait_amount > 0) { ?>
                    <tr>
                        <td colspan="2">Wait hourly rate</td>
                        <td><?php print number_format($hourly_wait_rate, 2); ?></td>
                    </tr>
                    <tr>
                        <td colspan="2">Wait hourly time</td>
                        <td><?php print $wait_hours . ":" . $wait_minutes; ?></td>
                    </tr>
                    <tr>
                        <td colspan="2">Wait hourly amount</td>
                        <td><?php print number_format($hourly_wait_amount, 2); ?></td>
                    </tr>
                    <tr>
                        <td colspan="3">
                            <hr>
                        </td>
                    </tr>
                    <?php } ?>
                    <?php if ($hourly_overtime_amount > 0) { ?>
                    <tr>
                        <td colspan="2">Overtime hourly rate</td>
                        <td><?php print number_format($hourly_overtime_rate, 2); ?></td>
                    </tr>
                    <tr>
                        <td colspan="2">Overtime hourly time</td>
                        <td><?php print $overtime_hours . ":" . $overtime_minutes; ?></td>
                    </tr>
                    <tr>
                        <td colspan="2">Overtime hourly amount</td>
                        <td><?php print number_format($hourly_overtime_amount, 2); ?></td>
                    </tr>
                    <tr>
                        <td colspan="3">
                            <hr>
                        </td>
                    </tr>
                    <?php } ?>
                    <tr>
                        <td colspan="2">Base amount</td>
                        <td><?php print number_format($base_amount, 2); ?></td>
                    </tr>
                    <tr>
                        <td colspan="3">
                            <hr>
                        </td>
                    </tr>
                    <?php if ($offtime_amount > 0) { ?>
                    <tr>
                        <td>Off-time</td>
                        <td><?php print $offtime_type; ?></td>
                        <td><?php print number_format($offtime_amount, 2); ?></td>
                    </tr>
                    <?php } ?>
                    <?php if ($extra_stops_amount > 0) { ?>
                    <tr>
                        <td>Extra stops</td>
                        <td><?php print $extra_stops; ?></td>
                        <td><?php print number_format($extra_stops_amount, 2); ?></td>
                    </tr>
                    <?php } ?>
                    <?php if ($tolls_amount > 0) { ?>
                    <tr>
                        <td>Tolls</td>
                        <td><?php print $toll_type; ?></td>
                        <td><?php print number_format($tolls_amount, 2); ?></td>
                    </tr>
                    <?php } ?>
                    <?php if ($parking_amount > 0) { ?>
                    <tr>
                        <td colspan="2">Parking</td>
                        <td><?php print number_format($parking_amount, 2); ?></td>
                    </tr>
                    <?php } ?>
                    <?php if ($gratuity_amount > 0) { ?>
                    <tr>
                        <td>Gratuity</td>
                        <td><?php print $gratuity_percent; ?>%</td>
                        <td><?php print number_format($gratuity_amount, 2); ?></td>
                    </tr>
                    <?php } ?>
                    <?php if ($gas_surcharge_amount > 0) { ?>
                    <tr>
                        <td>Gas surcharge</td>
                        <td><?php print $gas_surcharge_percent; ?>%</td>
                        <td><?php print number_format($gas_surcharge_amount, 2); ?></td>
                    </tr>
                    <?php } ?>
                    <?php if ($admin_fee_amount > 0) { ?>
                    <tr>
                        <td>Admin fee</td>
                        <td><?php print $admin_fee_percent; ?>%</td>
                        <td><?php print number_format($admin_fee_amount, 2); ?></td>
                    </tr>
                    <?php } ?>
                    <?php if ($discount_amount > 0) { ?>
                    <tr>
                        <td>Discount</td>
                        <td><?php print $discount_percent; ?>%</td>
                        <td><?php print number_format($discount_amount, 2); ?></td>
                    </tr>
                    <?php } ?>
                    <?php if ($tax_amount > 0) { ?>
                    <tr>
                        <td>Tax</td>
                        <td><?php print $tax_percent; ?>%</td>
                        <td><?php print number_format($tax_amount, 2); ?></td>
                    </tr>
                    <?php } ?>
                    <tr>
                        <td colspan="3">
                            <hr>
                        </td>
                    </tr>
                    <?php if ($trip_extra_charges > 0) { ?>
                    <tr>
                        <td colspan="2">Extra charges</td>
                        <td><?php print number_format($trip_extra_charges, 2); ?></td>
                    </tr>
                    <?php } ?>
                    <?php if ($flat_amount > 0) { ?>
                    <tr>
                        <td colspan="2">Flat amount</td>
                        <td><?php print number_format($flat_amount, 2); ?></td>
                    </tr>
                    <?php } ?>
                    <tr>
                        <td colspan="3">
                            <hr>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2">
                            <div class="view_h2 view_label">Total trip amount</div>
                        </td>
                        <td>
                            <div class="view_h1"><?php print number_format($total_trip_amount, 2); ?></div>
                        </td>
                    </tr>
                </table>
            </section>
        </div>
    </main>
    <?php include('php/_footer.php'); ?>
</body>
</html>