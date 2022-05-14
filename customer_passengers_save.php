<?php 
include('php/_code.php');
$show_form = true;
$focus_field = 'first_name';
// id passed for update
if (isset($_GET['customer_passengersid'])) {
	$record_id = trim($_GET['customer_passengersid']);
	if (!is_numeric($record_id)) exit;
	if (!isset($_POST['save_submit'])) {
		$results = mysqli_query($dbcon, "SELECT * FROM customer_passengers WHERE key_customer_passengers = $record_id");
		if ($row = mysqli_fetch_assoc($results)) {
			$first_name = $row['first_name'];
			$last_name = $row['last_name'];
			$address1 = $row['address1'];
			$address2 = $row['address2'];
			$city = $row['city'];
			$state = $row['state'];
			$country = $row['country'];
			$zip_code = $row['zip_code'];
			$work_phone = $row['work_phone'];
			$work_phone_extension = $row['work_phone_extension'];
			$mobile_phone = $row['mobile_phone'];
			$email = $row['email'];
			$website = $row['website'];
			$image_url = $row['image_url'];
			$company_name = $row['company_name'];
			$key_customer_companies = $row['key_customer_companies'];
			$package_name = $row['package_name'];
			$key_customer_rate_packages = $row['key_customer_rate_packages'];
			$billing_contact_name = $row['billing_contact_name'];
			$key_customer_billing_contacts = $row['key_customer_billing_contacts'];
			$payment_method = $row['payment_method'];
			$confirm_to_passenger = $row['confirm_to_passenger'];
			$confirm_to_contact = $row['confirm_to_contact'];
			$confirm_to_billing_contact = $row['confirm_to_billing_contact'];
			$notes = $row['notes'];
			$trip_ticket_notes = $row['trip_ticket_notes'];
			$ad_source = $row['ad_source'];
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
	if (strlen($active_status) > 5) {
		$msg_active_status = "<div class='message-error'>Provide a valid value of length 0-5</div>";
		$focus_field = 'active_status';
		$error = 1;
	}
	$ad_source = trim($_POST['ad_source']);
	if (strlen($ad_source) > 100) {
		$msg_ad_source = "<div class='message-error'>Provide a valid value of length 0-100</div>";
		$focus_field = 'ad_source';
		$error = 1;
	}
	$trip_ticket_notes = trim($_POST['trip_ticket_notes']);
	if (strlen($trip_ticket_notes) > 2000) {
		$msg_trip_ticket_notes = "<div class='message-error'>Provide a valid value of length 0-2000</div>";
		$focus_field = 'trip_ticket_notes';
		$error = 1;
	}
	$notes = trim($_POST['notes']);
	if (strlen($notes) > 2000) {
		$msg_notes = "<div class='message-error'>Provide a valid value of length 0-2000</div>";
		$focus_field = 'notes';
		$error = 1;
	}
	$confirm_to_billing_contact = trim($_POST['confirm_to_billing_contact']);
	if (strlen($confirm_to_billing_contact) > 10) {
		$msg_confirm_to_billing_contact = "<div class='message-error'>Provide a valid value of length 0-10</div>";
		$focus_field = 'confirm_to_billing_contact';
		$error = 1;
	}
	$confirm_to_contact = trim($_POST['confirm_to_contact']);
	if (strlen($confirm_to_contact) > 10) {
		$msg_confirm_to_contact = "<div class='message-error'>Provide a valid value of length 0-10</div>";
		$focus_field = 'confirm_to_contact';
		$error = 1;
	}
	$confirm_to_passenger = trim($_POST['confirm_to_passenger']);
	if (strlen($confirm_to_passenger) > 10) {
		$msg_confirm_to_passenger = "<div class='message-error'>Provide a valid value of length 0-10</div>";
		$focus_field = 'confirm_to_passenger';
		$error = 1;
	}
	$payment_method = trim($_POST['payment_method']);
	if (strlen($payment_method) > 100) {
		$msg_payment_method = "<div class='message-error'>Provide a valid value of length 0-100</div>";
		$focus_field = 'payment_method';
		$error = 1;
	}
	$key_customer_billing_contacts = trim($_POST['key_customer_billing_contacts']);
	if (strlen($key_customer_billing_contacts) > 100 || !is_numeric($key_customer_billing_contacts)) {
		$msg_key_customer_billing_contacts = "<div class='message-error'>Provide a valid value of length 0-100</div>";
		$focus_field = 'key_customer_billing_contacts';
		$error = 1;
	}
	$billing_contact_name = trim($_POST['billing_contact_name']);
	if (strlen($billing_contact_name) > 100) {
		$msg_billing_contact_name = "<div class='message-error'>Provide a valid value of length 0-100</div>";
		$focus_field = 'billing_contact_name';
		$error = 1;
	}
	$key_customer_rate_packages = trim($_POST['key_customer_rate_packages']);
	if (strlen($key_customer_rate_packages) > 100 || !is_numeric($key_customer_rate_packages)) {
		$msg_key_customer_rate_packages = "<div class='message-error'>Provide a valid value of length 0-100</div>";
		$focus_field = 'key_customer_rate_packages';
		$error = 1;
	}
	$package_name = trim($_POST['package_name']);
	if (strlen($package_name) > 50) {
		$msg_package_name = "<div class='message-error'>Provide a valid value of length 0-50</div>";
		$focus_field = 'package_name';
		$error = 1;
	}
	$key_customer_companies = trim($_POST['key_customer_companies']);
	if (strlen($key_customer_companies) > 100 || !is_numeric($key_customer_companies)) {
		$msg_key_customer_companies = "<div class='message-error'>Provide a valid value of length 0-100</div>";
		$focus_field = 'key_customer_companies';
		$error = 1;
	}
	$company_name = trim($_POST['company_name']);
	if (strlen($company_name) > 100) {
		$msg_company_name = "<div class='message-error'>Provide a valid value of length 0-100</div>";
		$focus_field = 'company_name';
		$error = 1;
	}
	$image_url = trim($_POST['image_url']);
	if (strlen($image_url) > 100) {
		$msg_image_url = "<div class='message-error'>Provide a valid value of length 0-100</div>";
		$focus_field = 'image_url';
		$error = 1;
	}
	$website = trim($_POST['website']);
	if (strlen($website) > 100) {
		$msg_website = "<div class='message-error'>Provide a valid value of length 0-100</div>";
		$focus_field = 'website';
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
	if (strlen($work_phone_extension) > 10 || !is_numeric($work_phone_extension)) {
		$msg_work_phone_extension = "<div class='message-error'>Provide a valid value of length 0-10</div>";
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
	$country = trim($_POST['country']);
	if (strlen($country) > 100) {
		$msg_country = "<div class='message-error'>Provide a valid value of length 0-100</div>";
		$focus_field = 'country';
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
	$last_name = trim($_POST['last_name']);
	if (strlen($last_name) < 3 || strlen($last_name) > 100) {
		$msg_last_name = "<div class='message-error'>Provide a valid value of length 3-100</div>";
		$focus_field = 'last_name';
		$error = 1;
	}
	$first_name = trim($_POST['first_name']);
	if (strlen($first_name) < 3 || strlen($first_name) > 100) {
		$msg_first_name = "<div class='message-error'>Provide a valid value of length 3-100</div>";
		$focus_field = 'first_name';
		$error = 1;
	}
	// no validation error
	if ($error == 0) {
		if (isset($record_id) && $error != 1) { // update
			$results = mysqli_query($dbcon, "UPDATE customer_passengers SET 
			first_name = '" . sd($dbcon, $first_name) . "',
			last_name = '" . sd($dbcon, $last_name) . "',
			address1 = '" . sd($dbcon, $address1) . "',
			address2 = '" . sd($dbcon, $address2) . "',
			city = '" . sd($dbcon, $city) . "',
			state = '" . sd($dbcon, $state) . "',
			country = '" . sd($dbcon, $country) . "',
			zip_code = '" . sd($dbcon, $zip_code) . "',
			work_phone = '" . sd($dbcon, $work_phone) . "',
			work_phone_extension = '" . sd($dbcon, $work_phone_extension) . "',
			mobile_phone = '" . sd($dbcon, $mobile_phone) . "',
			email = '" . sd($dbcon, $email) . "',
			website = '" . sd($dbcon, $website) . "',
			image_url = '" . sd($dbcon, $image_url) . "',
			company_name = '" . sd($dbcon, $company_name) . "',
			key_customer_companies = '" . sd($dbcon, $key_customer_companies) . "',
			package_name = '" . sd($dbcon, $package_name) . "',
			key_customer_rate_packages = '" . sd($dbcon, $key_customer_rate_packages) . "',
			billing_contact_name = '" . sd($dbcon, $billing_contact_name) . "',
			key_customer_billing_contacts = '" . sd($dbcon, $key_customer_billing_contacts) . "',
			payment_method = '" . sd($dbcon, $payment_method) . "',
			confirm_to_passenger = '" . sd($dbcon, $confirm_to_passenger) . "',
			confirm_to_contact = '" . sd($dbcon, $confirm_to_contact) . "',
			confirm_to_billing_contact = '" . sd($dbcon, $confirm_to_billing_contact) . "',
			notes = '" . sd($dbcon, $notes) . "',
			trip_ticket_notes = '" . sd($dbcon, $trip_ticket_notes) . "',
			ad_source = '" . sd($dbcon, $ad_source) . "',
			active_status = '" . sd($dbcon, $active_status) . "'
				WHERE key_customer_passengers = $record_id");
			if ($results) {
				$message = "<script>parent.location.reload(false);</script>";
			} else {
				//print mysqli_error($dbcon);
				die('Unable to update, please contact your system administrator.');
			}
		} else if ($error != 1) { // insert
			$results = mysqli_query($dbcon, "INSERT INTO customer_passengers (
			first_name,
			last_name,
			address1,
			address2,
			city,
			state,
			country,
			zip_code,
			work_phone,
			work_phone_extension,
			mobile_phone,
			email,
			website,
			image_url,
			company_name,
			key_customer_companies,
			package_name,
			key_customer_rate_packages,
			billing_contact_name,
			key_customer_billing_contacts,
			payment_method,
			confirm_to_passenger,
			confirm_to_contact,
			confirm_to_billing_contact,
			notes,
			trip_ticket_notes,
			ad_source,
			active_status
			) 
			VALUES (
			'" . sd($dbcon, $first_name) . "',
			'" . sd($dbcon, $last_name) . "',
			'" . sd($dbcon, $address1) . "',
			'" . sd($dbcon, $address2) . "',
			'" . sd($dbcon, $city) . "',
			'" . sd($dbcon, $state) . "',
			'" . sd($dbcon, $country) . "',
			'" . sd($dbcon, $zip_code) . "',
			'" . sd($dbcon, $work_phone) . "',
			'" . sd($dbcon, $work_phone_extension) . "',
			'" . sd($dbcon, $mobile_phone) . "',
			'" . sd($dbcon, $email) . "',
			'" . sd($dbcon, $website) . "',
			'" . sd($dbcon, $image_url) . "',
			'" . sd($dbcon, $company_name) . "',
			'" . sd($dbcon, $key_customer_companies) . "',
			'" . sd($dbcon, $package_name) . "',
			'" . sd($dbcon, $key_customer_rate_packages) . "',
			'" . sd($dbcon, $billing_contact_name) . "',
			'" . sd($dbcon, $key_customer_billing_contacts) . "',
			'" . sd($dbcon, $payment_method) . "',
			'" . sd($dbcon, $confirm_to_passenger) . "',
			'" . sd($dbcon, $confirm_to_contact) . "',
			'" . sd($dbcon, $confirm_to_billing_contact) . "',
			'" . sd($dbcon, $notes) . "',
			'" . sd($dbcon, $trip_ticket_notes) . "',
			'" . sd($dbcon, $ad_source) . "',
			'" . sd($dbcon, $active_status) . "'
			)");
			if ($results) {
				$last_inserted_key = mysqli_insert_id($dbcon);
				$message = "
				<div class='center'>
					<br><br>
					<input type='button' value='Close' onclick='parent.location.reload(false);'>
					<br>
					<p><a href='trips_save.php?id=" . $last_inserted_key . "&passenger=" . $first_name . " " .$last_name . "'>Add a new trip</a></p>
				</div>
				";
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
	<title>CUSTOMER PASSENGER</title>
	<?php include('php/_head.php'); ?>
</head>
<body id='page-save' class='page_save page_customer_passengers_save'>

	<section id='sub-menu'>
		<div class='left-block'>customer passenger</div>
		<div class='right-block'>

		</div>
	</section>

	<?php if (isset($message)) print $message; ?>
	
	<main>

	<?php if (isset($show_form) && $show_form) { ?>
	<form method='post'>
		
		<fieldset>

			 <div>
				 <label for='first_name'>First name</label> <span class='red'> *</span>             <?php if(isset($msg_first_name)) print $msg_first_name; ?>
				 <input <?php if ($focus_field == 'first_name') print 'autofocus'; ?> id='first_name' name='first_name' type='text' value='<?php if (isset($first_name)) {print $first_name;} else { print '';} ?>' required><br>
			 </div>

			 <div>
				 <label for='last_name'>Last name</label> <span class='red'> *</span>             <?php if(isset($msg_last_name)) print $msg_last_name; ?>
				 <input <?php if ($focus_field == 'last_name') print 'autofocus'; ?> id='last_name' name='last_name' type='text' value='<?php if (isset($last_name)) {print $last_name;} else { print '';} ?>' required><br>
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
				 <input id='state' name='state' list='list_state' value='<?php if (isset($state)) {print $state;} ?>'><br>
				 <datalist id='list_state'>
				 <?php 
					 $options = '';
					 
					 $results = mysqli_query($dbcon, 'SELECT state FROM settings_state_values');
					 while ($row = mysqli_fetch_assoc($results)) {
						 $options .= "<option value='" . $row['state'] . "'>";
					 }
					 print $options; 
					 ?>
				 </datalist>
			 </div>

			 <div>
				 <label for='country'>Country</label><br>
				 <?php if(isset($msg_country)) print $msg_country; ?>
				 <select id='country' name='country'>
					 <?php 
					 $options = '';
					 
					 $results = mysqli_query($dbcon, 'SELECT country FROM settings_country_values');
					 while ($row = mysqli_fetch_assoc($results)) {
						 $selection = '';
						 if ($row['country'] == $country) $selection = "selected='selected'";
							 $options .= "<option $selection>" . $row['country'] . "</option>";
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
		<fieldset>
		
			 <div>
				 <label for='work_phone'>Work phone</label>             <?php if(isset($msg_work_phone)) print $msg_work_phone; ?>
				 <input <?php if ($focus_field == 'work_phone') print 'autofocus'; ?> id='work_phone' name='work_phone' type='tel' value='<?php if (isset($work_phone)) {print $work_phone;} else { print '';} ?>'><br>
			 </div>

			 <div>
				 <label for='work_phone_extension'>Work phone ext.</label>             <?php if(isset($msg_work_phone_extension)) print $msg_work_phone_extension; ?>
				 <input <?php if ($focus_field == 'work_phone_extension') print 'autofocus'; ?> id='work_phone_extension' name='work_phone_extension' type='number' value='<?php if (isset($work_phone_extension)) {print $work_phone_extension;} else { print '0';} ?>'><br>
			 </div>

			 <div>
				 <label for='mobile_phone'>Mobile phone</label>             <?php if(isset($msg_mobile_phone)) print $msg_mobile_phone; ?>
				 <input <?php if ($focus_field == 'mobile_phone') print 'autofocus'; ?> id='mobile_phone' name='mobile_phone' type='tel' value='<?php if (isset($mobile_phone)) {print $mobile_phone;} else { print '';} ?>'><br>
			 </div>

			 <div>
				 <label for='email'>Email</label>             <?php if(isset($msg_email)) print $msg_email; ?>
				 <input <?php if ($focus_field == 'email') print 'autofocus'; ?> id='email' name='email' type='email' value='<?php if (isset($email)) {print $email;} else { print '';} ?>'><br>
			 </div>

			 <div>
				 <label for='website'>Website</label>             <?php if(isset($msg_website)) print $msg_website; ?>
				 <input <?php if ($focus_field == 'website') print 'autofocus'; ?> id='website' name='website' type='url' value='<?php if (isset($website)) {print $website;} else { print '';} ?>'><br>
			 </div>

			 <div>
				 <label for='image_url'>Image url</label>             <?php if(isset($msg_image_url)) print $msg_image_url; ?>
				 <input <?php if ($focus_field == 'image_url') print 'autofocus'; ?> id='image_url' name='image_url' type='text' value='<?php if (isset($image_url)) {print $image_url;} else { print '';} ?>'><br>
			 </div>

		</fieldset>
		<fieldset>

			 <div>
				 <label for='company_name'>Company name</label>
				 <small>
						 <a href='customer_passengers_select_customer_companies.php' target='overlay-iframe2' onclick='overlayOpen2();'>Select</a> &nbsp;
						 <a href='#' onclick='unselectKeyValue("key_customer_companies","company_name");return false;'>?</a>
				 </small><br>
				 <?php if(isset($msg_company_name)) print $msg_company_name; ?>
				 <input <?php if ($focus_field == 'company_name') print 'autofocus'; ?> id='company_name' name='company_name' type='text' value='<?php if (isset($company_name)) {print $company_name;} else { print '';} ?>' readonly><br>
			 </div>

			 <input id='key_customer_companies' name='key_customer_companies' type='hidden' value='<?php if (isset($key_customer_companies)) {print $key_customer_companies;} else {print '0';} ?>'>


			 <div>
				 <label for='package_name'>Package</label>
				 <small>
						 <a href='customer_passengers_select_customer_rate_packages.php' target='overlay-iframe2' onclick='overlayOpen2();'>Select</a> &nbsp;
						 <a href='#' onclick='unselectKeyValue("key_customer_rate_packages","package_name");return false;'>?</a>
				 </small><br>
				 <?php if(isset($msg_package_name)) print $msg_package_name; ?>
				 <input <?php if ($focus_field == 'package_name') print 'autofocus'; ?> id='package_name' name='package_name' type='text' value='<?php if (isset($package_name)) {print $package_name;} else { print '';} ?>' readonly><br>
			 </div>

			 <input id='key_customer_rate_packages' name='key_customer_rate_packages' type='hidden' value='<?php if (isset($key_customer_rate_packages)) {print $key_customer_rate_packages;} else {print '0';} ?>'>


			 <div>
				 <label for='billing_contact_name'>Billing contact name</label>
				 <small>
						 <a href='customer_passengers_select_customer_billing_contacts.php' target='overlay-iframe2' onclick='overlayOpen2();'>Select</a> &nbsp;
						 <a href='#' onclick='unselectKeyValue("key_customer_billing_contacts","billing_contact_name");return false;'>?</a>
				 </small><br>
				 <?php if(isset($msg_billing_contact_name)) print $msg_billing_contact_name; ?>
				 <input <?php if ($focus_field == 'billing_contact_name') print 'autofocus'; ?> id='billing_contact_name' name='billing_contact_name' type='text' value='<?php if (isset($billing_contact_name)) {print $billing_contact_name;} else { print '';} ?>' readonly><br>
			 </div>

			 <input id='key_customer_billing_contacts' name='key_customer_billing_contacts' type='hidden' value='<?php if (isset($key_customer_billing_contacts)) {print $key_customer_billing_contacts;} else {print '0';} ?>'>


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
				 <?php if(isset($msg_confirm_to_passenger)) print $msg_confirm_to_passenger; ?>
				 <input <?php if (!isset($confirm_to_passenger) || $confirm_to_passenger=='on') {print "checked='checked'";} ?> type='checkbox' id='confirm_to_passenger' name='confirm_to_passenger'> <label for='confirm_to_passenger'>Confirm to passenger</label><br>
			 </div>

			 <div>
				 <?php if(isset($msg_confirm_to_contact)) print $msg_confirm_to_contact; ?>
				 <input <?php if (!isset($confirm_to_contact) || $confirm_to_contact=='on') {print "checked='checked'";} ?> type='checkbox' id='confirm_to_contact' name='confirm_to_contact'> <label for='confirm_to_contact'>Confirm to contact</label><br>
			 </div>

			 <div>
				 <?php if(isset($msg_confirm_to_billing_contact)) print $msg_confirm_to_billing_contact; ?>
				 <input <?php if (!isset($confirm_to_billing_contact) || $confirm_to_billing_contact=='on') {print "checked='checked'";} ?> type='checkbox' id='confirm_to_billing_contact' name='confirm_to_billing_contact'> <label for='confirm_to_billing_contact'>Confirm to billing contact</label><br>
			 </div>

		</fieldset>
		<fieldset>

			 <div>
				 <label for='notes'>Notes</label>             <?php if(isset($msg_notes)) print $msg_notes; ?>
				 <textarea <?php if ($focus_field == 'notes') print 'autofocus'; ?> id='notes' name='notes'><?php if (isset($notes)) print $notes; ?></textarea><br>
			 </div>

			 <div>
				 <label for='trip_ticket_notes'>Trip ticket notes</label>             <?php if(isset($msg_trip_ticket_notes)) print $msg_trip_ticket_notes; ?>
				 <textarea <?php if ($focus_field == 'trip_ticket_notes') print 'autofocus'; ?> id='trip_ticket_notes' name='trip_ticket_notes'><?php if (isset($trip_ticket_notes)) print $trip_ticket_notes; ?></textarea><br>
			 </div>

			 <div>
				 <label for='ad_source'>Ad source</label><br>
				 <?php if(isset($msg_ad_source)) print $msg_ad_source; ?>
				 <select id='ad_source' name='ad_source'>
					 <?php 
					 $options = '';
					 
					 $results = mysqli_query($dbcon, 'SELECT ad_source FROM settings_ad_source_values');
					 while ($row = mysqli_fetch_assoc($results)) {
						 $selection = '';
						 if ($row['ad_source'] == $ad_source) $selection = "selected='selected'";
							 $options .= "<option $selection>" . $row['ad_source'] . "</option>";
					 }
					 print $options; 
					 ?>
				 </select>
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
