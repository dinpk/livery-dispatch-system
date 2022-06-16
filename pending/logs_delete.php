<?php 
include('php/_code.php');
$show_record = true;
if (isset($_GET['logid'])) {
	$record_id = trim($_GET['logid']);
	if (!is_numeric($record_id)) die('Invalid record id.');
	if (isset($_GET['delete'])) {
		$results = mysqli_query($dbcon, "DELETE FROM logs WHERE key_logs = $record_id");
		if ($results) {
			$message = "<div class='success-result'>Deleted successfully</div>
			<div class='center'><br><br><input type='button' value='Close' onclick='parent.location.reload(false);'></div>";
			$show_record = false;
			
		} else {
			$message = "<div class='failure-result'>Could not delete record</div>";
		}
	} else {
		$results = mysqli_query($dbcon, "SELECT * FROM logs WHERE key_logs = $record_id");
		if ($row = mysqli_fetch_assoc($results)) {
			$log_type = $row['log_type'];
			$log_datetime = $row['log_datetime'];
			$action_performed = $row['action_performed'];
		} else {
			$message = "<div class='failure-result'>Record not found</div>";
		}
	}
}
?>
<!DOCTYPE html>
<html>
<head>
 <title>LOGS</title>
 <?php include('php/_head.php'); ?>
</head>
<body id='page-delete' class='page_delete page_logs_delete'>

 <?php if (isset($message)) print $message; ?>

 <?php if ($show_record) { ?>

 <main>

     <div class='center'>
         <p class='red'><b>Do you really want to delete this record?</b></p>
         <p>
             <br>
             <a class='button-big' href='<?php print $_SERVER['REQUEST_URI']; ?>&delete=1'>Delete</a> &nbsp 
             <a class='button-big' href='#' onclick='parent.location.reload(false);'>Cancel</a><br>
         </p>
         <br><hr><br>
     </div>

     <table class='record-table'>
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

 <?php } // show_record ?>


 <?php include('php/_footer.php'); ?>
</body>
</html>
