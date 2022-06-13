<?php 
include('php/_code.php');
if (isset($_GET['customer_billing_contactsid'])) {
	$record_id = trim($_GET['customer_billing_contactsid']);
	if (!is_numeric($record_id)) die('Invalid record id.');
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
		$country = $row['country'];
		$zip_code = $row['zip_code'];
		$confirmation_email = $row['confirmation_email'];
		$phone = $row['phone'];
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
	<title>CUSTOMER BILLING CONTACTS</title>
	<?php include('php/_head.php'); ?>
</head>
<body id='page-view' class='page_view page_customer_billing_contacts_view'>

	<?php if (isset($message)) print $message; ?>
	
	<main>

		<div class='flex'>
			<section>
				<?php 
					$active_symbol = (($active_status == "on") ? "<p class='green'>&#10003;</p>" : "<p class='red'>x</p>");
					if (empty($image_url)) {
						print "<div class='profile-avatar' style='background-image:url(images/icons/avatar_billing_contact.png);'></div> ";
					} else {
						print "<div class='profile-image'><a href='$image_url' target='_blank'><img src='$image_url'></a></div> ";
					}
					
					print "<h1>$contact_name</h1>";
					if (!empty($card_type)) print "<h2>$card_type</h2>";
				?>
			</section>
			<section>
				<table>
				<?php
					if (!empty($card_number)) print "<tr><td>Card #</td><td>$card_number</td></tr>";
					if (!empty($card_expiration)) print "<tr><td>Expiration</td><td>$card_expiration</td></tr>";
					if (!empty($card_security_code)) print "<tr><td>Security code</td><td>$card_security_code</td></tr>";
					if (!empty($name_on_card)) print "<tr><td>Name on card</td><td>$name_on_card</td></tr>";
					print "<tr><td>&nbsp;</td><td></td></tr>";
					if (!empty($confirmation_email)) print "<tr><td>Email</td><td>$confirmation_email</td></tr>";
					if (!empty($phone)) print "<tr><td>Phone</td><td>$phone</td></tr>";
					print "<tr><td>&nbsp;</td><td></td></tr>";
					if (!empty($address1)) print "<tr><td>Address</td><td>$address1</td></tr>";
					if (!empty($address2)) print "<tr><td>Address 2</td><td>$address2</td></tr>";
					if (!empty($city)) print "<tr><td></td><td>$city, $state $zip_code</td></tr>";
					if (!empty($country)) print "<tr><td>Address 2</td><td>$country</td></tr>";
				?>
				</table>
			</section>
			<section>
				<table>
				<?php
					if (!empty($notes)) print "<tr><td>Notes</td><td>$notes</td></tr>";
				?>
				</table>
			</section>
		</div>
	
	</main>
	<?php include('php/_footer.php'); ?>
</body>
</html>
