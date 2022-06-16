<?php 
include('php/_code.php');
$show_form = true;
$focus_field = 'category';
// id passed for update
if (isset($_GET['settingsextrachargeid'])) {
	$record_id = trim($_GET['settingsextrachargeid']);
	if (!is_numeric($record_id)) exit;
	if (!isset($_POST['save_submit'])) {
		$results = mysqli_query($dbcon, "SELECT * FROM settings_extra_charges_values WHERE key_settings_extra_charges_values = $record_id");
		if ($row = mysqli_fetch_assoc($results)) {
			$category = $row['category'];
		} else {
			$message = "<div class='failure-result'>Record not found</div>";
			$show_form = false;
		}
	}
}
// save button clicked
if (isset($_POST['save_submit'])) {
	$error = 0;
	$category = trim($_POST['category']);
	if (strlen($category) < 3 || strlen($category) > 50) {
		$msg_category = "<div class='message-error'>Provide a valid value of length 3-50</div>";
		$focus_field = 'category';
		$error = 1;
	}
	// no validation error
	if ($error == 0) {
		if (isset($record_id) && $error != 1) { // update
			$results = mysqli_query($dbcon, "UPDATE settings_extra_charges_values SET 
			category = '" . sd($dbcon, $category) . "'
				WHERE key_settings_extra_charges_values = $record_id");
			if ($results) {
				$message = "<script>parent.location.reload(false);</script>";
			} else {
				//print mysqli_error($dbcon);
				die('Unable to update, please contact your system administrator.');
			}
		} else if ($error != 1) { // insert
			$results = mysqli_query($dbcon, "INSERT INTO settings_extra_charges_values (category) VALUES ('" . sd($dbcon, $category) . "')");
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
		}	
	}
	if ($error == 0) $show_form = false;
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>SETTINGS EXTRA CHARGES</title>
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
                    <label for='category'>Category</label> <span class='red'> *</span>
                    <?php if(isset($msg_category)) print $msg_category; ?>
                    <input id='category' name='category' type='text'
                        value='<?php if (isset($category)) {print $category;} else { print '';} ?>' required><br>
                </div>
            </fieldset> <input id='save_submit' name='save_submit' type='submit' value='Save'>
        </form>
        <?php } ?>
    </main>
    <?php include('php/_footer.php'); ?>
</body>
</html>