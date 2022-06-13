<?php 
include('php/_code.php'); 
if (isset($_GET['make'])) {
	$record_id = trim($_GET['make']);
	$results = mysqli_query($dbcon, "SELECT vehicle_model FROM settings_vehicle_model_values WHERE vehicle_make = '$record_id' ORDER BY vehicle_model");
	while ($row = mysqli_fetch_assoc($results)) {
		print "<option>" . $row['vehicle_model']  . "</option>";
	}
}
?>