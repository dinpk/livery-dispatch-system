<?php 
include('php/_code.php');
if (isset($_GET['tripid'])) {
	$record_id = trim($_GET['tripid']);
	if (!is_numeric($record_id)) die('Invalid record id.');
	$results = mysqli_query($dbcon, "SELECT * FROM trips WHERE key_trips = $record_id");
	if ($row = mysqli_fetch_assoc($results)) {
		$key_drivers = $row['key_drivers'];
		$key_trips = $row['key_trips'];
		$passenger_name = $row['passenger_name'];
		$total_passengers = $row['total_passengers'];
		$pickup_datetime = date('M d, Y - h:ia', strtotime($row['pickup_datetime']));
		$driver_name = $row['driver_name'];
		$airline = $row['airline'];
		$flight_number = $row['flight_number'];
		$zone_from = $row['zone_from'];
		$zone_to = $row['zone_to'];
		$routing_from = $row['routing_from'];
		$routing_to = $row['routing_to'];
		$routing_notes = $row['routing_notes'];
	} else {
		$message = "<div class='failure-result'>Record not found</div>";
	}
	$results = mysqli_query($dbcon, "SELECT first_name, last_name, email FROM drivers WHERE key_drivers = $key_drivers");
	if ($row = mysqli_fetch_assoc($results)) {
		$driver_email = $row['email'];
	}
	if (isset($_POST['view_submit'])) {
		$subject = "Dispatch trip # " . $key_trips;
		$email_body = "
			<div class='center' style='line-height:80%'>
				<h1 style='line-height:110%'>Trip # $key_trips</h1>
				<h3>Passenger name</h3>
					<div>$passenger_name</div>
				<h3>Total passengers</h3>
					<div>$total_passengers</div>
				<h3>Date Time</h3>
					<div>" . date('M d, Y - h:ia', strtotime($row['pickup_datetime'])) . "</div>
				<h3>Zone</h3>
					<div>$zone_from > $zone_to</div>
				<h3>From</h3>
					<div>$routing_from</div>
				<h3>To</h3>
					<div>$routing_to</div>
				<h3>Flight</h3>
					<div>$airline - $flight_number</div>
				<h3>Notes</h3>
					<div>$routing_notes</div>
			</div>
		";
		if (send_email($driver_email, $subject, $email_body)) {
			$message = "<div class='success-result'>Email has been sent.</div>";
		} else {
			$message = "<div class='failure-result'>Could not send email, please try again later.</div>";
		}		
	}
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>TRIP - DISPATCH</title>
    <?php include('php/_head.php'); ?>
</head>
<body id='page-view'>
    <?php if (isset($message)) print $message; ?>
    <main>
        <?php 
		print "
		<form class='center' method='post'>
			<h1>Dispatch trip # $key_trips</h1>
			<h2>$driver_name</h2>
			<p>$driver_email</p>
			<p><input type='submit' name='view_submit' id='view_submit' value='Dispatch'></p>
		</form>
		<br>
		";
		?>
        <table class='record-table'>
            <tr>
                <td class='label-cell'>Trip #</td>
                <td class='value-cell'><?php print $key_trips; ?></td>
            </tr>
            <tr>
                <td class='label-cell'>Passenger name</td>
                <td class='value-cell'><?php print $passenger_name; ?></td>
            </tr>
            <tr>
                <td class='label-cell'>Total passengers</td>
                <td class='value-cell'><?php print $total_passengers; ?></td>
            </tr>
            <tr>
                <td class='label-cell'>Date Time</td>
                <td class='value-cell'><?php print $pickup_datetime; ?></td>
            </tr>
            <tr>
                <td class='label-cell'>Flight</td>
                <td class='value-cell'><?php print $airline . ' ' . $flight_number; ?></td>
            </tr>
            <tr>
                <td class='label-cell'>Zone</td>
                <td class='value-cell'><?php print $zone_from . ' > ' . $zone_to; ?></td>
            </tr>
            <tr>
                <td class='label-cell'>From</td>
                <td class='value-cell'><?php print $routing_from; ?></td>
            </tr>
            <tr>
                <td class='label-cell'>To</td>
                <td class='value-cell'><?php print $routing_to; ?></td>
            </tr>
            <tr>
                <td class='label-cell'>Notes</td>
                <td class='value-cell'><?php print $routing_notes; ?></td>
            </tr>
        </table>
    </main>
    <?php include('php/_footer.php'); ?>
</body>
</html>