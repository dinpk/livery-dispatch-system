<?php 
include('php/_code.php');
if (isset($_GET['settingsdispatchareaid'])) {
	$record_id = trim($_GET['settingsdispatchareaid']);
	if (!is_numeric($record_id)) die('Invalid record id.');
	$results = mysqli_query($dbcon, "SELECT * FROM settings_dispatch_area_values WHERE key_settings_dispatch_area_values = $record_id");
	if ($row = mysqli_fetch_assoc($results)) {
		$dispatch_area = $row['dispatch_area'];
	} else {
		$message = "<div class='failure-result'>Record not found</div>";
	}
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>SETTINGS DISPATCH AREA</title>
    <?php include('php/_head.php'); ?>
</head>
<body id='page-view'>
    <?php if (isset($message)) print $message; ?>
    <main>
        <table class='record-table'>
            <tr>
                <td class='label-cell'>Dispatch area</td>
                <td class='value-cell'><?php if (isset($dispatch_area)) print $dispatch_area; ?></td>
            </tr>
        </table>
    </main>
    <?php include('php/_footer.php'); ?>
</body>
</html>