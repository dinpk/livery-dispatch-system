<?php 
include('php/_code.php');
if (isset($_GET['staffid'])) {
	$record_id = trim($_GET['staffid']);
	if (!is_numeric($record_id)) die('Invalid record id.');
	$results = mysqli_query($dbcon, "SELECT * FROM staff WHERE key_staff = $record_id");
	if ($row = mysqli_fetch_assoc($results)) {
		$image_url = $row['image_url'];
		$username = $row['username'];
		$password = $row['password'];
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
	}
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>STAFF</title>
    <?php include('php/_head.php'); ?>
</head>
<body id='page-view'>
    <?php if (isset($message)) print $message; ?>
    <main>
        <table class='record-table'>
            <tr>
                <td class='label-cell'>Image url</td>
                <td class='value-cell'><?php if (isset($image_url)) print $image_url; ?></td>
            </tr>
            <tr>
                <td class='label-cell'>User name</td>
                <td class='value-cell'><?php if (isset($username)) print $username; ?></td>
            </tr>

            <tr>
                <td class='label-cell'>Password</td>
                <td class='value-cell'><?php if (isset($password)) print $password; ?></td>
            </tr>
            <tr>
                <td class='label-cell'>Designation</td>
                <td class='value-cell'><?php if (isset($designation)) print $designation; ?></td>
            </tr>
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
                <td class='label-cell'>Date of birth</td>
                <td class='value-cell'><?php if (isset($date_of_birth)) print $date_of_birth; ?></td>
            </tr>
            <tr>
                <td class='label-cell'>Hire date</td>
                <td class='value-cell'><?php if (isset($hire_date)) print $hire_date; ?></td>
            </tr>
            <tr>
                <td class='label-cell'>Ssn</td>
                <td class='value-cell'><?php if (isset($social_security_number)) print $social_security_number; ?></td>
            </tr>
            <tr>
                <td class='label-cell'>Notes</td>
                <td class='value-cell'><?php if (isset($notes)) print $notes; ?></td>
            </tr>
            <tr>
                <td class='label-cell'>Salary period</td>
                <td class='value-cell'><?php if (isset($payroll_period)) print $payroll_period; ?></td>
            </tr>
            <tr>
                <td class='label-cell'>Salary amount</td>
                <td class='value-cell'><?php if (isset($salary_amount)) print $salary_amount; ?></td>
            </tr>
            <tr>
                <td class='label-cell'>Hours per week</td>
                <td class='value-cell'><?php if (isset($hours_per_week)) print $hours_per_week; ?></td>
            </tr>

            <tr>
                <td class='label-cell'>Hourly regular rate</td>
                <td class='value-cell'><?php if (isset($hourly_regular_rate)) print $hourly_regular_rate; ?></td>
            </tr>
            <tr>
                <td class='label-cell'>Hourly overtime rate</td>
                <td class='value-cell'><?php if (isset($hourly_overtime_rate)) print $hourly_overtime_rate; ?></td>
            </tr>
            <tr>
                <td class='label-cell'>Annual paid days</td>
                <td class='value-cell'><?php if (isset($annual_paid_days)) print $annual_paid_days; ?></td>
            </tr>
            <tr>
                <td class='label-cell'>House rent allowance</td>
                <td class='value-cell'><?php if (isset($house_rent_allowance)) print $house_rent_allowance; ?></td>
            </tr>
            <tr>
                <td class='label-cell'>Conveyance_allowance</td>
                <td class='value-cell'><?php if (isset($conveyance_allowance)) print $conveyance_allowance; ?></td>
            </tr>
            <tr>
                <td class='label-cell'>Status</td>
                <td class='value-cell'><?php if (isset($active_status)) print $active_status; ?></td>
            </tr>
        </table>
    </main>
    <?php include('php/_footer.php'); ?>
</body>
</html>