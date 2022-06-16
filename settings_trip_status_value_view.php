<?php 
include('php/_code.php');
if (isset($_GET['settingstripstatusid'])) {
	$record_id = trim($_GET['settingstripstatusid']);
	if (!is_numeric($record_id)) die('Invalid record id.');
	$results = mysqli_query($dbcon, "SELECT * FROM settings_trip_status_values WHERE key_settings_trip_status_values = $record_id");
	if ($row = mysqli_fetch_assoc($results)) {
		$trip_status = $row['trip_status'];
		$text_color = $row['text_color'];
		$back_color = $row['back_color'];
	} else {
		$message = "<div class='failure-result'>Record not found</div>";
	}
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>SETTINGS - TRIP STATUS</title>
    <?php include('php/_head.php'); ?>
</head>
<body id='page-view'>
    <?php if (isset($message)) print $message; ?>
    <main>
        <table class='record-table'>
            <tr>
                <td class='label-cell'>Trip status</td>
                <td class='value-cell'><?php if (isset($trip_status)) print $trip_status; ?></td>
            </tr>
            <tr>
                <td class='label-cell'>Text color</td>
                <td class='value-cell'><?php if (isset($text_color)) print $text_color; ?></td>
            </tr>
            <tr>
                <td class='label-cell'>Back color</td>
                <td class='value-cell'><?php if (isset($back_color)) print $back_color; ?></td>
            </tr>
        </table>
    </main>
    <?php include('php/_footer.php'); ?>
</body>
</html>