<?php 
include('php/_code.php');
$show_record = true;
if (isset($_GET['tripid'])) {
	$record_id = trim($_GET['tripid']);
	if (!is_numeric($record_id)) die('Invalid record id.');
	if (isset($_GET['delete'])) {
		$results = mysqli_query($dbcon, "DELETE FROM trips WHERE key_trips = $record_id");
		if ($results) {
			$message = "<div class='success-result'>Deleted successfully</div>
			<div class='center'><br><br><input type='button' value='Close' onclick='parent.location.reload(false);'></div>";
			$show_record = false;
		} else {
			$message = "<div class='failure-result'>Could not delete record</div>";
		}
	} else {
		$results = mysqli_query($dbcon, "SELECT key_trips, reference_number, passenger_name, total_passengers, reserved_by, pickup_datetime, driver_name, vehicle, zone_from, zone_to FROM trips WHERE key_trips = $record_id");
		if ($row = mysqli_fetch_assoc($results)) {
			$key_trips = $row['key_trips'];
			$reference_number = $row['reference_number'];
			$passenger_name = $row['passenger_name'];
			$total_passengers = $row['total_passengers'];
			$reserved_by = $row['reserved_by'];
			$pickup_datetime = date('M d, Y - h:ia', strtotime($row['pickup_datetime']));
			$driver_name = $row['driver_name'];
			$vehicle = $row['vehicle'];
			$zone_from = $row['zone_from'];
			$zone_to = $row['zone_to'];

		} else {
			$message = "<div class='failure-result'>Record not found</div>";
		}
	}
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>TRIP</title>
    <?php include('php/_head.php'); ?>
</head>
<body id='page-delete'>
    <?php if (isset($message)) print $message; ?>
    <?php if ($show_record) { ?>
    <main>
        <div class='center'>
            <p class='red'><b>Do you really want to delete trip # <?php print $key_trips; ?> ?</b></p>
            <p>
                <br>
                <a class='button-big' href='<?php print $_SERVER['REQUEST_URI']; ?>&delete=1'>Delete</a> &nbsp
                <a class='button-big' href='#' onclick='parent.location.reload(false);'>Cancel</a><br>
            </p>
            <br>
            <hr><br>
        </div>
        <table class='record-table'>
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
                <td class='label-cell'>Driver name</td>
                <td class='value-cell'><?php if (isset($driver_name)) print $driver_name; ?></td>
            </tr>
            <tr>
                <td class='label-cell'>Vehicle</td>
                <td class='value-cell'><?php if (isset($vehicle)) print $vehicle; ?></td>
            </tr>
            <tr>
                <td class='label-cell'>Zone from</td>
                <td class='value-cell'><?php if (isset($zone_from)) print $zone_from; ?></td>
            </tr>
            <tr>
                <td class='label-cell'>Zone to</td>
                <td class='value-cell'><?php if (isset($zone_to)) print $zone_to; ?></td>
            </tr>
        </table>
    </main>
    <?php } // show_record ?>
    <?php include('php/_footer.php'); ?>
</body>
</html>