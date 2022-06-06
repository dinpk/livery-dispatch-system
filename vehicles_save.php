<?php 
include('php/_code.php');
$show_form = true;
$focus_field = 'fleet_number';
// id passed for update
if (isset($_GET['vehiclesid'])) {
	$record_id = trim($_GET['vehiclesid']);
	if (!is_numeric($record_id)) exit;
	if (!isset($_POST['save_submit'])) {
		$results = mysqli_query($dbcon, "SELECT * FROM vehicles WHERE key_vehicles = $record_id");
		if ($row = mysqli_fetch_assoc($results)) {
			$fleet_number = $row['fleet_number'];
			$vehicle_type = $row['vehicle_type'];
			$tag = $row['tag'];
			$vin_number = $row['vin_number'];
			$year_made = $row['year_made'];
			$make = $row['make'];
			$model = $row['model'];
			$max_seats = $row['max_seats'];
			$color = $row['color'];
			$key_settings_insurance_company_values = $row['key_settings_insurance_company_values'];
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
	$notes = trim($_POST['notes']);
	if (strlen($notes) > 3000) {
		$msg_notes = "<div class='message-error'>Provide a valid value of length 0-3000</div>";
		$focus_field = 'notes';
		$error = 1;
	}
	$hourly_overtime_rate = trim($_POST['hourly_overtime_rate']);
	if (strlen($hourly_overtime_rate) > 10 || !is_numeric($hourly_overtime_rate)) {
		$msg_hourly_overtime_rate = "<div class='message-error'>Provide a valid value of length 0-10</div>";
		$focus_field = 'hourly_overtime_rate';
		$error = 1;
	}
	$hourly_wait_rate = trim($_POST['hourly_wait_rate']);
	if (strlen($hourly_wait_rate) > 10 || !is_numeric($hourly_wait_rate)) {
		$msg_hourly_wait_rate = "<div class='message-error'>Provide a valid value of length 0-10</div>";
		$focus_field = 'hourly_wait_rate';
		$error = 1;
	}
	$hourly_regular_rate = trim($_POST['hourly_regular_rate']);
	if (strlen($hourly_regular_rate) > 10 || !is_numeric($hourly_regular_rate)) {
		$msg_hourly_regular_rate = "<div class='message-error'>Provide a valid value of length 0-10</div>";
		$focus_field = 'hourly_regular_rate';
		$error = 1;
	}
	$zone_rate_percent = trim($_POST['zone_rate_percent']);
	if (strlen($zone_rate_percent) > 10 || !is_numeric($zone_rate_percent)) {
		$msg_zone_rate_percent = "<div class='message-error'>Provide a valid value of length 0-10</div>";
		$focus_field = 'zone_rate_percent';
		$error = 1;
	}
	
	$image_url = trim($_POST['image_url']);
	if (strlen($image_url) > 100) {
		$msg_image_url = "<div class='message-error'>Provide a valid value of length 0-100</div>";
		$focus_field = 'image_url';
		$error = 1;
	}
	$insurance_expiry_date = trim($_POST['insurance_expiry_date']);
	if (empty($insurance_expiry_date)) {
		$insurance_expiry_date = '1970-01-01';
	} else if (!is_date($insurance_expiry_date)) {
		$msg_insurance_expiry_date = "<div class='message-error'>Acceptable date format is 'yyyy-mm-dd'</div>";
		$focus_field = 'insurance_expiry_date';
		$error = 1;
	}
	$insurance_company = trim($_POST['insurance_company']);
	if (strlen($insurance_company) > 100) {
		$msg_insurance_company = "<div class='message-error'>Provide a valid value of length 0-100</div>";
		$focus_field = 'insurance_company';
		$error = 1;
	}
	$key_settings_insurance_company_values = trim($_POST['key_settings_insurance_company_values']);
	if (strlen($key_settings_insurance_company_values) > 100 || !is_numeric($key_settings_insurance_company_values)) {
		$msg_key_settings_insurance_company_values = "<div class='message-error'>Provide a valid value of length 0-100</div>";
		$focus_field = 'key_settings_insurance_company_values';
		$error = 1;
	}
	$color = trim($_POST['color']);
	if (strlen($color) > 100) {
		$msg_color = "<div class='message-error'>Provide a valid value of length 0-100</div>";
		$focus_field = 'color';
		$error = 1;
	}
	$max_seats = trim($_POST['max_seats']);
	if (strlen($max_seats) > 100 || !is_numeric($max_seats)) {
		$msg_max_seats = "<div class='message-error'>Provide a valid value of length 0-100</div>";
		$focus_field = 'max_seats';
		$error = 1;
	}
	$model = trim($_POST['model']);
	if (strlen($model) > 50) {
		$msg_model = "<div class='message-error'>Provide a valid value of length 0-50</div>";
		$focus_field = 'model';
		$error = 1;
	}
	$make = trim($_POST['make']);
	if (strlen($make) > 50) {
		$msg_make = "<div class='message-error'>Provide a valid value of length 0-50</div>";
		$focus_field = 'make';
		$error = 1;
	}
	$year_made = trim($_POST['year_made']);
	if (strlen($year_made) > 100) {
		$msg_year_made = "<div class='message-error'>Provide a valid value of length 0-100</div>";
		$focus_field = 'year_made';
		$error = 1;
	}
	$vin_number = trim($_POST['vin_number']);
	if (strlen($vin_number) > 100) {
		$msg_vin_number = "<div class='message-error'>Provide a valid value of length 0-100</div>";
		$focus_field = 'vin_number';
		$error = 1;
	}
	$tag = trim($_POST['tag']);
	if (strlen($tag) > 100) {
		$msg_tag = "<div class='message-error'>Provide a valid value of length 0-100</div>";
		$focus_field = 'tag';
		$error = 1;
	}
	$vehicle_type = trim($_POST['vehicle_type']);
	// if (empty($vehicle_type)) print "vehicle_type is empty";
	if (strlen($vehicle_type) < 3 || strlen($vehicle_type) > 100) {
		$msg_vehicle_type = "<div class='message-error'>Provide a valid value of length 3-100</div>";
		$focus_field = 'vehicle_type';
		$error = 1;
	}
	$fleet_number = trim($_POST['fleet_number']);
	if (strlen($fleet_number) > 50) {
		$msg_fleet_number = "<div class='message-error'>Provide a valid value of length 0-50</div>";
		$focus_field = 'fleet_number';
		$error = 1;
	}
	// no validation error
	if ($error == 0) {
		if (isset($record_id) && $error != 1) { // update
			$results = mysqli_query($dbcon, "UPDATE vehicles SET 
			fleet_number = '" . sd($dbcon, $fleet_number) . "',
			vehicle_type = '" . sd($dbcon, $vehicle_type) . "',
			tag = '" . sd($dbcon, $tag) . "',
			vin_number = '" . sd($dbcon, $vin_number) . "',
			year_made = '" . sd($dbcon, $year_made) . "',
			make = '" . sd($dbcon, $make) . "',
			model = '" . sd($dbcon, $model) . "',
			max_seats = '" . sd($dbcon, $max_seats) . "',
			color = '" . sd($dbcon, $color) . "',
			key_settings_insurance_company_values = '" . sd($dbcon, $key_settings_insurance_company_values) . "',
			insurance_company = '" . sd($dbcon, $insurance_company) . "',
			insurance_expiry_date = '" . sd($dbcon, $insurance_expiry_date) . "',
			image_url = '" . sd($dbcon, $image_url) . "',
			zone_rate_percent = '" . sd($dbcon, $zone_rate_percent) . "',
			hourly_regular_rate = '" . sd($dbcon, $hourly_regular_rate) . "',
			hourly_wait_rate = '" . sd($dbcon, $hourly_wait_rate) . "',
			hourly_overtime_rate = '" . sd($dbcon, $hourly_overtime_rate) . "',
			notes = '" . sd($dbcon, $notes) . "',
			active_status = '" . sd($dbcon, $active_status) . "'
			WHERE key_vehicles = $record_id");
			if ($results) {
				$message = "<script>parent.location.reload(false);</script>";
			} else {
				print mysqli_error($dbcon);
				die('Unable to update, please contact your system administrator.');
			}
		} else if ($error != 1) { // insert
			$results = mysqli_query($dbcon, "INSERT INTO vehicles (
			fleet_number,
			vehicle_type,
			tag,
			vin_number,
			year_made,
			make,
			model,
			max_seats,
			color,
			key_settings_insurance_company_values,
			insurance_company,
			insurance_expiry_date,
			image_url,
			zone_rate_percent,
			hourly_regular_rate,
			hourly_wait_rate,
			hourly_overtime_rate,
			notes,
			active_status
			) 
			VALUES (
			'" . sd($dbcon, $fleet_number) . "',
			'" . sd($dbcon, $vehicle_type) . "',
			'" . sd($dbcon, $tag) . "',
			'" . sd($dbcon, $vin_number) . "',
			'" . sd($dbcon, $year_made) . "',
			'" . sd($dbcon, $make) . "',
			'" . sd($dbcon, $model) . "',
			'" . sd($dbcon, $max_seats) . "',
			'" . sd($dbcon, $color) . "',
			'" . sd($dbcon, $key_settings_insurance_company_values) . "',
			'" . sd($dbcon, $insurance_company) . "',
			'" . sd($dbcon, $insurance_expiry_date) . "',
			'" . sd($dbcon, $image_url) . "',
			'" . sd($dbcon, $zone_rate_percent) . "',
			'" . sd($dbcon, $hourly_regular_rate) . "',
			'" . sd($dbcon, $hourly_wait_rate) . "',
			'" . sd($dbcon, $hourly_overtime_rate) . "',
			'" . sd($dbcon, $notes) . "',
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
				}         }
		}	
	}
	if ($error == 0) $show_form = false;
}
?>
<!DOCTYPE html>
<html>
<head>
	<title>VEHICLE</title>
	<?php include('php/_head.php'); ?>
	<style>
		#loader {display:none;}
	</style>
	<script>
		function populateModelsOfVehicle(make) {
			
			document.getElementById("model").innerHTML = "";
			if (make.length != 0) {
				document.getElementById("loader").style.display = "block";
				var xmlhttp = new XMLHttpRequest();
				xmlhttp.onreadystatechange = function() {
					if (this.readyState == 4 && this.status == 200) {
						document.getElementById("model").innerHTML = this.responseText;
						document.getElementById("loader").style.display = "none";
					}
				};
				xmlhttp.open("GET", "vehicles_select_options_make_model.php?make=" + make, true);
				xmlhttp.send();
			}
		}
	</script>
</head>
<body id='page-save' class='page_save page_vehicles_save'>

	<section id='sub-menu'>
		<div class='left-block'>vehicle</div>
		<div class='right-block'>

		</div>
	</section>

	<?php if (isset($message)) print $message; ?>
	
	<main>

	<?php if (isset($show_form) && $show_form) { ?>
	<form method='post'>
		<fieldset>

         <div>
             <label for='fleet_number'>Fleet #</label>             
			 <?php if(isset($msg_fleet_number)) print $msg_fleet_number; ?>
             <input id='fleet_number' name='fleet_number' type='text' value='<?php if (isset($fleet_number)) {print $fleet_number;} else { print '';} ?>'><br>
         </div>

         <div>
             <label for='vehicle_type'>Vehicle type</label> <span class='red'> *</span><br>
             <?php if(isset($msg_vehicle_type)) print $msg_vehicle_type; ?>
             <select id='vehicle_type' name='vehicle_type' required>
                 <?php 
                 $options = '';
                 $results = mysqli_query($dbcon, 'SELECT vehicle_type FROM settings_vehicle_type_values');
                 while ($row = mysqli_fetch_assoc($results)) {
                     $selection = '';
                     if ($row['vehicle_type'] == $vehicle_type) $selection = "selected='selected'";
                         $options .= "<option $selection>" . $row['vehicle_type'] . "</option>";
                 }
                 print $options; 
                 ?>
             </select>
         </div>

         <div>
             <label for='tag'>Tag <span class='red'> *</span></label>
			 <?php if(isset($msg_tag)) print $msg_tag; ?>
             <input id='tag' name='tag' type='text' value='<?php if (isset($tag)) {print $tag;} else { print '';} ?>' required><br>
         </div>

         <div>
             <label for='vin_number'>Vin #</label>             
			 <?php if(isset($msg_vin_number)) print $msg_vin_number; ?>
             <input id='vin_number' name='vin_number' type='text' value='<?php if (isset($vin_number)) {print $vin_number;} else { print '';} ?>'><br>
         </div>

         <div>
             <label for='year_made'>Year</label>             
			 <?php if(isset($msg_year_made)) print $msg_year_made; ?>
             <input id='year_made' name='year_made' type='text' value='<?php if (isset($year_made)) {print $year_made;} else { print '';} ?>'><br>
         </div>

         <div>
             <label for='make'>Make</label><br>
             <?php if(isset($msg_make)) print $msg_make; ?>
             <select id='make' name='make' onchange='populateModelsOfVehicle(this.value);'>
				 <option></option>
                 <?php 
                 $options = '';
                 $results = mysqli_query($dbcon, 'SELECT vehicle_make FROM settings_vehicle_make_values');
                 while ($row = mysqli_fetch_assoc($results)) {
                     $selection = '';
                     if ($row['vehicle_make'] == $make) $selection = "selected='selected'";
                         $options .= "<option $selection>" . $row['vehicle_make'] . "</option>";
                 }
                 print $options; 
                 ?>
             </select>
         </div>


         <div>
             <label for='model'>Model</label><br>
             <?php if(isset($msg_model)) print $msg_model; ?>
			 <progress id='loader'></progress>
             <select id='model' name='model'>
                 <?php 
                 $options = '';
                 $results = mysqli_query($dbcon, "SELECT vehicle_model FROM settings_vehicle_model_values WHERE vehicle_make = '$make'");
                 while ($row = mysqli_fetch_assoc($results)) {
					$selection = '';
					if ($row['vehicle_model'] == $model) $selection = "selected='selected'";
					$options .= "<option $selection>" . $row['vehicle_model'] . "</option>";
                 }
                 print $options; 
                 ?>
             </select>
         </div>

         <div>
             <label for='max_seats'>Max seats</label>             
			 <?php if(isset($msg_max_seats)) print $msg_max_seats; ?>
             <input id='max_seats' name='max_seats' type='number' value='<?php if (isset($max_seats)) {print $max_seats;} else { print '0';} ?>'><br>
         </div>

         <div>
             <label for='color'>Color</label><br>
             <?php if(isset($msg_color)) print $msg_color; ?>
             <select id='color' name='color'>
                 <?php
                 if (!isset($color)) $color = '';
                 print "
                 <option" . (($color == 'Black') ? " selected='selected'" : '') .  ">Black</option>
                 <option" . (($color == 'White') ? " selected='selected'" : '') .  ">White</option>
				 <option" . (($color == 'Off-white') ? " selected='selected'" : '') .  ">Off-white</option>
				 <option" . (($color == 'Silver') ? " selected='selected'" : '') .  ">Silver</option>
                 ";
                 ?>
             </select>
         </div>

         <input id='key_settings_insurance_company_values' name='key_settings_insurance_company_values' type='hidden' value='<?php if (isset($key_settings_insurance_company_values)) {print $key_settings_insurance_company_values;} else {print '0';} ?>'>

		</fieldset>
		<fieldset>

		 <div>
			 <label for='insurance_company'>Insurance company</label>
			 <small>
					 <a href='vehicles_select_settings_insurance_company_values.php' target='overlay-iframe2' onclick='overlayOpen2();'>Select</a> &nbsp;
					 <a href='#' onclick='unselectKeyValue("key_settings_insurance_company_values","insurance_company");return false;'>x</a>
			 </small><br>
			 <?php if(isset($msg_insurance_company)) print $msg_insurance_company; ?>
			 <input id='insurance_company' name='insurance_company' type='text' value='<?php if (isset($insurance_company)) {print $insurance_company;} else { print '';} ?>' readonly><br>
		 </div>

         <div>
             <label for='insurance_expiry_date'>Insurance expiration</label><br>
             <?php if(isset($msg_insurance_expiry_date)) print $msg_insurance_expiry_date; ?>
             <input id='insurance_expiry_date' name='insurance_expiry_date' type='date' placeholder='yyyy-mm-dd' value='<?php if (isset($insurance_expiry_date)) {print $insurance_expiry_date;} ?>'><br>
         </div>
		 
         <div>
             <label for='notes'>Notes</label>             
			 <?php if(isset($msg_notes)) print $msg_notes; ?>
             <textarea id='notes' name='notes'><?php if (isset($notes)) print $notes; ?></textarea><br>
         </div>
		 
         <div>
             <label for='image_url'>Image url</label>             
			 <?php if(isset($msg_image_url)) print $msg_image_url; ?>
             <input id='image_url' name='image_url' type='text' value='<?php if (isset($image_url)) {print $image_url;} else { print '';} ?>'><br>
         </div>

		 </fieldset>
		 <fieldset>

         <div>
             <label for='zone_rate_percent'>Zone rate %</label>
             <?php if(isset($msg_zone_rate_percent)) print $msg_zone_rate_percent; ?>
             <input id='zone_rate_percent' name='zone_rate_percent' type='number' step='any' value='<?php if (isset($zone_rate_percent)) {print $zone_rate_percent;} else { print '100';} ?>' required><br>
         </div>
		 
         <div>
             <label for='hourly_regular_rate'>Hourly regular rate</label>
             <?php if(isset($msg_hourly_regular_rate)) print $msg_hourly_regular_rate; ?>
             <input id='hourly_regular_rate' name='hourly_regular_rate' type='number' step='0.10' value='<?php if (isset($hourly_regular_rate)) {print $hourly_regular_rate;} else { print '0';} ?>'><br>
         </div>

         <div>
             <label for='hourly_wait_rate'>Hourly wait rate</label>
             <?php if(isset($msg_hourly_wait_rate)) print $msg_hourly_wait_rate; ?>
             <input id='hourly_wait_rate' name='hourly_wait_rate' type='number' step='0.10' value='<?php if (isset($hourly_wait_rate)) {print $hourly_wait_rate;} else { print '0';} ?>'><br>
         </div>

         <div>
             <label for='hourly_overtime_rate'>Hourly overtime rate</label>
             <?php if(isset($msg_hourly_overtime_rate)) print $msg_hourly_overtime_rate; ?>
             <input id='hourly_overtime_rate' name='hourly_overtime_rate' type='number' step='0.10' value='<?php if (isset($hourly_overtime_rate)) {print $hourly_overtime_rate;} else { print '0';} ?>'><br>
         </div>

		<br><br>

         <div>
             <?php if(isset($msg_active_status)) print $msg_active_status; ?>
             <input <?php if (!isset($active_status) || $active_status=='on') {print "checked='checked'";} ?> type='checkbox' id='active_status' name='active_status'> <label for='active_status'>Status</label><br>
         </div>

		</fieldset>
		
		<input id='save_submit' name='save_submit' type='submit' value='Save'>
		
		
	</form>
	<?php } ?>

	</main>
	<?php include('php/_footer.php'); ?>

</body>
</html>
