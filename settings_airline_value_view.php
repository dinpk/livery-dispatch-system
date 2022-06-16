<?php 
include('php/_code.php');
if (isset($_GET['settingsairlineid'])) {
	$record_id = trim($_GET['settingsairlineid']);
	if (!is_numeric($record_id)) die('Invalid record id.');
	$dbcon = db_connection();
	$results = mysqli_query($dbcon, "SELECT * FROM settings_airline_values WHERE key_settings_airline_values = $record_id");
	if ($row = mysqli_fetch_assoc($results)) {
		$airline = $row['airline'];
	} else {
		$message = "<div class='failure-result'>Record not found</div>";
	}
	
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>SETTINGS AIRLINE</title>
    <?php include('php/_head.php'); ?>
</head>
<body id='page-view'>
    <?php if (isset($message)) print $message; ?>
    <main>
        <table class='record-table'>
            <tr>
                <td class='label-cell'>Airline</td>
                <td class='value-cell'><?php if (isset($airline)) print $airline; ?></td>
            </tr>
        </table>
    </main>
    <?php include('php/_footer.php'); ?>
</body>
</html>