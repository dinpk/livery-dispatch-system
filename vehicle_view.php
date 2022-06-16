<?php 
include('php/_code.php');
if (isset($_GET['vehicleid'])) {
	$record_id = trim($_GET['vehicleid']);
	if (!is_numeric($record_id)) die('Invalid record id.');
	$results = mysqli_query($dbcon, "SELECT * FROM vehicles WHERE key_vehicles = $record_id");
	if ($row = mysqli_fetch_assoc($results)) {
		$fleet_number = $row['fleet_number'];
		$vehicle_type = $row['vehicle_type'];
		$tag = $row['tag'];
		$vin_number = $row['vin_number'];
		$year_made = $row['year_made'];
		$model = $row['model'];
		$max_seats = $row['max_seats'];
		$color = $row['color'];
		$key_insurance_company_values = $row['key_insurance_company_values'];
		$insurance_company = $row['insurance_company'];
		$insurance_expiry_date = $row['insurance_expiry_date'];
		$image_url = $row['image_url'];
		$zone_rate_percent = $row['zone_rate_percent'];
		$hourly_regular_rate = $row['hourly_regular_rate'];
		$hourly_wait_rate = $row['hourly_wait_rate'];
		$hourly_overtime_rate = $row['hourly_overtime_rate'];
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
    <title>VEHICLE</title>
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
						print "<div class='profile-avatar' style='background-image:url(images/icons/avatar_vehicle.png);'></div> ";
					} else {
						print "<div class='profile-image'><a href='$image_url' target='_blank'><img src='$image_url'></a></div> ";
					}
					print "
						<h1>
							$vehicle_type
							<p>$year_made</p>
							<b>$active_symbol</b>
						</h1>
					";
				?>
            </section>
            <section>
                <table>
                    <?php 
					if (!empty($fleet_number)) print "<tr><td>Fleet #</td><td>$fleet_number</td></tr>";
					if (!empty($tag)) print "<tr><td>Tag</td><td>$tag</td></tr>";
					if (!empty($vin_number)) print "<tr><td>Vin #</td><td>$vin_number</td></tr>";
					if (!empty($model)) print "<tr><td>Model</td><td>$model</td></tr>";
					if (!empty($max_seats)) print "<tr><td>Seats</td><td>$max_seats</td></tr>";
					if (!empty($color)) print "<tr><td>Color</td><td>$color</td></tr>";
					print "<tr><td>&nbsp;</td><td></td></tr>";
					if (!empty($insurance_company)) print "<tr><td>Insurance company</td><td>$insurance_company</td></tr>";
					if (!empty($insurance_expiry_date)) print "<tr><td>Expiration</td><td>" . date("M d, Y", strtotime($insurance_expiry_date)) .  "</td></tr>";
					if (!empty($vin_number)) print "<tr><td>Vin #</td><td>$vin_number</td></tr>";
					if (!empty($model)) print "<tr><td>Model</td><td>$model</td></tr>";
					if (!empty($max_seats)) print "<tr><td>Seats</td><td>$max_seats</td></tr>";
					if (!empty($color)) print "<tr><td>Color</td><td>$color</td></tr>";
					print "<tr><td>&nbsp;</td><td></td></tr>";
					if ($zone_rate_percent != "0") print "<tr><td>Zone rate %</td><td>$zone_rate_percent</td></tr>";
					if ($hourly_regular_rate != "0") print "<tr><td>Hourly regular rate</td><td>$hourly_regular_rate</td></tr>";
					if ($hourly_wait_rate != "0") print "<tr><td>Hourly wait rate</td><td>$hourly_wait_rate</td></tr>";
					if ($hourly_overtime_rate != "0") print "<tr><td>Hourly overtime rate</td><td>$hourly_overtime_rate</td></tr>";
				?>
                </table>
            </section>
            <section>
                <?php
					if (!empty($notes)) print "<h3>Notes</h3><p>$notes</p>";
				?>
            </section>
        </div>
    </main>
    <?php include('php/_footer.php'); ?>
</body>
</html>