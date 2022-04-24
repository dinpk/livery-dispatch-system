<?php 
include('php/_code.php');
$show_record = true;
if (isset($_GET['driver_payrollid'])) {
	$record_id = trim($_GET['driver_payrollid']);
	if (!is_numeric($record_id)) die('Invalid record id.');
	if (isset($_GET['delete'])) {
		$results = mysqli_query($dbcon, "DELETE FROM driver_payroll WHERE key_driver_payroll = $record_id");
		if ($results) {
			$message = "<div class='success-result'>Deleted successfully</div>
			<div class='center'><br><br><input type='button' value='Close' onclick='parent.location.reload(false);'></div>";
			$show_record = false;
		} else {
			$message = "<div class='failure-result'>Could not delete record</div>";
		}
	} else {
		$results = mysqli_query($dbcon, "SELECT * FROM driver_payroll WHERE key_driver_payroll = $record_id");
		if ($row = mysqli_fetch_assoc($results)) {
			$key_drivers = $row['key_drivers'];
			$start_date = $row['start_date'];
			$end_date = $row['end_date'];
			$amount = $row['amount'];
			$amount_paid = $row['amount_paid'];
			$payment_method = $row['payment_method'];
			$due_date = $row['due_date'];
			$issue_date = $row['issue_date'];
			$notes = $row['notes'];
		} else {
			$message = "<div class='failure-result'>Record not found</div>";
		}
	}
}
?>
<!DOCTYPE html>
<html>
<head>
 <title>DRIVER PAYROLL</title>
 <?php include('php/_head.php'); ?>
</head>
<body id='page-delete' class='page_delete page_driver_payroll_delete'>

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
         <td class='label-cell'>Start date</td>
         <td class='value-cell'><?php if (isset($start_date)) print $start_date; ?></td>
         </tr>

         <tr>
         <td class='label-cell'>End date</td>
         <td class='value-cell'><?php if (isset($end_date)) print $end_date; ?></td>
         </tr>

         <tr>
         <td class='label-cell'>Amount</td>
         <td class='value-cell'><?php if (isset($amount)) print $amount; ?></td>
         </tr>

         <tr>
         <td class='label-cell'>Amount paid</td>
         <td class='value-cell'><?php if (isset($amount_paid)) print $amount_paid; ?></td>
         </tr>

         <tr>
         <td class='label-cell'>Payment method</td>
         <td class='value-cell'><?php if (isset($payment_method)) print $payment_method; ?></td>
         </tr>

         <tr>
         <td class='label-cell'>Due date</td>
         <td class='value-cell'><?php if (isset($due_date)) print $due_date; ?></td>
         </tr>

         <tr>
         <td class='label-cell'>Issue date</td>
         <td class='value-cell'><?php if (isset($issue_date)) print $issue_date; ?></td>
         </tr>

         <tr>
         <td class='label-cell'>Notes</td>
         <td class='value-cell'><?php if (isset($notes)) print $notes; ?></td>
         </tr>

     </table>

 </main>

 <?php } // show_record ?>


 <?php include('php/_footer.php'); ?>
</body>
</html>
