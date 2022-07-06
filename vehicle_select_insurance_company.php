<?php 
include('php/_code.php'); 
$run_query = true;
$sql_where = ' LIMIT 20';
if (isset($_GET['search'])) {
	$search = trim($_GET['search']);
	if (empty($search)) {
		$message = "<div class='failure-result'>Provide a search term</div>";
	} else {
		$sql_where = "WHERE MATCH(insurance_company) AGAINST('" . cd($dbcon, $search) . "')";
		$run_query = true;
	}
}
if ($run_query) {
	$results = mysqli_query($dbcon, "SELECT key_settings_insurance_company_values, insurance_company FROM settings_insurance_company_values $sql_where");
	if ($results) {
		$table_rows = '';
		while ($row = mysqli_fetch_assoc($results)) {
			$table_rows .= "
			<tr>
			<td>" . $row['insurance_company'] . "</td>
			<td class='record-icons'>
				<a href='#' onclick='
					parent.document.getElementById(\"insurance_company\").value = \"" . $row['insurance_company']  . "\";
					parent.document.getElementById(\"key_settings_insurance_company_values\").value = \"" . $row['key_settings_insurance_company_values']  . "\";
					closeOverlay2(\"fromiframe\");'>Select</a>
				<a href='settings_insurance_company_value_view.php?settingsinsurancecompanyid=" . $row['key_settings_insurance_company_values'] . "' target='overlay-iframe3' onclick='overlayOpen3();'>View</a> 
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
    <title>VEHILCE - INSURANCE COMPANY</title>
    <?php include('php/_head.php'); ?>
</head>
<body id='page-select' onload="document.getElementById('search').focus();">
    <section id='sub-menu'>
        <h3>SELECT INSURANCE COMPANY</h3>
    </section>
    <?php if (isset($message)) print $message; ?>
    <main>
        <section id='search-forms'>
            <form method='get'>
                <input id='search' name='search' type='text' autofocus required>
                <input type='submit' value='Search'> &nbsp; <a href='settings_insurance_company_value_save.php'
                    target='overlay-iframe3' onclick='overlayOpen3();'>Add new</a>
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