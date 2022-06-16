<?php 
include('php/_code.php');
$show_form = true;
$focus_field = 'airline';
// id passed for update
if (isset($_GET['settingsairlineid'])) {
	
	$record_id = trim($_GET['settingsairlineid']);
	if (!is_numeric($record_id)) exit;
	if (!isset($_POST['save_submit'])) {
		$dbcon = db_connection();
		$results = mysqli_query($dbcon, "SELECT * FROM settings_airline_values WHERE key_settings_airline_values = $record_id");
		if ($row = mysqli_fetch_assoc($results)) {
			$airline = $row['airline'];
		} else {
			$message = "<div class='failure-result'>Record not found</div>";
			$show_form = false;
		}		
	}
}
// save button clicked
if (isset($_POST['save_submit'])) {
	
	$error = 0;
	$airline = trim($_POST['airline']);
	if (strlen($airline) < 3 || strlen($airline) > 50) {
		$msg_airline = "<div class='message-error'>Provide a valid value of length 3-50</div>";
		$focus_field = 'airline';
		$error = 1;
	}
	// no validation error
	if ($error == 0) {
		$dbcon = db_connection();
		if (isset($record_id) && $error != 1) { // update
			$results = mysqli_query($dbcon, "UPDATE settings_airline_values SET 
			airline = '" . sd($dbcon, $airline) . "'
				WHERE key_settings_airline_values = $record_id");
			if ($results) {
				$message = "<script>parent.location.reload(false);</script>";
			} else {
				//print mysqli_error($dbcon);
				die('Unable to update, please contact your system administrator.');
			}
		} else if ($error != 1) { // insert
			$results = mysqli_query($dbcon, "INSERT INTO settings_airline_values (airline) VALUES ('" . sd($dbcon, $airline) . "')");
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
    <title>SETTINGS AIRLINE</title>
    <?php include('php/_head.php'); ?>
</head>
<body id='page-save'>
    <section id='sub-menu'>
        <div class='left-block'></div>
        <div class='right-block'>

        </div>
    </section>
    <?php if (isset($message)) print $message; ?>
    <main>
        <?php if (isset($show_form) && $show_form) { ?>
        <form method='post'>
            <fieldset>
                <div>
                    <label for='airline'>Airline</label> <span class='red'> *</span>
                    <?php if(isset($msg_airline)) print $msg_airline; ?>
                    <input id='airline' name='airline' type='text'
                        value='<?php if (isset($airline)) {print $airline;} else { print '';} ?>' required><br>
                </div>

            </fieldset>
            <input id='save_submit' name='save_submit' type='submit' value='Save'>
        </form>
        <?php } ?>
    </main>
    <?php include('php/_footer.php'); ?>
</body>
</html>