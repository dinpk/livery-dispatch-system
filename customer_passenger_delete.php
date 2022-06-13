<?php 
include('php/_code.php');
$show_record = true;
if (isset($_GET['customer_passengersid'])) {
	$record_id = trim($_GET['customer_passengersid']);
	if (!is_numeric($record_id)) die('Invalid record id.');
	if (isset($_GET['delete'])) {
		$results = mysqli_query($dbcon, "DELETE FROM customer_passengers WHERE key_customer_passengers = $record_id");
		if ($results) {
			$message = "<div class='success-result'>Deleted successfully</div>
			<div class='center'><br><br><input type='button' value='Close' onclick='parent.location.reload(false);'></div>";
			$show_record = false;
		} else {
			$message = "<div class='failure-result'>Could not delete record</div>";
		}
	} else {
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
		}
	}
}
?>
<!DOCTYPE html>
<html>
<head>
 <title>CUSTOMER PASSENGERS</title>
 <?php include('php/_head.php'); ?>
</head>
<body id='page-delete' class='page_delete page_customer_passengers_delete'>

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
         <td class='label-cell'>First name</td>
         <td class='value-cell'><?php if (isset($first_name)) print $first_name; ?></td>
         </tr>

         <tr>
         <td class='label-cell'>Last name</td>
         <td class='value-cell'><?php if (isset($last_name)) print $last_name; ?></td>
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
         <td class='label-cell'>Country</td>
         <td class='value-cell'><?php if (isset($country)) print $country; ?></td>
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
         <td class='label-cell'>Website</td>
         <td class='value-cell'><?php if (isset($website)) print $website; ?></td>
         </tr>

         <tr>
         <td class='label-cell'>Image url</td>
         <td class='value-cell'><?php if (isset($image_url)) print $image_url; ?></td>
         </tr>

         <tr>
         <td class='label-cell'>Company name</td>
         <td class='value-cell'><?php if (isset($company_name)) print $company_name; ?></td>
         </tr>

         <tr>
         <td class='label-cell'>Package</td>
         <td class='value-cell'><?php if (isset($package_name)) print $package_name; ?></td>
         </tr>

         <tr>
         <td class='label-cell'>Billing contact name</td>
         <td class='value-cell'><?php if (isset($billing_contact_name)) print $billing_contact_name; ?></td>
         </tr>

         <tr>
         <td class='label-cell'>Payment method</td>
         <td class='value-cell'><?php if (isset($payment_method)) print $payment_method; ?></td>
         </tr>

         <tr>
         <td class='label-cell'>Confirm to passenger</td>
         <td class='value-cell'><?php if (isset($confirm_to_passenger)) print $confirm_to_passenger; ?></td>
         </tr>

         <tr>
         <td class='label-cell'>Confirm to contact</td>
         <td class='value-cell'><?php if (isset($confirm_to_contact)) print $confirm_to_contact; ?></td>
         </tr>

         <tr>
         <td class='label-cell'>Confirm to billing contact</td>
         <td class='value-cell'><?php if (isset($confirm_to_billing_contact)) print $confirm_to_billing_contact; ?></td>
         </tr>

         <tr>
         <td class='label-cell'>Notes</td>
         <td class='value-cell'><?php if (isset($notes)) print $notes; ?></td>
         </tr>

         <tr>
         <td class='label-cell'>Trip ticket notes</td>
         <td class='value-cell'><?php if (isset($trip_ticket_notes)) print $trip_ticket_notes; ?></td>
         </tr>

         <tr>
         <td class='label-cell'>Ad source</td>
         <td class='value-cell'><?php if (isset($ad_source)) print $ad_source; ?></td>
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
