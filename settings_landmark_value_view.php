<?php 
include('php/_code.php');
if (isset($_GET['settingslandmarkid'])) {
	$record_id = trim($_GET['settingslandmarkid']);
	if (!is_numeric($record_id)) die('Invalid record id.');
	$results = mysqli_query($dbcon, "SELECT * FROM settings_landmark_values WHERE key_settings_landmark_values = $record_id");
	if ($row = mysqli_fetch_assoc($results)) {
		$category = $row['category'];
	} else {
		$message = "<div class='failure-result'>Record not found</div>";
	}
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>SETTINGS - LANDMARK</title>
    <?php include('php/_head.php'); ?>
</head>
<body id='page-view'>
    <?php if (isset($message)) print $message; ?>
    <main>
        <table class='record-table'>
            <tr>
                <td class='label-cell'>Category</td>
                <td class='value-cell'><?php if (isset($category)) print $category; ?></td>
            </tr>
        </table>
    </main>
    <?php include('php/_footer.php'); ?>
</body>
</html>