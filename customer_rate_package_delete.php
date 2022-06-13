<?php 
include('php/_code.php');
$show_record = true;
if (isset($_GET['customer_rate_packagesid'])) {
	$record_id = trim($_GET['customer_rate_packagesid']);
	if (!is_numeric($record_id)) die('Invalid record id.');
	if (isset($_GET['delete'])) {
		$results = mysqli_query($dbcon, "DELETE FROM customer_rate_packages WHERE key_customer_rate_packages = $record_id");
		if ($results) {
			$message = "<div class='success-result'>Deleted successfully</div>
			<div class='center'><br><br><input type='button' value='Close' onclick='parent.location.reload(false);'></div>";
			$show_record = false;
			
		} else {
			$message = "<div class='failure-result'>Could not delete record</div>";
		}
	} else {
		$results = mysqli_query($dbcon, "SELECT * FROM customer_rate_packages WHERE key_customer_rate_packages = $record_id");
		if ($row = mysqli_fetch_assoc($results)) {
			$package_name = $row['package_name'];
			$gratuity_percent = $row['gratuity_percent'];
			$gas_surcharge_percent = $row['gas_surcharge_percent'];
			$admin_fee_percent = $row['admin_fee_percent'];
			$discount_percent = $row['discount_percent'];
		} else {
			$message = "<div class='failure-result'>Record not found</div>";
		}
	}
}
?>


<!DOCTYPE html>
<html>
<head>
 <title>CUSTOMER RATE PACKAGES</title>
 <?php include('php/_head.php'); ?>
</head>
<body id='page-delete' class='page_delete page_customer_rate_packages_delete'>

 <?php if (isset($message)) print $message; ?>

 <?php if ($show_record) { ?>

 <main>

     <div class='center'>
         <p class='red'><b>Do you really want to delete this record?</b></p>
         <p>
             <br>
             <a class='button-big' href='<?php print $_SERVER['REQUEST_URI']; ?>&delete=1'>Delete</a> &nbsp 
             <a class='button-big' href='#' onclick='parent.location.reload(false);'>Cancel</a><br>
         </p>
         <br><hr><br>
     </div>

     <table class='record-table'>
         <tr>
         <td class='label-cell'>Package name</td>
         <td class='value-cell'><?php if (isset($package_name)) print $package_name; ?></td>
         </tr>

         <tr>
         <td class='label-cell'>Gratuity %</td>
         <td class='value-cell'><?php if (isset($gratuity_percent)) print $gratuity_percent; ?></td>
         </tr>

         <tr>
         <td class='label-cell'>Gas surcharge %</td>
         <td class='value-cell'><?php if (isset($gas_surcharge_percent)) print $gas_surcharge_percent; ?></td>
         </tr>

         <tr>
         <td class='label-cell'>Admin fee %</td>
         <td class='value-cell'><?php if (isset($admin_fee_percent)) print $admin_fee_percent; ?></td>
         </tr>

         <tr>
         <td class='label-cell'>Discount %</td>
         <td class='value-cell'><?php if (isset($discount_percent)) print $discount_percent; ?></td>
         </tr>

     </table>

 </main>

 <?php } // show_record ?>


 <?php include('php/_footer.php'); ?>
</body>
</html>
