<?php 
include('php/_code.php');
// parent id passed
if (isset($_GET['customer_passengersid'])) {
	$parent_id = trim($_GET['customer_passengersid']);
	if (!is_numeric($parent_id)) die('Parent table id is invalid');
	
	$results = mysqli_query($dbcon, "SELECT first_name, last_name FROM customer_passengers WHERE key_customer_passengers = $parent_id");
	if ($row = mysqli_fetch_assoc($results)) {
		$parent_record_label = "Address — " . $row['first_name'] . " " . $row['last_name'];
	} else {
		die('Parent id does not exist');
	}
} else {
	die('Parent id is not set');
}
$show_form = true;
$focus_field = 'title';
// id passed for update
if (isset($_GET['customer_address_bookid'])) {
	
	$record_id = trim($_GET['customer_address_bookid']);
	
	if (!is_numeric($record_id)) exit;
	if (!isset($_POST['save_submit'])) {
		
		$results = mysqli_query($dbcon, "SELECT * FROM customer_address_book WHERE key_customer_address_book = $record_id  AND key_customer_passengers = $parent_id");
		if ($row = mysqli_fetch_assoc($results)) {
			
			$title = $row['title'];
			$category = $row['category'];
			$address1 = $row['address1'];
			$address2 = $row['address2'];
			$city = $row['city'];
			$state = $row['state'];
			$zip_code = $row['zip_code'];
			$image_url = $row['image_url'];
			$notes = $row['notes'];
		} else {
			$message = "<div class='failure-result'>Record not found</div>";
			$show_form = false;
		}
		
		
	}
}
$form_url_parameter = '';
if (isset($parent_id) && isset($record_id)) {
	$form_url_parameter = "?customer_address_bookid=$record_id&customer_passengersid=$parent_id"; // for record update		
} else if (isset($parent_id)) {
	$form_url_parameter = "?customer_passengersid=$parent_id"; // for new record
}
// 'Save' button clicked
if (isset($_POST['save_submit'])) {
	
	$error = 0;
	
	// validation of input data
	$notes = trim($_POST['notes']);
	if (strlen($notes) > 2000) {
		$msg_notes = "<div class='message-error'>Provide a valid value up to length 2000</div>";
		$focus_field = 'notes';
		$error = 1;
	}
	
	$image_url = trim($_POST['image_url']);
	if (strlen($image_url) > 100) {
		$msg_image_url = "<div class='message-error'>Provide a valid value up to length 100</div>";
		$focus_field = 'image_url';
		$error = 1;
	}
	
	$zip_code = trim($_POST['zip_code']);
	if (strlen($zip_code) > 50) {
		$msg_zip_code = "<div class='message-error'>Provide a valid value up to length 50</div>";
		$focus_field = 'zip_code';
		$error = 1;
	}
	
	$state = trim($_POST['state']);
	if (strlen($state) > 100) {
		$msg_state = "<div class='message-error'>Provide a valid value up to length 100</div>";
		$focus_field = 'state';
		$error = 1;
	}
	
	$city = trim($_POST['city']);
	if (strlen($city) > 100) {
		$msg_city = "<div class='message-error'>Provide a valid value up to length 100</div>";
		$focus_field = 'city';
		$error = 1;
	}
	
	$address2 = trim($_POST['address2']);
	if (strlen($address2) > 100) {
		$msg_address2 = "<div class='message-error'>Provide a valid value up to length 100</div>";
		$focus_field = 'address2';
		$error = 1;
	}
	
	$address1 = trim($_POST['address1']);
	if (strlen($address1) > 100) {
		$msg_address1 = "<div class='message-error'>Provide a valid value up to length 100</div>";
		$focus_field = 'address1';
		$error = 1;
	}
	
	$category = trim($_POST['category']);
	if (strlen($category) > 100) {
		$msg_category = "<div class='message-error'>Provide a valid value up to length 100</div>";
		$focus_field = 'category';
		$error = 1;
	}
	
	$title = trim($_POST['title']);
	if (strlen($title) > 100) {
		$msg_title = "<div class='message-error'>Provide a valid value up to length 100</div>";
		$focus_field = 'title';
		$error = 1;
	}
	
	// no validation error
	if ($error == 0) {
		
		
		
		if (isset($record_id) && $error != 1) { // update
			$results = mysqli_query($dbcon, "UPDATE customer_address_book SET 
				title = '" . sd($dbcon, $title) . "', 
				category = '" . sd($dbcon, $category) . "', 
				address1 = '" . sd($dbcon, $address1) . "', 
				address2 = '" . sd($dbcon, $address2) . "', 
				city = '" . sd($dbcon, $city) . "', 
				state = '" . sd($dbcon, $state) . "', 
				zip_code = '" . sd($dbcon, $zip_code) . "', 
				image_url = '" . sd($dbcon, $image_url) . "', 
				notes = '" . sd($dbcon, $notes) . "' WHERE key_customer_address_book = $record_id  AND key_customer_passengers = $parent_id");
			if ($results) {
				$message = "<script>parent.location.reload(false);</script>";
			} else {
				//print mysqli_error($dbcon);
				die('Unable to update, please contact your system administrator.');
			}
			$show_form = false;
		} else if ($error != 1) { // insert
			$results = mysqli_query($dbcon, "INSERT INTO customer_address_book (key_customer_passengers,title,category,address1,address2,city,state,zip_code,image_url,notes) VALUES (
				'" . sd($dbcon, $parent_id) . "',
				'" . sd($dbcon, $title) . "',
				'" . sd($dbcon, $category) . "',
				'" . sd($dbcon, $address1) . "',
				'" . sd($dbcon, $address2) . "',
				'" . sd($dbcon, $city) . "',
				'" . sd($dbcon, $state) . "',
				'" . sd($dbcon, $zip_code) . "',
				'" . sd($dbcon, $image_url) . "',
				'" . sd($dbcon, $notes) . "')");
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
	<title>CUSTOMER ADDRESS BOOK</title>
	<?php include('php/_head.php'); ?>
</head>
<body id='page-save' class='foreign'>

	<?php if (isset($parent_record_label)) print '<h2>' . $parent_record_label . '</h2>'; ?>

	<?php if (isset($message)) print $message; ?>
	
	<main>

	<?php if (isset($show_form) && $show_form) { ?>
	<form method='post' action='customer_address_book_save.php<?php print $form_url_parameter; ?>'>

		<fieldset>

		<div>
		<label for='title'>Title</label><br>
		<?php if(isset($msg_title)) print $msg_title; ?>
		<input <?php if ($focus_field == 'title') print 'autofocus'; ?> id='title' name='title' type='text' value='<?php if (isset($title)) {print $title;}  ?>'><br>
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
		<label for='address1'>Address 1</label><br>
		<?php if(isset($msg_address1)) print $msg_address1; ?>
		<input <?php if ($focus_field == 'address1') print 'autofocus'; ?> id='address1' name='address1' type='text' value='<?php if (isset($address1)) {print $address1;}  ?>'><br>
		</div>
		
		<div>
		<label for='address2'>Address 2</label><br>
		<?php if(isset($msg_address2)) print $msg_address2; ?>
		<input <?php if ($focus_field == 'address2') print 'autofocus'; ?> id='address2' name='address2' type='text' value='<?php if (isset($address2)) {print $address2;}  ?>'><br>
		</div>
		
		<div>
		<label for='city'>City</label><br>
		<?php if(isset($msg_city)) print $msg_city; ?>
		<input <?php if ($focus_field == 'city') print 'autofocus'; ?> id='city' name='city' type='text' value='<?php if (isset($city)) {print $city;}  ?>'><br>
		</div>
		
		<div>
		<label for='state'>State</label><br>
		<?php if(isset($msg_state)) print $msg_state; ?>
		<input id='state' name='state' list='list_state' value='<?php if (isset($state)) {print $state;} ?>'><br>
		<datalist id='list_state'>
		<?php 
		$options = '';
		
		$results = mysqli_query($dbcon, 'SELECT state FROM settings_state_values');
		while ($row = mysqli_fetch_assoc($results)) {
			$options .= "<option value='" . $row['state'] . "'>";
		}
		print $options; 
		?>
		</datalist>
		</div>
		
		<div>
		<label for='zip_code'>Zip code</label><br>
		<?php if(isset($msg_zip_code)) print $msg_zip_code; ?>
		<input <?php if ($focus_field == 'zip_code') print 'autofocus'; ?> id='zip_code' name='zip_code' type='text' value='<?php if (isset($zip_code)) {print $zip_code;}  ?>'><br>
		</div>
		
		</fieldset>
		<fieldset>
		
		<div>
		<label for='image_url'>Image URL</label><br>
		<?php if(isset($msg_image_url)) print $msg_image_url; ?>
		<input <?php if ($focus_field == 'image_url') print 'autofocus'; ?> id='image_url' name='image_url' type='image url' value='<?php if (isset($image_url)) {print $image_url;}  ?>'><br>
		</div>
		
		<div>
		<label for='notes'>Notes</label><br>
		<?php if(isset($msg_notes)) print $msg_notes; ?>
		<textarea <?php if ($focus_field == 'notes') print 'autofocus'; ?> id='notes' name='notes'><?php if (isset($notes)) print $notes; ?></textarea><br>
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

