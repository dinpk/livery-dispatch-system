<?php 
include('php/_code.php');
if (isset($_GET['ratezoneid'])) {
	$record_id = trim($_GET['ratezoneid']);
	if (!is_numeric($record_id)) die('Invalid record id.');
	$results = mysqli_query($dbcon, "SELECT * FROM rates_zones WHERE key_rates_zones = $record_id");
	if ($row = mysqli_fetch_assoc($results)) {
		$from_city = $row['from_city'];
		$from_state = $row['from_state'];
		$to_city = $row['to_city'];
		$to_state = $row['to_state'];
		$rate = $row['rate'];
		$tolls = $row['tolls'];
		$miles = $row['miles'];
		$active_status = $row['active_status'];
	} else {
		$message = "<div class='failure-result'>Record not found</div>";
	}
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>RATES ZONES</title>
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
						print "<div class='profile-avatar' style='background-image:url(images/icons/avatar_zone.png);'></div> ";
					}
					print "
						<h2>$from_city, $from_state</h2>
						<div class='font-size-200 center'>⇩</div>
						<h2>$to_city, $to_state</h2>
						<h1>$active_symbol</h1>
					";
				?>
            </section>
            <section>
                <?php 
					print "
						<table>
						<tr><td>From</td><td>$from_city, $from_state</td></tr>
						<tr><td>To</td><td>$to_city, $to_state</td></tr>
						<tr><td>&nbsp;</td><td></td></tr>
						<tr><td>Rate</td><td>$rate</td></tr>
						<tr><td>Tolls</td><td>$tolls</td></tr>
						<tr><td>Miles</td><td>$miles</td></tr>
						</table>
					";
				?>
            </section>
        </div>
    </main>
    <?php include('php/_footer.php'); ?>
</body>
</html>