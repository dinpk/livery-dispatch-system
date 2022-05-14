<?php 
include('php/_code.php');
$show_form = true;
$focus_field = 'workshop_name';
// id passed for update
if (isset($_GET['settings_workshop_name_valuesid'])) {
	$record_id = trim($_GET['settings_workshop_name_valuesid']);
	if (!is_numeric($record_id)) exit;
	if (!isset($_POST['save_submit'])) {
		$results = mysqli_query($dbcon, "SELECT * FROM settings_workshop_name_values WHERE key_settings_workshop_name_values = $record_id");
		if ($row = mysqli_fetch_assoc($results)) {
			$workshop_name = $row['workshop_name'];
			$contact_name = $row['contact_name'];
			$address1 = $row['address1'];
			$address2 = $row['address2'];
			$phone = $row['phone'];
			$email = $row['email'];
			$city = $row['city'];
			$state = $row['state'];
			$zip_code = $row['zip_code'];
		} else {
			$message = "<div class='failure-result'>Record not found</div>";
			$show_form = false;
		}
	}
}
// 'Save' button clicked
if (isset($_POST['save_submit'])) {
	$error = 0;
	$zip_code = trim($_POST['zip_code']);
	if (strlen($zip_code) > 50) {
		$msg_zip_code = "<div class='message-error'>Provide a valid value of length 0-50</div>";
		$focus_field = 'zip_code';
		$error = 1;
	}
	$state = trim($_POST['state']);
	if (strlen($state) > 50) {
		$msg_state = "<div class='message-error'>Provide a valid value of length 0-50</div>";
		$focus_field = 'state';
		$error = 1;
	}
	$city = trim($_POST['city']);
	if (strlen($city) > 100) {
		$msg_city = "<div class='message-error'>Provide a valid value of length 0-100</div>";
		$focus_field = 'city';
		$error = 1;
	}
	$email = trim($_POST['email']);
	if (strlen($email) > 100) {
		$msg_email = "<div class='message-error'>Provide a valid value of length 0-100</div>";
		$focus_field = 'email';
		$error = 1;
	}
	$phone = trim($_POST['phone']);
	if (strlen($phone) > 100) {
		$msg_phone = "<div class='message-error'>Provide a valid value of length 0-100</div>";
		$focus_field = 'phone';
		$error = 1;
	}
	$address2 = trim($_POST['address2']);
	if (strlen($address2) > 100) {
		$msg_address2 = "<div class='message-error'>Provide a valid value of length 0-100</div>";
		$focus_field = 'address2';
		$error = 1;
	}
	$address1 = trim($_POST['address1']);
	if (strlen($address1) > 100) {
		$msg_address1 = "<div class='message-error'>Provide a valid value of length 0-100</div>";
		$focus_field = 'address1';
		$error = 1;
	}
	$contact_name = trim($_POST['contact_name']);
	if (strlen($contact_name) > 100) {
		$msg_contact_name = "<div class='message-error'>Provide a valid value of length 0-100</div>";
		$focus_field = 'contact_name';
		$error = 1;
	}
	$workshop_name = trim($_POST['workshop_name']);
	if (strlen($workshop_name) < 3 || strlen($workshop_name) > 100) {
		$msg_workshop_name = "<div class='message-error'>Provide a valid value of length 3-100</div>";
		$focus_field = 'workshop_name';
		$error = 1;
	}
	// no validation error
	if ($error == 0) {
		if (isset($record_id) && $error != 1) { // update
			$results = mysqli_query($dbcon, "UPDATE settings_workshop_name_values SET 
			workshop_name = '" . sd($dbcon, $workshop_name) . "',
			contact_name = '" . sd($dbcon, $contact_name) . "',
			address1 = '" . sd($dbcon, $address1) . "',
			address2 = '" . sd($dbcon, $address2) . "',
			phone = '" . sd($dbcon, $phone) . "',
			email = '" . sd($dbcon, $email) . "',
			city = '" . sd($dbcon, $city) . "',
			state = '" . sd($dbcon, $state) . "',
			zip_code = '" . sd($dbcon, $zip_code) . "'
				WHERE key_settings_workshop_name_values = $record_id");
			if ($results) {
				$message = "<script>parent.location.reload(false);</script>";
			} else {
				//print mysqli_error($dbcon);
				die('Unable to update, please contact your system administrator.');
			}
		} else if ($error != 1) { // insert
			$results = mysqli_query($dbcon, "INSERT INTO settings_workshop_name_values (
			workshop_name,
			contact_name,
			address1,
			address2,
			phone,
			email,
			city,
			state,
			zip_code
			) 
			VALUES (
			'" . sd($dbcon, $workshop_name) . "',
			'" . sd($dbcon, $contact_name) . "',
			'" . sd($dbcon, $address1) . "',
			'" . sd($dbcon, $address2) . "',
			'" . sd($dbcon, $phone) . "',
			'" . sd($dbcon, $email) . "',
			'" . sd($dbcon, $city) . "',
			'" . sd($dbcon, $state) . "',
			'" . sd($dbcon, $zip_code) . "'
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
	<title>SETTINGS WORKSHOP NAME VALUES</title>
	<?php include('php/_head.php'); ?>
</head>
<body id='page-save' class='page_save page_settings_workshop_name_values_save'>

	<section id='sub-menu'>
		<div class='left-block'> </div>
		<div class='right-block'> </div>
	</section>

	<?php if (isset($message)) print $message; ?>
	
	<main>

	<?php if (isset($show_form) && $show_form) { ?>
	<form method='post'>
		<fieldset>

         <div>
             <label for='workshop_name'>Workshop name</label> <span class='red'> *</span>             <?php if(isset($msg_workshop_name)) print $msg_workshop_name; ?>
             <input <?php if ($focus_field == 'workshop_name') print 'autofocus'; ?> id='workshop_name' name='workshop_name' type='text' value='<?php if (isset($workshop_name)) {print $workshop_name;} else { print '';} ?>' required><br>
         </div>

         <div>
             <label for='contact_name'>Contact person</label>             <?php if(isset($msg_contact_name)) print $msg_contact_name; ?>
             <input <?php if ($focus_field == 'contact_name') print 'autofocus'; ?> id='contact_name' name='contact_name' type='text' value='<?php if (isset($contact_name)) {print $contact_name;} else { print '';} ?>'><br>
         </div>

         <div>
             <label for='address1'>Address 1</label>             <?php if(isset($msg_address1)) print $msg_address1; ?>
             <input <?php if ($focus_field == 'address1') print 'autofocus'; ?> id='address1' name='address1' type='text' value='<?php if (isset($address1)) {print $address1;} else { print '';} ?>'><br>
         </div>

         <div>
             <label for='address2'>Address 2</label>             <?php if(isset($msg_address2)) print $msg_address2; ?>
             <input <?php if ($focus_field == 'address2') print 'autofocus'; ?> id='address2' name='address2' type='text' value='<?php if (isset($address2)) {print $address2;} else { print '';} ?>'><br>
         </div>

         <div>
             <label for='phone'>Phone</label>             <?php if(isset($msg_phone)) print $msg_phone; ?>
             <input <?php if ($focus_field == 'phone') print 'autofocus'; ?> id='phone' name='phone' type='tel' value='<?php if (isset($phone)) {print $phone;} else { print '';} ?>'><br>
         </div>

         <div>
             <label for='email'>Email</label>             <?php if(isset($msg_email)) print $msg_email; ?>
             <input <?php if ($focus_field == 'email') print 'autofocus'; ?> id='email' name='email' type='email' value='<?php if (isset($email)) {print $email;} else { print '';} ?>'><br>
         </div>

         <div>
             <label for='city'>City</label>             <?php if(isset($msg_city)) print $msg_city; ?>
             <input <?php if ($focus_field == 'city') print 'autofocus'; ?> id='city' name='city' type='text' value='<?php if (isset($city)) {print $city;} else { print '';} ?>'><br>
         </div>

         <div>
             <label for='state'>State</label><br>
             <?php if(isset($msg_state)) print $msg_state; ?>
             <select id='state' name='state'>
                 <?php 
                 $options = '';
                 
                 $results = mysqli_query($dbcon, 'SELECT state FROM values_state');
                 while ($row = mysqli_fetch_assoc($results)) {
                     $selection = '';
                     if ($row['state'] == $state) $selection = "selected='selected'";
                         $options .= "<option $selection>" . $row['state'] . "</option>";
                 }
                 print $options; 
                 ?>
             </select>
         </div>

         <div>
             <label for='zip_code'>Zip code</label>             <?php if(isset($msg_zip_code)) print $msg_zip_code; ?>
             <input <?php if ($focus_field == 'zip_code') print 'autofocus'; ?> id='zip_code' name='zip_code' type='text' value='<?php if (isset($zip_code)) {print $zip_code;} else { print '';} ?>'><br>
         </div>

		</fieldset>
		<div class='clear-fix'>
		<input id='save_submit' name='save_submit' type='submit' value='Save'>
		</div>
		
	</form>
	<?php } ?>

	</main>
	<?php include('php/_footer.php'); ?>

</body>
</html>
