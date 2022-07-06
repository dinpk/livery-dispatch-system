<?php 
include('php/_code.php'); 
$run_query = true;
$sql_where = " LIMIT 20";
if (isset($_GET['search'])) {
	$search = trim($_GET['search']);
	if (empty($search)) {
		$message = "<div class='failure-result'>Provide a search term</div>";
	} else {
		$sql_where = "WHERE MATCH(contract_type,first_name,last_name,city,state,zip_code,fleet_number) AGAINST('" . cd($dbcon, $search) . "')";
		$run_query = true;
	}
}
if ($run_query) {
	$results = mysqli_query($dbcon, "SELECT key_drivers, first_name, last_name, fleet_number, key_vehicles FROM drivers $sql_where");
	if ($results) {
		$table_rows = '';
		while ($row = mysqli_fetch_assoc($results)) {
			$table_rows .= "
			<tr>
			<td>" . $row['first_name'] . " " . $row['last_name'] . "</td>
			<td class='record-icons'>
			<a href='#' onclick='
				parent.document.getElementById(\"driver_name\").value = \"" . $row['first_name'] . " " . $row['last_name'] . "\";
				parent.document.getElementById(\"key_drivers\").value = \"" . $row['key_drivers'] . "\";
				parent.document.getElementById(\"vehicle\").value = \"" . $row['fleet_number'] . "\";
				parent.document.getElementById(\"key_vehicles\").value = \"" . $row['key_vehicles'] . "\";
				closeOverlay2(\"fromiframe\");'>Select</a> &nbsp; 
			<a href='driver_view.php?driverid=" . $row['key_drivers'] . "' target='overlay-iframe3' onclick='overlayOpen3();'>View</a> 
			</td>
			</tr>
			";
		}
		$listing_html = "
		<table>
			$table_rows
		</table>
		";
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
    <title>TRIP - DRIVER</title>
    <?php include('php/_head.php'); ?>
</head>
<body id='page-select' onload="document.getElementById('search').focus();">
    <section id='sub-menu'>
        <h3>SELECT DRIVER</h3>
    </section>
    <?php if (isset($message)) print $message; ?>
    <main>
        <section id='search-forms'>
            <form method='get'>
                <input id='search' name='search' type='text' autofocus required>
                <input type='submit' value='Search'> &nbsp; 
				<a href='driver_save.php' target='overlay-iframe3' onclick='overlayOpen3();'>Add new</a>
            </form>
        </section>
        <?php 
		if (isset($listing_html)) print $listing_html;
			if (isset($pager)) print $pager;
		?>
    </main>
    <?php include('php/_footer.php'); ?>
</body>
</html>