<?php 
include('php/_code.php');
$show_form = true;
$focus_field = 'sender_email';
// id passed for update
if (isset($_GET['settings_email_configurationid'])) {
	$record_id = trim($_GET['settings_email_configurationid']);
	if (!is_numeric($record_id)) exit;
	if (!isset($_POST['save_submit'])) {
		$results = mysqli_query($dbcon, "SELECT * FROM settings_email_configuration WHERE key_settings_email_configuration = $record_id");
		if ($row = mysqli_fetch_assoc($results)) {
			$sender_email = $row['sender_email'];
			$sender_password = $row['sender_password'];
			$reply_to_email = $row['reply_to_email'];
			$copy_to_email = $row['copy_to_email'];
			$smtp_address = $row['smtp_address'];
		} else {
			$message = "<div class='failure-result'>Record not found</div>";
			$show_form = false;
		}
	}
}
// 'Save' button clicked
if (isset($_POST['save_submit'])) {
	$error = 0;
	$smtp_address = trim($_POST['smtp_address']);
	if (strlen($smtp_address) > 100) {
		$msg_smtp_address = "<div class='message-error'>Provide a valid value of length 0-100</div>";
		$focus_field = 'smtp_address';
		$error = 1;
	}
	$copy_to_email = trim($_POST['copy_to_email']);
	if (strlen($copy_to_email) > 100) {
		$msg_copy_to_email = "<div class='message-error'>Provide a valid value of length 0-100</div>";
		$focus_field = 'copy_to_email';
		$error = 1;
	}
	$reply_to_email = trim($_POST['reply_to_email']);
	if (strlen($reply_to_email) > 100) {
		$msg_reply_to_email = "<div class='message-error'>Provide a valid value of length 0-100</div>";
		$focus_field = 'reply_to_email';
		$error = 1;
	}
	$sender_password = trim($_POST['sender_password']);
	if (strlen($sender_password) > 100) {
		$msg_sender_password = "<div class='message-error'>Provide a valid value of length 0-100</div>";
		$focus_field = 'sender_password';
		$error = 1;
	}
	$sender_email = trim($_POST['sender_email']);
	if (strlen($sender_email) > 100) {
		$msg_sender_email = "<div class='message-error'>Provide a valid value of length 0-100</div>";
		$focus_field = 'sender_email';
		$error = 1;
	}
	// no validation error
	if ($error == 0) {
		if (isset($record_id) && $error != 1) { // update
			$results = mysqli_query($dbcon, "UPDATE settings_email_configuration SET 
			sender_email = '" . sd($dbcon, $sender_email) . "',
			sender_password = '" . sd($dbcon, $sender_password) . "',
			reply_to_email = '" . sd($dbcon, $reply_to_email) . "',
			copy_to_email = '" . sd($dbcon, $copy_to_email) . "',
			smtp_address = '" . sd($dbcon, $smtp_address) . "'
				WHERE key_settings_email_configuration = $record_id");
			if ($results) {
				$message = "<script>parent.location.reload(false);</script>";
			} else {
				//print mysqli_error($dbcon);
				die('Unable to update, please contact your system administrator.');
			}
		} else if ($error != 1) { // insert
			$results = mysqli_query($dbcon, "INSERT INTO settings_email_configuration (
			sender_email,
			sender_password,
			reply_to_email,
			copy_to_email,
			smtp_address
			) 
			VALUES (
			'" . sd($dbcon, $sender_email) . "',
			'" . sd($dbcon, $sender_password) . "',
			'" . sd($dbcon, $reply_to_email) . "',
			'" . sd($dbcon, $copy_to_email) . "',
			'" . sd($dbcon, $smtp_address) . "'
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
		}	
	}
	if ($error == 0) $show_form = false;
}
?>
<!DOCTYPE html>
<html>
<head>
	<title>SETTINGS - EMAIL CONFIGURATION</title>
	<?php include('php/_head.php'); ?>
</head>
<body id='page-save' class='page_save page_settings_email_configuration_save'>

	<section id='sub-menu'>
		<div class='left-block'><img src="images/icons/set_email_configuration.png"> settings - email configuration</div>
		<div class='right-block'> </div>
	</section>

	<?php if (isset($message)) print $message; ?>
	
	<main>

	<?php if (isset($show_form) && $show_form) { ?>
	<form method='post'>
		<fieldset>


         <div>
             <label for='sender_email'>Sender email</label>
			 <?php if(isset($msg_sender_email)) print $msg_sender_email; ?>
             <input id='sender_email' name='sender_email' type='email' value='<?php if (isset($sender_email)) {print $sender_email;} else { print '';} ?>'><br>
         </div>

         <div>
             <label for='sender_password'>Sender password</label>
			 <?php if(isset($msg_sender_password)) print $msg_sender_password; ?>
             <input id='sender_password' name='sender_password' type='password' value='<?php if (isset($sender_password)) {print $sender_password;} else { print '';} ?>'><br>
         </div>

         <div>
             <label for='reply_to_email'>Reply to email</label>
			 <?php if(isset($msg_reply_to_email)) print $msg_reply_to_email; ?>
             <input id='reply_to_email' name='reply_to_email' type='email' value='<?php if (isset($reply_to_email)) {print $reply_to_email;} else { print '';} ?>'><br>
         </div>

         <div>
             <label for='copy_to_email'>Copy to email</label>
			 <?php if(isset($msg_copy_to_email)) print $msg_copy_to_email; ?>
             <input id='copy_to_email' name='copy_to_email' type='email' value='<?php if (isset($copy_to_email)) {print $copy_to_email;} else { print '';} ?>'><br>
         </div>

         <div>
             <label for='smtp_address'>Smtp</label>
			 <?php if(isset($msg_smtp_address)) print $msg_smtp_address; ?>
             <input id='smtp_address' name='smtp_address' type='text' value='<?php if (isset($smtp_address)) {print $smtp_address;} else { print '';} ?>'><br>
         </div>

		</fieldset>
		
		<input id='save_submit' name='save_submit' type='submit' value='Save'>
		
		
	</form>
	<?php } ?>

	</main>
	<?php include('php/_footer.php'); ?>

</body>
</html>
