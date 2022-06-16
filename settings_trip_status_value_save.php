<?php 
include('php/_code.php');
$show_form = true;
$focus_field = 'trip_status';
// id passed for update
if (isset($_GET['settingstripstatusid'])) {
	$record_id = trim($_GET['settingstripstatusid']);
	if (!is_numeric($record_id)) exit;
	if (!isset($_POST['save_submit'])) {
		$results = mysqli_query($dbcon, "SELECT * FROM settings_trip_status_values WHERE key_settings_trip_status_values = $record_id");
		if ($row = mysqli_fetch_assoc($results)) {
			$trip_status = $row['trip_status'];
			$text_color = $row['text_color'];
			$back_color = $row['back_color'];
			$sort = $row['sort'];
			$active_status = $row['active_status'];
		} else {
			$message = "<div class='failure-result'>Record not found</div>";
			$show_form = false;
		}
	}
}
// save button clicked
if (isset($_POST['save_submit'])) {
	$error = 0;
	$active_status = trim($_POST['active_status']);
	if (strlen($active_status) > 10) {
		$msg_active_status = "<div class='message-error'>Provide a valid value of length 0-10</div>";
		$focus_field = 'active_status';
		$error = 1;
	}
	$sort = trim($_POST['sort']);
	if (strlen($sort) > 10 || !is_numeric($sort)) {
		$msg_sort = "<div class='message-error'>Provide a valid value of length 0-10</div>";
		$focus_field = 'sort';
		$error = 1;
	}
	$back_color = trim($_POST['back_color']);
	if (strlen($back_color) > 20) {
		$msg_back_color = "<div class='message-error'>Provide a valid value of length 0-20</div>";
		$focus_field = 'back_color';
		$error = 1;
	}
	$text_color = trim($_POST['text_color']);
	if (strlen($text_color) > 20) {
		$msg_text_color = "<div class='message-error'>Provide a valid value of length 0-20</div>";
		$focus_field = 'text_color';
		$error = 1;
	}
	$trip_status = trim($_POST['trip_status']);
	if (strlen($trip_status) < 3 || strlen($trip_status) > 50) {
		$msg_trip_status = "<div class='message-error'>Provide a valid value of length 3-50</div>";
		$focus_field = 'trip_status';
		$error = 1;
	}
	// no validation error
	if ($error == 0) {
		if (isset($record_id) && $error != 1) { // update
			$results = mysqli_query($dbcon, "UPDATE settings_trip_status_values SET 
			trip_status = '" . sd($dbcon, $trip_status) . "',
			text_color = '" . sd($dbcon, $text_color) . "',
			back_color = '" . sd($dbcon, $back_color) . "',
			sort = '" . sd($dbcon, $sort) . "',
			active_status = '" . sd($dbcon, $active_status) . "'
			WHERE key_settings_trip_status_values = $record_id");
			if ($results) {
				$message = "<script>parent.location.reload(false);</script>";
			} else {
				//print mysqli_error($dbcon);
				die('Unable to update, please contact your system administrator.');
			}
		} else if ($error != 1) { // insert
			$results = mysqli_query($dbcon, "INSERT INTO settings_trip_status_values (
			trip_status,
			text_color,
			back_color,
			sort,
			active_status
			) 
			VALUES (
			'" . sd($dbcon, $trip_status) . "',
			'" . sd($dbcon, $text_color) . "',
			'" . sd($dbcon, $back_color) . "',
			'" . sd($dbcon, $sort) . "',
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
				}
			}
		}		}
	if ($error == 0) $show_form = false;
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>SETTINGS - TRIP STATUS</title>
    <?php include('php/_head.php'); ?>
</head>
<body id='page-save'>
    <section id='sub-menu'>
        <div class='left-block'> </div>
        <div class='right-block'> </div>
    </section>
    <?php if (isset($message)) print $message; ?>
    <main>
        <?php if (isset($show_form) && $show_form) { ?>
        <form method='post'>
            <fieldset>
                <div>
                    <label for='trip_status'>Trip status</label> <span class='red'> *</span>
                    <?php if(isset($msg_trip_status)) print $msg_trip_status; ?>
                    <input id='trip_status' name='trip_status' type='text'
                        value='<?php if (isset($trip_status)) {print $trip_status;} else { print '';} ?>' required><br>
                </div>
                <div>
                    <label for='text_color'>Text color</label>
                    <?php if(isset($msg_text_color)) print $msg_text_color; ?>
                    <input id='text_color' name='text_color' type='color'
                        value='<?php if (isset($text_color)) {print $text_color;} else { print '';} ?>'><br>
                </div>
                <div>
                    <label for='back_color'>Back color</label>
                    <?php if(isset($msg_back_color)) print $msg_back_color; ?>
                    <input id='back_color' name='back_color' type='color'
                        value='<?php if (isset($back_color)) {print $back_color;} else { print '';} ?>'><br>
                </div>
                <div>
                    <label for='sort'>Sort</label>
                    <?php if(isset($msg_sort)) print $msg_sort; ?>
                    <input id='sort' name='sort' type='number' step='0.10'
                        value='<?php if (isset($sort)) {print $sort;} else { print '0';} ?>'><br>
                </div>
                <div>
                    <?php if(isset($msg_active_status)) print $msg_active_status; ?>
                    <input <?php if (!isset($active_status) || $active_status=='on') {print "checked='checked'";} ?>
                        type='checkbox' id='active_status' name='active_status'> <label
                        for='active_status'>Status</label><br>
                </div>
            </fieldset> <input id='save_submit' name='save_submit' type='submit' value='Save'>
        </form>
        <?php } ?>
    </main>
    <?php include('php/_footer.php'); ?>
</body>
</html>