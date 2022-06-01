<?php 
include('php/_code.php');
$show_form = true;
$focus_field = 'start_date';
// id passed for update
if (isset($_GET['driver_payrollid'])) {
	$record_id = trim($_GET['driver_payrollid']);
	if (!is_numeric($record_id)) exit;
	if (!isset($_POST['save_submit'])) {
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
			$show_form = false;
		}
	}
}
// 'Save' button clicked
if (isset($_POST['save_submit'])) {
	$error = 0;
	$notes = trim($_POST['notes']);
	if (strlen($notes) > 2000) {
		$msg_notes = "<div class='message-error'>Provide a valid value of length 0-2000</div>";
		$focus_field = 'notes';
		$error = 1;
	}
	$issue_date = trim($_POST['issue_date']);
	if (empty($issue_date)) {
		$issue_date = '1970-01-01';
	} else if (!is_date($issue_date)) {
		$msg_issue_date = "<div class='message-error'>Acceptable date format is 'yyyy-mm-dd'</div>";
		$focus_field = 'issue_date';
		$error = 1;
	}
	$due_date = trim($_POST['due_date']);
	if (empty($due_date)) {
		$due_date = '1970-01-01';
	} else if (!is_date($due_date)) {
		$msg_due_date = "<div class='message-error'>Acceptable date format is 'yyyy-mm-dd'</div>";
		$focus_field = 'due_date';
		$error = 1;
	}
	$payment_method = trim($_POST['payment_method']);
	if (strlen($payment_method) > 50) {
		$msg_payment_method = "<div class='message-error'>Provide a valid value of length 0-50</div>";
		$focus_field = 'payment_method';
		$error = 1;
	}
	$amount_paid = trim($_POST['amount_paid']);
	if (strlen($amount_paid) > 10 || !is_numeric($amount_paid)) {
		$msg_amount_paid = "<div class='message-error'>Provide a valid value of length 0-10</div>";
		$focus_field = 'amount_paid';
		$error = 1;
	}
	$amount = trim($_POST['amount']);
	if (strlen($amount) > 10 || !is_numeric($amount)) {
		$msg_amount = "<div class='message-error'>Provide a valid value of length 0-10</div>";
		$focus_field = 'amount';
		$error = 1;
	}
	$end_date = trim($_POST['end_date']);
	if (empty($end_date)) {
		$end_date = '1970-01-01';
	} else if (!is_date($end_date)) {
		$msg_end_date = "<div class='message-error'>Acceptable date format is 'yyyy-mm-dd'</div>";
		$focus_field = 'end_date';
		$error = 1;
	}
	$start_date = trim($_POST['start_date']);
	if (empty($start_date)) {
		$start_date = '1970-01-01';
	} else if (!is_date($start_date)) {
		$msg_start_date = "<div class='message-error'>Acceptable date format is 'yyyy-mm-dd'</div>";
		$focus_field = 'start_date';
		$error = 1;
	}
	$key_drivers = trim($_POST['key_drivers']);
	if (strlen($key_drivers) > 100 || !is_numeric($key_drivers)) {
		$msg_key_drivers = "<div class='message-error'>Provide a valid value of length 0-100</div>";
		$focus_field = 'key_drivers';
		$error = 1;
	}
	// no validation error
	if ($error == 0) {
		if (isset($record_id) && $error != 1) { // update
			$results = mysqli_query($dbcon, "UPDATE driver_payroll SET 
			key_drivers = '" . sd($dbcon, $key_drivers) . "',
			start_date = '" . sd($dbcon, $start_date) . "',
			end_date = '" . sd($dbcon, $end_date) . "',
			amount = '" . sd($dbcon, $amount) . "',
			amount_paid = '" . sd($dbcon, $amount_paid) . "',
			payment_method = '" . sd($dbcon, $payment_method) . "',
			due_date = '" . sd($dbcon, $due_date) . "',
			issue_date = '" . sd($dbcon, $issue_date) . "',
			notes = '" . sd($dbcon, $notes) . "'
			WHERE key_driver_payroll = $record_id");
			if ($results) {
				$message = "<script>parent.location.reload(false);</script>";
			} else {
				//print mysqli_error($dbcon);
				die('Unable to update, please contact your system administrator.');
			}
		} else if ($error != 1) { // insert
			$results = mysqli_query($dbcon, "INSERT INTO driver_payroll (
			key_drivers,
			start_date,
			end_date,
			amount,
			amount_paid,
			payment_method,
			due_date,
			issue_date,
			notes
			) 
			VALUES (
			'" . sd($dbcon, $key_drivers) . "',
			'" . sd($dbcon, $start_date) . "',
			'" . sd($dbcon, $end_date) . "',
			'" . sd($dbcon, $amount) . "',
			'" . sd($dbcon, $amount_paid) . "',
			'" . sd($dbcon, $payment_method) . "',
			'" . sd($dbcon, $due_date) . "',
			'" . sd($dbcon, $issue_date) . "',
			'" . sd($dbcon, $notes) . "'
			)");
			if ($results) {
				$message = "<script>parent.location.reload(false);</script>";
			} else {
				if (strpos(mysqli_error($dbcon), "Duplicate") > -1) {
					$message = "<div class='failure-result'>" . mysqli_error($dbcon) . "</div>";
					$error = 1;
				} else {
					die('Unable to add, please contact your system administrator.');
				}
			}
		}
	}
	if ($error == 0) $show_form = false;
}
?>
<!DOCTYPE html>
<html>
<head>
	<title>DRIVER PAYROLL</title>
	<?php include('php/_head.php'); ?>
</head>
<body id='page-save' class='page_save page_driver_payroll_save'>

	<section id='sub-menu'>
		<div class='left-block'>driver payroll</div>
		<div class='right-block'>

		</div>
	</section>

	<?php if (isset($message)) print $message; ?>
	
	<main>

	<?php if (isset($show_form) && $show_form) { ?>
	<form method='post'>
		<fieldset>


         <input id='key_drivers' name='key_drivers' type='hidden' value='<?php if (isset($key_drivers)) {print $key_drivers;} else {print '0';} ?>'>


         <div>
             <label for='start_date'>Start date</label> <span class='red'> *</span><br>
             <?php if(isset($msg_start_date)) print $msg_start_date; ?>
             <input id='start_date' name='start_date' type='date' placeholder='yyyy-mm-dd' value='<?php if (isset($start_date)) {print $start_date;} ?>' required readonly><br>
         </div>

         <div>
             <label for='end_date'>End date</label> <span class='red'> *</span><br>
             <?php if(isset($msg_end_date)) print $msg_end_date; ?>
             <input id='end_date' name='end_date' type='date' placeholder='yyyy-mm-dd' value='<?php if (isset($end_date)) {print $end_date;} ?>' required readonly><br>
         </div>

         <div>
             <label for='amount'>Amount</label>
             <?php if(isset($msg_amount)) print $msg_amount; ?>
             <input id='amount' name='amount' type='number' step='0.10' value='<?php if (isset($amount)) {print $amount;} else { print '0';} ?>' readonly><br>
         </div>

         <div>
             <label for='amount_paid'>Amount paid</label>
             <?php if(isset($msg_amount_paid)) print $msg_amount_paid; ?>
             <input id='amount_paid' name='amount_paid' type='number' step='0.10' value='<?php if (isset($amount_paid)) {print $amount_paid;} else { print '0';} ?>' required><br>
         </div>

         <div>
             <label for='payment_method'>Payment method</label><br>
             <?php if(isset($msg_payment_method)) print $msg_payment_method; ?>
             <select id='payment_method' name='payment_method'>
                 <?php 
                 $options = '';
                 $results = mysqli_query($dbcon, 'SELECT payment_method FROM settings_payment_method_values');
                 while ($row = mysqli_fetch_assoc($results)) {
                     $selection = '';
                     if ($row['payment_method'] == $payment_method) $selection = "selected='selected'";
                         $options .= "<option $selection>" . $row['payment_method'] . "</option>";
                 }
                 print $options; 
                 ?>
             </select>
         </div>

         <div>
             <label for='issue_date'>Issue date</label><br>
             <?php if(isset($msg_issue_date)) print $msg_issue_date; ?>
             <input id='issue_date' name='issue_date' type='date' placeholder='yyyy-mm-dd' value='<?php if (isset($issue_date)) {print $issue_date;} ?>' readonly><br>
         </div>

         <div>
             <label for='due_date'>Due date</label><br>
             <?php if(isset($msg_due_date)) print $msg_due_date; ?>
             <input id='due_date' name='due_date' type='date' placeholder='yyyy-mm-dd' value='<?php if (isset($due_date)) {print $due_date;} ?>'><br>
         </div>

         <div>
             <label for='notes'>Notes</label>
             <?php if(isset($msg_notes)) print $msg_notes; ?>
             <textarea id='notes' name='notes'><?php if (isset($notes)) print $notes; ?></textarea><br>
         </div>

		</fieldset>
		
		<input id='save_submit' name='save_submit' type='submit' value='Save'>
		
		
	</form>
	<?php } ?>

	</main>
	<?php include('php/_footer.php'); ?>

</body>
</html>

