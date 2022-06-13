<?php 
include('php/_code.php');
if (isset($_GET['settings_insurance_company_valuesid'])) {
	$record_id = trim($_GET['settings_insurance_company_valuesid']);
	if (!is_numeric($record_id)) die('Invalid record id.');
	$results = mysqli_query($dbcon, "SELECT * FROM settings_insurance_company_values WHERE key_settings_insurance_company_values = $record_id");
	if ($row = mysqli_fetch_assoc($results)) {
		$insurance_company = $row['insurance_company'];
	} else {
		$message = "<div class='failure-result'>Record not found</div>";
	}
}
?>
<!DOCTYPE html>
<html>
<head>
	<title>SETTINGS INSURANCE COMPANY VALUES</title>
	<?php include('php/_head.php'); ?>
</head>
<body id='page-view' class='page_view page_settings_insurance_company_values_view'>

	<?php if (isset($message)) print $message; ?>
	
	<main>
		
     <table class='record-table'>
         <tr>
         <td class='label-cell'>Insurance company</td>
         <td class='value-cell'><?php if (isset($insurance_company)) print $insurance_company; ?></td>
         </tr>

     </table>

	</main>
	<?php include('php/_footer.php'); ?>
</body>
</html>
