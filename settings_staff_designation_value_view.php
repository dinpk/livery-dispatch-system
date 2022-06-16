<?php 
include('php/_code.php');
if (isset($_GET['settingsstaffdesignationid'])) {
	$record_id = trim($_GET['settingsstaffdesignationid']);
	if (!is_numeric($record_id)) die('Invalid record id.');
	$dbcon = db_connection();
	$results = mysqli_query($dbcon, "SELECT * FROM `settings_staff_designation_values` WHERE `key_settings_staff_designation_values` = $record_id");
	if ($row = mysqli_fetch_assoc($results)) {
			$designation = $row['designation'];
	} else {
		$message = "<div class='failure-result'>Record not found</div>";
	}
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>SETTINGS - STAFF DESIGNATION</title>
    <?php include('php/_head.php'); ?>
</head>
<body id='page-view'>
    <?php if (isset($message)) print $message; ?>
    <main>
        <table class='record-table'>
            <tr>
                <td class='label-cell'>Designation</td>
                <td class='value-cell'><?php if (isset($designation)) print $designation; ?></td>
            </tr>
        </table>
    </main>
    <?php include('php/_footer.php'); ?>
</body>
</html>