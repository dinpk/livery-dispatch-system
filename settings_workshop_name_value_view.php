<?php 
include('php/_code.php');
if (isset($_GET['settingsworkshopnameid'])) {
	$record_id = trim($_GET['settingsworkshopnameid']);
	if (!is_numeric($record_id)) die('Invalid record id.');
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
	}
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>SETTINGS - WORKSHOP NAME</title>
    <?php include('php/_head.php'); ?>
</head>
<body id='page-view'>
    <?php if (isset($message)) print $message; ?>
    <main>
        <table class='record-table'>
            <tr>
                <td class='label-cell'>Workshop name</td>
                <td class='value-cell'><?php if (isset($workshop_name)) print $workshop_name; ?></td>
            </tr>
            <tr>
                <td class='label-cell'>Contact person</td>
                <td class='value-cell'><?php if (isset($contact_name)) print $contact_name; ?></td>
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
                <td class='label-cell'>Phone</td>
                <td class='value-cell'><?php if (isset($phone)) print $phone; ?></td>
            </tr>
            <tr>
                <td class='label-cell'>Email</td>
                <td class='value-cell'><?php if (isset($email)) print $email; ?></td>
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
        </table>
    </main>
    <?php include('php/_footer.php'); ?>
</body>
</html>