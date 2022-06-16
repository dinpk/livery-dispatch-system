<?php 
include('php/_code.php');
$show_form = true;
$focus_field = 'company_name';
// id passed for update
if (isset($_GET['customercompanyid'])) {
	$record_id = trim($_GET['customercompanyid']);
	if (!is_numeric($record_id)) exit;
	if (!isset($_POST['save_submit'])) {		$results = mysqli_query($dbcon, "SELECT * FROM customer_companies WHERE key_customer_companies = $record_id");
		if ($row = mysqli_fetch_assoc($results)) {
			$company_name = $row['company_name'];
			$image_url = $row['image_url'];
			$address1 = $row['address1'];
			$address2 = $row['address2'];
			$city = $row['city'];
			$state = $row['state'];
			$zip_code = $row['zip_code'];
			$phone1 = $row['phone1'];
			$phone2 = $row['phone2'];
			$email = $row['email'];
			$website = $row['website'];
			$country = $row['country'];
			$notes = $row['notes'];
			$active_status = $row['active_status'];
		} else {
			$message = "<div class='failure-result'>Record not found</div>";
			$show_form = false;
		}
	}
}
// save button clicked
if (isset($_POST['save_submit'])) {
	$error = 0;
	$active_status = trim($_POST['active_status']);
	if (strlen($active_status) > 5) {
		$msg_active_status = "<div class='message-error'>Provide a valid value of length 0-5</div>";
		$focus_field = 'active_status';
		$error = 1;
	}
	$notes = trim($_POST['notes']);
	if (strlen($notes) > 2000) {
		$msg_notes = "<div class='message-error'>Provide a valid value of length 0-2000</div>";
		$focus_field = 'notes';
		$error = 1;
	}
	$country = trim($_POST['country']);
	if (strlen($country) > 100) {
		$msg_country = "<div class='message-error'>Provide a valid value of length 0-100</div>";
		$focus_field = 'country';
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
	$phone2 = trim($_POST['phone2']);
	if (strlen($phone2) > 30) {
		$msg_phone2 = "<div class='message-error'>Provide a valid value of length 0-30</div>";
		$focus_field = 'phone2';
		$error = 1;
	}	
	$phone1 = trim($_POST['phone1']);
	if (strlen($phone1) > 30) {
		$msg_phone1 = "<div class='message-error'>Provide a valid value of length 0-30</div>";
		$focus_field = 'phone1';
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
	$image_url = trim($_POST['image_url']);
	if (strlen($image_url) > 100) {
		$msg_image_url = "<div class='message-error'>Provide a valid value of length 0-100</div>";
		$focus_field = 'image_url';
		$error = 1;
	}
	$company_name = trim($_POST['company_name']);
	if (strlen($company_name) < 3 || strlen($company_name) > 100) {
		$msg_company_name = "<div class='message-error'>Provide a valid value of length 3-100</div>";
		$focus_field = 'company_name';
		$error = 1;
	}
	// no validation error
	if ($error == 0) {
		if (isset($record_id) && $error != 1) { // update
			$results = mysqli_query($dbcon, "UPDATE customer_companies SET 
			company_name = '" . sd($dbcon, $company_name) . "',
			image_url = '" . sd($dbcon, $image_url) . "',
			address1 = '" . sd($dbcon, $address1) . "',
			address2 = '" . sd($dbcon, $address2) . "',
			city = '" . sd($dbcon, $city) . "',
			state = '" . sd($dbcon, $state) . "',
			zip_code = '" . sd($dbcon, $zip_code) . "',
			phone1 = '" . sd($dbcon, $phone1) . "',
			phone2 = '" . sd($dbcon, $phone2) . "',
			email = '" . sd($dbcon, $email) . "',
			website = '" . sd($dbcon, $website) . "',
			country = '" . sd($dbcon, $country) . "',
			notes = '" . sd($dbcon, $notes) . "',
			active_status = '" . sd($dbcon, $active_status) . "'
				WHERE key_customer_companies = $record_id");
			if ($results) {
				$message = "<script>parent.location.reload(false);</script>";
			} else {
				//print mysqli_error($dbcon);
				die('Unable to update, please contact your system administrator.');
			}
		} else if ($error != 1) { // insert
			$results = mysqli_query($dbcon, "INSERT INTO customer_companies (
			company_name,
			image_url,
			address1,
			address2,
			city,
			state,
			zip_code,
			phone1,
			phone2,
			email,
			website,
			country,
			notes,
			active_status
			) 
			VALUES (
			'" . sd($dbcon, $company_name) . "',
			'" . sd($dbcon, $image_url) . "',
			'" . sd($dbcon, $address1) . "',
			'" . sd($dbcon, $address2) . "',
			'" . sd($dbcon, $city) . "',
			'" . sd($dbcon, $state) . "',
			'" . sd($dbcon, $zip_code) . "',
			'" . sd($dbcon, $phone1) . "',
			'" . sd($dbcon, $phone2) . "',
			'" . sd($dbcon, $email) . "',
			'" . sd($dbcon, $website) . "',
			'" . sd($dbcon, $country) . "',
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
    <title>CUSTOMER COMPANY</title>
    <?php include('php/_head.php'); ?>
</head>
<body id='page-save'>
    <section id='sub-menu'>
        <div class='left-block'>customer company</div>
        <div class='right-block'>

        </div>
    </section>
    <?php if (isset($message)) print $message; ?>
    <main>
        <?php if (isset($show_form) && $show_form) { ?>
        <form method='post'>
            <fieldset>
                <div>
                    <label for='company_name'>Company name</label> <span class='red'> *</span>
                    <?php if(isset($msg_company_name)) print $msg_company_name; ?>
                    <input id='company_name' name='company_name' type='text'
                        value='<?php if (isset($company_name)) {print $company_name;} else { print '';} ?>'
                        required><br>
                </div>
                <div>
                    <label for='address1'>Address 1</label>
                    <?php if(isset($msg_address1)) print $msg_address1; ?>
                    <input id='address1' name='address1' type='text'
                        value='<?php if (isset($address1)) {print $address1;} else { print '';} ?>'><br>
                </div>
                <div>
                    <label for='address2'>Address 2</label>
                    <?php if(isset($msg_address2)) print $msg_address2; ?>
                    <input id='address2' name='address2' type='text'
                        value='<?php if (isset($address2)) {print $address2;} else { print '';} ?>'><br>
                </div>
                <div>
                    <label for='city'>City</label>
                    <?php if(isset($msg_city)) print $msg_city; ?>
                    <input id='city' name='city' type='text'
                        value='<?php if (isset($city)) {print $city;} else { print '';} ?>'><br>
                </div>
                <div>
                    <label for='country'>Country</label><br>
                    <?php if(isset($msg_country)) print $msg_country; ?>
                    <select id='country' name='country' onchange='populateStatesOfCountry(this.value);'>
                        <option></option>
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
                    <label for='state'>State</label><br>
                    <?php if(isset($msg_state)) print $msg_state; ?>
                    <progress id='loader'></progress>
                    <select id='state' name='state'>
                        <?php 
						$options = '';
						$results = mysqli_query($dbcon, "SELECT state FROM settings_state_values WHERE country = '$country'");
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
                    <label for='zip_code'>Zip code</label>
                    <?php if(isset($msg_zip_code)) print $msg_zip_code; ?>
                    <input id='zip_code' name='zip_code' type='text'
                        value='<?php if (isset($zip_code)) {print $zip_code;} else { print '';} ?>'><br>
                </div>
            </fieldset>
            <fieldset>
                <div>
                    <label for='phone1'>Phone 1</label>
                    <?php if(isset($msg_phone1)) print $msg_phone1; ?>
                    <input id='phone1' name='phone1' type='tel'
                        value='<?php if (isset($phone1)) {print $phone1;} else { print '';} ?>'><br>
                </div>
                <div>
                    <label for='phone2'>Phone 2</label>
                    <?php if(isset($msg_phone2)) print $msg_phone2; ?>
                    <input id='phone2' name='phone2' type='tel'
                        value='<?php if (isset($phone2)) {print $phone2;} else { print '';} ?>'><br>
                </div>
                <div>
                    <label for='email'>Email</label>
                    <?php if(isset($msg_email)) print $msg_email; ?>
                    <input id='email' name='email' type='email'
                        value='<?php if (isset($email)) {print $email;} else { print '';} ?>'><br>
                </div>
                <div>
                    <label for='website'>Website</label>
                    <?php if(isset($msg_website)) print $msg_website; ?>
                    <input id='website' name='website' type='url'
                        value='<?php if (isset($website)) {print $website;} else { print '';} ?>'><br>
                </div>
                <div>
                    <label for='image_url'>Image url</label>
                    <?php if(isset($msg_image_url)) print $msg_image_url; ?>
                    <input id='image_url' name='image_url' type='text'
                        value='<?php if (isset($image_url)) {print $image_url;} else { print '';} ?>'><br>
                </div>
                <div>
                    <label for='notes'>Notes</label>
                    <?php if(isset($msg_notes)) print $msg_notes; ?>
                    <textarea id='notes' name='notes'><?php if (isset($notes)) print $notes; ?></textarea><br>
                </div>
                <div>
                    <?php if(isset($msg_active_status)) print $msg_active_status; ?>
                    <input <?php if (!isset($active_status) || $active_status=='on') {print "checked='checked'";} ?>
                        type='checkbox' id='active_status' name='active_status'> <label
                        for='active_status'>Status</label><br>
                </div>
            </fieldset>
            <input id='save_submit' name='save_submit' type='submit' value='Save'>
        </form>
        <?php } ?>
    </main>
    <?php include('php/_footer.php'); ?>
</body>
</html>