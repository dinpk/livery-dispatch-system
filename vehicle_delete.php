<?php 
include('php/_code.php');
$show_record = true;
if (isset($_GET['vehiclesid'])) {
	$record_id = trim($_GET['vehiclesid']);
	if (!is_numeric($record_id)) die('Invalid record id.');
	if (isset($_GET['delete'])) {
		$results = mysqli_query($dbcon, "DELETE FROM vehicles WHERE key_vehicles = $record_id");
		if ($results) {
			$message = "<div class='success-result'>Deleted successfully</div>
			<div class='center'><br><br><input type='button' value='Close' onclick='parent.location.reload(false);'></div>";
			$show_record = false;
		} else {
			$message = "<div class='failure-result'>Could not delete record</div>";
		}
	} else {
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
}
?>
<!DOCTYPE html>
<html>
<head>
 <title>VEHICLES</title>
 <?php include('php/_head.php'); ?>
</head>
<body id='page-delete' class='page_delete page_vehicles_delete'>

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
         <br><hr><br>
     </div>

     <table class='record-table'>
         <tr>
         <td class='label-cell'>Fleet #</td>
         <td class='value-cell'><?php if (isset($fleet_number)) print $fleet_number; ?></td>
         </tr>

         <tr>
         <td class='label-cell'>Vehicle type</td>
         <td class='value-cell'><?php if (isset($vehicle_type)) print $vehicle_type; ?></td>
         </tr>

         <tr>
         <td class='label-cell'>Tag</td>
         <td class='value-cell'><?php if (isset($tag)) print $tag; ?></td>
         </tr>

         <tr>
         <td class='label-cell'>Vin #</td>
         <td class='value-cell'><?php if (isset($vin_number)) print $vin_number; ?></td>
         </tr>

         <tr>
         <td class='label-cell'>Year</td>
         <td class='value-cell'><?php if (isset($year_made)) print $year_made; ?></td>
         </tr>

         <tr>
         <td class='label-cell'>Model</td>
         <td class='value-cell'><?php if (isset($model)) print $model; ?></td>
         </tr>

         <tr>
         <td class='label-cell'>Max seats</td>
         <td class='value-cell'><?php if (isset($max_seats)) print $max_seats; ?></td>
         </tr>

         <tr>
         <td class='label-cell'>Color</td>
         <td class='value-cell'><?php if (isset($color)) print $color; ?></td>
         </tr>

         <tr>
         <td class='label-cell'>Insurance company</td>
         <td class='value-cell'><?php if (isset($insurance_company)) print $insurance_company; ?></td>
         </tr>

         <tr>
         <td class='label-cell'>Insurance expiration</td>
         <td class='value-cell'><?php if (isset($insurance_expiry_date)) print $insurance_expiry_date; ?></td>
         </tr>

         <tr>
         <td class='label-cell'>Image url</td>
         <td class='value-cell'><?php if (isset($image_url)) print $image_url; ?></td>
         </tr>

         <tr>
         <td class='label-cell'>Zone rate %</td>
         <td class='value-cell'><?php if (isset($zone_rate_percent)) print $zone_rate_percent; ?></td>
         </tr>

         <tr>
         <td class='label-cell'>Hourly regular rate</td>
         <td class='value-cell'><?php if (isset($hourly_regular_rate)) print $hourly_regular_rate; ?></td>
         </tr>

         <tr>
         <td class='label-cell'>Hourly wait rate</td>
         <td class='value-cell'><?php if (isset($hourly_wait_rate)) print $hourly_wait_rate; ?></td>
         </tr>

         <tr>
         <td class='label-cell'>Hourly overtime rate</td>
         <td class='value-cell'><?php if (isset($hourly_overtime_rate)) print $hourly_overtime_rate; ?></td>
         </tr>

         <tr>
         <td class='label-cell'>Notes</td>
         <td class='value-cell'><?php if (isset($notes)) print $notes; ?></td>
         </tr>

         <tr>
         <td class='label-cell'>Status</td>
         <td class='value-cell'><?php if (isset($active_status)) print $active_status; ?></td>
         </tr>

     </table>

 </main>

 <?php } // show_record ?>


 <?php include('php/_footer.php'); ?>
</body>
</html>
