<?php 
include('php/_code.php');
$show_form = true;
$focus_field = 'package_name';
// id passed for update
if (isset($_GET['customer_rate_packagesid'])) {
	$record_id = trim($_GET['customer_rate_packagesid']);
	if (!is_numeric($record_id)) exit;
	if (!isset($_POST['save_submit'])) {
		$results = mysqli_query($dbcon, "SELECT * FROM customer_rate_packages WHERE key_customer_rate_packages = $record_id");
		if ($row = mysqli_fetch_assoc($results)) {
			$package_name = $row['package_name'];
			$gratuity_percent = $row['gratuity_percent'];
			$gas_surcharge_percent = $row['gas_surcharge_percent'];
			$admin_fee_percent = $row['admin_fee_percent'];
			$discount_percent = $row['discount_percent'];
		} else {
			$message = "<div class='failure-result'>Record not found</div>";
			$show_form = false;
		}
	}
}
// 'Save' button clicked
if (isset($_POST['save_submit'])) {
	$error = 0;
	$discount_percent = trim($_POST['discount_percent']);
	if (strlen($discount_percent) < 0 || strlen($discount_percent) > 5 || !is_numeric($discount_percent)) {
		$msg_discount_percent = "<div class='message-error'>Provide a valid value of length 0-5</div>";
		$focus_field = 'discount_percent';
		$error = 1;
	}
	$admin_fee_percent = trim($_POST['admin_fee_percent']);
	if (strlen($admin_fee_percent) < 0 || strlen($admin_fee_percent) > 5 || !is_numeric($admin_fee_percent)) {
		$msg_admin_fee_percent = "<div class='message-error'>Provide a valid value of length 0-5</div>";
		$focus_field = 'admin_fee_percent';
		$error = 1;
	}
	$gas_surcharge_percent = trim($_POST['gas_surcharge_percent']);
	if (strlen($gas_surcharge_percent) < 0 || strlen($gas_surcharge_percent) > 5 || !is_numeric($gas_surcharge_percent)) {
		$msg_gas_surcharge_percent = "<div class='message-error'>Provide a valid value of length 0-5</div>";
		$focus_field = 'gas_surcharge_percent';
		$error = 1;
	}
	$gratuity_percent = trim($_POST['gratuity_percent']);
	if (strlen($gratuity_percent) < 0 || strlen($gratuity_percent) > 5 || !is_numeric($gratuity_percent)) {
		$msg_gratuity_percent = "<div class='message-error'>Provide a valid value of length 0-5</div>";
		$focus_field = 'gratuity_percent';
		$error = 1;
	}
	$package_name = (isset($_POST['package_name']) ? trim($_POST['package_name']) : '');
	if (strlen($package_name) < 3 || strlen($package_name) > 50) {
		$msg_package_name = "<div class='message-error'>Provide a valid value of length 3-50</div>";
		$focus_field = 'package_name';
		$error = 1;
	}
	// no validation error
	if ($error == 0) {
		if (isset($record_id) && $error != 1) { // update
			$results = mysqli_query($dbcon, "UPDATE customer_rate_packages SET 
			package_name = '" . sd($dbcon, $package_name) . "',
			gratuity_percent = '" . sd($dbcon, $gratuity_percent) . "',
			gas_surcharge_percent = '" . sd($dbcon, $gas_surcharge_percent) . "',
			admin_fee_percent = '" . sd($dbcon, $admin_fee_percent) . "',
			discount_percent = '" . sd($dbcon, $discount_percent) . "'
				WHERE key_customer_rate_packages = $record_id");
			if ($results) {
				$message = "<script>parent.location.reload(false);</script>";
			} else {
				//print mysqli_error($dbcon);
				die('Unable to update, please contact your system administrator.');
			}
		} else if ($error != 1) { // insert
			$results = mysqli_query($dbcon, "INSERT INTO customer_rate_packages (
			package_name,
			gratuity_percent,
			gas_surcharge_percent,
			admin_fee_percent,
			discount_percent
			) 
			VALUES (
			'" . sd($dbcon, $package_name) . "',
			'" . sd($dbcon, $gratuity_percent) . "',
			'" . sd($dbcon, $gas_surcharge_percent) . "',
			'" . sd($dbcon, $admin_fee_percent) . "',
			'" . sd($dbcon, $discount_percent) . "'
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
	<title>CUSTOMER RATE PACKAGE</title>
	<?php include('php/_head.php'); ?>
</head>
<body id='page-save' class='page_save page_customer_rate_packages_save'>

	<section id='sub-menu'>
		<div class='left-block'>customer rate package</div>
		<div class='right-block'>

		</div>
	</section>

	<?php if (isset($message)) print $message; ?>
	
	<main>

	<?php if (isset($show_form) && $show_form) { ?>
	<form method='post'>
		<fieldset>

         <div>
             <label for='package_name'>Package name</label> <span class='red'> *</span>             <?php if(isset($msg_package_name)) print $msg_package_name; ?>
             <input <?php if ($focus_field == 'package_name') print 'autofocus'; ?> id='package_name' name='package_name' type='text' value='<?php if (isset($package_name)) {print $package_name;} else { print '';} ?>' required><br>
         </div>

         <div>
             <label for='gratuity_percent'>Gratuity %</label>             <?php if(isset($msg_gratuity_percent)) print $msg_gratuity_percent; ?>
             <input <?php if ($focus_field == 'gratuity_percent') print 'autofocus'; ?> id='gratuity_percent' name='gratuity_percent' type='number' step='0.10' value='<?php if (isset($gratuity_percent)) {print $gratuity_percent;} else { print '0';} ?>'><br>
         </div>

         <div>
             <label for='gas_surcharge_percent'>Gas surcharge %</label>             <?php if(isset($msg_gas_surcharge_percent)) print $msg_gas_surcharge_percent; ?>
             <input <?php if ($focus_field == 'gas_surcharge_percent') print 'autofocus'; ?> id='gas_surcharge_percent' name='gas_surcharge_percent' type='number' step='0.10' value='<?php if (isset($gas_surcharge_percent)) {print $gas_surcharge_percent;} else { print '0';} ?>'><br>
         </div>

         <div>
             <label for='admin_fee_percent'>Admin fee %</label>             <?php if(isset($msg_admin_fee_percent)) print $msg_admin_fee_percent; ?>
             <input <?php if ($focus_field == 'admin_fee_percent') print 'autofocus'; ?> id='admin_fee_percent' name='admin_fee_percent' type='number' step='0.10' value='<?php if (isset($admin_fee_percent)) {print $admin_fee_percent;} else { print '0';} ?>'><br>
         </div>

         <div>
             <label for='discount_percent'>Discount %</label>             <?php if(isset($msg_discount_percent)) print $msg_discount_percent; ?>
             <input <?php if ($focus_field == 'discount_percent') print 'autofocus'; ?> id='discount_percent' name='discount_percent' type='number' step='0.10' value='<?php if (isset($discount_percent)) {print $discount_percent;} else { print '0';} ?>'><br>
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
