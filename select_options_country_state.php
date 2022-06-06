<?php 
include('php/_code.php'); 
if (isset($_GET['country'])) {
	$country = trim($_GET['country']);
	$results = mysqli_query($dbcon, "SELECT state FROM settings_state_values WHERE country = '$country' ORDER BY state");
	while ($row = mysqli_fetch_assoc($results)) {
		print "<option>" . $row['state']  . "</option>";
	}
}
?>