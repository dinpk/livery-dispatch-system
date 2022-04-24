<?php 
include('php/_code.php');
if (isset($_GET['trip_extra_chargesid'])) {
	$record_id = trim($_GET['trip_extra_chargesid']);
	if (!is_numeric($record_id)) die('Invalid record id.');
	$results = mysqli_query($dbcon, "SELECT * FROM trip_extra_charges WHERE key_trip_extra_charges = $record_id");
	if ($row = mysqli_fetch_assoc($results)) {
		$category = $row['category'];
		$amount = $row['amount'];
		$notes = $row['notes'];
	} else {
		$message = "<div class='failure-result'>Record not found</div>";
	}
}
?>

<!DOCTYPE html>
<html>
<head>
	<title>TRIP EXTRA CHARGES</title>
	<?php include('php/_head.php'); ?>
</head>
<body id='page-view' class='foreign'>

	<?php if (isset($message)) print $message; ?>
	
	<main>
		
	
	<table class='record-table'>
		
		<tr>
			<td class='label-cell'>CATEGORY</td>
			<td class='value-cell'><?php if (isset($category)) print $category; ?></td>
		</tr>

		
		<tr>
			<td class='label-cell'>AMOUNT</td>
			<td class='value-cell'><?php if (isset($amount)) print $amount; ?></td>
		</tr>

		
		
		<tr>
			<td class='label-cell'>NOTES</td>
			<td class='value-cell'><?php if (isset($notes)) print $notes; ?></td>
		</tr>

		
	</table>
	

	</main>
	<?php include('php/_footer.php'); ?>
</body>
</html>

