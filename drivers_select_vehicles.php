<?php 
include('php/_code.php'); 
$run_query = true;
$sql_where = ' LIMIT 20';
if (isset($_GET['search'])) {
	$search = trim($_GET['search']);
	if (empty($search)) {
		$message = "<div class='failure-result'>Provide a search term</div>";
	} else {
		$sql_where = "WHERE MATCH(tag,vin_number,year_made,model,color,notes,vehicle_type,fleet_number) AGAINST('" . cd($dbcon, $search) . "')";
		$run_query = true;
	}
}
if ($run_query) {
	$results = mysqli_query($dbcon, "SELECT key_vehicles, fleet_number, vehicle_type FROM vehicles $sql_where");
	if ($results) {
		$table_rows = '';
		while ($row = mysqli_fetch_assoc($results)) {
			$table_rows .= "
			<tr>
			<td>" . $row['fleet_number'] . "</td>
			<td>" . $row['vehicle_type'] . "</td>
			<td class='record-icons'>
			<a href='#' onclick='
				parent.document.getElementById(\"fleet_number\").value = \"" . $row['vehicle_type'] . " (" . $row['fleet_number'] . ")\";
				parent.document.getElementById(\"key_vehicles\").value = \"" . $row['key_vehicles'] . "\";
				closeOverlay2(\"fromiframe\");'>Select</a> &nbsp; 
			<a href='vehicles_view.php?vehiclesid=" . $row['key_vehicles'] . "' target='overlay-iframe3' onclick='overlayOpen3();'>View</a> 
			</td>
			</tr>
			";
		}
		$listing_html = "
			<table>
				$table_rows
			</table>";
		if (mysqli_num_rows($results) == 0) {
			$message = "<div class='failure-result'>No record found</div>";
		}
	} else {
		print mysqli_error($dbcon);
		die('Unable to get records, please contact your system administrator.');
	}
}
?>
<!DOCTYPE html>
<html>
<head>
	<title>VEHICLES</title>
	<?php include('php/_head.php'); ?>
</head>
<body id='page-select' onload="document.getElementById('search').focus();">
	
	<section id='sub-menu'>
		<h3>VEHICLES</h3>
	</section>

	<?php if (isset($message)) print $message; ?>

	<main>
		<section id='search-forms'>
			<form method='get'>
				<input id='search' name='search' type='text' autofocus required> 
				<input type='submit' value='Search'> &nbsp; <a href='vehicles_save.php' target='overlay-iframe3' onclick='overlayOpen3();'>Add new</a>
			</form>
		</section>
		<?php 
		if (isset($listing_html)) print $listing_html;
		?>
		
	</main>
	<?php include('php/_footer.php'); ?>
</body>
</html>

