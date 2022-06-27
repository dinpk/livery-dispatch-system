<?php 

include('php/_code.php');
$show_form = true;
$focus_field = 'first_name';
// id passed for update
if (isset($_GET['staffid'])) {
	$record_id = trim($_GET['staffid']);
	if (!is_numeric($record_id)) exit;
	if (!isset($_POST['save_submit'])) {
		$results = mysqli_query($dbcon, "SELECT * FROM staff WHERE key_staff = $record_id");
		if ($row = mysqli_fetch_assoc($results)) {
			$image_url = $row['image_url'];
			$username = $row['username'];
			// $password = $row['password'];
			$designation = $row['designation'];
			$first_name = $row['first_name'];
			$last_name = $row['last_name'];
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
			$hire_date = $row['hire_date'];
			$social_security_number = $row['social_security_number'];
			$notes = $row['notes'];
			$payroll_period = $row['payroll_period'];
			$salary_amount = $row['salary_amount'];
			$hours_per_week = $row['hours_per_week'];
			$hourly_regular_rate = $row['hourly_regular_rate'];
			$hourly_overtime_rate = $row['hourly_overtime_rate'];
			$annual_paid_days = $row['annual_paid_days'];
			$house_rent_allowance = $row['house_rent_allowance'];
			$conveyance_allowance = $row['conveyance_allowance'];
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
	if (strlen($active_status) > 10) {
		$msg_active_status = "<div class='message-error'>Provide a valid value of length 0-10</div>";
		$focus_field = 'active_status';
		$error = 1;
	}
	$conveyance_allowance = trim($_POST['conveyance_allowance']);
	if (strlen($conveyance_allowance) > 10 || !is_numeric($conveyance_allowance)) {
		$msg_conveyance_allowance = "<div class='message-error'>Provide a valid value of length 0-10</div>";
		$focus_field = 'conveyance_allowance';
		$error = 1;
	}
	$house_rent_allowance = trim($_POST['house_rent_allowance']);
	if (strlen($house_rent_allowance) > 10 || !is_numeric($house_rent_allowance)) {
		$msg_house_rent_allowance = "<div class='message-error'>Provide a valid value of length 0-10</div>";
		$focus_field = 'house_rent_allowance';
		$error = 1;
	}	
	$annual_paid_days = trim($_POST['annual_paid_days']);
	if (strlen($annual_paid_days) > 3 || !is_numeric($annual_paid_days)) {
		$msg_annual_paid_days = "<div class='message-error'>Provide a valid value of length 0-2</div>";
		$focus_field = 'annual_paid_days';
		$error = 1;
	}	
	$hourly_overtime_rate = trim($_POST['hourly_overtime_rate']);
	if (strlen($hourly_overtime_rate) > 10 || !is_numeric($hourly_overtime_rate)) {
		$msg_hourly_overtime_rate = "<div class='message-error'>Provide a valid value of length 0-10</div>";
		$focus_field = 'hourly_overtime_rate';
		$error = 1;
	}
	$hourly_regular_rate = trim($_POST['hourly_regular_rate']);
	if (strlen($hourly_regular_rate) > 10 || !is_numeric($hourly_regular_rate)) {
		$msg_hourly_regular_rate = "<div class='message-error'>Provide a valid value of length 0-10</div>";
		$focus_field = 'hourly_regular_rate';
		$error = 1;
	}
	$hours_per_week = trim($_POST['hours_per_week']);
	if (strlen($hours_per_week) > 2) {
		$msg_hours_per_week = "<div class='message-error'>Provide a valid value of length 0-2</div>";
		$focus_field = 'hours_per_week';
		$error = 1;
	}
	$salary_amount = trim($_POST['salary_amount']);
	if (strlen($salary_amount) > 10 || !is_numeric($salary_amount)) {
		$msg_salary_amount = "<div class='message-error'>Provide a valid value of length 0-10</div>";
		$focus_field = 'salary_amount';
		$error = 1;
	}
	$payroll_period = trim($_POST['payroll_period']);
	if (strlen($payroll_period) > 50) {
		$msg_payroll_period = "<div class='message-error'>Provide a valid value of length 0-10</div>";
		$focus_field = 'payroll_period';
		$error = 1;
	}
	$notes = trim($_POST['notes']);
	if (strlen($notes) > 3000) {
		$msg_notes = "<div class='message-error'>Provide a valid value of length 0-3000</div>";
		$focus_field = 'notes';
		$error = 1;
	}
	$social_security_number = trim($_POST['social_security_number']);
	if (strlen($social_security_number) > 100) {
		$msg_social_security_number = "<div class='message-error'>Provide a valid value of length 0-100</div>";
		$focus_field = 'social_security_number';
		$error = 1;
	}
	$hire_date = trim($_POST['hire_date']);
	if (empty($hire_date)) {
		$hire_date = '1970-01-01';
	} else if (!is_date($hire_date)) {
		$msg_hire_date = "<div class='message-error'>Acceptable date format is 'yyyy-mm-dd'</div>";
		$focus_field = 'hire_date';
		$error = 1;
	}
	$date_of_birth = trim($_POST['date_of_birth']);
	if (empty($date_of_birth)) {
		$date_of_birth = '1970-01-01';
	} else if (!is_date($date_of_birth)) {
		$msg_date_of_birth = "<div class='message-error'>Acceptable date format is 'yyyy-mm-dd'</div>";
		$focus_field = 'date_of_birth';
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
	if (strlen($work_phone_extension) > 20) {
		$msg_work_phone_extension = "<div class='message-error'>Provide a valid value of length 0-20</div>";
		$focus_field = 'work_phone_extension';
		$error = 1;
	}
	$work_phone = trim($_POST['work_phone']);
	if (strlen($work_phone) > 30) {
		$msg_work_phone = "<div class='message-error'>Provide a valid value of length 0-30</div>";
		$focus_field = 'work_phone';
		$error = 1;
	}
	$zip_code = trim($_POST['zip_code']);
	if (strlen($zip_code) > 30) {
		$msg_zip_code = "<div class='message-error'>Provide a valid value of length 0-30</div>";
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
	if (strlen($last_name) > 50) {
		$msg_last_name = "<div class='message-error'>Provide a valid value of length 0-50</div>";
		$focus_field = 'last_name';
		$error = 1;
	}
	$first_name = trim($_POST['first_name']);
	if (strlen($first_name) > 50) {
		$msg_first_name = "<div class='message-error'>Provide a valid value of length 0-50</div>";
		$focus_field = 'first_name';
		$error = 1;
	}
	$designation = trim($_POST['designation']);
	if (strlen($designation) > 100) {
		$msg_designation = "<div class='message-error'>Provide a valid value of length 0-100</div>";
		$focus_field = 'designation';
		$error = 1;
	}
	$password = trim($_POST['password']);
	if (!empty($password) && strlen($password) < 5 || strlen($password) > 15) {
		$msg_password = "<div class='message-error'>Provide a valid value of length 5-15</div>";
		$focus_field = 'password';
		$error = 1;
	}
	$username = trim($_POST['username']);
	if (strlen($username) < 5 || strlen($username) > 15) {
		$msg_username = "<div class='message-error'>Provide a valid value of length 5-15</div>";
		$focus_field = 'username';
		$error = 1;
	}
	$image_url = trim($_POST['image_url']);
	if (strlen($image_url) > 100) {
		$msg_image_url = "<div class='message-error'>Provide a valid value of length 0-100</div>";
		$focus_field = 'image_url';
		$error = 1;
	}
	// no validation error
	if ($error == 0) {
		
		if (!empty($password)) {
			$password = password_hash($password, PASSWORD_DEFAULT);
		}

		if (isset($record_id) && $error != 1) { // update
			$results = mysqli_query($dbcon, "UPDATE staff SET 
			image_url = '" . sd($dbcon, $image_url) . "',
			username = '" . sd($dbcon, $username) . "',
			password = '" . sd($dbcon, $password) . "',
			designation = '" . sd($dbcon, $designation) . "',
			first_name = '" . sd($dbcon, $first_name) . "',
			last_name = '" . sd($dbcon, $last_name) . "',
			address1 = '" . sd($dbcon, $address1) . "',
			address2 = '" . sd($dbcon, $address2) . "',
			city = '" . sd($dbcon, $city) . "',
			state = '" . sd($dbcon, $state) . "',
			zip_code = '" . sd($dbcon, $zip_code) . "',
			work_phone = '" . sd($dbcon, $work_phone) . "',
			work_phone_extension = '" . sd($dbcon, $work_phone_extension) . "',
			mobile_phone = '" . sd($dbcon, $mobile_phone) . "',
			email = '" . sd($dbcon, $email) . "',
			date_of_birth = '" . sd($dbcon, $date_of_birth) . "',
			hire_date = '" . sd($dbcon, $hire_date) . "',
			social_security_number = '" . sd($dbcon, $social_security_number) . "',
			notes = '" . sd($dbcon, $notes) . "',
			payroll_period = '" . sd($dbcon, $payroll_period) . "',
			salary_amount = '" . sd($dbcon, $salary_amount) . "',
			hours_per_week = '" . sd($dbcon, $hours_per_week) . "',
			hourly_regular_rate = '" . sd($dbcon, $hourly_regular_rate) . "',
			hourly_overtime_rate = '" . sd($dbcon, $hourly_overtime_rate) . "',
			annual_paid_days = '" . sd($dbcon, $annual_paid_days) . "',
			house_rent_allowance = '" . sd($dbcon, $house_rent_allowance) . "',
			conveyance_allowance = '" . sd($dbcon, $conveyance_allowance) . "',
			active_status = '" . sd($dbcon, $active_status) . "'
			WHERE key_staff = $record_id");
			if ($results) {
				$message = "<script>parent.location.reload(false);</script>";
			} else {
				//print mysqli_error($dbcon);
				die('Unable to update, please contact your system administrator.');
			}
		} else if ($error != 1) { // insert
			$results = mysqli_query($dbcon, "INSERT INTO staff (
			image_url,
			username,
			password,
			designation,
			first_name,
			last_name,
			address1,
			address2,
			city,
			state,
			zip_code,
			work_phone,
			work_phone_extension,
			mobile_phone,
			email,
			date_of_birth,
			hire_date,
			social_security_number,
			notes,
			payroll_period,
			salary_amount,
			hours_per_week,
			hourly_regular_rate,
			hourly_overtime_rate,
			annual_paid_days,
			house_rent_allowance,
			conveyance_allowance,
			permission_items,
			active_status
			) 
			VALUES (
			'" . sd($dbcon, $image_url) . "',
			'" . sd($dbcon, $username) . "',
			'" . sd($dbcon, $password) . "',
			'" . sd($dbcon, $designation) . "',
			'" . sd($dbcon, $first_name) . "',
			'" . sd($dbcon, $last_name) . "',
			'" . sd($dbcon, $address1) . "',
			'" . sd($dbcon, $address2) . "',
			'" . sd($dbcon, $city) . "',
			'" . sd($dbcon, $state) . "',
			'" . sd($dbcon, $zip_code) . "',
			'" . sd($dbcon, $work_phone) . "',
			'" . sd($dbcon, $work_phone_extension) . "',
			'" . sd($dbcon, $mobile_phone) . "',
			'" . sd($dbcon, $email) . "',
			'" . sd($dbcon, $date_of_birth) . "',
			'" . sd($dbcon, $hire_date) . "',
			'" . sd($dbcon, $social_security_number) . "',
			'" . sd($dbcon, $notes) . "',
			'" . sd($dbcon, $payroll_period) . "',
			'" . sd($dbcon, $salary_amount) . "',
			'" . sd($dbcon, $hours_per_week) . "',
			'" . sd($dbcon, $hourly_regular_rate) . "',
			'" . sd($dbcon, $hourly_overtime_rate) . "',
			'" . sd($dbcon, $annual_paid_days) . "',
			'" . sd($dbcon, $house_rent_allowance) . "',
			'" . sd($dbcon, $conveyance_allowance) . "',
			'[]',
			'" . sd($dbcon, $active_status) . "'
			)");
			if ($results) {
				$message = "<script>parent.location.reload(false);</script>";
			} else {
				if (strpos(mysqli_error($dbcon), "Duplicate") > -1) {
					$message = "<div class='failure-result'>" . mysqli_error($dbcon) . "</div>";
					$error = 1;
				} else {
					print mysqli_error($dbcon) . "<br>";
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
    <title>STAFF</title>
    <?php include('php/_head.php'); ?>
</head>
<body id='page-save'>
    <section id='sub-menu'>
        <div class='left-block'>staff</div>
        <div class='right-block'>

        </div>
    </section>
    <?php if (isset($message)) print $message; ?>
    <main>
        <?php if (isset($show_form) && $show_form) { ?>
        <form method='post'>
            <fieldset>
                <div>
                    <label for='first_name'>First name</label>
                    <?php if(isset($msg_first_name)) print $msg_first_name; ?>
                    <input id='first_name' name='first_name' type='text'
                        value='<?php if (isset($first_name)) {print $first_name;} else { print '';} ?>'><br>
                </div>
                <div>
                    <label for='last_name'>Last name</label>
                    <?php if(isset($msg_last_name)) print $msg_last_name; ?>
                    <input id='last_name' name='last_name' type='text'
                        value='<?php if (isset($last_name)) {print $last_name;} else { print '';} ?>'><br>
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
                    <label for='state'>State</label><br>
                    <?php if(isset($msg_state)) print $msg_state; ?>
                    <select id='state' name='state'>
                        <?php 
						$options = '';
						
						$results = mysqli_query($dbcon, 'SELECT state FROM settings_state_values');
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
                    <input id='work_phone_extension' name='work_phone_extension' type='text'
                        value='<?php if (isset($work_phone_extension)) {print $work_phone_extension;} else { print '';} ?>'><br>
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
                <div>
                    <label for='date_of_birth'>Date of birth</label><br>
                    <?php if(isset($msg_date_of_birth)) print $msg_date_of_birth; ?>
                    <input id='date_of_birth' name='date_of_birth' type='date' placeholder='yyyy-mm-dd'
                        value='<?php if (isset($date_of_birth)) {print $date_of_birth;} ?>'><br>
                </div>
            </fieldset>
            <fieldset>
                <div>
                    <label for='username'>User name</label> <span class='red'> *</span>
                    <?php if(isset($msg_username)) print $msg_username; ?>
                    <input id='username' name='username' type='text'
                        value='<?php if (isset($username)) {print $username;} else { print '';} ?>' required><br>
                </div>
                <div>
                    <label for='password'>Password</label> <span class='red'> *</span>
                    <?php if(isset($msg_password)) print $msg_password; ?>
                    <input id='password' name='password' type='password'><br>
                </div>
                <div>
                    <a href='staff_permissions.php?staffid=<?php print $record_id; ?>' target='overlay-iframe2'
                        onclick='overlayOpen2();'>Permissions</a>
                </div>
                <div>
                    <label for='image_url'>Image url</label>
                    <?php if(isset($msg_image_url)) print $msg_image_url; ?>
                    <input id='image_url' name='image_url' type='text'
                        value='<?php if (isset($image_url)) {print $image_url;} else { print '';} ?>'><br>
                </div>
            </fieldset>
            <fieldset>
                <div>
                    <label for='designation'>Designation</label><br>
                    <?php if(isset($msg_designation)) print $msg_designation; ?>
                    <select id='designation' name='designation'>
                        <?php 
						$options = '';
						$results = mysqli_query($dbcon, 'SELECT designation FROM settings_staff_designation_values');
						while ($row = mysqli_fetch_assoc($results)) {
							$selection = '';
							if ($row['designation'] == $designation) $selection = "selected='selected'";
								$options .= "<option $selection>" . $row['designation'] . "</option>";
						}
						print $options; 
						?>
                    </select>
                </div>
                <div>
                    <label for='hire_date'>Hire date</label><br>
                    <?php if(isset($msg_hire_date)) print $msg_hire_date; ?>
                    <input id='hire_date' name='hire_date' type='date' placeholder='yyyy-mm-dd'
                        value='<?php if (isset($hire_date)) {print $hire_date;} ?>'><br>
                </div>
                <div>
                    <label for='social_security_number'>Ssn</label>
                    <?php if(isset($msg_social_security_number)) print $msg_social_security_number; ?>
                    <input id='social_security_number' name='social_security_number' type='text'
                        value='<?php if (isset($social_security_number)) {print $social_security_number;} else { print '';} ?>'><br>
                </div>
                <div>
                    <label for='notes'>Notes</label>
                    <?php if(isset($msg_notes)) print $msg_notes; ?>
                    <textarea id='notes' name='notes'><?php if (isset($notes)) print $notes; ?></textarea><br>
                </div>
            </fieldset>
            <fieldset>
                <div>
                    <label for='payroll_period'>Salary period</label><br>
                    <?php if(isset($msg_payroll_period)) print $msg_payroll_period; ?>
                    <select id='payroll_period' name='payroll_period'>
                        <?php
						if (!isset($payroll_period)) $payroll_period = '';
						print "
						<option" . (($payroll_period == 'Weekly') ? ' selected' : '') .  ">Weekly</option>
						<option" . (($payroll_period == 'Bi-weekly') ? ' selected' : '') .  ">Bi-weekly</option>
						<option" . (($payroll_period == 'Semi-monthly') ? ' selected' : '') .  ">Semi-monthly</option>
						<option" . (($payroll_period == 'Monthly') ? ' selected' : '') .  ">Monthly</option>
						";
						?>
                    </select>
                </div>
                <div>
                    <label for='salary_amount'>Salary amount</label>
                    <?php if(isset($msg_salary_amount)) print $msg_salary_amount; ?>
                    <input id='salary_amount' name='salary_amount' type='number' step='0.10'
                        value='<?php if (isset($salary_amount)) {print $salary_amount;} else { print '0';} ?>'><br>
                </div>
                <div>
                    <label for='hours_per_week'>Hours per week</label>
                    <?php if(isset($msg_hours_per_week)) print $msg_hours_per_week; ?>
                    <input id='hours_per_week' name='hours_per_week' type='number'
                        value='<?php if (isset($hours_per_week)) {print $hours_per_week;} else { print '0';} ?>'><br>
                </div>
                <div>
                    <label for='hourly_regular_rate'>Hourly regular rate</label>
                    <?php if(isset($msg_hourly_regular_rate)) print $msg_hourly_regular_rate; ?>
                    <input id='hourly_regular_rate' name='hourly_regular_rate' type='number' step='0.10'
                        value='<?php if (isset($hourly_regular_rate)) {print $hourly_regular_rate;} else { print '0';} ?>'><br>
                </div>
                <div>
                    <label for='hourly_overtime_rate'>Hourly overtime rate</label>
                    <?php if(isset($msg_hourly_overtime_rate)) print $msg_hourly_overtime_rate; ?>
                    <input id='hourly_overtime_rate' name='hourly_overtime_rate' type='number' step='0.10'
                        value='<?php if (isset($hourly_overtime_rate)) {print $hourly_overtime_rate;} else { print '0';} ?>'><br>
                </div>
                <div>
                    <label for='annual_paid_days'>Annual pay days</label>
                    <?php if(isset($msg_annual_paid_days)) print $msg_annual_paid_days; ?>
                    <input id='annual_paid_days' name='annual_paid_days' type='number'
                        value='<?php if (isset($annual_paid_days)) {print $annual_paid_days;} else { print '0';} ?>'
                        required><br>
                </div>
                <div>
                    <label for='house_rent_allowance'>House rent allowance %</label>
                    <?php if(isset($msg_house_rent_allowance)) print $msg_house_rent_allowance; ?>
                    <input id='house_rent_allowance' name='house_rent_allowance' type='number' step='0.01'
                        value='<?php if (isset($house_rent_allowance)) {print $house_rent_allowance;} else { print '0';} ?>'><br>
                </div>
                <div>
                    <label for='conveyance_allowance'>Conveyance allowance %</label>
                    <?php if(isset($msg_conveyance_allowance)) print $msg_conveyance_allowance; ?>
                    <input id='conveyance_allowance' name='conveyance_allowance' type='number' step='0.01'
                        value='<?php if (isset($conveyance_allowance)) {print $conveyance_allowance;} else { print '0';} ?>'><br>
                </div>
                <br><br><br>
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
