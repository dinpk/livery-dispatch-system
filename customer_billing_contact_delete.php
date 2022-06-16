<?php 
include('php/_code.php');
$show_record = true;
if (isset($_GET['customerbillingcontactid'])) {
	$record_id = trim($_GET['customerbillingcontactid']);
	if (!is_numeric($record_id)) die('Invalid record id.');
	if (isset($_GET['delete'])) {
		$results = mysqli_query($dbcon, "DELETE FROM customer_billing_contacts WHERE key_customer_billing_contacts = $record_id");
		if ($results) {
			$message = "<div class='success-result'>Deleted successfully</div>
			<div class='center'><br><br><input type='button' value='Close' onclick='parent.location.reload(false);'></div>";
			$show_record = false;
		} else {
			$message = "<div class='failure-result'>Could not delete record</div>";
		}
	} else {
		$results = mysqli_query($dbcon, "SELECT * FROM customer_billing_contacts WHERE key_customer_billing_contacts = $record_id");
		if ($row = mysqli_fetch_assoc($results)) {
			$contact_name = $row['contact_name'];
			$card_type = $row['card_type'];
			$card_number = $row['card_number'];
			$card_expiration = $row['card_expiration'];
			$card_security_code = $row['card_security_code'];
			$name_on_card = $row['name_on_card'];
			$address1 = $row['address1'];
			$address2 = $row['address2'];
			$city = $row['city'];
			$state = $row['state'];
			$zip_code = $row['zip_code'];
			$confirmation_email = $row['confirmation_email'];
			$phone = $row['phone'];
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
 <title>CUSTOMER BILLING CONTACTS</title>
 <?php include('php/_head.php'); ?>
</head>
<body id='page-delete'>
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
         <td class='label-cell'>Contact name</td>
         <td class='value-cell'><?php if (isset($contact_name)) print $contact_name; ?></td>
         </tr>
         <tr>
         <td class='label-cell'>Card type</td>
         <td class='value-cell'><?php if (isset($card_type)) print $card_type; ?></td>
         </tr>
         <tr>
         <td class='label-cell'>Card #</td>
         <td class='value-cell'><?php if (isset($card_number)) print $card_number; ?></td>
         </tr>
         <tr>
         <td class='label-cell'>Expiration</td>
         <td class='value-cell'><?php if (isset($card_expiration)) print $card_expiration; ?></td>
         </tr>
         <tr>
         <td class='label-cell'>Security code</td>
         <td class='value-cell'><?php if (isset($card_security_code)) print $card_security_code; ?></td>
         </tr>
         <tr>
         <td class='label-cell'>Name on card</td>
         <td class='value-cell'><?php if (isset($name_on_card)) print $name_on_card; ?></td>
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
         <td class='label-cell'>Confirmation email</td>
         <td class='value-cell'><?php if (isset($confirmation_email)) print $confirmation_email; ?></td>
         </tr>
         <tr>
         <td class='label-cell'>Phone</td>
         <td class='value-cell'><?php if (isset($phone)) print $phone; ?></td>
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
