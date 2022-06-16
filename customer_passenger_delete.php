<?php 
include('php/_code.php');
$show_record = true;
if (isset($_GET['customerpassengerid'])) {
	$record_id = trim($_GET['customerpassengerid']);
	if (!is_numeric($record_id)) die('Invalid record id.');
	if (isset($_GET['delete'])) {
		$results = mysqli_query($dbcon, "DELETE FROM customer_passengers WHERE key_customer_passengers = $record_id");
		if ($results) {
			$message = "<div class='success-result'>Deleted successfully</div>
			<div class='center'><br><br><input type='button' value='Close' onclick='parent.location.reload(false);'></div>";
			$show_record = false;
		} else {
			$message = "<div class='failure-result'>Could not delete record</div>";
		}
	} else {
		$results = mysqli_query($dbcon, "SELECT first_name, last_name, address1, city, state, country, zip_code, company_name FROM customer_passengers WHERE key_customer_passengers = $record_id");
		if ($row = mysqli_fetch_assoc($results)) {
			$first_name = $row['first_name'];
			$last_name = $row['last_name'];
			$address1 = $row['address1'];
			$city = $row['city'];
			$state = $row['state'];
			$country = $row['country'];
			$zip_code = $row['zip_code'];
			$company_name = $row['company_name'];
		} else {
			$message = "<div class='failure-result'>Record not found</div>";
		}
	}
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>CUSTOMER PASSENGERS</title>
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
            <br>
            <hr><br>
        </div>
        <table class='record-table'>
            <tr>
                <td class='label-cell'>First name</td>
                <td class='value-cell'><?php if (isset($first_name)) print $first_name; ?></td>
            </tr>
            <tr>
                <td class='label-cell'>Last name</td>
                <td class='value-cell'><?php if (isset($last_name)) print $last_name; ?></td>
            </tr>
            <tr>
                <td class='label-cell'>Address</td>
                <td class='value-cell'><?php if (isset($address1)) print $address1; ?></td>
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
                <td class='label-cell'>Country</td>
                <td class='value-cell'><?php if (isset($country)) print $country; ?></td>
            </tr>
            <tr>
                <td class='label-cell'>Zip code</td>
                <td class='value-cell'><?php if (isset($zip_code)) print $zip_code; ?></td>
            </tr>
            <tr>
                <td class='label-cell'>Company name</td>
                <td class='value-cell'><?php if (isset($company_name)) print $company_name; ?></td>
            </tr>
        </table>
    </main>
    <?php } // show_record ?>
    <?php include('php/_footer.php'); ?>
</body>
</html>