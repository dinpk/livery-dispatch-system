<?php 
include('php/_code.php');
if (isset($_GET['driversid'])) {
	$record_id = trim($_GET['driversid']);
	if (!is_numeric($record_id)) die('Invalid record id.');
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
		$hourly_rate = $row['hourly_rate'];
		$pay_gratuity_checkbox = $row['pay_gratuity_checkbox'];
		$gratuity_percent = $row['gratuity_percent'];
		$pay_commission_checkbox = $row['pay_commission_checkbox'];
		$commission_percent = $row['commission_percent'];
		$pay_wait_checkbox = $row['pay_wait_checkbox'];
		$wait_percent = $row['wait_percent'];
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
	}
}
?>
<!DOCTYPE html>
<html>
<head>
	<title>DRIVERS</title>
	<?php include('php/_head.php'); ?>
</head>
<body id='page-view' class='page_view page_drivers_view'>

	<?php if (isset($message)) print $message; ?>
	
	<main>

		<div class='flex'>
			<section>
				<?php 
					$active_symbol = (($active_status == "on") ? "<p class='green'>&#10003;</p>" : "<p class='red'>x</p>");
					if (empty($image_url)) {
						print "<div class='profile-avatar' style='background-image:url(images/icons/avatar_driver.png);'></div> ";
					} else {
						print "<div class='profile-image'><a href='$image_url' target='_blank'><img src='$image_url'></a></div> ";
					}
					
					print "
						<h1>$first_name $last_name</h1>
						<h2>$fleet_number</h2>
						<h3>$contract_type</h3>
						<h1>$active_symbol</h1>
					";
				?>
			</section>
			<section>
				<table>
				<?php 
					if (!empty($username)) print "<tr><td>Username</td><td>$username</td></tr>";
					if (!empty($email)) print "<tr><td>Email</td><td>$email</td></tr>";
					if (!empty($work_phone)) print "<tr><td>Work phone</td><td>$work_phone  " . (!empty($work_phone_extension) ? "($work_phone_extension)" : "") . "</td></tr>";
					if (!empty($mobile_phone)) print "<tr><td>Mobile phone</td><td>$mobile_phone</td></tr>";
					print "<tr><td>&nbsp;</td><td></td></tr>";
					if (!empty($mobile_phone)) print "<tr><td>Hired</td><td>" . date("M d, Y", strtotime($hire_date)) .  "</td></tr>";
					print "<tr><td>&nbsp;</td><td></td></tr>";
					if (!empty($date_of_birth)) print "<tr><td>Date of birth</td><td>" . date("M d, Y", strtotime($date_of_birth)) .  "</td></tr>";
					if (!empty($license_number)) print "<tr><td>License #</td><td>$license_number</td></tr>";
					if (!empty($license_expiry_date)) print "<tr><td>License Expiration</td><td>" . date("M d, Y", strtotime($license_expiry_date)) .  "</td></tr>";
					if (!empty($social_security_number)) print "<tr><td>SSN</td><td>$social_security_number</td></tr>";
					print "<tr><td>&nbsp;</td><td></td></tr>";
					if (!empty($address1)) print "<tr><td>Address</td><td>$address1</td></tr>";
					if (!empty($address2)) print "<tr><td></td><td>$address2</td></tr>";
					if (!empty($city)) print "<tr><td></td><td>$city, $state $zip_code</td></tr>";
					print "<tr><td>&nbsp;</td><td></td></tr>";
					if (!empty($notes)) print "<tr><td>Notes</td><td>$notes</td></tr>";
				?>
				</table>
			</section>
			<section>
				<table>
				<?php 
					if (!empty($payment_method)) print "<tr><td>Payment method</td><td>$payment_method</td><td></td></tr>";
					print "<tr><td>&nbsp;</td><td></td></tr>";
					if ($base_amount_percent != '0') print "<tr><td>Base Amount %</td><td>$base_amount_percent</td><td></td></tr>";
					if ($gratuity_percent != '0') print "<tr><td>Gratuity %</td><td>$gratuity_percent</td><td>" . (($pay_gratuity_checkbox == "on") ? "&#10003;" : "") . "</td></tr>";
					if ($commission_percent != '0') print "<tr><td>Commission %</td><td>$commission_percent</td><td>" . (($pay_commission_checkbox == "on") ? "&#10003;" : "") . "</td></tr>";
					if ($extra_stops_percent != '0') print "<tr><td>Extra stops %</td><td>$extra_stops_percent</td><td>" . (($pay_extra_stops_checkbox == "on") ? "&#10003;" : "") . "</td></tr>";
					if ($offtime_percent != '0') print "<tr><td>Off-time %</td><td>$offtime_percent</td><td>" . (($pay_offtime_checkbox == "on") ? "&#10003;" : "") . "</td></tr>";
					if ($tolls_percent != '0') print "<tr><td>Tolls %</td><td>$tolls_percent</td><td>" . (($pay_tolls_checkbox == "on") ? "&#10003;" : "") . "</td></tr>";
					if ($parking_percent != '0') print "<tr><td>Parking %</td><td>$parking_percent</td><td>" . (($pay_parking_checkbox == "on") ? "&#10003;" : "") . "</td></tr>";
					if ($gas_surcharge_percent != '0') print "<tr><td>Gas surcharge %</td><td>$gas_surcharge_percent</td><td>" . (($pay_gas_surcharge_checkbox == "on") ? "&#10003;" : "") . "</td></tr>";
					if ($extra_charges_percent != '0') print "<tr><td>Extra charge %</td><td>$extra_charges_percent</td><td>" . (($pay_extra_charges_checkbox == "on") ? "&#10003;" : "") . "</td></tr>";
				?>
				</table>
			</section>
		</div>
		
	</main>
	<?php include('php/_footer.php'); ?>
</body>
</html>
