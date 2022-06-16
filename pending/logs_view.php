<?php 
include('php/_code.php');
if (isset($_GET['logid'])) {
	$record_id = trim($_GET['logid']);
	if (!is_numeric($record_id)) die('Invalid record id.');
	$results = mysqli_query($dbcon, "SELECT * FROM logs WHERE key_logs = $record_id");
	if ($row = mysqli_fetch_assoc($results)) {
		$log_type = $row['log_type'];
		$log_datetime = $row['log_datetime'];
		$action_performed = $row['action_performed'];
	} else {
		$message = "<div class='failure-result'>Record not found</div>";
	}
}
?>
<!DOCTYPE html>
<html>
<head>
	<title>LOGS</title>
	<?php include('php/_head.php'); ?>
</head>
<body id='page-view' class='page_view page_logs_view'>

	<?php if (isset($message)) print $message; ?>
	
	<main>     <table class='record-table'>
         <tr>
         <td class='label-cell'>Log type</td>
         <td class='value-cell'><?php if (isset($log_type)) print $log_type; ?></td>
         </tr>

         <tr>
         <td class='label-cell'>Log date time</td>
         <td class='value-cell'><?php if (isset($log_datetime)) print $log_datetime; ?></td>
         </tr>

         <tr>
         <td class='label-cell'>Action performed</td>
         <td class='value-cell'><?php if (isset($action_performed)) print $action_performed; ?></td>
         </tr>

     </table>

	</main>
	<?php include('php/_footer.php'); ?>
</body>
</html>
