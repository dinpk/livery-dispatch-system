<?php 
include('php/_code.php');
if (isset($_GET['settingsadsourceid'])) {
	$record_id = trim($_GET['settingsadsourceid']);
	if (!is_numeric($record_id)) die('Invalid record id.');
	$results = mysqli_query($dbcon, "SELECT * FROM settings_ad_source_values WHERE key_settings_ad_source_values = $record_id");
	if ($row = mysqli_fetch_assoc($results)) {
		$ad_source = $row['ad_source'];
	} else {
		$message = "<div class='failure-result'>Record not found</div>";
	}
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>SETTINGS AD SOURCE</title>
    <?php include('php/_head.php'); ?>
</head>
<body id='page-view'>
    <?php if (isset($message)) print $message; ?>
    <main>
        <table class='record-table'>
            <tr>
                <td class='label-cell'>Ad source</td>
                <td class='value-cell'><?php if (isset($ad_source)) print $ad_source; ?></td>
            </tr>

        </table>
    </main>
    <?php include('php/_footer.php'); ?>
</body>
</html>