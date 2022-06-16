<?php 
include('php/_code.php');
if (isset($_GET['customerpassengerid'])) {
	$record_id = trim($_GET['customerpassengerid']);
	if (!is_numeric($record_id)) die('Invalid record id.');
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
?>
<!DOCTYPE html>
<html>
<head>
    <title>CUSTOMER PASSENGERS</title>
    <?php include('php/_head.php'); ?>
</head>
<body id='page-view'>
    <?php if (isset($message)) print $message; ?>
    <main>
        <div class='flex'>
            <section>
                <?php 
					$active_symbol = (($active_status == "on") ? "<p class='green'>&#10003;</p>" : "<p class='red'>x</p>");
					if (empty($image_url)) {
						print "<div class='profile-avatar' style='background-image:url(images/icons/avatar_passenger.png);'></div> ";
					} else {
						print "<div class='profile-image'><a href='$image_url' target='_blank'><img src='$image_url'></a></div> ";
					}
					
					print "<h1>$first_name $last_name</h1>";
					if (!empty($company_name)) print "<h2>$company_name</h2>";
					if (!empty($city)) print "<h3>$city, $state</h3>";
				?>
            </section>
            <section>
                <table>
                    <?php
					if (!empty($address1)) print "<tr><td>Address</td><td>$address1</td></tr>";
					if (!empty($address2)) print "<tr><td>Address 2</td><td>$address2</td></tr>";
					if (!empty($city)) print "<tr><td></td><td>$city, $state $zip_code</td></tr>";
					if (!empty($country)) print "<tr><td></td><td>$country</td></tr>";
					print "<tr><td>&nbsp;</td><td></td></tr>";
					if (!empty($email)) print "<tr><td>Email</td><td>$email</td></tr>";
					if (!empty($work_phone)) print "<tr><td>Work phone</td><td>$work_phone " . (!empty($work_phone_extension) ? "($work_phone_extension)" : "") . "</td></tr>";
					if (!empty($mobile_phone)) print "<tr><td>Mobile phone</td><td>$mobile_phone</td></tr>";
					if (!empty($website)) print "<tr><td>Website</td><td>$website</td></tr>";
					print "<tr><td>&nbsp;</td><td></td></tr>";
					if (!empty($package_name)) print "<tr><td>Package</td><td>$package_name</td></tr>";
					if (!empty($billing_contact_name)) print "<tr><td>Billing contact</td><td>$billing_contact_name</td></tr>";
					if (!empty($payment_method)) print "<tr><td>Payment method</td><td>$payment_method</td></tr>";
					if (!empty($confirm_to_passenger) || !empty($confirm_to_contact) || !empty($confirm_to_billing_contact)) {
						print "<tr><td>Confirm</td><td>";
						if (!empty($confirm_to_passenger)) print (str_replace("on", "&#10003;", $confirm_to_passenger) . "  passenger<br>");
						if (!empty($confirm_to_contact)) print (str_replace("on", "&#10003;", $confirm_to_contact) . "  contact<br>");
						if (!empty($confirm_to_billing_contact)) print (str_replace("on", "&#10003;", $confirm_to_billing_contact) . "  billing contact<br>");
						print "</td></tr>";
						
					}
					if (!empty($ad_source)) print "<tr><td>Ad source</td><td>$ad_source</td></tr>";
					?>
                </table>
            </section>
            <section>
                <table>
                    <?php
					if (!empty($notes)) print "<tr><td>Notes</td><td>$notes</td></tr>";
					if (!empty($trip_ticket_notes)) print "<tr><td>Trip ticket notes</td><td>$trip_ticket_notes</td></tr>";
					?>
                </table>
            </section>
        </div>
    </main>
    <?php include('php/_footer.php'); ?>
</body>
</html>