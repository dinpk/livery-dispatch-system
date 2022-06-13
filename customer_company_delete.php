<?php 
include('php/_code.php');
$show_record = true;
if (isset($_GET['customer_companiesid'])) {
	$record_id = trim($_GET['customer_companiesid']);
	if (!is_numeric($record_id)) die('Invalid record id.');
	if (isset($_GET['delete'])) {
		$results = mysqli_query($dbcon, "DELETE FROM customer_companies WHERE key_customer_companies = $record_id");
		if ($results) {
			$message = "<div class='success-result'>Deleted successfully</div>
			<div class='center'><br><br><input type='button' value='Close' onclick='parent.location.reload(false);'></div>";
			$show_record = false;
		} else {
			$message = "<div class='failure-result'>Could not delete record</div>";
		}
	} else {
		$results = mysqli_query($dbcon, "SELECT * FROM customer_companies WHERE key_customer_companies = $record_id");
		if ($row = mysqli_fetch_assoc($results)) {
			$company_name = $row['company_name'];
			$image_url = $row['image_url'];
			$address1 = $row['address1'];
			$address2 = $row['address2'];
			$city = $row['city'];
			$state = $row['state'];
			$zip_code = $row['zip_code'];
			$country = $row['country'];
			$active_status = $row['active_status'];
		} else {
			$message = "<div class='failure-result'>Record not found</div>";
		}
	}
}
?>
<!DOCTYPE html>
<html>
<head>
 <title>CUSTOMER COMPANIES</title>
 <?php include('php/_head.php'); ?>
</head>
<body id='page-delete' class='page_delete page_customer_companies_delete'>

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
         <td class='label-cell'>Company name</td>
         <td class='value-cell'><?php if (isset($company_name)) print $company_name; ?></td>
         </tr>

         <tr>
         <td class='label-cell'>Image url</td>
         <td class='value-cell'><?php if (isset($image_url)) print $image_url; ?></td>
         </tr>

         <tr>
         <td class='label-cell'>Address 1</td>
         <td class='value-cell'><?php if (isset($address1)) print $address1; ?></td>
         </tr>

         <tr>
         <td class='label-cell'>Address 2</td>
         <td class='value-cell'><?php if (isset($address2)) print $address2; ?></td>
         </tr>

         <tr>
         <td class='label-cell'>City</td>
         <td class='value-cell'><?php if (isset($city)) print $city; ?></td>
         </tr>

         <tr>
         <td class='label-cell'>State</td>
         <td class='value-cell'><?php if (isset($state)) print $state; ?></td>
         </tr>

         <tr>
         <td class='label-cell'>Zip code</td>
         <td class='value-cell'><?php if (isset($zip_code)) print $zip_code; ?></td>
         </tr>

         <tr>
         <td class='label-cell'>Country</td>
         <td class='value-cell'><?php if (isset($country)) print $country; ?></td>
         </tr>

         <tr>
         <td class='label-cell'>Status</td>
         <td class='value-cell'><?php if (isset($active_status)) print $active_status; ?></td>
         </tr>

     </table>

 </main>

 <?php } // show_record ?>


 <?php include('php/_footer.php'); ?>
</body>
</html>
