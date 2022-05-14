<?php 
include('php/_code.php');
$show_form = true;
$focus_field = 'title';
// id passed for update
if (isset($_GET['landmarksid'])) {
	$record_id = trim($_GET['landmarksid']);
	if (!is_numeric($record_id)) exit;
	if (!isset($_POST['save_submit'])) {
		$results = mysqli_query($dbcon, "SELECT * FROM landmarks WHERE key_landmarks = $record_id");
		if ($row = mysqli_fetch_assoc($results)) {
			$title = $row['title'];
			$category = $row['category'];
			$image_url = $row['image_url'];
			$address1 = $row['address1'];
			$address2 = $row['address2'];
			$city = $row['city'];
			$state = $row['state'];
			$country = $row['country'];
			$zip_code = $row['zip_code'];
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
	if (strlen($notes) > 1000) {
		$msg_notes = "<div class='message-error'>Provide a valid value of length 0-1000</div>";
		$focus_field = 'notes';
		$error = 1;
	}
	$zip_code = trim($_POST['zip_code']);
	if (strlen($zip_code) > 50) {
		$msg_zip_code = "<div class='message-error'>Provide a valid value of length 0-50</div>";
		$focus_field = 'zip_code';
		$error = 1;
	}
	$country = trim($_POST['country']);
	if (strlen($country) > 100) {
		$msg_country = "<div class='message-error'>Provide a valid value of length 0-100</div>";
		$focus_field = 'country';
		$error = 1;
	}
	$state = trim($_POST['state']);
	if (strlen($state) > 100) {
		$msg_state = "<div class='message-error'>Provide a valid value of length 0-100</div>";
		$focus_field = 'state';
		$error = 1;
	}
	$city = trim($_POST['city']);
	if (strlen($city) > 100) {
		$msg_city = "<div class='message-error'>Provide a valid value of length 0-100</div>";
		$focus_field = 'city';
		$error = 1;
	}
	$address2 = trim($_POST['address2']);
	if (strlen($address2) > 100) {
		$msg_address2 = "<div class='message-error'>Provide a valid value of length 0-100</div>";
		$focus_field = 'address2';
		$error = 1;
	}
	$address1 = trim($_POST['address1']);
	if (strlen($address1) > 100) {
		$msg_address1 = "<div class='message-error'>Provide a valid value of length 0-100</div>";
		$focus_field = 'address1';
		$error = 1;
	}
	$image_url = trim($_POST['image_url']);
	if (strlen($image_url) > 100) {
		$msg_image_url = "<div class='message-error'>Provide a valid value of length 0-100</div>";
		$focus_field = 'image_url';
		$error = 1;
	}
	$category = trim($_POST['category']);
	if (strlen($category) > 100) {
		$msg_category = "<div class='message-error'>Provide a valid value of length 0-100</div>";
		$focus_field = 'category';
		$error = 1;
	}
	$title = trim($_POST['title']);
	if (strlen($title) < 3 || strlen($title) > 100) {
		$msg_title = "<div class='message-error'>Provide a valid value of length 3-100</div>";
		$focus_field = 'title';
		$error = 1;
	}
	// no validation error
	if ($error == 0) {
		if (isset($record_id) && $error != 1) { // update
			$results = mysqli_query($dbcon, "UPDATE landmarks SET 
			title = '" . sd($dbcon, $title) . "',
			category = '" . sd($dbcon, $category) . "',
			image_url = '" . sd($dbcon, $image_url) . "',
			address1 = '" . sd($dbcon, $address1) . "',
			address2 = '" . sd($dbcon, $address2) . "',
			city = '" . sd($dbcon, $city) . "',
			state = '" . sd($dbcon, $state) . "',
			country = '" . sd($dbcon, $country) . "',
			zip_code = '" . sd($dbcon, $zip_code) . "',
			notes = '" . sd($dbcon, $notes) . "',
			active_status = '" . sd($dbcon, $active_status) . "'
			WHERE key_landmarks = $record_id");
			if ($results) {
				$message = "<script>parent.location.reload(false);</script>";
			} else {
				//print mysqli_error($dbcon);
				die('Unable to update, please contact your system administrator.');
			}
		} else if ($error != 1) { // insert
			$results = mysqli_query($dbcon, "INSERT INTO landmarks (
			title,
			category,
			image_url,
			address1,
			address2,
			city,
			state,
			country,
			zip_code,
			notes,
			active_status
			) 
			VALUES (
			'" . sd($dbcon, $title) . "',
			'" . sd($dbcon, $category) . "',
			'" . sd($dbcon, $image_url) . "',
			'" . sd($dbcon, $address1) . "',
			'" . sd($dbcon, $address2) . "',
			'" . sd($dbcon, $city) . "',
			'" . sd($dbcon, $state) . "',
			'" . sd($dbcon, $country) . "',
			'" . sd($dbcon, $zip_code) . "',
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
	<title>LANDMARK</title>
	<?php include('php/_head.php'); ?>
</head>
<body id='page-save' class='page_save page_landmarks_save'>

	<section id='sub-menu'>
		<div class='left-block'>landmark</div>
		<div class='right-block'>

		</div>
	</section>

	<?php if (isset($message)) print $message; ?>
	
	<main>

	<?php if (isset($show_form) && $show_form) { ?>
	<form method='post'>
	
		<fieldset>

         <div>
             <label for='title'>Title</label> <span class='red'> *</span>             <?php if(isset($msg_title)) print $msg_title; ?>
             <input <?php if ($focus_field == 'title') print 'autofocus'; ?> id='title' name='title' type='text' value='<?php if (isset($title)) {print $title;} else { print '';} ?>' required><br>
         </div>

         <div>
             <label for='category'>Category</label><br>
             <?php if(isset($msg_category)) print $msg_category; ?>
             <select id='category' name='category'>
                 <?php 
                 $options = '';
                 $results = mysqli_query($dbcon, 'SELECT category FROM settings_landmark_values');
                 while ($row = mysqli_fetch_assoc($results)) {
                     $selection = '';
                     if ($row['category'] == $category) $selection = "selected='selected'";
                         $options .= "<option $selection>" . $row['category'] . "</option>";
                 }
                 print $options; 
                 ?>
             </select>
         </div>

         <div>
             <label for='address1'>Address 1</label>             <?php if(isset($msg_address1)) print $msg_address1; ?>
             <input <?php if ($focus_field == 'address1') print 'autofocus'; ?> id='address1' name='address1' type='text' value='<?php if (isset($address1)) {print $address1;} else { print '';} ?>'><br>
         </div>

         <div>
             <label for='address2'>Address 2</label>             <?php if(isset($msg_address2)) print $msg_address2; ?>
             <input <?php if ($focus_field == 'address2') print 'autofocus'; ?> id='address2' name='address2' type='text' value='<?php if (isset($address2)) {print $address2;} else { print '';} ?>'><br>
         </div>

         <div>
             <label for='city'>City</label>             <?php if(isset($msg_city)) print $msg_city; ?>
             <input <?php if ($focus_field == 'city') print 'autofocus'; ?> id='city' name='city' type='text' value='<?php if (isset($city)) {print $city;} else { print '';} ?>'><br>
         </div>

         <div>
             <label for='state'>State</label><br>
             <?php if(isset($msg_state)) print $msg_state; ?>
             <select id='state' name='state'>
                 <?php 
                 $options = '';
                 $results = mysqli_query($dbcon, 'SELECT state FROM settings_state_values');
                 while ($row = mysqli_fetch_assoc($results)) {
                     $selection = '';
                     if ($row['state'] == $state) $selection = "selected='selected'";
                         $options .= "<option $selection>" . $row['state'] . "</option>";
                 }
                 print $options; 
                 ?>
             </select>
         </div>

         <div>
             <label for='country'>Country</label><br>
             <?php if(isset($msg_country)) print $msg_country; ?>
             <select id='country' name='country'>
                 <?php 
                 $options = '';
                 $results = mysqli_query($dbcon, 'SELECT country FROM settings_country_values');
                 while ($row = mysqli_fetch_assoc($results)) {
                     $selection = '';
                     if ($row['country'] == $country) $selection = "selected='selected'";
                         $options .= "<option $selection>" . $row['country'] . "</option>";
                 }
                 print $options; 
                 ?>
             </select>
         </div>

         <div>
             <label for='zip_code'>Zip code</label>             <?php if(isset($msg_zip_code)) print $msg_zip_code; ?>
             <input <?php if ($focus_field == 'zip_code') print 'autofocus'; ?> id='zip_code' name='zip_code' type='text' value='<?php if (isset($zip_code)) {print $zip_code;} else { print '';} ?>'><br>
         </div>

		</fieldset>
		<fieldset>

         <div>
             <label for='image_url'>Image url</label>             <?php if(isset($msg_image_url)) print $msg_image_url; ?>
             <input <?php if ($focus_field == 'image_url') print 'autofocus'; ?> id='image_url' name='image_url' type='text' value='<?php if (isset($image_url)) {print $image_url;} else { print '';} ?>'><br>
         </div>

         <div>
             <label for='notes'>Notes</label>             <?php if(isset($msg_notes)) print $msg_notes; ?>
             <textarea <?php if ($focus_field == 'notes') print 'autofocus'; ?> id='notes' name='notes'><?php if (isset($notes)) print $notes; ?></textarea><br>
         </div>

		<br><br>

         <div>
             <?php if(isset($msg_active_status)) print $msg_active_status; ?>
             <input <?php if (!isset($active_status) || $active_status=='on') {print "checked='checked'";} ?> type='checkbox' id='active_status' name='active_status'> <label for='active_status'>Status</label><br>
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
