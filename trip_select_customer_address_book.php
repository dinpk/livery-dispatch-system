<?php 
include('php/_code.php'); 
if (isset($_GET['recordid']) && is_numeric($_GET['recordid'])) {
	$record_id = $_GET['recordid'];
} else {
	die("Select a passenger first.");
}
$run_query = true;
$sql_where = ' LIMIT 20';
if (isset($_POST['search'])) {
	$search = trim($_POST['search']);
	if (empty($search)) {
		$message = "<div class='failure-result'>Provide a search term</div>";
	} else {
		$sql_where = "WHERE MATCH(title, category, city, zip_code) AGAINST('" . cd($dbcon, $search) . "') AND key_customer_passengers = $record_id";
		$run_query = true;
	}
}
if ($run_query) {
	$results = mysqli_query($dbcon, "SELECT title, address1, address2, city, state, zip_code FROM customer_address_book $sql_where");
	if ($results) {
		$table_rows = '';
		while ($row = mysqli_fetch_assoc($results)) {
			$table_rows .= "
			<tr>
			<td>" . $row['title'] . "</td>
			<td>" . $row['category'] . "</td>
			<td>" . $row['city'] . "</td>
			<td>" . $row['state'] . "</td>
			<td>" . $row['zip_code'] . "</td>
			<td class='record-icons'>
				<a href='#' onclick='
					parent.document.getElementById(\"routing_from\").value = parent.document.getElementById(\"routing_to\").value + \"\\n\" + \"" . $row['title'] . " (" . $row['address1'] . ", " . $row['address2'] . ", " . $row['city'] . ", " . $row['state'] . " " . $row['zip_code'] . "\";
					closeOverlay2(\"fromiframe\");'>From</a>&nbsp;&nbsp;&nbsp;
				<a href='#' onclick='parent.document.getElementById(\"routing_to\").value = parent.document.getElementById(\"routing_to\").value + \"\\n\" + \"" . $row['title'] . " (" . $row['address1'] . ", " . $row['address2'] . ", " . $row['city'] . ", " . $row['state'] . " " . $row['zip_code'] . "\";
					closeOverlay2(\"fromiframe\");'>To</a></td>
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
    <title>TRIP - CUSTOMER ADDRESS</title>
    <?php include('php/_head.php'); ?>
</head>
<body id='page-select' onload="document.getElementById('search').focus();">
    <section id='sub-menu'>
        <h3>SELECT CUSTOMER ADDRESS</h3>
    </section>
    <?php if (isset($message)) print $message; ?>
    <main>
        <section id='search-forms'>
            <form method='post'>
                <input id='search' name='search' type='text' autofocus required>
                <input type='submit' value='Search'> &nbsp; 
				<a href='customer_passenger_save.php' target='overlay-iframe3' onclick='overlayOpen3();'>Add new</a>
            </form>
        </section>
        <?php 
		if (isset($listing_html)) print $listing_html;
		?>
    </main>
    <?php include('php/_footer.php'); ?>
</body>
</html>
