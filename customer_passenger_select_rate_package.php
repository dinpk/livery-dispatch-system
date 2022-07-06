<?php 
include('php/_code.php'); 
$run_query = true;
$sql_where = ' LIMIT 20';
if (isset($_GET['search'])) {
	$search = trim($_GET['search']);
	if (empty($search)) {
		$message = "<div class='failure-result'>Provide a search term</div>";
	} else {
		$sql_where = "WHERE MATCH(package_name) AGAINST('" . cd($dbcon, $search) . "')";
		$run_query = true;
	}
}
if ($run_query) {
	$results = mysqli_query($dbcon, "SELECT key_customer_rate_packages, package_name FROM customer_rate_packages $sql_where");
	if ($results) {
		$table_rows = '';
		while ($row = mysqli_fetch_assoc($results)) {
			$table_rows .= "
			<tr>
			<td>" . $row['package_name'] . "</td>
			<td class='record-icons'>
			<a href='#' onclick='
				parent.document.getElementById(\"package_name\").value = \"" . $row['package_name']  . "\";
				parent.document.getElementById(\"key_customer_rate_packages\").value = \"" . $row['key_customer_rate_packages']  . "\";
				closeOverlay2(\"fromiframe\");'>Select</a> &nbsp; 
			<a href='customer_rate_package_view.php?customerratepackageid=" . $row['key_customer_rate_packages'] . "' target='overlay-iframe3' onclick='overlayOpen3();'>View</a> 
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
    <title>CUSTOMER RATE PACKAGES</title>
    <?php include('php/_head.php'); ?>
</head>
<body id='page-select' onload="document.getElementById('search').focus();">
    <section id='sub-menu'>
        <h3>CUSTOMER RATE PACKAGES</h3>
    </section>
    <?php if (isset($message)) print $message; ?>
    <main>
        <section id='search-forms'>
            <form method='get'>
                <input id='search' name='search' type='text' autofocus required>
                <input type='submit' value='Search'> &nbsp; <a href='customer_rate_package_save.php'
                    target='overlay-iframe3' onclick='overlayOpen3();'>Add new</a>
            </form>
        </section>
        <?php 
		if (isset($listing_html)) print $listing_html;
		?>
    </main>
    <?php include('php/_footer.php'); ?>
</body>
</html>
