<?php 
include('php/_code.php'); 
$run_query = false;
$sql_where = '';
if (isset($_GET['search'])) {

	$search_from = trim($_GET['search_from']);
	$search_to = trim($_GET['search_to']);
	$from_sql = '';
	$to_sql = '';
	if (!empty($search_from)) {
		$from_sql = "from_city = '" . cd($dbcon, $search_from) . "'";
	}
	if (!empty($search_to)) {
		$to_sql = " AND to_city = '" . cd($dbcon, $search_to) . "'";
	}
	if (!empty($search_from)) {
		$sql_where = "WHERE $from_sql $to_sql";
		$run_query = true;
	}
}
if ($run_query) {
	$results = mysqli_query($dbcon, "SELECT key_rates_zones, from_city, from_state, to_city, to_state, tolls, rate FROM rates_zones $sql_where");
	if ($results) {
		$table_rows = '';
		while ($row = mysqli_fetch_assoc($results)) {
			$table_rows .= "
			<tr>
			<td>" . $row['from_city'] . ", " . $row['from_state']  . " <i>to</i> " . $row['to_city'] . ", " . $row['to_state'] . "</td>
			<td class='record-icons'>
				<a href='#' onclick='
					parent.document.getElementById(\"zone_from\").value = \"" . $row['from_city'] . ", " . $row['from_state'] . "\";
					parent.document.getElementById(\"zone_to\").value = \"" . $row['to_city'] . ", " . $row['to_state'] . "\";
					parent.document.getElementById(\"key_rates_zones\").value = \"" . $row['key_rates_zones']  . "\";
					parent.document.getElementById(\"tolls_amount\").value = \"" . $row['tolls']  . "\";
					parent.document.getElementById(\"zone_rate\").value = \"" . $row['rate']  . "\";
					parent.calculateTripRate();
					closeOverlay2(\"fromiframe\");'>Select</a> &nbsp; 
				<a href='rate_zone_view.php?ratezoneid=" . $row['key_rates_zones'] . "' target='overlay-iframe3' onclick='overlayOpen3();'>View</a> 
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
    <title>TRIP - ZONE RATE</title>
    <?php include('php/_head.php'); ?>
</head>
<body id='page-select' onload="document.getElementById('search_from').focus();">
    <section id='sub-menu'>
        <h3>SELECT ZONE RATE</h3>
    </section>
    <?php if (isset($message)) print $message; ?>
    <main>
        <section id='search-forms'>
            <form method='get'>
                <input id='search_from' name='search_from' type='text'
                    value='<?php if (isset($search_from)) print $search_from; ?>' autofocus required>
                <input name='search_to' type='text' value='<?php if (isset($search_to)) print $search_to; ?>'>
                <input type='submit' name='search' value='Search'> &nbsp; 
				<a href='rate_zone_save.php' target='overlay-iframe3' onclick='overlayOpen3();'>Add new</a>
            </form>
        </section>
        <?php 
		if (isset($listing_html)) print $listing_html;
		?>
    </main>
    <?php include('php/_footer.php'); ?>
</body>
</html>