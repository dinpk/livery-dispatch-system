<?php 
include('php/_code.php');
if (isset($_GET['settingsofftimetypeid'])) {
	$record_id = trim($_GET['settingsofftimetypeid']);
	if (!is_numeric($record_id)) die('Invalid record id.');
	$results = mysqli_query($dbcon, "SELECT * FROM settings_offtime_type_values WHERE key_settings_offtime_type_values = $record_id");
	if ($row = mysqli_fetch_assoc($results)) {
		$offtime_type = $row['offtime_type'];
	} else {
		$message = "<div class='failure-result'>Record not found</div>";
	}
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>SETTINGS - OFFTIME TYPE</title>
    <?php include('php/_head.php'); ?>
</head>
<body id='page-view'>
    <?php if (isset($message)) print $message; ?>
    <main>
        <table class='record-table'>
            <tr>
                <td class='label-cell'>Off-time type</td>
                <td class='value-cell'><?php if (isset($offtime_type)) print $offtime_type; ?></td>
            </tr>
        </table>
    </main>
    <?php include('php/_footer.php'); ?>
</body>
</html>