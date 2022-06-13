<?php 
include('php/_code.php');
// parent id passed
if (isset($_GET['tripsid'])) {
	$parent_id = trim($_GET['tripsid']);
	if (!is_numeric($parent_id)) die('Parent table id is invalid');
	$results = mysqli_query($dbcon, "SELECT key_trips, passenger_name FROM trips WHERE key_trips = $parent_id");
	if ($row = mysqli_fetch_assoc($results)) {
		$parent_record_label = "Trip # " . $row['key_trips'] . " - " . $row['passenger_name'];
	} else {
		die('Parent id does not exist');
	}
} else {
	die('Parent id is not set');
}
$show_form = true;
$focus_field = 'amount';
// id passed for update
if (isset($_GET['trip_extra_chargesid'])) {
	$record_id = trim($_GET['trip_extra_chargesid']);
	if (!is_numeric($record_id)) exit;
	if (!isset($_POST['save_submit'])) {
		
		$results = mysqli_query($dbcon, "SELECT * FROM trip_extra_charges WHERE key_trip_extra_charges = $record_id  AND key_trips = $parent_id");
		if ($row = mysqli_fetch_assoc($results)) {
			$category = $row['category'];
			$amount = $row['amount'];
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
	// validation of input data
	$notes = trim($_POST['notes']);
	if (strlen($notes) > 1000) {
		$msg_notes = "<div class='message-error'>Provide a valid value up to length 1000</div>";
		$focus_field = 'notes';
		$error = 1;
	}
	$amount = trim($_POST['amount']);
	if (strlen($amount) > 100 || !is_numeric($amount)) {
		$msg_amount = "<div class='message-error'>Provide a valid value up to length 100</div>";
		$focus_field = 'amount';
		$error = 1;
	}
	$category = trim($_POST['category']);
	if (strlen($category) > 50) {
		$msg_category = "<div class='message-error'>Provide a valid value up to length 50</div>";
		$focus_field = 'category';
		$error = 1;
	}
	// no validation error
	if ($error == 0) {
		if (isset($record_id) && $error != 1) { // update
			$results = mysqli_query($dbcon, "UPDATE trip_extra_charges SET 
				category = '" . sd($dbcon, $category) . "', 
				amount = '" . sd($dbcon, $amount) . "', 
				notes = '" . sd($dbcon, $notes) . "' WHERE key_trip_extra_charges = $record_id  AND key_trips = $parent_id");
			if ($results) {
				$message = "<script>parent.location.reload(false);</script>";
			} else {
				//print mysqli_error($dbcon);
				die('Unable to update, please contact your system administrator.');
			}
			$show_form = false;
		} else if ($error != 1) { // insert
			$results = mysqli_query($dbcon, "INSERT INTO trip_extra_charges 
			(
			key_trips,
			category,
			amount,notes
			) VALUES (
			'" . sd($dbcon, $parent_id) . "',
			'" . sd($dbcon, $category) . "',
			'" . sd($dbcon, $amount) . "',
			'" . sd($dbcon, $notes) . "')");
			if ($results) {
				$message = "<script>parent.location.reload(false);</script>";
			} else {
				//print mysqli_error($dbcon);
				die('Unable to add, please contact your system administrator.');
			}
			$show_form = false;
		}	
	}
}
?>
<!DOCTYPE html>
<html>
<head>
	<title>TRIP EXTRA CHARGE</title>
	<?php include('php/_head.php'); ?>
</head>
<body id='page-save' class='foreign'>

	<?php if (isset($parent_record_label)) print '<h2>' . $parent_record_label . '</h2>'; ?>

	<?php if (isset($message)) print $message; ?>
	
	<main>

	<?php if (isset($show_form) && $show_form) { ?>
	<form method='post'>
		<fieldset>

		<div>
		<label for='category'>CATEGORY</label> <span class='red'> *</span><br>
		<?php if(isset($msg_category)) print $msg_category; ?>
		<select id='category' name='category' required>
		<?php 
		$options = '';
		
		$results = mysqli_query($dbcon, 'SELECT category FROM settings_extra_charges_values');
		while ($row = mysqli_fetch_assoc($results)) {
			$selection = '';
			if ($row['category'] == $category) $selection = "selected='selected'";
			$options .= "<option $selection>" . $row['category'] . "</option>";
		}
		print $options; 
		?>
		</select>
		</div>
		
		<div>
		<label for='amount'>AMOUNT</label> <span class='red'> *</span><br>
		<?php if(isset($msg_amount)) print $msg_amount; ?>
		<input id='amount' name='amount' type='number' step='any' value='<?php if (isset($amount)) {print $amount;} else {print '0';} ?>' required><br>
		</div>
		
		<div>
		<label for='notes'>NOTES</label><br>
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

