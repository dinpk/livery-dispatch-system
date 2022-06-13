<?php 
include('php/_code.php');
if (isset($_GET['customer_rate_packagesid'])) {
	$record_id = trim($_GET['customer_rate_packagesid']);
	if (!is_numeric($record_id)) die('Invalid record id.');
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
?>
<!DOCTYPE html>
<html>
<head>
	<title>CUSTOMER RATE PACKAGES</title>
	<?php include('php/_head.php'); ?>
</head>
<body id='page-view' class='page_view page_customer_rate_packages_view'>

	<?php if (isset($message)) print $message; ?>
	
	<main>
		
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
	<?php include('php/_footer.php'); ?>
</body>
</html>
