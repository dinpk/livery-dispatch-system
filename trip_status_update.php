<?php 
include('php/_code.php');
$show_form = true;
$focus_field = 'reference_number';
// id passed for update
if (isset($_GET['tripid'])) {
	$record_id = trim($_GET['tripid']);
	if (!is_numeric($record_id)) exit;
	if (!isset($_POST['save_submit'])) {
		$results = mysqli_query($dbcon, "SELECT key_trips, trip_status FROM trips WHERE key_trips = $record_id");
		if ($row = mysqli_fetch_assoc($results)) {
			$key_trips = $row['key_trips'];
			$trip_status = $row['trip_status'];
		} else {
			$message = "<div class='failure-result'>Record not found</div>";
			$show_form = false;
		}
	}
}
// save button clicked
if (isset($_POST['save_submit'])) {
	$error = 0;
	$trip_status = (isset($_POST['trip_status']) ? trim($_POST['trip_status']) : '');
	if (strlen($trip_status) < 0 || strlen($trip_status) > 50) {
		$msg_trip_status = "<div class='message-error'>Provide a valid value of length 0-50</div>";
		$focus_field = 'trip_status';
		$error = 1;
	}
	// no validation error
	if ($error == 0) {
		if (isset($record_id) && $error != 1) { // update
			$results = mysqli_query($dbcon, "UPDATE trips SET trip_status = '" . sd($dbcon, $trip_status) . "' WHERE key_trips = $record_id");
			if ($results) {
				$message = "<script>parent.location.reload(false);</script>";
			} else {
				//print mysqli_error($dbcon);
				die('Unable to update, please contact your system administrator.');
			}
		}
	}
	if ($error == 0) $show_form = false;
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>TRIP - STATUS</title>
    <?php include('php/_head.php'); ?>
</head>
<body id='page-save'>
    <section id='sub-menu'>
        <div class='left-block'>Status - trip # <?php print $key_trips; ?></div>
        <div class='right-block'>
        </div>
    </section>
    <?php if (isset($message)) print $message; ?>
    <main>
        <?php if (isset($show_form) && $show_form) { ?>
        <form method='post'>
            <fieldset id="trips_fieldset1">
                <div>
                    <label for='trip_status'>Trip status</label><br>
                    <?php if(isset($msg_trip_status)) print $msg_trip_status; ?>
                    <select id='trip_status' name='trip_status'>
                        <?php 
						$options = '';
						$results = mysqli_query($dbcon, 'SELECT trip_status FROM settings_trip_status_values WHERE active_status = "on" ORDER BY sort');
						while ($row = mysqli_fetch_assoc($results)) {
							$selection = '';
							if ($row['trip_status'] == $trip_status) $selection = "selected='selected'";
								$options .= "<option $selection>" . $row['trip_status'] . "</option>";
						}
						print $options; 
						?>
                    </select>
                </div>
            </fieldset>
            <div class='clear-fix'>
                <input id='save_submit' name='save_submit' type='submit' value='Save'>
            </div>
        </form>
        <?php } ?>
    </main>
    <?php include('php/_footer.php'); ?>
</body>
</html>