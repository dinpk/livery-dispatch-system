<?php 
include('php/_code.php');
if (isset($_GET['settings_trip_type_valuesid'])) {
	$record_id = trim($_GET['settings_trip_type_valuesid']);
	if (!is_numeric($record_id)) die('Invalid record id.');
	$results = mysqli_query($dbcon, "SELECT * FROM settings_trip_type_values WHERE key_settings_trip_type_values = $record_id");
	if ($row = mysqli_fetch_assoc($results)) {
		$trip_type = $row['trip_type'];
	} else {
		$message = "<div class='failure-result'>Record not found</div>";
	}
}
?>
<!DOCTYPE html>
<html>
<head>
	<title>SETTINGS TRIP TYPE VALUES</title>
	<?php include('php/_head.php'); ?>
</head>
<body id='page-view' class='page_view page_settings_trip_type_values_view'>

	<?php if (isset($message)) print $message; ?>
	
	<main>
		
     <table class='record-table'>
         <tr>
         <td class='label-cell'>Trip type</td>
         <td class='value-cell'><?php if (isset($trip_type)) print $trip_type; ?></td>
         </tr>

     </table>

	</main>
	<?php include('php/_footer.php'); ?>
</body>
</html>
