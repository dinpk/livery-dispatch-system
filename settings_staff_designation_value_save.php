<?php 

include('php/_code.php');

$show_form = true;
$focus_field = 'designation';
	
// id passed for update
if (isset($_GET['settings_staff_designation_valuesid'])) {
	
 $record_id = trim($_GET['settings_staff_designation_valuesid']);

 if (!is_numeric($record_id)) exit;

 if (!isset($_POST['save_submit'])) {

     $dbcon = db_connection();
     $results = mysqli_query($dbcon, "SELECT * FROM `settings_staff_designation_values` WHERE `key_settings_staff_designation_values` = $record_id");

     if ($row = mysqli_fetch_assoc($results)) {
			$designation = $row['designation'];

     } else {

         $message = "<div class='failure-result'>Record not found</div>";
         $show_form = false;

     }
		
     mysqli_close($dbcon);
 }
}

// 'Save' button clicked
if (isset($_POST['save_submit'])) {
	
     $error = 0;

		$designation = (isset($_POST['designation']) ? trim($_POST['designation']) : '');
		if (strlen($designation) < 3 || strlen($designation) > 50) {
			$msg_designation = "<div class='message-error'>Provide a valid value of length 3-50</div>";
			$focus_field = 'designation';
			$error = 1;
		}

 // no validation error
 if ($error == 0) {

     $dbcon = db_connection();

     if (isset($record_id) && $error != 1) { // update

         $results = mysqli_query($dbcon, "UPDATE `settings_staff_designation_values` SET 
               `designation` = '" . sd($dbcon, $designation) . "'
                WHERE `key_settings_staff_designation_values` = $record_id");

         if ($results) {
             $message = "<script>parent.location.reload(false);</script>";
         } else {
             //print mysqli_error($dbcon);
             die('Unable to update, please contact your system administrator.');
         }


     } else if ($error != 1) { // insert

         $results = mysqli_query($dbcon, "INSERT INTO `settings_staff_designation_values` (
               `designation`
             ) 
             VALUES (
             '" . sd($dbcon, $designation) . "'
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

     mysqli_close($dbcon);

 }

 if ($error == 0) $show_form = false;

}
?>


<!DOCTYPE html>
<html>
<head>
	<title>SETTINGS - STAFF DESIGNATION</title>
	<?php include('php/_head.php'); ?>
</head>
<body id='page-save' class='page_save page_settings_staff_designation_values_save'>

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
             <label for='designation'>Designation</label> <span class='red'> *</span>
             <?php if(isset($msg_designation)) print $msg_designation; ?>
             <input id='designation' name='designation' type='text' value='<?php if (isset($designation)) {print $designation;} else { print '';} ?>' required><br>
         </div>

		</fieldset>
		
		<input id='save_submit' name='save_submit' type='submit' value='Save'>
		
		
	</form>
	<?php } ?>

	</main>
	<?php include('php/_footer.php'); ?>

</body>
</html>
