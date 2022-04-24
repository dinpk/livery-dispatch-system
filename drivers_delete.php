<?php 
include('php/_code.php');
$show_record = true;
if (isset($_GET['driversid'])) {
	$record_id = trim($_GET['driversid']);
	if (!is_numeric($record_id)) die('Invalid record id.');
	if (isset($_GET['delete'])) {
		$results = mysqli_query($dbcon, "DELETE FROM drivers WHERE key_drivers = $record_id");
		if ($results) {
			$message = "<div class='success-result'>Deleted successfully</div>
			<div class='center'><br><br><input type='button' value='Close' onclick='parent.location.reload(false);'></div>";
			$show_record = false;
		} else {
			$message = "<div class='failure-result'>Could not delete record</div>";
		}
	} else {
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
}
?>
<!DOCTYPE html>
<html>
<head>
 <title>DRIVERS</title>
 <?php include('php/_head.php'); ?>
</head>
<body id='page-delete' class='page_delete page_drivers_delete'>

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
         <td class='label-cell'>Image url</td>
         <td class='value-cell'><?php if (isset($image_url)) print $image_url; ?></td>
         </tr>

         <tr>
         <td class='label-cell'>User name</td>
         <td class='value-cell'><?php if (isset($username)) print $username; ?></td>
         </tr>

         <tr>
         <td class='label-cell'>Password</td>
         <td class='value-cell'><?php if (isset($password)) print $password; ?></td>
         </tr>

         <tr>
         <td class='label-cell'>First name</td>
         <td class='value-cell'><?php if (isset($first_name)) print $first_name; ?></td>
         </tr>

         <tr>
         <td class='label-cell'>Last name</td>
         <td class='value-cell'><?php if (isset($last_name)) print $last_name; ?></td>
         </tr>

         <tr>
         <td class='label-cell'>Contract type</td>
         <td class='value-cell'><?php if (isset($contract_type)) print $contract_type; ?></td>
         </tr>

         <tr>
         <td class='label-cell'>Address 1</td>
         <td class='value-cell'><?php if (isset($address1)) print $address1; ?></td>
         </tr>

         <tr>
         <td class='label-cell'>Address 2</td>
         <td class='value-cell'><?php if (isset($address2)) print $address2; ?></td>
         </tr>

         <tr>
         <td class='label-cell'>City</td>
         <td class='value-cell'><?php if (isset($city)) print $city; ?></td>
         </tr>

         <tr>
         <td class='label-cell'>State</td>
         <td class='value-cell'><?php if (isset($state)) print $state; ?></td>
         </tr>

         <tr>
         <td class='label-cell'>Zip code</td>
         <td class='value-cell'><?php if (isset($zip_code)) print $zip_code; ?></td>
         </tr>

         <tr>
         <td class='label-cell'>Work phone</td>
         <td class='value-cell'><?php if (isset($work_phone)) print $work_phone; ?></td>
         </tr>

         <tr>
         <td class='label-cell'>Work phone ext.</td>
         <td class='value-cell'><?php if (isset($work_phone_extension)) print $work_phone_extension; ?></td>
         </tr>

         <tr>
         <td class='label-cell'>Mobile phone</td>
         <td class='value-cell'><?php if (isset($mobile_phone)) print $mobile_phone; ?></td>
         </tr>

         <tr>
         <td class='label-cell'>Email</td>
         <td class='value-cell'><?php if (isset($email)) print $email; ?></td>
         </tr>

         <tr>
         <td class='label-cell'>Date of birth</td>
         <td class='value-cell'><?php if (isset($date_of_birth)) print $date_of_birth; ?></td>
         </tr>

         <tr>
         <td class='label-cell'>License #</td>
         <td class='value-cell'><?php if (isset($license_number)) print $license_number; ?></td>
         </tr>

         <tr>
         <td class='label-cell'>License expiry date</td>
         <td class='value-cell'><?php if (isset($license_expiry_date)) print $license_expiry_date; ?></td>
         </tr>

         <tr>
         <td class='label-cell'>Ssn</td>
         <td class='value-cell'><?php if (isset($social_security_number)) print $social_security_number; ?></td>
         </tr>

         <tr>
         <td class='label-cell'>Hire date</td>
         <td class='value-cell'><?php if (isset($hire_date)) print $hire_date; ?></td>
         </tr>

         <tr>
         <td class='label-cell'>Fleet #</td>
         <td class='value-cell'><?php if (isset($fleet_number)) print $fleet_number; ?></td>
         </tr>

         <tr>
         <td class='label-cell'>Payment method</td>
         <td class='value-cell'><?php if (isset($payment_method)) print $payment_method; ?></td>
         </tr>

         <tr>
         <td class='label-cell'>Base amount ^</td>
         <td class='value-cell'><?php if (isset($base_amount_percent)) print $base_amount_percent; ?></td>
         </tr>

         <tr>
         <td class='label-cell'>Hourly rate</td>
         <td class='value-cell'><?php if (isset($hourly_rate)) print $hourly_rate; ?></td>
         </tr>

         <tr>
         <td class='label-cell'>Pay gratuity</td>
         <td class='value-cell'><?php if (isset($pay_gratuity_checkbox)) print $pay_gratuity_checkbox; ?></td>
         </tr>

         <tr>
         <td class='label-cell'>Gratuity %</td>
         <td class='value-cell'><?php if (isset($gratuity_percent)) print $gratuity_percent; ?></td>
         </tr>

         <tr>
         <td class='label-cell'>Pay commission</td>
         <td class='value-cell'><?php if (isset($pay_commission_checkbox)) print $pay_commission_checkbox; ?></td>
         </tr>

         <tr>
         <td class='label-cell'>Commission %</td>
         <td class='value-cell'><?php if (isset($commission_percent)) print $commission_percent; ?></td>
         </tr>

         <tr>
         <td class='label-cell'>Pay wait time</td>
         <td class='value-cell'><?php if (isset($pay_wait_checkbox)) print $pay_wait_checkbox; ?></td>
         </tr>

         <tr>
         <td class='label-cell'>Wait time %</td>
         <td class='value-cell'><?php if (isset($wait_percent)) print $wait_percent; ?></td>
         </tr>

         <tr>
         <td class='label-cell'>Pay extra stops</td>
         <td class='value-cell'><?php if (isset($pay_extra_stops_checkbox)) print $pay_extra_stops_checkbox; ?></td>
         </tr>

         <tr>
         <td class='label-cell'>Extra stops %</td>
         <td class='value-cell'><?php if (isset($extra_stops_percent)) print $extra_stops_percent; ?></td>
         </tr>

         <tr>
         <td class='label-cell'>Pay off-time</td>
         <td class='value-cell'><?php if (isset($pay_offtime_checkbox)) print $pay_offtime_checkbox; ?></td>
         </tr>

         <tr>
         <td class='label-cell'>Off-time %</td>
         <td class='value-cell'><?php if (isset($offtime_percent)) print $offtime_percent; ?></td>
         </tr>

         <tr>
         <td class='label-cell'>Pay tolls</td>
         <td class='value-cell'><?php if (isset($pay_tolls_checkbox)) print $pay_tolls_checkbox; ?></td>
         </tr>

         <tr>
         <td class='label-cell'>Tolls %</td>
         <td class='value-cell'><?php if (isset($tolls_percent)) print $tolls_percent; ?></td>
         </tr>

         <tr>
         <td class='label-cell'>Pay parking</td>
         <td class='value-cell'><?php if (isset($pay_parking_checkbox)) print $pay_parking_checkbox; ?></td>
         </tr>

         <tr>
         <td class='label-cell'>Parking %</td>
         <td class='value-cell'><?php if (isset($parking_percent)) print $parking_percent; ?></td>
         </tr>

         <tr>
         <td class='label-cell'>Pay gas surcharge</td>
         <td class='value-cell'><?php if (isset($pay_gas_surcharge_checkbox)) print $pay_gas_surcharge_checkbox; ?></td>
         </tr>

         <tr>
         <td class='label-cell'>Gas surcharge %</td>
         <td class='value-cell'><?php if (isset($gas_surcharge_percent)) print $gas_surcharge_percent; ?></td>
         </tr>

         <tr>
         <td class='label-cell'>Pay extra charges</td>
         <td class='value-cell'><?php if (isset($pay_extra_charges_checkbox)) print $pay_extra_charges_checkbox; ?></td>
         </tr>

         <tr>
         <td class='label-cell'>Extra charges %</td>
         <td class='value-cell'><?php if (isset($extra_charges_percent)) print $extra_charges_percent; ?></td>
         </tr>

         <tr>
         <td class='label-cell'>Notes</td>
         <td class='value-cell'><?php if (isset($notes)) print $notes; ?></td>
         </tr>

         <tr>
         <td class='label-cell'>Status</td>
         <td class='value-cell'><?php if (isset($active_status)) print $active_status; ?></td>
         </tr>

     </table>

 </main>

 <?php } // show_record ?>


 <?php include('php/_footer.php'); ?>
</body>
</html>
