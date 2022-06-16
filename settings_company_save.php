<?php 
include('php/_code.php');
$show_form = true;
$focus_field = 'company_name';
// id passed for update
if (isset($_GET['settingscompanyid'])) {
	$record_id = trim($_GET['settingscompanyid']);
	if (!is_numeric($record_id)) exit;
	if (!isset($_POST['save_submit'])) {
		$results = mysqli_query($dbcon, "SELECT * FROM settings_company WHERE key_settings_company = $record_id");
		if ($row = mysqli_fetch_assoc($results)) {
			$company_name = $row['company_name'];
			$company_label = $row['company_label'];
			$slogan = $row['slogan'];
			$address1 = $row['address1'];
			$address2 = $row['address2'];
			$city = $row['city'];
			$state = $row['state'];
			$zip_code = $row['zip_code'];
			$country = $row['country'];
			$phone1 = $row['phone1'];
			$phone2 = $row['phone2'];
			$email1 = $row['email1'];
			$email2 = $row['email2'];
			$website1 = $row['website1'];
			$website2 = $row['website2'];
			$social_media_url1 = $row['social_media_url1'];
			$social_media_url2 = $row['social_media_url2'];
			$social_media_url3 = $row['social_media_url3'];
			$social_media_url4 = $row['social_media_url4'];
			$social_media_url5 = $row['social_media_url5'];
			$notes = $row['notes'];
			$image_url1 = $row['image_url1'];
			$image_url2 = $row['image_url2'];
		} else {
			$message = "<div class='failure-result'>Record not found</div>";
			$show_form = false;
		}
	}
}
// save button clicked
if (isset($_POST['save_submit'])) {
	$error = 0;
	$image_url2 = trim($_POST['image_url2']);
	if (strlen($image_url2) > 100) {
		$msg_image_url2 = "<div class='message-error'>Provide a valid value of length 0-100</div>";
		$focus_field = 'image_url2';
		$error = 1;
	}
	$image_url1 = trim($_POST['image_url1']);
	if (strlen($image_url1) > 100) {
		$msg_image_url1 = "<div class='message-error'>Provide a valid value of length 0-100</div>";
		$focus_field = 'image_url1';
		$error = 1;
	}
	$notes = trim($_POST['notes']);
	if (strlen($notes) > 2000) {
		$msg_notes = "<div class='message-error'>Provide a valid value of length 0-2000</div>";
		$focus_field = 'notes';
		$error = 1;
	}
	$social_media_url5 = trim($_POST['social_media_url5']);
	if (strlen($social_media_url5) > 200) {
		$msg_social_media_url5 = "<div class='message-error'>Provide a valid value of length 0-200</div>";
		$focus_field = 'social_media_url5';
		$error = 1;
	}
	$social_media_url4 = trim($_POST['social_media_url4']);
	if (strlen($social_media_url4) > 200) {
		$msg_social_media_url4 = "<div class='message-error'>Provide a valid value of length 0-200</div>";
		$focus_field = 'social_media_url4';
		$error = 1;
	}
	$social_media_url3 = trim($_POST['social_media_url3']);
	if (strlen($social_media_url3) > 200) {
		$msg_social_media_url3 = "<div class='message-error'>Provide a valid value of length 0-200</div>";
		$focus_field = 'social_media_url3';
		$error = 1;
	}
	$social_media_url2 = trim($_POST['social_media_url2']);
	if (strlen($social_media_url2) > 200) {
		$msg_social_media_url2 = "<div class='message-error'>Provide a valid value of length 0-200</div>";
		$focus_field = 'social_media_url2';
		$error = 1;
	}
	$social_media_url1 = trim($_POST['social_media_url1']);
	if (strlen($social_media_url1) > 200) {
		$msg_social_media_url1 = "<div class='message-error'>Provide a valid value of length 0-200</div>";
		$focus_field = 'social_media_url1';
		$error = 1;
	}
	$website2 = trim($_POST['website2']);
	if (strlen($website2) > 100) {
		$msg_website2 = "<div class='message-error'>Provide a valid value of length 0-100</div>";
		$focus_field = 'website2';
		$error = 1;
	}
	$website1 = trim($_POST['website1']);
	if (strlen($website1) > 100) {
		$msg_website1 = "<div class='message-error'>Provide a valid value of length 0-100</div>";
		$focus_field = 'website1';
		$error = 1;
	}
	$email2 = trim($_POST['email2']);
	if (strlen($email2) > 100) {
		$msg_email2 = "<div class='message-error'>Provide a valid value of length 0-100</div>";
		$focus_field = 'email2';
		$error = 1;
	}
	$email1 = trim($_POST['email1']);
	if (strlen($email1) > 100) {
		$msg_email1 = "<div class='message-error'>Provide a valid value of length 0-100</div>";
		$focus_field = 'email1';
		$error = 1;
	}
	$phone2 = trim($_POST['phone2']);
	if (strlen($phone2) > 50) {
		$msg_phone2 = "<div class='message-error'>Provide a valid value of length 0-50</div>";
		$focus_field = 'phone2';
		$error = 1;
	}
	$phone1 = trim($_POST['phone1']);
	if (strlen($phone1) > 50) {
		$msg_phone1 = "<div class='message-error'>Provide a valid value of length 0-50</div>";
		$focus_field = 'phone1';
		$error = 1;
	}
	$country = trim($_POST['country']);
	if (strlen($country) > 100) {
		$msg_country = "<div class='message-error'>Provide a valid value of length 0-100</div>";
		$focus_field = 'country';
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
	if (strlen($address1) > 200) {
		$msg_address1 = "<div class='message-error'>Provide a valid value of length 0-200</div>";
		$focus_field = 'address1';
		$error = 1;
	}
	$slogan = trim($_POST['slogan']);
	if (strlen($slogan) > 200) {
		$msg_slogan = "<div class='message-error'>Provide a valid value of length 0-200</div>";
		$focus_field = 'slogan';
		$error = 1;
	}
	$company_label = trim($_POST['company_label']);
	if (strlen($company_label) < 3 || strlen($company_label) > 100) {
		$msg_company_label = "<div class='message-error'>Provide a valid value of length 3-100</div>";
		$focus_field = 'company_label';
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
			$results = mysqli_query($dbcon, "UPDATE settings_company SET 
			company_name = '" . sd($dbcon, $company_name) . "',
			company_label = '" . sd($dbcon, $company_label) . "',
			slogan = '" . sd($dbcon, $slogan) . "',
			address1 = '" . sd($dbcon, $address1) . "',
			address2 = '" . sd($dbcon, $address2) . "',
			city = '" . sd($dbcon, $city) . "',
			state = '" . sd($dbcon, $state) . "',
			zip_code = '" . sd($dbcon, $zip_code) . "',
			country = '" . sd($dbcon, $country) . "',
			phone1 = '" . sd($dbcon, $phone1) . "',
			phone2 = '" . sd($dbcon, $phone2) . "',
			email1 = '" . sd($dbcon, $email1) . "',
			email2 = '" . sd($dbcon, $email2) . "',
			website1 = '" . sd($dbcon, $website1) . "',
			website2 = '" . sd($dbcon, $website2) . "',
			social_media_url1 = '" . sd($dbcon, $social_media_url1) . "',
			social_media_url2 = '" . sd($dbcon, $social_media_url2) . "',
			social_media_url3 = '" . sd($dbcon, $social_media_url3) . "',
			social_media_url4 = '" . sd($dbcon, $social_media_url4) . "',
			social_media_url5 = '" . sd($dbcon, $social_media_url5) . "',
			notes = '" . sd($dbcon, $notes) . "',
			image_url1 = '" . sd($dbcon, $image_url1) . "',
			image_url2 = '" . sd($dbcon, $image_url2) . "'
				WHERE key_settings_company = $record_id");
			if ($results) {
				$message = "<script>parent.location.reload(false);</script>";
			} else {
				//print mysqli_error($dbcon);
				die('Unable to update, please contact your system administrator.');
			}
		} else if ($error != 1) { // insert
			$results = mysqli_query($dbcon, "INSERT INTO settings_company (
			company_name,
			company_label,
			slogan,
			address1,
			address2,
			city,
			state,
			zip_code,
			country,
			phone1,
			phone2,
			email1,
			email2,
			website1,
			website2,
			social_media_url1,
			social_media_url2,
			social_media_url3,
			social_media_url4,
			social_media_url5,
			notes,
			image_url1,
			image_url2
			) 
			VALUES (
			'" . sd($dbcon, $company_name) . "',
			'" . sd($dbcon, $company_label) . "',
			'" . sd($dbcon, $slogan) . "',
			'" . sd($dbcon, $address1) . "',
			'" . sd($dbcon, $address2) . "',
			'" . sd($dbcon, $city) . "',
			'" . sd($dbcon, $state) . "',
			'" . sd($dbcon, $zip_code) . "',
			'" . sd($dbcon, $country) . "',
			'" . sd($dbcon, $phone1) . "',
			'" . sd($dbcon, $phone2) . "',
			'" . sd($dbcon, $email1) . "',
			'" . sd($dbcon, $email2) . "',
			'" . sd($dbcon, $website1) . "',
			'" . sd($dbcon, $website2) . "',
			'" . sd($dbcon, $social_media_url1) . "',
			'" . sd($dbcon, $social_media_url2) . "',
			'" . sd($dbcon, $social_media_url3) . "',
			'" . sd($dbcon, $social_media_url4) . "',
			'" . sd($dbcon, $social_media_url5) . "',
			'" . sd($dbcon, $notes) . "',
			'" . sd($dbcon, $image_url1) . "',
			'" . sd($dbcon, $image_url2) . "'
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
    <title>SETTINGS - COMPANY</title>
    <?php include('php/_head.php'); ?>
</head>
<body id='page-save'>
    <section id='sub-menu'>
        <div class='left-block'><img src="images/icons/set_company.png"> settings - company</div>
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
                    <label for='company_label'>Company label</label> <span class='red'> *</span>
                    <?php if(isset($msg_company_label)) print $msg_company_label; ?>
                    <input id='company_label' name='company_label' type='text'
                        value='<?php if (isset($company_label)) {print $company_label;} else { print '';} ?>'
                        required><br>
                </div>
                <div>
                    <label for='slogan'>Slogan</label>
                    <?php if(isset($msg_slogan)) print $msg_slogan; ?>
                    <input id='slogan' name='slogan' type='text'
                        value='<?php if (isset($slogan)) {print $slogan;} else { print '';} ?>'><br>
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
                    <label for='email1'>Email 1</label>
                    <?php if(isset($msg_email1)) print $msg_email1; ?>
                    <input id='email1' name='email1' type='email'
                        value='<?php if (isset($email1)) {print $email1;} else { print '';} ?>'><br>
                </div>
                <div>
                    <label for='email2'>Email 2</label>
                    <?php if(isset($msg_email2)) print $msg_email2; ?>
                    <input id='email2' name='email2' type='email'
                        value='<?php if (isset($email2)) {print $email2;} else { print '';} ?>'><br>
                </div>
                <div>
                    <label for='website1'>Website 1</label>
                    <?php if(isset($msg_website1)) print $msg_website1; ?>
                    <input id='website1' name='website1' type='url'
                        value='<?php if (isset($website1)) {print $website1;} else { print '';} ?>'><br>
                </div>
                <div>
                    <label for='website2'>Website 2</label>
                    <?php if(isset($msg_website2)) print $msg_website2; ?>
                    <input id='website2' name='website2' type='url'
                        value='<?php if (isset($website2)) {print $website2;} else { print '';} ?>'><br>
                </div>
                <div>
                    <label for='social_media_url1'>Social media url 1</label>
                    <?php if(isset($msg_social_media_url1)) print $msg_social_media_url1; ?>
                    <input id='social_media_url1' name='social_media_url1' type='url'
                        value='<?php if (isset($social_media_url1)) {print $social_media_url1;} else { print '';} ?>'><br>
                </div>
                <div>
                    <label for='social_media_url2'>Social media url 2</label>
                    <?php if(isset($msg_social_media_url2)) print $msg_social_media_url2; ?>
                    <input id='social_media_url2' name='social_media_url2' type='url'
                        value='<?php if (isset($social_media_url2)) {print $social_media_url2;} else { print '';} ?>'><br>
                </div>
                <div>
                    <label for='social_media_url3'>Social media url 3</label>
                    <?php if(isset($msg_social_media_url3)) print $msg_social_media_url3; ?>
                    <input id='social_media_url3' name='social_media_url3' type='url'
                        value='<?php if (isset($social_media_url3)) {print $social_media_url3;} else { print '';} ?>'><br>
                </div>
                <div>
                    <label for='social_media_url4'>Social media url 4</label>
                    <?php if(isset($msg_social_media_url4)) print $msg_social_media_url4; ?>
                    <input id='social_media_url4' name='social_media_url4' type='url'
                        value='<?php if (isset($social_media_url4)) {print $social_media_url4;} else { print '';} ?>'><br>
                </div>
                <div>
                    <label for='social_media_url5'>Social media url 5</label>
                    <?php if(isset($msg_social_media_url5)) print $msg_social_media_url5; ?>
                    <input id='social_media_url5' name='social_media_url5' type='url'
                        value='<?php if (isset($social_media_url5)) {print $social_media_url5;} else { print '';} ?>'><br>
                </div>
            </fieldset>
            <fieldset>
                <div>
                    <label for='notes'>Notes</label>
                    <?php if(isset($msg_notes)) print $msg_notes; ?>
                    <textarea id='notes' name='notes'><?php if (isset($notes)) print $notes; ?></textarea><br>
                </div>
                <div>
                    <label for='image_url1'>Image url 1</label>
                    <?php if(isset($msg_image_url1)) print $msg_image_url1; ?>
                    <input id='image_url1' name='image_url1' type='text'
                        value='<?php if (isset($image_url1)) {print $image_url1;} else { print '';} ?>'><br>
                </div>
                <div>
                    <label for='image_url2'>Image url 2</label>
                    <?php if(isset($msg_image_url2)) print $msg_image_url2; ?>
                    <input id='image_url2' name='image_url2' type='text'
                        value='<?php if (isset($image_url2)) {print $image_url2;} else { print '';} ?>'><br>
                </div>

            </fieldset>
            <input id='save_submit' name='save_submit' type='submit' value='Save'>
        </form>
        <?php } ?>
    </main>
    <?php include('php/_footer.php'); ?>
</body>
</html>