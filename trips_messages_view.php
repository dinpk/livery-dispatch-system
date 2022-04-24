<?php 
include('php/_code.php');
if (isset($_GET['trips_messagesid'])) {
	$record_id = trim($_GET['trips_messagesid']);
	if (!is_numeric($record_id)) die('Invalid record id.');
	$results = mysqli_query($dbcon, "SELECT * FROM trips_messages WHERE key_trips_messages = $record_id");
	if ($row = mysqli_fetch_assoc($results)) {
		$key_trips = $row['key_trips'];
		$key_drivers = $row['key_drivers'];
		$key_staff = $row['key_staff'];
		$date_time = $row['date_time'];
		$message = $row['message'];
	} else {
		$message = "<div class='failure-result'>Record not found</div>";
	}
}
?>
<!DOCTYPE html>
<html>
<head>
	<title>TRIPS MESSAGES</title>
	<?php include('php/_head.php'); ?>
</head>
<body id='page-view' class='page_view page_trips_messages_view'>

	<?php if (isset($message)) print $message; ?>
	
	<main>
		
     <table class='record-table'>
         <tr>
         <td class='label-cell'>Date time</td>
         <td class='value-cell'><?php if (isset($date_time)) print $date_time; ?></td>
         </tr>

         <tr>
         <td class='label-cell'>Message</td>
         <td class='value-cell'><?php if (isset($message)) print $message; ?></td>
         </tr>

     </table>

	</main>
	<?php include('php/_footer.php'); ?>
</body>
</html>
