<?php 
include('php/_code.php');
if (isset($_GET['settingsvehiclemakeid'])) {
	$record_id = trim($_GET['settingsvehiclemakeid']);
	if (!is_numeric($record_id)) die('Invalid record id.');
	$results = mysqli_query($dbcon, "SELECT * FROM settings_vehicle_make_values WHERE key_settings_vehicle_make_values = $record_id");
	if ($row = mysqli_fetch_assoc($results)) {
		$vehicle_make = $row['vehicle_make'];
	} else {
		$message = "<div class='failure-result'>Record not found</div>";
	}
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>SETTINGS - VEHICLE MAKE</title>
    <?php include('php/_head.php'); ?>
</head>
<body id='page-view'>
    <?php if (isset($message)) print $message; ?>
    <main>
        <table class='record-table'>
            <tr>
                <td class='label-cell'>Make</td>
                <td class='value-cell'><?php if (isset($vehicle_make)) print $vehicle_make; ?></td>
            </tr>
        </table>
    </main>
    <?php include('php/_footer.php'); ?>
</body>
</html>