<?php 
include('php/_code.php'); 
$run_query = false;
$sql_where = '';
if (isset($_GET['search'])) {
	$search = trim($_GET['search']);
	if (empty($search)) {
		$message = "<div class='failure-result'>Provide a search term</div>";
	} else {
		$sql_where = "WHERE MATCH(first_name, last_name, address1, city, state, country, zip_code, email, ad_source) AGAINST('" . cd($dbcon, $search) . "')";
		$run_query = true;
	}
}
if ($run_query) {
	$gratuity_percent = $gas_surcharge_percent = $admin_fee_percent = $tax_percent = $discount_percent = 0;
	$results = mysqli_query($dbcon, "SELECT gratuity_percent, gas_surcharge_percent, admin_fee_percent, tax_percent FROM settings_trips WHERE key_settings_trips = 1");
	if ($results && $row = mysqli_fetch_assoc($results)) {
		$gratuity_percent = $row['gratuity_percent'];
		$gas_surcharge_percent = $row['gas_surcharge_percent'];
		$admin_fee_percent = $row['admin_fee_percent'];
		$tax_percent = $row['tax_percent'];
	}
	$results = mysqli_query($dbcon, "SELECT key_customer_passengers, key_customer_rate_packages, first_name, last_name, trip_ticket_notes FROM customer_passengers $sql_where");
	if ($results) {
		$table_rows = '';
		while ($row = mysqli_fetch_assoc($results)) {
			$key_customer_rate_packages = $row['key_customer_rate_packages'];
			$results_package = mysqli_query($dbcon, "SELECT gratuity_percent, gas_surcharge_percent, admin_fee_percent, discount_percent FROM customer_rate_packages 
												WHERE key_customer_rate_packages  = $key_customer_rate_packages");
			if ($results_package && $row_package = mysqli_fetch_assoc($results_package)) {
				$gratuity_percent = $row_package['gratuity_percent'];
				$gas_surcharge_percent = $row_package['gas_surcharge_percent'];
				$admin_fee_percent = $row_package['admin_fee_percent'];
				$discount_percent = $row_package['discount_percent'];
			}
			$table_rows .= "
			<tr>
			<td>" . $row['first_name'] . "</td>
			<td>" . $row['last_name'] . "</td>
			<td class='record-icons'>
				<a href='#' onclick='
					parent.document.getElementById(\"passenger_name\").value = \"" . $row['first_name'] . " " . $row['last_name'] . "\";
					parent.document.getElementById(\"key_customer_passengers\").value = \"" . $row['key_customer_passengers']  . "\";
					parent.document.getElementById(\"routing_notes\").value = \"" . $row['trip_ticket_notes']  . "\";
					parent.document.getElementById(\"discount_percent\").value = \"" . $discount_percent  . "\";
					parent.document.getElementById(\"gas_surcharge_percent\").value = \"" . $gas_surcharge_percent  . "\";
					parent.document.getElementById(\"admin_fee_percent\").value = \"" . $admin_fee_percent  . "\";
					parent.document.getElementById(\"gratuity_percent\").value = \"" . $gratuity_percent  . "\";
					parent.document.getElementById(\"tax_percent\").value = \"" . $tax_percent  . "\";
					closeOverlay2(\"fromiframe\");'>Select</a> &nbsp; 
				<a href='customer_passenger_view.php?customerpassengerid=" . $row['key_customer_passengers'] . "' target='overlay-iframe3' onclick='overlayOpen3();'>View</a> 
			</td>
			</tr>
			<script>parent.set_passenger_id_for_select_address('" . $row['key_customer_passengers'] . "');</script>
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
    <title>TRIP - CUSTOMER PASSENGER</title>
    <?php include('php/_head.php'); ?>
</head>

<body id='page-select' onload="document.getElementById('search').focus();">
    <section id='sub-menu'>
        <h3>SELECT CUSTOMER PASSENGER</h3>
    </section>
    <?php if (isset($message)) print $message; ?>
    <main>
        <section id='search-forms'>
            <form method='get'>
                <input id='search' name='search' type='text' autofocus required>
                <input type='submit' value='Search'> &nbsp;
                <!-- <a href='customer_passenger_save.php' target='overlay-iframe3' onclick='overlayOpen3();'>Add new</a> -->
            </form>
        </section>
        <?php 
		if (isset($listing_html)) print $listing_html;
		?>
    </main>
    <?php include('php/_footer.php'); ?>
</body>
</html>
