<?php 
include('php/_code.php');
if (isset($_GET['tripsid'])) {
	$record_id = trim($_GET['tripsid']);
	if (!is_numeric($record_id)) die('Invalid record id.');
	$results = mysqli_query($dbcon, "SELECT * FROM trips WHERE key_trips = $record_id");
	if ($row = mysqli_fetch_assoc($results)) {
		$key_customer_passengers = $row['key_customer_passengers'];
		$key_trips = $row['key_trips'];
		$passenger_name = $row['passenger_name'];
		$reserved_by = $row['reserved_by'];
		$total_passengers = $row['total_passengers'];
		$pickup_datetime = date('M d, Y - h:ia', strtotime($row['pickup_datetime']));
		$airline = $row['airline'];
		$flight_number = $row['flight_number'];
		$routing_from = $row['routing_from'];
		$routing_to = $row['routing_to'];
		$total_trip_amount = $row['total_trip_amount'];
	} else {
		$message = "<div class='failure-result'>Record not found</div>";
	}
	$results = mysqli_query($dbcon, "SELECT first_name, last_name, email FROM customer_passengers WHERE key_customer_passengers = $key_customer_passengers");
	if ($row = mysqli_fetch_assoc($results)) {
		$passenger_email = $row['email'];
	}
	if (isset($_POST['view_submit'])) {

		$subject = "Confirmation of trip # " . $key_trips;
		$email_body = "
			<div class='center' style='line-height:80%'>
				<h1 style='line-height:110%'>Trip Confirmation # $key_trips</h1>
				<h3>Passenger name</h3>
					<div>$passenger_name</div>
				<h3>Total passengers</h3>
					<div>$total_passengers</div>
				<h3>Reserved by</h3>
					<div>$reserved_by</div>
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
				<h3>Estimated charges</h3>
					<div>$total_trip_amount</div>
			</div>
		";
		
		if (send_email($passenger_email, $subject, $email_body)) {
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
	<title>TRIP CONFIRMATION</title>
	<?php include('php/_head.php'); ?>
</head>
<body id='page-view' class='page_view page_trips_view'>

	<?php if (isset($message)) print $message; ?>
	
	<main>
	<?php 
		print "
		
		<form class='center' method='post'>
			<h1>Confirmation # $key_trips</h1>
			<h2>$driver_name</h2>
			<p>$driver_email</p>
			<p><input type='submit' name='view_submit' id='view_submit' value='Send Confirmation'></p>
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
         <td class='label-cell'>Reserved by</td>
         <td class='value-cell'><?php print $reserved_by; ?></td>
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
         <td class='label-cell'>From</td>
         <td class='value-cell'><?php print $routing_from; ?></td>
         </tr>

         <tr>
         <td class='label-cell'>To</td>
         <td class='value-cell'><?php print $routing_to; ?></td>
         </tr>
		 
         <tr>
         <td class='label-cell'>Estimated charges</td>
         <td class='value-cell'><?php print $total_trip_amount; ?></td>
         </tr>

     </table>

	</main>
	<?php include('php/_footer.php'); ?>
</body>
</html>
