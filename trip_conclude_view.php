<?php 
include('php/_code.php');
if (isset($_GET['tripid'])) {
	$record_id = trim($_GET['tripid']);
	if (!is_numeric($record_id)) die('Invalid record id.');
	$results = mysqli_query($dbcon, "SELECT * FROM trips WHERE key_trips = $record_id");
	if ($row = mysqli_fetch_assoc($results)) {
		$key_customer_invoices = $row['key_customer_invoices'];
		$key_driver_payroll = $row['key_driver_payroll'];
		$key_customer_passengers = $row['key_customer_passengers'];
		$key_customer_contacts = $row['key_customer_contacts'];
		$key_drivers = $row['key_drivers'];
		$key_rates_zones = $row['key_rates_zones'];
		$key_trips = $row['key_trips'];
		$reference_number = $row['reference_number'];
		$passenger_name = $row['passenger_name'];
		$total_passengers = $row['total_passengers'];
		$reserved_by = $row['reserved_by'];
		$pickup_datetime = date('M d, Y - h:ia', strtotime($row['pickup_datetime']));
		$dropoff_datetime = date('M d, Y - h:ia', strtotime($row['dropoff_datetime']));
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
		$rate_type = $row['rate_type'];
		$hourly_rate = $row['hourly_rate'];
		$regular_hours = $row['regular_hours'];
		$regular_minutes = $row['regular_minutes'];
		$regular_hourly_amount = $row['regular_hourly_amount'];
		$wait_hours = $row['wait_hours'];
		$wait_minutes = $row['wait_minutes'];
		$wait_hourly_amount = $row['wait_hourly_amount'];
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
		$total_trip_amount = $row['total_trip_amount'];
		$pay_hourly_rate = $row['pay_hourly_rate'];
		$pay_regular_hours = $row['pay_regular_hours'];
		$pay_regular_minutes = $row['pay_regular_minutes'];
		$pay_wait_percent = $row['pay_wait_percent'];
		$pay_wait_amount = $row['pay_wait_amount'];
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
	} else {
		$message = "<div class='failure-result'>Record not found</div>";
	}
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>TRIPS</title>
    <?php include('php/_head.php'); ?>
</head>
<body id='page-view'>
    <?php if (isset($message)) print $message; ?>
    <main>
        <table class='record-table'>
            <tr>
                <td class='label-cell'>Trip #</td>
                <td class='value-cell'><?php if (isset($key_trips)) print $key_trips; ?></td>
            </tr>
            <tr>
                <td class='label-cell'>Reference #</td>
                <td class='value-cell'><?php if (isset($reference_number)) print $reference_number; ?></td>
            </tr>
            <tr>
                <td class='label-cell'>Passenger name</td>
                <td class='value-cell'><?php if (isset($passenger_name)) print $passenger_name; ?></td>
            </tr>
            <tr>
                <td class='label-cell'>Total passengers</td>
                <td class='value-cell'><?php if (isset($total_passengers)) print $total_passengers; ?></td>
            </tr>

            <tr>
                <td class='label-cell'>Reserved by</td>
                <td class='value-cell'><?php if (isset($reserved_by)) print $reserved_by; ?></td>
            </tr>
            <tr>
                <td class='label-cell'>Pickup date time</td>
                <td class='value-cell'><?php if (isset($pickup_datetime)) print $pickup_datetime; ?></td>
            </tr>
            <tr>
                <td class='label-cell'>Dropoff date time</td>
                <td class='value-cell'><?php if (isset($dropoff_datetime)) print $dropoff_datetime; ?></td>
            </tr>

            <tr>
                <td class='label-cell'>Trip type</td>
                <td class='value-cell'><?php if (isset($trip_type)) print $trip_type; ?></td>
            </tr>
            <tr>
                <td class='label-cell'>Trip status</td>
                <td class='value-cell'><?php if (isset($trip_status)) print $trip_status; ?></td>
            </tr>
            <tr>
                <td class='label-cell'>Driver name</td>
                <td class='value-cell'><?php if (isset($driver_name)) print $driver_name; ?></td>
            </tr>
            <tr>
                <td class='label-cell'>Vehicle</td>
                <td class='value-cell'><?php if (isset($vehicle)) print $vehicle; ?></td>
            </tr>
            <tr>
                <td class='label-cell'>Airline</td>
                <td class='value-cell'><?php if (isset($airline)) print $airline; ?></td>
            </tr>
            <tr>
                <td class='label-cell'>Flight #</td>
                <td class='value-cell'><?php if (isset($flight_number)) print $flight_number; ?></td>
            </tr>
            <tr>
                <td class='label-cell'>Zone from</td>
                <td class='value-cell'><?php if (isset($zone_from)) print $zone_from; ?></td>
            </tr>
            <tr>
                <td class='label-cell'>Zone to</td>
                <td class='value-cell'><?php if (isset($zone_to)) print $zone_to; ?></td>
            </tr>
            <tr>
                <td class='label-cell'>Routing from</td>
                <td class='value-cell'><?php if (isset($routing_from)) print $routing_from; ?></td>
            </tr>
            <tr>
                <td class='label-cell'>Routing to</td>
                <td class='value-cell'><?php if (isset($routing_to)) print $routing_to; ?></td>
            </tr>
            <tr>
                <td class='label-cell'>Routing notes</td>
                <td class='value-cell'><?php if (isset($routing_notes)) print $routing_notes; ?></td>
            </tr>
            <tr>
                <td class='label-cell'>Rate type</td>
                <td class='value-cell'><?php if (isset($rate_type)) print $rate_type; ?></td>
            </tr>
            <tr>
                <td class='label-cell'>Hourly rate</td>
                <td class='value-cell'><?php if (isset($hourly_rate)) print $hourly_rate; ?></td>
            </tr>
            <tr>
                <td class='label-cell'>Regular hours</td>
                <td class='value-cell'><?php if (isset($regular_hours)) print $regular_hours; ?></td>
            </tr>
            <tr>
                <td class='label-cell'>Regular minutes</td>
                <td class='value-cell'><?php if (isset($regular_minutes)) print $regular_minutes; ?></td>
            </tr>
            <tr>
                <td class='label-cell'>Regular hourly amount</td>
                <td class='value-cell'><?php if (isset($regular_hourly_amount)) print $regular_hourly_amount; ?></td>
            </tr>
            <tr>
                <td class='label-cell'>Wait hours</td>
                <td class='value-cell'><?php if (isset($wait_hours)) print $wait_hours; ?></td>
            </tr>
            <tr>
                <td class='label-cell'>Wait minutes</td>
                <td class='value-cell'><?php if (isset($wait_minutes)) print $wait_minutes; ?></td>
            </tr>
            <tr>
                <td class='label-cell'>Wait hourly amount</td>
                <td class='value-cell'><?php if (isset($wait_hourly_amount)) print $wait_hourly_amount; ?></td>
            </tr>
            <tr>
                <td class='label-cell'>Zone rate</td>
                <td class='value-cell'><?php if (isset($zone_rate)) print $zone_rate; ?></td>
            </tr>
            <tr>
                <td class='label-cell'>Base amount</td>
                <td class='value-cell'><?php if (isset($base_amount)) print $base_amount; ?></td>
            </tr>
            <tr>
                <td class='label-cell'>Offtime type</td>
                <td class='value-cell'><?php if (isset($offtime_type)) print $offtime_type; ?></td>
            </tr>
            <tr>
                <td class='label-cell'>Offtime amount</td>
                <td class='value-cell'><?php if (isset($offtime_amount)) print $offtime_amount; ?></td>
            </tr>
            <tr>
                <td class='label-cell'>Extra stops</td>
                <td class='value-cell'><?php if (isset($extra_stops)) print $extra_stops; ?></td>
            </tr>
            <tr>
                <td class='label-cell'>Extra stops amount</td>
                <td class='value-cell'><?php if (isset($extra_stops_amount)) print $extra_stops_amount; ?></td>
            </tr>
            <tr>
                <td class='label-cell'>Toll type</td>
                <td class='value-cell'><?php if (isset($toll_type)) print $toll_type; ?></td>
            </tr>
            <tr>
                <td class='label-cell'>Tolls amount</td>
                <td class='value-cell'><?php if (isset($tolls_amount)) print $tolls_amount; ?></td>
            </tr>
            <tr>
                <td class='label-cell'>Parking amount</td>
                <td class='value-cell'><?php if (isset($parking_amount)) print $parking_amount; ?></td>
            </tr>

            <tr>
                <td class='label-cell'>Gratuity %</td>
                <td class='value-cell'><?php if (isset($gratuity_percent)) print $gratuity_percent; ?></td>
            </tr>
            <tr>
                <td class='label-cell'>Gratuity amount</td>
                <td class='value-cell'><?php if (isset($gratuity_amount)) print $gratuity_amount; ?></td>
            </tr>
            <tr>
                <td class='label-cell'>Gas surcharge %</td>
                <td class='value-cell'><?php if (isset($gas_surcharge_percent)) print $gas_surcharge_percent; ?></td>
            </tr>

            <tr>
                <td class='label-cell'>Gas surcharge amount</td>
                <td class='value-cell'><?php if (isset($gas_surcharge_amount)) print $gas_surcharge_amount; ?></td>
            </tr>
            <tr>
                <td class='label-cell'>Admin fee %</td>
                <td class='value-cell'><?php if (isset($admin_fee_percent)) print $admin_fee_percent; ?></td>
            </tr>
            <tr>
                <td class='label-cell'>Admin fee amount</td>
                <td class='value-cell'><?php if (isset($admin_fee_amount)) print $admin_fee_amount; ?></td>
            </tr>
            <tr>
                <td class='label-cell'>Discount %</td>
                <td class='value-cell'><?php if (isset($discount_percent)) print $discount_percent; ?></td>
            </tr>
            <tr>
                <td class='label-cell'>Discount amount</td>
                <td class='value-cell'><?php if (isset($discount_amount)) print $discount_amount; ?></td>
            </tr>
            <tr>
                <td class='label-cell'>Tax %</td>
                <td class='value-cell'><?php if (isset($tax_percent)) print $tax_percent; ?></td>
            </tr>
            <tr>
                <td class='label-cell'>Tax amount</td>
                <td class='value-cell'><?php if (isset($tax_amount)) print $tax_amount; ?></td>
            </tr>
            <tr>
                <td class='label-cell'>Total trip amount</td>
                <td class='value-cell'><?php if (isset($total_trip_amount)) print $total_trip_amount; ?></td>
            </tr>
        </table>
    </main>
    <?php include('php/_footer.php'); ?>
</body>
</html>