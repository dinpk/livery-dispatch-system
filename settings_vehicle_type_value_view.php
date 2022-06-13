<?php 
include('php/_code.php');
if (isset($_GET['settings_vehicle_type_valuesid'])) {
	$record_id = trim($_GET['settings_vehicle_type_valuesid']);
	if (!is_numeric($record_id)) die('Invalid record id.');
	$results = mysqli_query($dbcon, "SELECT * FROM settings_vehicle_type_values WHERE key_settings_vehicle_type_values = $record_id");
	if ($row = mysqli_fetch_assoc($results)) {
		$vehicle_type = $row['vehicle_type'];
	} else {
		$message = "<div class='failure-result'>Record not found</div>";
	}
}
?>
<!DOCTYPE html>
<html>
<head>
	<title>SETTINGS VEHICLE TYPE VALUES</title>
	<?php include('php/_head.php'); ?>
</head>
<body id='page-view' class='page_view page_settings_vehicle_type_values_view'>

	<?php if (isset($message)) print $message; ?>
	
	<main>
		
     <table class='record-table'>
         <tr>
         <td class='label-cell'>Vehicle type</td>
         <td class='value-cell'><?php if (isset($vehicle_type)) print $vehicle_type; ?></td>
         </tr>

     </table>

	</main>
	<?php include('php/_footer.php'); ?>
</body>
</html>
