<?php 
include('php/_code.php');
if (isset($_GET['settingsvehiclemodelid'])) {
	$record_id = trim($_GET['settingsvehiclemodelid']);
	if (!is_numeric($record_id)) die('Invalid record id.');
	$results = mysqli_query($dbcon, "SELECT * FROM settings_vehicle_model_values WHERE key_settings_vehicle_model_values = $record_id");
	if ($row = mysqli_fetch_assoc($results)) {
		$vehicle_model = $row['vehicle_model'];
	} else {
		$message = "<div class='failure-result'>Record not found</div>";
	}
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>SETTINGS - VEHICLE MODEL</title>
    <?php include('php/_head.php'); ?>
</head>
<body id='page-view'>
    <?php if (isset($message)) print $message; ?>
    <main>
        <table class='record-table'>
            <tr>
                <td class='label-cell'>Model</td>
                <td class='value-cell'><?php if (isset($vehicle_model)) print $vehicle_model; ?></td>
            </tr>
        </table>
    </main>
    <?php include('php/_footer.php'); ?>
</body>
</html>