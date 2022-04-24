<?php 
include('php/_code.php');
if (isset($_GET['customer_contactsid'])) {
	$record_id = trim($_GET['customer_contactsid']);
	if (!is_numeric($record_id)) die('Invalid record id.');
	$results = mysqli_query($dbcon, "SELECT * FROM customer_contacts WHERE key_customer_contacts = $record_id");
	if ($row = mysqli_fetch_assoc($results)) {
		$company_name = $row['company_name'];
		$key_customer_companies = $row['key_customer_companies'];
		$image_url = $row['image_url'];
		$first_name = $row['first_name'];
		$last_name = $row['last_name'];
		$address1 = $row['address1'];
		$address2 = $row['address2'];
		$city = $row['city'];
		$state = $row['state'];
		$zip_code = $row['zip_code'];
		$country = $row['country'];
		$work_phone = $row['work_phone'];
		$work_phone_extension = $row['work_phone_extension'];
		$mobile_phone = $row['mobile_phone'];
		$email = $row['email'];
		$active_status = $row['active_status'];
	} else {
		$message = "<div class='failure-result'>Record not found</div>";
	}
}
?>
<!DOCTYPE html>
<html>
<head>
	<title>CUSTOMER CONTACTS</title>
	<?php include('php/_head.php'); ?>
</head>
<body id='page-view' class='page_view page_customer_contacts_view'>

	<?php if (isset($message)) print $message; ?>
	
	<main>
		
		<div class='flex'>
			<section>
				<?php 
					$active_symbol = (($active_status == "on") ? "<p class='green'>&#10003;</p>" : "<p class='red'>x</p>");
					if (empty($image_url)) {
						print "<div class='profile-avatar' style='background-image:url(images/icons/avatar_contact.png);'></div> ";
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
				?>
				</table>
			</section>
		</div>
		

	</main>
	<?php include('php/_footer.php'); ?>
</body>
</html>
