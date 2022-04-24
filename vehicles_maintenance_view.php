<?php 
include('php/_code.php');
if (isset($_GET['vehicles_maintenanceid'])) {
	$record_id = trim($_GET['vehicles_maintenanceid']);
	if (!is_numeric($record_id)) die('Invalid record id.');
	$results = mysqli_query($dbcon, "SELECT * FROM vehicles_maintenance WHERE key_vehicles_maintenance = $record_id");
	if ($row = mysqli_fetch_assoc($results)) {
		$repair_date = $row['repair_date'];
		$repair_description = $row['repair_description'];
		$workshop_name = $row['workshop_name'];
		$labor_cost = $row['labor_cost'];
		$parts_cost = $row['parts_cost'];
		$warranty_description = $row['warranty_description'];
		$warranty_expiration = $row['warranty_expiration'];
	} else {
		$message = "<div class='failure-result'>Record not found</div>";
	}
}
?>
<!DOCTYPE html>
<html>
<head>
	<title>VEHICLES MAINTENANCE</title>
	<?php include('php/_head.php'); ?>
</head>
<body id='page-view' class='foreign'>

	<?php if (isset($message)) print $message; ?>
	
	<main>
		
	
	<table class='record-table'>
		
		
		<tr>
			<td class='label-cell'>REPAIR DATE</td>
			<td class='value-cell'><?php if (isset($repair_date)) print $repair_date; ?></td>
		</tr>

		
		<tr>
			<td class='label-cell'>REPAIR DESCRIPTION</td>
			<td class='value-cell'><?php if (isset($repair_description)) print $repair_description; ?></td>
		</tr>

		
		<tr>
			<td class='label-cell'>WORKSHOP NAME</td>
			<td class='value-cell'><?php if (isset($workshop_name)) print $workshop_name; ?></td>
		</tr>

		
		<tr>
			<td class='label-cell'>LABOR COST</td>
			<td class='value-cell'><?php if (isset($labor_cost)) print $labor_cost; ?></td>
		</tr>

		
		<tr>
			<td class='label-cell'>PARTS COST</td>
			<td class='value-cell'><?php if (isset($parts_cost)) print $parts_cost; ?></td>
		</tr>

		
		<tr>
			<td class='label-cell'>WARRANTY DESCRIPTION</td>
			<td class='value-cell'><?php if (isset($warranty_description)) print $warranty_description; ?></td>
		</tr>

		
		<tr>
			<td class='label-cell'>WARRANTY EXPIRATION</td>
			<td class='value-cell'><?php if (isset($warranty_expiration)) print $warranty_expiration; ?></td>
		</tr>

		
	</table>
	

	</main>
	<?php include('php/_footer.php'); ?>
</body>
</html>

