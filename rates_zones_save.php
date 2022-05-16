<?php 
include('php/_code.php');
$show_form = true;
$focus_field = 'from_city';
// id passed for update
if (isset($_GET['rates_zonesid'])) {
	$record_id = trim($_GET['rates_zonesid']);
	if (!is_numeric($record_id)) exit;
	if (!isset($_POST['save_submit'])) {
		$results = mysqli_query($dbcon, "SELECT * FROM rates_zones WHERE key_rates_zones = $record_id");
		if ($row = mysqli_fetch_assoc($results)) {
			$from_city = $row['from_city'];
			$from_state = $row['from_state'];
			$to_city = $row['to_city'];
			$to_state = $row['to_state'];
			$rate = $row['rate'];
			$tolls = $row['tolls'];
			$miles = $row['miles'];
			$active_status = $row['active_status'];
		} else {
			$message = "<div class='failure-result'>Record not found</div>";
			$show_form = false;
		}
	}
}
// 'Save' button clicked
if (isset($_POST['save_submit'])) {
	$error = 0;

	$reverse_record = trim($_POST['reverse_record']);
	if (strlen($reverse_record) > 5) {
		$msg_reverse_record = "<div class='message-error'>Provide a valid value of length 0-5</div>";
		$focus_field = 'reverse_record';
		$error = 1;
	}
	$active_status = trim($_POST['active_status']);
	if (strlen($active_status) > 5) {
		$msg_active_status = "<div class='message-error'>Provide a valid value of length 0-5</div>";
		$focus_field = 'active_status';
		$error = 1;
	}
	$miles = trim($_POST['miles']);
	if (strlen($miles) > 10 || !is_numeric($miles)) {
		$msg_miles = "<div class='message-error'>Provide a valid value of length 0-10</div>";
		$focus_field = 'miles';
		$error = 1;
	}
	$tolls = trim($_POST['tolls']);
	if (strlen($tolls) > 10 || !is_numeric($tolls)) {
		$msg_tolls = "<div class='message-error'>Provide a valid value of length 0-10</div>";
		$focus_field = 'tolls';
		$error = 1;
	}
	$rate = trim($_POST['rate']);
	if (strlen($rate) > 10 || !is_numeric($rate)) {
		$msg_rate = "<div class='message-error'>Provide a valid value of length 0-10</div>";
		$focus_field = 'rate';
		$error = 1;
	}
	$to_state = trim($_POST['to_state']);
	if (strlen($to_state) > 100) {
		$msg_to_state = "<div class='message-error'>Provide a valid value of length 0-100</div>";
		$focus_field = 'to_state';
		$error = 1;
	}
	$to_city = trim($_POST['to_city']);
	if (strlen($to_city) < 3 || strlen($to_city) > 100) {
		$msg_to_city = "<div class='message-error'>Provide a valid value of length 3-100</div>";
		$focus_field = 'to_city';
		$error = 1;
	}
	$from_state = trim($_POST['from_state']);
	if (strlen($from_state) > 100) {
		$msg_from_state = "<div class='message-error'>Provide a valid value of length 0-100</div>";
		$focus_field = 'from_state';
		$error = 1;
	}
	$from_city = trim($_POST['from_city']);
	if (strlen($from_city) < 3 || strlen($from_city) > 100) {
		$msg_from_city = "<div class='message-error'>Provide a valid value of length 3-100</div>";
		$focus_field = 'from_city';
		$error = 1;
	}

	// no validation error
	if ($error == 0) {
		if (isset($record_id)) { // update
			$duplicate_result = mysqli_query($dbcon, "SELECT key_rates_zones 
				FROM rates_zones 
				WHERE from_city = '$from_city' AND from_state = '$from_state' AND to_city = '$to_city' AND to_state = '$to_state' 
				AND key_rates_zones != $record_id");
			if ($row = mysqli_fetch_assoc($duplicate_result)) {
				$message .= "<div class='failure-result'>Zone <b>$from_city, $from_state</b> to <b>$to_city, $to_state</b> already exists.</div>";
				$error = 1;
			} else {
				$results = mysqli_query($dbcon, "UPDATE rates_zones SET 
				from_city = '" . sd($dbcon, $from_city) . "',
				from_state = '" . sd($dbcon, $from_state) . "',
				to_city = '" . sd($dbcon, $to_city) . "',
				to_state = '" . sd($dbcon, $to_state) . "',
				rate = '" . sd($dbcon, $rate) . "',
				tolls = '" . sd($dbcon, $tolls) . "',
				miles = '" . sd($dbcon, $miles) . "',
				active_status = '" . sd($dbcon, $active_status) . "'
				WHERE key_rates_zones = $record_id");
				if ($results) {
					$message = "<script>parent.location.reload(false);</script>";
				} else {
					//print mysqli_error($dbcon);
					die('Unable to update, please contact your system administrator.');
				}
			}

		} else { // insert

			$duplicate_result = mysqli_query($dbcon, "SELECT key_rates_zones 
				FROM rates_zones 
				WHERE from_city = '$from_city' AND from_state = '$from_state' AND to_city = '$to_city' AND to_state = '$to_state'
				");
			if ($row = mysqli_fetch_assoc($duplicate_result)) {
				$message .= "<div class='failure-result'>Zone <b>$from_city, $from_state</b> to <b>$to_city, $to_state</b> already exists.</div>";
				$error = 1;
			} else {
				$results = mysqli_query($dbcon, "INSERT INTO rates_zones (
				from_city,
				from_state,
				to_city,
				to_state,
				rate,
				tolls,
				miles,
				active_status
				) 
				VALUES (
				'" . sd($dbcon, $from_city) . "',
				'" . sd($dbcon, $from_state) . "',
				'" . sd($dbcon, $to_city) . "',
				'" . sd($dbcon, $to_state) . "',
				'" . sd($dbcon, $rate) . "',
				'" . sd($dbcon, $tolls) . "',
				'" . sd($dbcon, $miles) . "',
				'" . sd($dbcon, $active_status) . "'
				)");

				if ($results) {

					if ($reverse_record == "on") {
						mysqli_query($dbcon, "INSERT INTO rates_zones (
									from_city,
									from_state,
									to_city,
									to_state,
									rate,
									tolls,
									miles,
									active_status
									) 
									VALUES (
									'" . sd($dbcon, $to_city) . "',
									'" . sd($dbcon, $to_state) . "',
									'" . sd($dbcon, $from_city) . "',
									'" . sd($dbcon, $from_state) . "',
									'" . sd($dbcon, $rate) . "',
									'" . sd($dbcon, $tolls) . "',
									'" . sd($dbcon, $miles) . "',
									'" . sd($dbcon, $active_status) . "'
									)");					
					}
					$message = "<script>parent.location.reload(false);</script>";

				} else {
					//print mysqli_error($dbcon);
					die('Unable to add, please contact your system administrator.');
				}
			
			} // duplicate
		
		} // insert
	
	} // no error
	if ($error == 0) $show_form = false;
}
?>
<!DOCTYPE html>
<html>
<head>
	<title>ZONE RATe</title>
	<?php include('php/_head.php'); ?>
</head>
<body id='page-save' class='page_save page_rates_zones_save'>

	<section id='sub-menu'>
		<div class='left-block'>zone rate</div>
		<div class='right-block'>

		</div>
	</section>

	<?php if (isset($message)) print $message; ?>
	
	<main>

	<?php if (isset($show_form) && $show_form) { ?>
	<form method='post'>
		<fieldset>

         <div>
             <label for='from_city'>From city</label> <span class='red'> *</span>             
			 <?php if(isset($msg_from_city)) print $msg_from_city; ?>
             <input <?php if ($focus_field == 'from_city') print 'autofocus'; ?> id='from_city' name='from_city' type='text' value='<?php if (isset($from_city)) {print $from_city;} else { print '';} ?>' required><br>
         </div>

         <div>
             <label for='from_state'>From state</label><br>
             <?php if(isset($msg_from_state)) print $msg_from_state; ?>
             <select id='from_state' name='from_state'>
                 <?php 
                 $options = '';
                 
                 $results = mysqli_query($dbcon, 'SELECT state FROM settings_state_values');
                 while ($row = mysqli_fetch_assoc($results)) {
                     $selection = '';
                     if ($row['state'] == $from_state) $selection = "selected='selected'";
                         $options .= "<option $selection>" . $row['state'] . "</option>";
                 }
                 print $options; 
                 ?>
             </select>
         </div>

		</fieldset>
		<fieldset>

         <div>
             <label for='to_city'>To city</label> <span class='red'> *</span>             
			 <?php if(isset($msg_to_city)) print $msg_to_city; ?>
             <input <?php if ($focus_field == 'to_city') print 'autofocus'; ?> id='to_city' name='to_city' type='text' value='<?php if (isset($to_city)) {print $to_city;} else { print '';} ?>' required><br>
         </div>

         <div>
             <label for='to_state'>To state</label><br>
             <?php if(isset($msg_to_state)) print $msg_to_state; ?>
             <select id='to_state' name='to_state'>
                 <?php 
                 $options = '';
                 
                 $results = mysqli_query($dbcon, 'SELECT state FROM settings_state_values');
                 while ($row = mysqli_fetch_assoc($results)) {
                     $selection = '';
                     if ($row['state'] == $to_state) $selection = "selected='selected'";
                         $options .= "<option $selection>" . $row['state'] . "</option>";
                 }
                 print $options; 
                 ?>
             </select>
         </div>

		</fieldset>
		<fieldset>
		
         <div>
             <label for='rate'>Rate</label>
			 <?php if(isset($msg_rate)) print $msg_rate; ?>
             <input <?php if ($focus_field == 'rate') print 'autofocus'; ?> id='rate' name='rate' type='number' step='0.10' value='<?php if (isset($rate)) {print $rate;} else { print '0';} ?>'><br>
         </div>

         <div>
             <label for='tolls'>Tolls</label>             
			 <?php if(isset($msg_tolls)) print $msg_tolls; ?>
             <input <?php if ($focus_field == 'tolls') print 'autofocus'; ?> id='tolls' name='tolls' type='number' step='0.10' value='<?php if (isset($tolls)) {print $tolls;} else { print '0';} ?>'><br>
         </div>

         <div>
             <label for='miles'>Miles</label>             
			 <?php if(isset($msg_miles)) print $msg_miles; ?>
             <input <?php if ($focus_field == 'miles') print 'autofocus'; ?> id='miles' name='miles' type='number' step='0.10' value='<?php if (isset($miles)) {print $miles;} else { print '0';} ?>'><br>
         </div>

         <div>
             <?php if(isset($msg_active_status)) print $msg_active_status; ?>
             <input <?php if (!isset($active_status) || $active_status=='on') {print "checked='checked'";} ?> type='checkbox' id='active_status' name='active_status'> <label for='active_status'>Status</label><br>
         </div>

		</fieldset>

		<?php if (!isset($record_id))  {?>
		<fieldset>
         <div>
             <input <?php if (!isset($reverse_record) || $reverse_record=='on') {print "checked='checked'";} ?> type='checkbox' id='reverse_record' name='reverse_record'> <label for='reverse_record'>Create Reverse</label><br>
         </div>
		</fieldset>
		<?php } ?>

		<div class='clear-fix'>
		<input id='save_submit' name='save_submit' type='submit' value='Save'>
		</div>
		
	</form>
	<?php } ?>

	</main>
	<?php include('php/_footer.php'); ?>

</body>
</html>
