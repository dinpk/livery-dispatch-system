<?php 
include('php/_code.php');
$show_form = true;
$focus_field = 'image_url';
// id passed for update
if (isset($_GET['driversid'])) {
	$record_id = trim($_GET['driversid']);
	if (!is_numeric($record_id)) exit;
	if (!isset($_POST['save_submit'])) {
		$results = mysqli_query($dbcon, "SELECT * FROM drivers WHERE key_drivers = $record_id");
		if ($row = mysqli_fetch_assoc($results)) {
			$image_url = $row['image_url'];
			$username = $row['username'];
			$password = $row['password'];
			$first_name = $row['first_name'];
			$last_name = $row['last_name'];
			$contract_type = $row['contract_type'];
			$address1 = $row['address1'];
			$address2 = $row['address2'];
			$city = $row['city'];
			$state = $row['state'];
			$zip_code = $row['zip_code'];
			$work_phone = $row['work_phone'];
			$work_phone_extension = $row['work_phone_extension'];
			$mobile_phone = $row['mobile_phone'];
			$email = $row['email'];
			$date_of_birth = $row['date_of_birth'];
			$license_number = $row['license_number'];
			$license_expiry_date = $row['license_expiry_date'];
			$social_security_number = $row['social_security_number'];
			$hire_date = $row['hire_date'];
			$fleet_number = $row['fleet_number'];
			$key_vehicles = $row['key_vehicles'];
			$payment_method = $row['payment_method'];
			$base_amount_percent = $row['base_amount_percent'];
			$pay_gratuity_checkbox = $row['pay_gratuity_checkbox'];
			$gratuity_percent = $row['gratuity_percent'];
			$pay_commission_checkbox = $row['pay_commission_checkbox'];
			$commission_percent = $row['commission_percent'];
			$pay_extra_stops_checkbox = $row['pay_extra_stops_checkbox'];
			$extra_stops_percent = $row['extra_stops_percent'];
			$pay_offtime_checkbox = $row['pay_offtime_checkbox'];
			$offtime_percent = $row['offtime_percent'];
			$pay_tolls_checkbox = $row['pay_tolls_checkbox'];
			$tolls_percent = $row['tolls_percent'];
			$pay_parking_checkbox = $row['pay_parking_checkbox'];
			$parking_percent = $row['parking_percent'];
			$pay_gas_surcharge_checkbox = $row['pay_gas_surcharge_checkbox'];
			$gas_surcharge_percent = $row['gas_surcharge_percent'];
			$pay_extra_charges_checkbox = $row['pay_extra_charges_checkbox'];
			$extra_charges_percent = $row['extra_charges_percent'];
			$notes = $row['notes'];
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
	$active_status = trim($_POST['active_status']);
	if (strlen($active_status) > 10) {
		$msg_active_status = "<div class='message-error'>Provide a valid value of length 0-10</div>";
		$focus_field = 'active_status';
		$error = 1;
	}
	$notes = trim($_POST['notes']);
	if (strlen($notes) > 3000) {
		$msg_notes = "<div class='message-error'>Provide a valid value of length 0-3000</div>";
		$focus_field = 'notes';
		$error = 1;
	}
	$extra_charges_percent = trim($_POST['extra_charges_percent']);
	if (strlen($extra_charges_percent) > 5 || !is_numeric($extra_charges_percent)) {
		$msg_extra_charges_percent = "<div class='message-error'>Provide a valid value of length 0-5</div>";
		$focus_field = 'extra_charges_percent';
		$error = 1;
	}
	$pay_extra_charges_checkbox = trim($_POST['pay_extra_charges_checkbox']);
	if (strlen($pay_extra_charges_checkbox) > 10) {
		$msg_pay_extra_charges_checkbox = "<div class='message-error'>Provide a valid value of length 0-10</div>";
		$focus_field = 'pay_extra_charges_checkbox';
		$error = 1;
	}
	$gas_surcharge_percent = trim($_POST['gas_surcharge_percent']);
	if (strlen($gas_surcharge_percent) > 5 || !is_numeric($gas_surcharge_percent)) {
		$msg_gas_surcharge_percent = "<div class='message-error'>Provide a valid value of length 0-5</div>";
		$focus_field = 'gas_surcharge_percent';
		$error = 1;
	}
	$pay_gas_surcharge_checkbox = trim($_POST['pay_gas_surcharge_checkbox']);
	if (strlen($pay_gas_surcharge_checkbox) > 100) {
		$msg_pay_gas_surcharge_checkbox = "<div class='message-error'>Provide a valid value of length 0-100</div>";
		$focus_field = 'pay_gas_surcharge_checkbox';
		$error = 1;
	}
	$parking_percent = trim($_POST['parking_percent']);
	if (strlen($parking_percent) > 5 || !is_numeric($parking_percent)) {
		$msg_parking_percent = "<div class='message-error'>Provide a valid value of length 0-5</div>";
		$focus_field = 'parking_percent';
		$error = 1;
	}
	$pay_parking_checkbox = trim($_POST['pay_parking_checkbox']);
	if (strlen($pay_parking_checkbox) > 10) {
		$msg_pay_parking_checkbox = "<div class='message-error'>Provide a valid value of length 0-10</div>";
		$focus_field = 'pay_parking_checkbox';
		$error = 1;
	}
	$tolls_percent = trim($_POST['tolls_percent']);
	if (strlen($tolls_percent) > 5 || !is_numeric($tolls_percent)) {
		$msg_tolls_percent = "<div class='message-error'>Provide a valid value of length 0-5</div>";
		$focus_field = 'tolls_percent';
		$error = 1;
	}
	$pay_tolls_checkbox = trim($_POST['pay_tolls_checkbox']);
	if (strlen($pay_tolls_checkbox) > 10) {
		$msg_pay_tolls_checkbox = "<div class='message-error'>Provide a valid value of length 0-10</div>";
		$focus_field = 'pay_tolls_checkbox';
		$error = 1;
	}
	$offtime_percent = trim($_POST['offtime_percent']);
	if (strlen($offtime_percent) > 5 || !is_numeric($offtime_percent)) {
		$msg_offtime_percent = "<div class='message-error'>Provide a valid value of length 0-5</div>";
		$focus_field = 'offtime_percent';
		$error = 1;
	}
	$pay_offtime_checkbox = trim($_POST['pay_offtime_checkbox']);
	if (strlen($pay_offtime_checkbox) > 10) {
		$msg_pay_offtime_checkbox = "<div class='message-error'>Provide a valid value of length 0-10</div>";
		$focus_field = 'pay_offtime_checkbox';
		$error = 1;
	}
	$extra_stops_percent = trim($_POST['extra_stops_percent']);
	if (strlen($extra_stops_percent) > 5 || !is_numeric($extra_stops_percent)) {
		$msg_extra_stops_percent = "<div class='message-error'>Provide a valid value of length 0-5</div>";
		$focus_field = 'extra_stops_percent';
		$error = 1;
	}
	$pay_extra_stops_checkbox = trim($_POST['pay_extra_stops_checkbox']);
	if (strlen($pay_extra_stops_checkbox) > 10) {
		$msg_pay_extra_stops_checkbox = "<div class='message-error'>Provide a valid value of length 0-10</div>";
		$focus_field = 'pay_extra_stops_checkbox';
		$error = 1;
	}
	$commission_percent = trim($_POST['commission_percent']);
	if (strlen($commission_percent) > 5 || !is_numeric($commission_percent)) {
		$msg_commission_percent = "<div class='message-error'>Provide a valid value of length 0-5</div>";
		$focus_field = 'commission_percent';
		$error = 1;
	}
	$pay_commission_checkbox = trim($_POST['pay_commission_checkbox']);
	if (strlen($pay_commission_checkbox) > 10) {
		$msg_pay_commission_checkbox = "<div class='message-error'>Provide a valid value of length 0-10</div>";
		$focus_field = 'pay_commission_checkbox';
		$error = 1;
	}
	$gratuity_percent = trim($_POST['gratuity_percent']);
	if (strlen($gratuity_percent) > 5 || !is_numeric($gratuity_percent)) {
		$msg_gratuity_percent = "<div class='message-error'>Provide a valid value of length 0-5</div>";
		$focus_field = 'gratuity_percent';
		$error = 1;
	}
	$pay_gratuity_checkbox = trim($_POST['pay_gratuity_checkbox']);
	if (strlen($pay_gratuity_checkbox) > 10) {
		$msg_pay_gratuity_checkbox = "<div class='message-error'>Provide a valid value of length 0-10</div>";
		$focus_field = 'pay_gratuity_checkbox';
		$error = 1;
	}
	$base_amount_percent = trim($_POST['base_amount_percent']);
	if (strlen($base_amount_percent) > 5 || !is_numeric($base_amount_percent)) {
		$msg_base_amount_percent = "<div class='message-error'>Provide a valid value of length 0-5</div>";
		$focus_field = 'base_amount_percent';
		$error = 1;
	}
	$payment_method = trim($_POST['payment_method']);
	if (strlen($payment_method) > 30) {
		$msg_payment_method = "<div class='message-error'>Provide a valid value of length 0-30</div>";
		$focus_field = 'payment_method';
		$error = 1;
	}
	$key_vehicles = trim($_POST['key_vehicles']);
	if (strlen($key_vehicles) > 100 || !is_numeric($key_vehicles)) {
		$msg_key_vehicles = "<div class='message-error'>Provide a valid value of length 0-100</div>";
		$focus_field = 'key_vehicles';
		$error = 1;
	}
	$fleet_number = trim($_POST['fleet_number']);
	if (strlen($fleet_number) > 50) {
		$msg_fleet_number = "<div class='message-error'>Provide a valid value of length 0-50</div>";
		$focus_field = 'fleet_number';
		$error = 1;
	}
	$hire_date = trim($_POST['hire_date']);
	if (empty($hire_date)) {
		$hire_date = '1970-01-01';
	} else if (!is_date($hire_date)) {
		$msg_hire_date = "<div class='message-error'>Acceptable date format is 'yyyy-mm-dd'</div>";
		$focus_field = 'hire_date';
		$error = 1;
	}
	$social_security_number = trim($_POST['social_security_number']);
	if (strlen($social_security_number) > 100) {
		$msg_social_security_number = "<div class='message-error'>Provide a valid value of length 0-100</div>";
		$focus_field = 'social_security_number';
		$error = 1;
	}
	$license_expiry_date = trim($_POST['license_expiry_date']);
	if (empty($license_expiry_date)) {
		$license_expiry_date = '1970-01-01';
	} else if (!is_date($license_expiry_date)) {
		$msg_license_expiry_date = "<div class='message-error'>Acceptable date format is 'yyyy-mm-dd'</div>";
		$focus_field = 'license_expiry_date';
		$error = 1;
	}
	$license_number = trim($_POST['license_number']);
	if (strlen($license_number) > 100) {
		$msg_license_number = "<div class='message-error'>Provide a valid value of length 0-100</div>";
		$focus_field = 'license_number';
		$error = 1;
	}
	$date_of_birth = trim($_POST['date_of_birth']);
	if (empty($date_of_birth)) {
		$date_of_birth = '1970-01-01';
	} else if (!is_date($date_of_birth)) {
		$msg_date_of_birth = "<div class='message-error'>Acceptable date format is 'yyyy-mm-dd'</div>";
		$focus_field = 'date_of_birth';
		$error = 1;
	}
	$email = trim($_POST['email']);
	if (strlen($email) > 100) {
		$msg_email = "<div class='message-error'>Provide a valid value of length 0-100</div>";
		$focus_field = 'email';
		$error = 1;
	}
	$mobile_phone = trim($_POST['mobile_phone']);
	if (strlen($mobile_phone) > 30) {
		$msg_mobile_phone = "<div class='message-error'>Provide a valid value of length 0-30</div>";
		$focus_field = 'mobile_phone';
		$error = 1;
	}
	$work_phone_extension = trim($_POST['work_phone_extension']);
	if (strlen($work_phone_extension) > 30) {
		$msg_work_phone_extension = "<div class='message-error'>Provide a valid value of length 0-30</div>";
		$focus_field = 'work_phone_extension';
		$error = 1;
	}
	$work_phone = trim($_POST['work_phone']);
	if (strlen($work_phone) > 30) {
		$msg_work_phone = "<div class='message-error'>Provide a valid value of length 0-30</div>";
		$focus_field = 'work_phone';
		$error = 1;
	}
	$zip_code = trim($_POST['zip_code']);
	if (strlen($zip_code) > 50) {
		$msg_zip_code = "<div class='message-error'>Provide a valid value of length 0-50</div>";
		$focus_field = 'zip_code';
		$error = 1;
	}
	$state = trim($_POST['state']);
	if (strlen($state) > 100) {
		$msg_state = "<div class='message-error'>Provide a valid value of length 0-100</div>";
		$focus_field = 'state';
		$error = 1;
	}
	$city = trim($_POST['city']);
	if (strlen($city) > 100) {
		$msg_city = "<div class='message-error'>Provide a valid value of length 0-100</div>";
		$focus_field = 'city';
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
	$contract_type = trim($_POST['contract_type']);
	if (strlen($contract_type) > 50) {
		$msg_contract_type = "<div class='message-error'>Provide a valid value of length 0-50</div>";
		$focus_field = 'contract_type';
		$error = 1;
	}
	$last_name = trim($_POST['last_name']);
	if (strlen($last_name) > 50) {
		$msg_last_name = "<div class='message-error'>Provide a valid value of length 0-50</div>";
		$focus_field = 'last_name';
		$error = 1;
	}
	$first_name = trim($_POST['first_name']);
	if (strlen($first_name) > 50) {
		$msg_first_name = "<div class='message-error'>Provide a valid value of length 0-50</div>";
		$focus_field = 'first_name';
		$error = 1;
	}
	$password = trim($_POST['password']);
	if (strlen($password) < 5 || strlen($password) > 15) {
		$msg_password = "<div class='message-error'>Provide a valid value of length 5-15</div>";
		$focus_field = 'password';
		$error = 1;
	}
	$username = trim($_POST['username']);
	if (strlen($username) < 5 || strlen($username) > 15) {
		$msg_username = "<div class='message-error'>Provide a valid value of length 5-15</div>";
		$focus_field = 'username';
		$error = 1;
	}
	$image_url = trim($_POST['image_url']);
	if (strlen($image_url) > 100) {
		$msg_image_url = "<div class='message-error'>Provide a valid value of length 0-100</div>";
		$focus_field = 'image_url';
		$error = 1;
	}
	// no validation error
	if ($error == 0) {
		if (isset($record_id) && $error != 1) { // update
			$results = mysqli_query($dbcon, "UPDATE drivers SET 
			image_url = '" . sd($dbcon, $image_url) . "',
			username = '" . sd($dbcon, $username) . "',
			password = '" . sd($dbcon, $password) . "',
			first_name = '" . sd($dbcon, $first_name) . "',
			last_name = '" . sd($dbcon, $last_name) . "',
			contract_type = '" . sd($dbcon, $contract_type) . "',
			address1 = '" . sd($dbcon, $address1) . "',
			address2 = '" . sd($dbcon, $address2) . "',
			city = '" . sd($dbcon, $city) . "',
			state = '" . sd($dbcon, $state) . "',
			zip_code = '" . sd($dbcon, $zip_code) . "',
			work_phone = '" . sd($dbcon, $work_phone) . "',
			work_phone_extension = '" . sd($dbcon, $work_phone_extension) . "',
			mobile_phone = '" . sd($dbcon, $mobile_phone) . "',
			email = '" . sd($dbcon, $email) . "',
			date_of_birth = '" . sd($dbcon, $date_of_birth) . "',
			license_number = '" . sd($dbcon, $license_number) . "',
			license_expiry_date = '" . sd($dbcon, $license_expiry_date) . "',
			social_security_number = '" . sd($dbcon, $social_security_number) . "',
			hire_date = '" . sd($dbcon, $hire_date) . "',
			fleet_number = '" . sd($dbcon, $fleet_number) . "',
			key_vehicles = '" . sd($dbcon, $key_vehicles) . "',
			payment_method = '" . sd($dbcon, $payment_method) . "',
			base_amount_percent = '" . sd($dbcon, $base_amount_percent) . "',
			pay_gratuity_checkbox = '" . sd($dbcon, $pay_gratuity_checkbox) . "',
			gratuity_percent = '" . sd($dbcon, $gratuity_percent) . "',
			pay_commission_checkbox = '" . sd($dbcon, $pay_commission_checkbox) . "',
			commission_percent = '" . sd($dbcon, $commission_percent) . "',
			pay_extra_stops_checkbox = '" . sd($dbcon, $pay_extra_stops_checkbox) . "',
			extra_stops_percent = '" . sd($dbcon, $extra_stops_percent) . "',
			pay_offtime_checkbox = '" . sd($dbcon, $pay_offtime_checkbox) . "',
			offtime_percent = '" . sd($dbcon, $offtime_percent) . "',
			pay_tolls_checkbox = '" . sd($dbcon, $pay_tolls_checkbox) . "',
			tolls_percent = '" . sd($dbcon, $tolls_percent) . "',
			pay_parking_checkbox = '" . sd($dbcon, $pay_parking_checkbox) . "',
			parking_percent = '" . sd($dbcon, $parking_percent) . "',
			pay_gas_surcharge_checkbox = '" . sd($dbcon, $pay_gas_surcharge_checkbox) . "',
			gas_surcharge_percent = '" . sd($dbcon, $gas_surcharge_percent) . "',
			pay_extra_charges_checkbox = '" . sd($dbcon, $pay_extra_charges_checkbox) . "',
			extra_charges_percent = '" . sd($dbcon, $extra_charges_percent) . "',
			notes = '" . sd($dbcon, $notes) . "',
			active_status = '" . sd($dbcon, $active_status) . "'
			WHERE key_drivers = $record_id");
			if ($results) {
				$message = "<script>parent.location.reload(false);</script>";
			} else {
				//print mysqli_error($dbcon);
				die('Unable to update, please contact your system administrator.');
			}
		} else if ($error != 1) { // insert
			$results = mysqli_query($dbcon, "INSERT INTO drivers (
			image_url,
			username,
			password,
			first_name,
			last_name,
			contract_type,
			address1,
			address2,
			city,
			state,
			zip_code,
			work_phone,
			work_phone_extension,
			mobile_phone,
			email,
			date_of_birth,
			license_number,
			license_expiry_date,
			social_security_number,
			hire_date,
			fleet_number,
			key_vehicles,
			payment_method,
			base_amount_percent,
			pay_gratuity_checkbox,
			gratuity_percent,
			pay_commission_checkbox,
			commission_percent,
			pay_extra_stops_checkbox,
			extra_stops_percent,
			pay_offtime_checkbox,
			offtime_percent,
			pay_tolls_checkbox,
			tolls_percent,
			pay_parking_checkbox,
			parking_percent,
			pay_gas_surcharge_checkbox,
			gas_surcharge_percent,
			pay_extra_charges_checkbox,
			extra_charges_percent,
			notes,
			active_status
			) 
			VALUES (
			'" . sd($dbcon, $image_url) . "',
			'" . sd($dbcon, $username) . "',
			'" . sd($dbcon, $password) . "',
			'" . sd($dbcon, $first_name) . "',
			'" . sd($dbcon, $last_name) . "',
			'" . sd($dbcon, $contract_type) . "',
			'" . sd($dbcon, $address1) . "',
			'" . sd($dbcon, $address2) . "',
			'" . sd($dbcon, $city) . "',
			'" . sd($dbcon, $state) . "',
			'" . sd($dbcon, $zip_code) . "',
			'" . sd($dbcon, $work_phone) . "',
			'" . sd($dbcon, $work_phone_extension) . "',
			'" . sd($dbcon, $mobile_phone) . "',
			'" . sd($dbcon, $email) . "',
			'" . sd($dbcon, $date_of_birth) . "',
			'" . sd($dbcon, $license_number) . "',
			'" . sd($dbcon, $license_expiry_date) . "',
			'" . sd($dbcon, $social_security_number) . "',
			'" . sd($dbcon, $hire_date) . "',
			'" . sd($dbcon, $fleet_number) . "',
			'" . sd($dbcon, $key_vehicles) . "',
			'" . sd($dbcon, $payment_method) . "',
			'" . sd($dbcon, $base_amount_percent) . "',
			'" . sd($dbcon, $pay_gratuity_checkbox) . "',
			'" . sd($dbcon, $gratuity_percent) . "',
			'" . sd($dbcon, $pay_commission_checkbox) . "',
			'" . sd($dbcon, $commission_percent) . "',
			'" . sd($dbcon, $pay_extra_stops_checkbox) . "',
			'" . sd($dbcon, $extra_stops_percent) . "',
			'" . sd($dbcon, $pay_offtime_checkbox) . "',
			'" . sd($dbcon, $offtime_percent) . "',
			'" . sd($dbcon, $pay_tolls_checkbox) . "',
			'" . sd($dbcon, $tolls_percent) . "',
			'" . sd($dbcon, $pay_parking_checkbox) . "',
			'" . sd($dbcon, $parking_percent) . "',
			'" . sd($dbcon, $pay_gas_surcharge_checkbox) . "',
			'" . sd($dbcon, $gas_surcharge_percent) . "',
			'" . sd($dbcon, $pay_extra_charges_checkbox) . "',
			'" . sd($dbcon, $extra_charges_percent) . "',
			'" . sd($dbcon, $notes) . "',
			'" . sd($dbcon, $active_status) . "'
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
	<title>DRIVER</title>
	<?php include('php/_head.php'); ?>
</head>
<body id='page-save' class='page_save page_drivers_save'>

	<section id='sub-menu'>
		<div class='left-block'>driver</div>
		<div class='right-block'>

		</div>
	</section>

	<?php if (isset($message)) print $message; ?>
	
	<main>

	<?php if (isset($show_form) && $show_form) { ?>
	<form method='post'>
		<fieldset>

         <div>
             <label for='first_name'>First name</label>             <?php if(isset($msg_first_name)) print $msg_first_name; ?>
             <input <?php if ($focus_field == 'first_name') print 'autofocus'; ?> id='first_name' name='first_name' type='text' value='<?php if (isset($first_name)) {print $first_name;} else { print '';} ?>'><br>
         </div>

         <div>
             <label for='last_name'>Last name</label>             <?php if(isset($msg_last_name)) print $msg_last_name; ?>
             <input <?php if ($focus_field == 'last_name') print 'autofocus'; ?> id='last_name' name='last_name' type='text' value='<?php if (isset($last_name)) {print $last_name;} else { print '';} ?>'><br>
         </div>

         <div>
             <label for='contract_type'>Contract type</label><br>
             <?php if(isset($msg_contract_type)) print $msg_contract_type; ?>
             <select id='contract_type' name='contract_type'>
                 <?php
                 if (!isset($contract_type)) $contract_type = '';
                 print "
                 <option" . (($contract_type == 'Employee') ? ' selected' : '') .  ">Employee</option>
                 <option" . (($contract_type == 'Contractor') ? ' selected' : '') .  ">Contractor</option>
                 <option" . (($contract_type == 'Affiliate') ? ' selected' : '') .  ">Affiliate</option>
                 ";
                 ?>
             </select>
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
             <label for='city'>City</label>             <?php if(isset($msg_city)) print $msg_city; ?>
             <input <?php if ($focus_field == 'city') print 'autofocus'; ?> id='city' name='city' type='text' value='<?php if (isset($city)) {print $city;} else { print '';} ?>'><br>
         </div>

         <div>
             <label for='state'>State</label><br>
             <?php if(isset($msg_state)) print $msg_state; ?>
             <select id='state' name='state'>
                 <?php 
                 $options = '';
                 
                 $results = mysqli_query($dbcon, 'SELECT state FROM settings_state_values');
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

         <div>
             <label for='work_phone'>Work phone</label>             <?php if(isset($msg_work_phone)) print $msg_work_phone; ?>
             <input <?php if ($focus_field == 'work_phone') print 'autofocus'; ?> id='work_phone' name='work_phone' type='tel' value='<?php if (isset($work_phone)) {print $work_phone;} else { print '';} ?>'><br>
         </div>

         <div>
             <label for='work_phone_extension'>Work phone ext.</label>             <?php if(isset($msg_work_phone_extension)) print $msg_work_phone_extension; ?>
             <input <?php if ($focus_field == 'work_phone_extension') print 'autofocus'; ?> id='work_phone_extension' name='work_phone_extension' type='tel' value='<?php if (isset($work_phone_extension)) {print $work_phone_extension;} else { print '';} ?>'><br>
         </div>

         <div>
             <label for='mobile_phone'>Mobile phone</label>             <?php if(isset($msg_mobile_phone)) print $msg_mobile_phone; ?>
             <input <?php if ($focus_field == 'mobile_phone') print 'autofocus'; ?> id='mobile_phone' name='mobile_phone' type='tel' value='<?php if (isset($mobile_phone)) {print $mobile_phone;} else { print '';} ?>'><br>
         </div>

         <div>
             <label for='email'>Email</label>             <?php if(isset($msg_email)) print $msg_email; ?>
             <input <?php if ($focus_field == 'email') print 'autofocus'; ?> id='email' name='email' type='email' value='<?php if (isset($email)) {print $email;} else { print '';} ?>'><br>
         </div>

		</fieldset>
		<fieldset>

         <div>
             <label for='image_url'>Image url</label>             <?php if(isset($msg_image_url)) print $msg_image_url; ?>
             <input <?php if ($focus_field == 'image_url') print 'autofocus'; ?> id='image_url' name='image_url' type='text' value='<?php if (isset($image_url)) {print $image_url;} else { print '';} ?>'><br>
         </div>

         <div>
             <label for='username'>User name</label> <span class='red'> *</span>             <?php if(isset($msg_username)) print $msg_username; ?>
             <input <?php if ($focus_field == 'username') print 'autofocus'; ?> id='username' name='username' type='text' value='<?php if (isset($username)) {print $username;} else { print '';} ?>' required><br>
         </div>

         <div>
             <label for='password'>Password</label> <span class='red'> *</span>             <?php if(isset($msg_password)) print $msg_password; ?>
             <input <?php if ($focus_field == 'password') print 'autofocus'; ?> id='password' name='password' type='password' value='<?php if (isset($password)) {print $password;} else { print '';} ?>' required><br>
         </div>


         <div>
             <label for='date_of_birth'>Date of birth</label><br>
             <?php if(isset($msg_date_of_birth)) print $msg_date_of_birth; ?>
             <input id='date_of_birth' name='date_of_birth' type='date' placeholder='yyyy-mm-dd' value='<?php if (isset($date_of_birth)) {print $date_of_birth;} ?>'><br>
         </div>

         <div>
             <label for='license_number'>License #</label>             <?php if(isset($msg_license_number)) print $msg_license_number; ?>
             <input <?php if ($focus_field == 'license_number') print 'autofocus'; ?> id='license_number' name='license_number' type='text' value='<?php if (isset($license_number)) {print $license_number;} else { print '';} ?>'><br>
         </div>

         <div>
             <label for='license_expiry_date'>License expiry date</label><br>
             <?php if(isset($msg_license_expiry_date)) print $msg_license_expiry_date; ?>
             <input id='license_expiry_date' name='license_expiry_date' type='date' placeholder='yyyy-mm-dd' value='<?php if (isset($license_expiry_date)) {print $license_expiry_date;} ?>'><br>
         </div>

         <div>
             <label for='social_security_number'>Ssn</label>             <?php if(isset($msg_social_security_number)) print $msg_social_security_number; ?>
             <input <?php if ($focus_field == 'social_security_number') print 'autofocus'; ?> id='social_security_number' name='social_security_number' type='text' value='<?php if (isset($social_security_number)) {print $social_security_number;} else { print '';} ?>'><br>
         </div>

         <div>
             <label for='hire_date'>Hire date</label><br>
             <?php if(isset($msg_hire_date)) print $msg_hire_date; ?>
             <input id='hire_date' name='hire_date' type='date' placeholder='yyyy-mm-dd' value='<?php if (isset($hire_date)) {print $hire_date;} ?>'><br>
         </div>

         <div>
             <label for='fleet_number'>Fleet #</label>
             <small>
					 <a href='drivers_select_vehicles.php' target='overlay-iframe2' onclick='overlayOpen2();'>Select</a> &nbsp;
					 <a href='#' onclick='unselectKeyValue("key_vehicles","fleet_number");return false;'>?</a>
             </small><br>
             <?php if(isset($msg_fleet_number)) print $msg_fleet_number; ?>
             <input <?php if ($focus_field == 'fleet_number') print 'autofocus'; ?> id='fleet_number' name='fleet_number' type='text' value='<?php if (isset($fleet_number)) {print $fleet_number;} else { print '';} ?>' readonly><br>
         </div>

         <input id='key_vehicles' name='key_vehicles' type='hidden' value='<?php if (isset($key_vehicles)) {print $key_vehicles;} else {print '0';} ?>'>


         <div>
             <label for='notes'>Notes</label>             <?php if(isset($msg_notes)) print $msg_notes; ?>
             <textarea <?php if ($focus_field == 'notes') print 'autofocus'; ?> id='notes' name='notes'><?php if (isset($notes)) print $notes; ?></textarea><br>
         </div>

		</fieldset>
		<fieldset>

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
             <?php if(isset($msg_base_amount_percent)) print $msg_base_amount_percent; ?>
             <input class="input_number_small" <?php if ($focus_field == 'base_amount_percent') print 'autofocus'; ?> id='base_amount_percent' name='base_amount_percent' type='number' step='0.5' value='<?php if (isset($base_amount_percent)) {print $base_amount_percent;} else { print '100';} ?>'>% 
             <label for='base_amount_percent'>Base amount</label>
         </div>

        <div>
             <?php if(isset($msg_gratuity_percent)) print $msg_gratuity_percent; ?>
             <input class="input_number_small" <?php if ($focus_field == 'gratuity_percent') print 'autofocus'; ?> id='gratuity_percent' name='gratuity_percent' type='number' step='0.5' value='<?php if (isset($gratuity_percent)) {print $gratuity_percent;} else { print '100';} ?>'>% 
             <input <?php if (!isset($pay_gratuity_checkbox) || $pay_gratuity_checkbox=='on') {print "checked='checked'";} ?> type='checkbox' id='pay_gratuity_checkbox' name='pay_gratuity_checkbox'> 
			 <label for='gratuity_percent'>Gratuity </label>
         </div>

         <div>
             <?php if(isset($msg_commission_percent)) print $msg_commission_percent; ?>
             <input class="input_number_small" <?php if ($focus_field == 'commission_percent') print 'autofocus'; ?> id='commission_percent' name='commission_percent' type='number' step='0.5' value='<?php if (isset($commission_percent)) {print $commission_percent;} else { print '0';} ?>'>% 
             <input <?php if (!isset($pay_commission_checkbox) || $pay_commission_checkbox=='on') {print "checked='checked'";} ?> type='checkbox' id='pay_commission_checkbox' name='pay_commission_checkbox'> 
			 <label for='commission_percent'>Commission</label>
         </div>

         <div>
             <?php if(isset($msg_extra_stops_percent)) print $msg_extra_stops_percent; ?>
             <input class="input_number_small" <?php if ($focus_field == 'extra_stops_percent') print 'autofocus'; ?> id='extra_stops_percent' name='extra_stops_percent' type='number' step='0.5' value='<?php if (isset($extra_stops_percent)) {print $extra_stops_percent;} else { print '100';} ?>'>% 
             <input <?php if (!isset($pay_extra_stops_checkbox) || $pay_extra_stops_checkbox=='on') {print "checked='checked'";} ?> type='checkbox' id='pay_extra_stops_checkbox' name='pay_extra_stops_checkbox'> 
			 <label for='extra_stops_percent'>Extra stops</label>
         </div>

         <div>
             <?php if(isset($msg_offtime_percent)) print $msg_offtime_percent; ?>
             <input class="input_number_small" <?php if ($focus_field == 'offtime_percent') print 'autofocus'; ?> id='offtime_percent' name='offtime_percent' type='number' step='0.5' value='<?php if (isset($offtime_percent)) {print $offtime_percent;} else { print '100';} ?>'>% 
             <input <?php if (!isset($pay_offtime_checkbox) || $pay_offtime_checkbox=='on') {print "checked='checked'";} ?> type='checkbox' id='pay_offtime_checkbox' name='pay_offtime_checkbox'> 
			 <label for='offtime_percent'>Off-time</label>
         </div>

         <div>
             <?php if(isset($msg_tolls_percent)) print $msg_tolls_percent; ?>
             <input class="input_number_small" <?php if ($focus_field == 'tolls_percent') print 'autofocus'; ?> id='tolls_percent' name='tolls_percent' type='number' step='0.5' value='<?php if (isset($tolls_percent)) {print $tolls_percent;} else { print '100';} ?>'>% 
             <input <?php if (!isset($pay_tolls_checkbox) || $pay_tolls_checkbox=='on') {print "checked='checked'";} ?> type='checkbox' id='pay_tolls_checkbox' name='pay_tolls_checkbox'> 
             <label for='tolls_percent'>Tolls</label>
         </div>

         <div>
             <?php if(isset($msg_parking_percent)) print $msg_parking_percent; ?>
             <input class="input_number_small" <?php if ($focus_field == 'parking_percent') print 'autofocus'; ?> id='parking_percent' name='parking_percent' type='number' step='0.5' value='<?php if (isset($parking_percent)) {print $parking_percent;} else { print '100';} ?>'>% 
             <input <?php if (!isset($pay_parking_checkbox) || $pay_parking_checkbox=='on') {print "checked='checked'";} ?> type='checkbox' id='pay_parking_checkbox' name='pay_parking_checkbox'> 
             <label for='parking_percent'>Parking</label>
         </div>

         <div>
             <?php if(isset($msg_gas_surcharge_percent)) print $msg_gas_surcharge_percent; ?>
             <input class="input_number_small" <?php if ($focus_field == 'gas_surcharge_percent') print 'autofocus'; ?> id='gas_surcharge_percent' name='gas_surcharge_percent' type='number' step='0.5' value='<?php if (isset($gas_surcharge_percent)) {print $gas_surcharge_percent;} else { print '100';} ?>'>% 
             <input <?php if (!isset($pay_gas_surcharge_checkbox) || $pay_gas_surcharge_checkbox=='on') {print "checked='checked'";} ?> type='checkbox' id='pay_gas_surcharge_checkbox' name='pay_gas_surcharge_checkbox'> 
             <label for='gas_surcharge_percent'>Gas surcharge</label>
         </div>

         <div>
             <?php if(isset($msg_extra_charges_percent)) print $msg_extra_charges_percent; ?>
             <input class="input_number_small" <?php if ($focus_field == 'extra_charges_percent') print 'autofocus'; ?> id='extra_charges_percent' name='extra_charges_percent' type='number' step='0.5' value='<?php if (isset($extra_charges_percent)) {print $extra_charges_percent;} else { print '100';} ?>'>% 
             <input <?php if (!isset($pay_extra_charges_checkbox) || $pay_extra_charges_checkbox=='on') {print "checked='checked'";} ?> type='checkbox' id='pay_extra_charges_checkbox' name='pay_extra_charges_checkbox'> 
             <label for='extra_charges_percent'>Extra charges</label>
         </div>

		<br><br>
		
         <div>
             <?php if(isset($msg_active_status)) print $msg_active_status; ?>
             <input <?php if (!isset($active_status) || $active_status=='on') {print "checked='checked'";} ?> type='checkbox' id='active_status' name='active_status'> <label for='active_status'>Status</label><br>
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
