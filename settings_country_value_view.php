<?php 
include('php/_code.php');
if (isset($_GET['settings_country_valuesid'])) {
	$record_id = trim($_GET['settings_country_valuesid']);
	if (!is_numeric($record_id)) die('Invalid record id.');
	$results = mysqli_query($dbcon, "SELECT * FROM settings_country_values WHERE key_settings_country_values = $record_id");
	if ($row = mysqli_fetch_assoc($results)) {
		$country = $row['country'];
		$country_code = $row['country_code'];
	} else {
		$message = "<div class='failure-result'>Record not found</div>";
	}
}
?>
<!DOCTYPE html>
<html>
<head>
	<title>SETTINGS COUNTRY VALUES</title>
	<?php include('php/_head.php'); ?>
</head>
<body id='page-view' class='page_view page_settings_country_values_view'>

	<?php if (isset($message)) print $message; ?>
	
	<main>
		
     <table class='record-table'>
         <tr>
         <td class='label-cell'>Country</td>
         <td class='value-cell'><?php if (isset($country)) print $country; ?></td>
         </tr>

         <tr>
         <td class='label-cell'>Country code</td>
         <td class='value-cell'><?php if (isset($country_code)) print $country_code; ?></td>
         </tr>

     </table>

	</main>
	<?php include('php/_footer.php'); ?>
</body>
</html>
