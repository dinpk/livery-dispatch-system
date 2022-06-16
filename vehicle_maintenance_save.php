<?php 
include('php/_code.php');
// parent id passed
if (isset($_GET['vehicleid'])) {
	$parent_id = trim($_GET['vehicleid']);
	if (!is_numeric($parent_id)) die('Parent table id is invalid');
	$results = mysqli_query($dbcon, "SELECT fleet_number FROM vehicles WHERE key_vehicles = $parent_id");
	if ($row = mysqli_fetch_assoc($results)) {
		$parent_record_label = "Fleet — " . $row['fleet_number'];
	} else {
		die('Parent id does not exist');
	}
} else {
	die('Parent id is not set');
}
$show_form = true;
$focus_field = 'repair_date';
// id passed for update
if (isset($_GET['vehiclemaintenanceid'])) {
	$record_id = trim($_GET['vehiclemaintenanceid']);
	if (!is_numeric($record_id)) exit;
	if (!isset($_POST['save_submit'])) {
		$results = mysqli_query($dbcon, "SELECT * FROM vehicles_maintenance WHERE key_vehicles_maintenance = $record_id  AND key_vehicles = $parent_id");
		if ($row = mysqli_fetch_assoc($results)) {
			$repair_date = $row['repair_date'];
			$repair_description = $row['repair_description'];
			$workshop_name = $row['workshop_name'];
			$labor_cost = $row['labor_cost'];
			$parts_cost = $row['parts_cost'];
			$warranty_description = $row['warranty_description'];
			$warranty_expiration = $row['warranty_expiration'];
		} else {
			$message = "<div class='failure-result'>Record not found</div>";
			$show_form = false;
		}
	}
}
$form_url_parameter = '';
if (isset($parent_id) && isset($record_id)) {
	$form_url_parameter = "?vehiclemaintenanceid=$record_id&vehicleid=$parent_id"; // for record update		
} else if (isset($parent_id)) {
	$form_url_parameter = "?vehicleid=$parent_id"; // for new record
}
// save button clicked
if (isset($_POST['save_submit'])) {
	$error = 0;
	// validation of input data
	$warranty_expiration = trim($_POST['warranty_expiration']);
	if (empty($warranty_expiration)) {
		$warranty_expiration = '1970-01-01';
	} else if (!is_date($warranty_expiration)) {
		$msg_warranty_expiration = "<div class='message-error'>Acceptable date format is 'yyyy-mm-dd'</div>";
		$focus_field = 'warranty_expiration';
		$error = 1;
	}
	$warranty_description = trim($_POST['warranty_description']);
	if (strlen($warranty_description) > 1000) {
		$msg_warranty_description = "<div class='message-error'>Provide a valid value up to length 1000</div>";
		$focus_field = 'warranty_description';
		$error = 1;
	}
	$parts_cost = trim($_POST['parts_cost']);
	if (strlen($parts_cost) > 100 || !is_numeric($parts_cost)) {
		$msg_parts_cost = "<div class='message-error'>Provide a valid value up to length 100</div>";
		$focus_field = 'parts_cost';
		$error = 1;
	}
	$labor_cost = trim($_POST['labor_cost']);
	if (strlen($labor_cost) > 100 || !is_numeric($labor_cost)) {
		$msg_labor_cost = "<div class='message-error'>Provide a valid value up to length 100</div>";
		$focus_field = 'labor_cost';
		$error = 1;
	}
	$workshop_name = trim($_POST['workshop_name']);
	if (strlen($workshop_name) > 100) {
		$msg_workshop_name = "<div class='message-error'>Provide a valid value up to length 100</div>";
		$focus_field = 'workshop_name';
		$error = 1;
	}
	$repair_description = trim($_POST['repair_description']);
	if (strlen($repair_description) > 3000) {
		$msg_repair_description = "<div class='message-error'>Provide a valid value up to length 3000</div>";
		$focus_field = 'repair_description';
		$error = 1;
	}
	$repair_date = trim($_POST['repair_date']);
	if (empty($repair_date)) {
		$repair_date = '1970-01-01';
	} else if (!is_date($repair_date)) {
		$msg_repair_date = "<div class='message-error'>Acceptable date format is 'yyyy-mm-dd'</div>";
		$focus_field = 'repair_date';
		$error = 1;
	}
	// no validation error
	if ($error == 0) {
		if (isset($record_id) && $error != 1) { // update
			$results = mysqli_query($dbcon, "UPDATE vehicles_maintenance SET 
				repair_date = '" . sd($dbcon, $repair_date) . "', 
				repair_description = '" . sd($dbcon, $repair_description) . "', 
				workshop_name = '" . sd($dbcon, $workshop_name) . "', 
				labor_cost = '" . sd($dbcon, $labor_cost) . "', 
				parts_cost = '" . sd($dbcon, $parts_cost) . "', 
				warranty_description = '" . sd($dbcon, $warranty_description) . "', 
				warranty_expiration = '" . sd($dbcon, $warranty_expiration) . "' WHERE key_vehicles_maintenance = $record_id  AND key_vehicles = $parent_id");
			if ($results) {
				$message = "<script>parent.location.reload(false);</script>";
			} else {
				//print mysqli_error($dbcon);
				die('Unable to update, please contact your system administrator.');
			}
			$show_form = false;
		} else if ($error != 1) { // insert
			$results = mysqli_query($dbcon, "INSERT INTO vehicles_maintenance (key_vehicles,repair_date,repair_description,workshop_name,labor_cost,parts_cost,warranty_description,warranty_expiration) VALUES (
				'" . sd($dbcon, $parent_id) . "',
				'" . sd($dbcon, $repair_date) . "',
				'" . sd($dbcon, $repair_description) . "',
				'" . sd($dbcon, $workshop_name) . "',
				'" . sd($dbcon, $labor_cost) . "',
				'" . sd($dbcon, $parts_cost) . "',
				'" . sd($dbcon, $warranty_description) . "',
				'" . sd($dbcon, $warranty_expiration) . "')");
			if ($results) {
				$message = "<script>parent.location.reload(false);</script>";
			} else {
				//print mysqli_error($dbcon);
				die('Unable to add, please contact your system administrator.');
			}
			$show_form = false;
		}	
	}
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>VEHICLE - MAINTENANCE</title>
    <?php include('php/_head.php'); ?>
</head>
<body id='page-save' class='foreign'>
    <?php if (isset($parent_record_label)) print '<h2>' . $parent_record_label . '</h2>'; ?>
    <section id='sub-menu'>
        <div class='left-block'>vehicle maintenance</div>
        <div class='right-block'>
        </div>
    </section>
    <?php if (isset($message)) print $message; ?>
    <main>
        <?php if (isset($show_form) && $show_form) { ?>
        <form method='post' action='vehicle_maintenance_save.php<?php print $form_url_parameter; ?>'>
            <fieldset>
                <div>
                    <label for='repair_date'>Repair date</label> <span class='red'> *</span><br>
                    <?php if(isset($msg_repair_date)) print $msg_repair_date; ?>
                    <input id='repair_date' name='repair_date' type='date' placeholder='yyyy-mm-dd'
                        value='<?php if (isset($repair_date)) {print $repair_date;} ?>' required><br>
                </div>
                <div>
                    <label for='repair_description'>Repair description</label><br>
                    <?php if(isset($msg_repair_description)) print $msg_repair_description; ?>
                    <textarea id='repair_description'
                        name='repair_description'><?php if (isset($repair_description)) print $repair_description; ?></textarea><br>
                </div>
            </fieldset>
            <fieldset>
                <div>
                    <label for='workshop_name'>Workshop name</label> <span class='red'> *</span><br>
                    <?php if(isset($msg_workshop_name)) print $msg_workshop_name; ?>
                    <select id='workshop_name' name='workshop_name' required>
                        <?php 
						$options = '';
						$results = mysqli_query($dbcon, 'SELECT workshop_name FROM settings_workshop_name_values');
						while ($row = mysqli_fetch_assoc($results)) {
							$selection = '';
							if ($row['workshop_name'] == $workshop_name) $selection = "selected='selected'";
								$options .= "<option $selection>" . $row['workshop_name'] . "</option>";
						}
						print $options; 
						?>
                    </select>
                </div>
                <div>
                    <label for='labor_cost'>Labor cost</label> <span class='red'> *</span><br>
                    <?php if(isset($msg_labor_cost)) print $msg_labor_cost; ?>
                    <input id='labor_cost' name='labor_cost' type='number' step='0.10'
                        value='<?php if (isset($labor_cost)) {print $labor_cost;} else {print '0';} ?>'><br>
                </div>
                <div>
                    <label for='parts_cost'>Parts cost</label> <span class='red'> *</span><br>
                    <?php if(isset($msg_parts_cost)) print $msg_parts_cost; ?>
                    <input id='parts_cost' name='parts_cost' type='number' step='0.10'
                        value='<?php if (isset($parts_cost)) {print $parts_cost;} else {print '0';} ?>'><br>
                </div>
                <div>
                    <label for='warranty_description'>Warranty description</label><br>
                    <?php if(isset($msg_warranty_description)) print $msg_warranty_description; ?>
                    <textarea id='warranty_description'
                        name='warranty_description'><?php if (isset($warranty_description)) print $warranty_description; ?></textarea><br>
                </div>
                <div>
                    <label for='warranty_expiration'>Warranty expiration</label> <span class='red'> *</span><br>
                    <?php if(isset($msg_warranty_expiration)) print $msg_warranty_expiration; ?>
                    <input id='warranty_expiration' name='warranty_expiration' type='date' placeholder='yyyy-mm-dd'
                        value='<?php if (isset($warranty_expiration)) {print $warranty_expiration;} ?>'><br>
                </div>
            </fieldset> <input id='save_submit' name='save_submit' type='submit' value='Save'>
        </form>
        <?php } ?>
    </main>
    <?php include('php/_footer.php'); ?>
</body>
</html>