<?php 
include('php/_code.php');
if (isset($_GET['settingstolltypeid'])) {
	$record_id = trim($_GET['settingstolltypeid']);
	if (!is_numeric($record_id)) die('Invalid record id.');
	$results = mysqli_query($dbcon, "SELECT * FROM settings_toll_type_values WHERE key_settings_toll_type_values = $record_id");
	if ($row = mysqli_fetch_assoc($results)) {
		$toll_type = $row['toll_type'];
	} else {
		$message = "<div class='failure-result'>Record not found</div>";
	}
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>SETTINGS - TOLL TYPE</title>
    <?php include('php/_head.php'); ?>
</head>
<body id='page-view'>
    <?php if (isset($message)) print $message; ?>
    <main>
        <table class='record-table'>
            <tr>
                <td class='label-cell'>Toll type</td>
                <td class='value-cell'><?php if (isset($toll_type)) print $toll_type; ?></td>
            </tr>
        </table>
    </main>
    <?php include('php/_footer.php'); ?>
</body>
</html>