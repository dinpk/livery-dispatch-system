<?php 
include('php/_code.php');
$show_form = true;
$focus_field = 'first_name';
// id passed for update
if (isset($_GET['customer_contactsid'])) {
	$record_id = trim($_GET['customer_contactsid']);
	if (!is_numeric($record_id)) exit;
	if (!isset($_POST['save_submit'])) {
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
			$show_form = false;
		}
	}
}
// 'Save' button clicked
if (isset($_POST['save_submit'])) {
	$error = 0;
	$active_status = trim($_POST['active_status']);
	if (strlen($active_status) > 5) {
		$msg_active_status = "<div class='message-error'>Provide a valid value of length 0-5</div>";
		$focus_field = 'active_status';
		$error = 1;
	}
	$email = trim($_POST['email']);
	if (strlen($email) > 100) {
		$msg_email = "<div class='message-error'>Provide a valid value of length 0-100</div>";
		$focus_field = 'email';
		$error = 1;
	}
	$mobile_phone = trim($_POST['mobile_phone']);
	if (strlen($mobile_phone) > 30) {
		$msg_mobile_phone = "<div class='message-error'>Provide a valid value of length 0-30</div>";
		$focus_field = 'mobile_phone';
		$error = 1;
	}
	$work_phone_extension = trim($_POST['work_phone_extension']);
	if (strlen($work_phone_extension) > 10 || !is_numeric($work_phone_extension)) {
		$msg_work_phone_extension = "<div class='message-error'>Provide a valid value of length 0-10</div>";
		$focus_field = 'work_phone_extension';
		$error = 1;
	}
	$work_phone = trim($_POST['work_phone']);
	if (strlen($work_phone) > 30) {
		$msg_work_phone = "<div class='message-error'>Provide a valid value of length 0-30</div>";
		$focus_field = 'work_phone';
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
	if (strlen($address1) > 100) {
		$msg_address1 = "<div class='message-error'>Provide a valid value of length 0-100</div>";
		$focus_field = 'address1';
		$error = 1;
	}
	$last_name = trim($_POST['last_name']);
	if (strlen($last_name) < 3 || strlen($last_name) > 50) {
		$msg_last_name = "<div class='message-error'>Provide a valid value of length 3-50</div>";
		$focus_field = 'last_name';
		$error = 1;
	}
	$first_name = trim($_POST['first_name']);
	if (strlen($first_name) < 3 || strlen($first_name) > 50) {
		$msg_first_name = "<div class='message-error'>Provide a valid value of length 3-50</div>";
		$focus_field = 'first_name';
		$error = 1;
	}
	$image_url = trim($_POST['image_url']);
	if (strlen($image_url) > 100) {
		$msg_image_url = "<div class='message-error'>Provide a valid value of length 0-100</div>";
		$focus_field = 'image_url';
		$error = 1;
	}
	$key_customer_companies = trim($_POST['key_customer_companies']);
	if (strlen($key_customer_companies) > 100 || !is_numeric($key_customer_companies)) {
		$msg_key_customer_companies = "<div class='message-error'>Provide a valid value of length 0-100</div>";
		$focus_field = 'key_customer_companies';
		$error = 1;
	}
	$company_name = trim($_POST['company_name']);
	if (strlen($company_name) > 100) {
		$msg_company_name = "<div class='message-error'>Provide a valid value of length 0-100</div>";
		$focus_field = 'company_name';
		$error = 1;
	}
	// no validation error
	if ($error == 0) {
		if (isset($record_id) && $error != 1) { // update
			$results = mysqli_query($dbcon, "UPDATE customer_contacts SET 
			company_name = '" . sd($dbcon, $company_name) . "',
			key_customer_companies = '" . sd($dbcon, $key_customer_companies) . "',
			image_url = '" . sd($dbcon, $image_url) . "',
			first_name = '" . sd($dbcon, $first_name) . "',
			last_name = '" . sd($dbcon, $last_name) . "',
			address1 = '" . sd($dbcon, $address1) . "',
			address2 = '" . sd($dbcon, $address2) . "',
			city = '" . sd($dbcon, $city) . "',
			state = '" . sd($dbcon, $state) . "',
			zip_code = '" . sd($dbcon, $zip_code) . "',
			country = '" . sd($dbcon, $country) . "',
			work_phone = '" . sd($dbcon, $work_phone) . "',
			work_phone_extension = '" . sd($dbcon, $work_phone_extension) . "',
			mobile_phone = '" . sd($dbcon, $mobile_phone) . "',
			email = '" . sd($dbcon, $email) . "',
			active_status = '" . sd($dbcon, $active_status) . "' 
				WHERE key_customer_contacts = $record_id");
			if ($results) {
				$message = "<script>parent.location.reload(false);</script>";
			} else {
				//print mysqli_error($dbcon);
				die('Unable to update, please contact your system administrator.');
			}
		} else if ($error != 1) { // insert
			$results = mysqli_query($dbcon, "INSERT INTO customer_contacts (
			company_name,
			key_customer_companies,
			image_url,
			first_name,
			last_name,
			address1,
			address2,
			city,
			state,
			zip_code,
			country,
			work_phone,
			work_phone_extension,
			mobile_phone,
			email,
			active_status
			) 
			VALUES (
			'" . sd($dbcon, $company_name) . "',
			'" . sd($dbcon, $key_customer_companies) . "',
			'" . sd($dbcon, $image_url) . "',
			'" . sd($dbcon, $first_name) . "',
			'" . sd($dbcon, $last_name) . "',
			'" . sd($dbcon, $address1) . "',
			'" . sd($dbcon, $address2) . "',
			'" . sd($dbcon, $city) . "',
			'" . sd($dbcon, $state) . "',
			'" . sd($dbcon, $zip_code) . "',
			'" . sd($dbcon, $country) . "',
			'" . sd($dbcon, $work_phone) . "',
			'" . sd($dbcon, $work_phone_extension) . "',
			'" . sd($dbcon, $mobile_phone) . "',
			'" . sd($dbcon, $email) . "',
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
    <title>CUSTOMER CONTACT</title>
    <?php include('php/_head.php'); ?>
</head>

<body id='page-save' class='page_save page_customer_contacts_save'>

    <section id='sub-menu'>
        <div class='left-block'>customer contact</div>
        <div class='right-block'>

        </div>
    </section>

    <?php if (isset($message)) print $message; ?>

    <main>

        <?php if (isset($show_form) && $show_form) { ?>
        <form method='post'>

            <fieldset>

                <div>
                    <label for='first_name'>First name</label> <span class='red'> *</span>
                    <?php if(isset($msg_first_name)) print $msg_first_name; ?>
                    <input id='first_name' name='first_name' type='text'
                        value='<?php if (isset($first_name)) {print $first_name;} else { print '';} ?>' required><br>
                </div>

                <div>
                    <label for='last_name'>Last name</label> <span class='red'> *</span>
                    <?php if(isset($msg_last_name)) print $msg_last_name; ?>
                    <input id='last_name' name='last_name' type='text'
                        value='<?php if (isset($last_name)) {print $last_name;} else { print '';} ?>' required><br>
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
                    <label for='work_phone'>Work phone</label>
                    <?php if(isset($msg_work_phone)) print $msg_work_phone; ?>
                    <input id='work_phone' name='work_phone' type='tel'
                        value='<?php if (isset($work_phone)) {print $work_phone;} else { print '';} ?>'><br>
                </div>

                <div>
                    <label for='work_phone_extension'>Work phone ext.</label>
                    <?php if(isset($msg_work_phone_extension)) print $msg_work_phone_extension; ?>
                    <input id='work_phone_extension' name='work_phone_extension' type='number'
                        value='<?php if (isset($work_phone_extension)) {print $work_phone_extension;} else { print '0';} ?>'><br>
                </div>

                <div>
                    <label for='mobile_phone'>Mobile phone</label>
                    <?php if(isset($msg_mobile_phone)) print $msg_mobile_phone; ?>
                    <input id='mobile_phone' name='mobile_phone' type='tel'
                        value='<?php if (isset($mobile_phone)) {print $mobile_phone;} else { print '';} ?>'><br>
                </div>

                <div>
                    <label for='email'>Email</label>
                    <?php if(isset($msg_email)) print $msg_email; ?>
                    <input id='email' name='email' type='email'
                        value='<?php if (isset($email)) {print $email;} else { print '';} ?>'><br>
                </div>

            </fieldset>
            <fieldset>

                <div>
                    <label for='company_name'>Company name</label>
                    <small>
                        <a href='customer_contacts_select_customer_companies.php' target='overlay-iframe2'
                            onclick='overlayOpen2();'>Select</a> &nbsp;
                        <a href='#'
                            onclick='unselectKeyValue("key_customer_companies","company_name");return false;'>x</a>
                    </small><br>
                    <?php if(isset($msg_company_name)) print $msg_company_name; ?>
                    <input id='company_name' name='company_name' type='text'
                        value='<?php if (isset($company_name)) {print $company_name;} else { print '';} ?>'
                        readonly><br>
                </div>

                <input id='key_customer_companies' name='key_customer_companies' type='hidden'
                    value='<?php if (isset($key_customer_companies)) {print $key_customer_companies;} else {print '0';} ?>'>


                <div>
                    <label for='image_url'>Image url</label>
                    <?php if(isset($msg_image_url)) print $msg_image_url; ?>
                    <input id='image_url' name='image_url' type='text'
                        value='<?php if (isset($image_url)) {print $image_url;} else { print '';} ?>'><br>
                </div>

                <br><br>

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