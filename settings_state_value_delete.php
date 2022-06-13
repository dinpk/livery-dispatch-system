<?php 
include('php/_code.php');
$show_record = true;
if (isset($_GET['settings_state_valuesid'])) {
	$record_id = trim($_GET['settings_state_valuesid']);
	if (!is_numeric($record_id)) die('Invalid record id.');
	if (isset($_GET['delete'])) {
		$results = mysqli_query($dbcon, "DELETE FROM settings_state_values WHERE key_settings_state_values = $record_id");
		if ($results) {
			$message = "<div class='success-result'>Deleted successfully</div>
			<div class='center'><br><br><input type='button' value='Close' onclick='parent.location.reload(false);'></div>";
			$show_record = false;
		} else {
			$message = "<div class='failure-result'>Could not delete record</div>";
		}
	} else {
		$results = mysqli_query($dbcon, "SELECT * FROM settings_state_values WHERE key_settings_state_values = $record_id");
		if ($row = mysqli_fetch_assoc($results)) {
			$state = $row['state'];
			$state_code = $row['state_code'];
		} else {
			$message = "<div class='failure-result'>Record not found</div>";
		}
	}
}
?>
<!DOCTYPE html>
<html>
<head>
 <title>SETTINGS STATE VALUES</title>
 <?php include('php/_head.php'); ?>
</head>
<body id='page-delete' class='page_delete page_settings_state_values_delete'>

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
         <td class='label-cell'>State</td>
         <td class='value-cell'><?php if (isset($state)) print $state; ?></td>
         </tr>

         <tr>
         <td class='label-cell'>State code</td>
         <td class='value-cell'><?php if (isset($state_code)) print $state_code; ?></td>
         </tr>

     </table>

 </main>

 <?php } // show_record ?>


 <?php include('php/_footer.php'); ?>
</body>
</html>
