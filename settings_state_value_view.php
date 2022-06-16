<?php 
include('php/_code.php');
if (isset($_GET['settingsstateid'])) {
	$record_id = trim($_GET['settingsstateid']);
	if (!is_numeric($record_id)) die('Invalid record id.');
	$results = mysqli_query($dbcon, "SELECT * FROM settings_state_values WHERE key_settings_state_values = $record_id");
	if ($row = mysqli_fetch_assoc($results)) {
		$state = $row['state'];
		$state_code = $row['state_code'];
	} else {
		$message = "<div class='failure-result'>Record not found</div>";
	}
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>SETTINGS - STATE</title>
    <?php include('php/_head.php'); ?>
</head>
<body id='page-view'>
    <?php if (isset($message)) print $message; ?>
    <main>
        <table class='record-table'>
            <tr>
                <td class='label-cell'>State</td>
                <td class='value-cell'><?php if (isset($state)) print $state; ?></td>
            </tr>
            <tr>
                <td class='label-cell'>State code</td>
                <td class='value-cell'><?php if (isset($state_code)) print $state_code; ?></td>
            </tr>
        </table>
    </main>
    <?php include('php/_footer.php'); ?>
</body>
</html>