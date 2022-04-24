<?php 
include('php/_code.php'); 
$status_array = array();
$results = mysqli_query($dbcon, "SELECT * FROM settings_trip_status_values WHERE active_status = 'on'");
while ($row = mysqli_fetch_assoc($results)) {
	$status_array[$row['trip_status']] = $row['text_color'] . "|" . $row['back_color'];
}
$base_file_name = 'trips_listing';
$url = $_SERVER['REQUEST_URI'];
// remove query string
if (strpos($url, '?sort_by')) $url = substr($url, 0, strpos($url, '?sort_by'));
if (strpos($url, '&sort_by')) $url = substr($url, 0, strpos($url, '&sort_by'));
if (strpos($url, '?page')) $url = substr($url, 0, strpos($url, '?page'));
if (strpos($url, '&page')) $url = substr($url, 0, strpos($url, '&page'));

if (isset($_GET['sort_by']) && isset($_GET['sort_seq']) && (sizeof($_GET) == 2)) {
	$query_symbol = '?';
} else if (sizeof($_GET) > 0) {
	$query_symbol = '&';
} else {
	$query_symbol = '?';
}

$sql_where = '';
$sql_order_by = 'pickup_datetime';
$sql_order_by_seq = 'desc';
$order_icon = '&nbsp;▲';
$page_offset = '0';
$items_per_page = '50';
$total_items = '0';
$list_type = 'table';
// ----------------- SQL PART BASED ON ID PASSED
$sql_where_alt = '';
$reset_url = $base_file_name . '.php';
if (isset($_GET['customer_passengersid']) && is_numeric($_GET['customer_passengersid'])) {
	$key_customer_passengers = $_GET['customer_passengersid'];
	$sql_where_alt = ' WHERE key_customer_passengers = ' . $_GET['customer_passengersid'];
	$reset_url = "$base_file_name.php?customer_passengersid=$key_customer_passengers";
}
if (isset($_GET['customer_contactsid']) && is_numeric($_GET['customer_contactsid'])) {
	$key_customer_contacts = $_GET['customer_contactsid'];
	$sql_where_alt = ' WHERE key_customer_contacts = ' . $_GET['customer_contactsid'];
	$reset_url = "$base_file_name.php?customer_contactsid=$key_customer_contacts";
}
if (isset($_GET['driversid']) && is_numeric($_GET['driversid'])) {
	$key_drivers = $_GET['driversid'];
	$sql_where_alt = ' WHERE key_drivers = ' . $_GET['driversid'];
	$reset_url = "$base_file_name.php?driversid=$key_drivers";
}
if (isset($_GET['vehiclesid']) && is_numeric($_GET['vehiclesid'])) {
	$key_vehicles = $_GET['vehiclesid'];
	$sql_where_alt = ' WHERE key_vehicles = ' . $_GET['vehiclesid'];
	$reset_url = "$base_file_name.php?vehiclesid=$key_vehicles";
}
if (isset($_GET['rates_zonesid']) && is_numeric($_GET['rates_zonesid'])) {
	$key_rates_zones = $_GET['rates_zonesid'];
	$sql_where_alt = ' WHERE key_rates_zones = ' . $_GET['rates_zonesid'];
	$reset_url = "$base_file_name.php?rates_zonesid=$key_rates_zones";
}
if (isset($_GET['search']) || isset($_GET['date_from'])) $sql_where_alt = str_replace('WHERE', 'AND', $sql_where_alt);
// ----------------- ITEMS PER PAGE
if (isset($_POST['items_per_page'])) {
	$items_per_page = $_POST['items_per_page'];
	setcookie($base_file_name . '_items_per_page', $items_per_page, time() + (86400 * 30 * 12), '/');
	header('location: ' . $_POST['forward_url']); // to reload with new items_per_page
} else if (isset($_COOKIE[$base_file_name . '_items_per_page'])) {
	$items_per_page = $_COOKIE[$base_file_name . '_items_per_page'];
}
// ----------------- DATES SEARCH
if (isset($_GET['date_from']) && isset($_GET['date_to'])) {
	$date_from = $_GET['date_from'];
	$date_to = $_GET['date_to'];
	if (!is_date($date_from) || !is_date($date_to)) {
		$message = "<div class='failure-result'>Invalid date</div>";
	} else if (strtotime($date_to) < strtotime($date_from)) {
		$message = "<div class='failure-result'>Invalid date range</div>";
	} else {
		$period_from = $date_from;
		$period_to = date('Y-m-d', strtotime($date_to) + 86400);
		$sql_where = "WHERE (pickup_datetime BETWEEN '" . cd($dbcon, $period_from) . "' AND '" . cd($dbcon, $period_to) . "') ";
	}
}
// ----------------- KEYWORD SEARCH
if (isset($_GET['search'])) {
	$search = trim($_GET['search']);
	if (empty($search)) {
		$message = "<div class='failure-result'>Provide a search term</div>";
	} else {
		$sql_where = "WHERE key_trips = '" . cd($dbcon, $search) . "' OR MATCH(reference_number, passenger_name, reserved_by, trip_type, driver_name, vehicle, airline, flight_number, zone_from, zone_to) AGAINST('" . cd($dbcon, $search) . "')";
	}
}
// ----------------- SORTING
if (isset($_GET['sort_by']) && isset($_GET['sort_seq'])) {
	$sql_order_by = sd($dbcon, $_GET['sort_by']);
	$sql_order_by_seq = ($_GET['sort_seq'] == 'asc') ? 'desc' : 'asc';
	setcookie($base_file_name . '_sort_by', $sql_order_by, time() + (86400 * 30 * 12), '/');
	setcookie($base_file_name . '_sort_seq', $sql_order_by_seq, time() + (86400 * 30 * 12), '/');
} else if (isset($_COOKIE[$base_file_name . '_sort_by']) && isset($_COOKIE[$base_file_name . '_sort_seq'])) {
	$sql_order_by = $_COOKIE[$base_file_name . '_sort_by'];
	$sql_order_by_seq = $_COOKIE[$base_file_name . '_sort_seq'];
}
$order_icon = ($sql_order_by_seq == 'asc') ? '&nbsp;▼' : '&nbsp;▲';
// ----------------- COUNT FOR PAGER
$count_results = mysqli_query($dbcon, "SELECT count(*) AS total_items FROM trips $sql_where $sql_where_alt ");
if ($count_results && $count_row = mysqli_fetch_assoc($count_results)) $total_items = $count_row['total_items'];
$page_offset = (isset($_GET['page']) && is_numeric($_GET['page']) ? $_GET['page'] : '0');
// ----------------- SELECT QUERY
$results = mysqli_query($dbcon, "SELECT key_trips, key_customer_passengers, key_customer_contacts, key_drivers, key_vehicles, key_rates_zones, reference_number,  passenger_name, total_passengers, reserved_by, pickup_datetime, trip_status, driver_name, vehicle, airline, flight_number, zone_from, zone_to, routing_from, routing_to, total_trip_amount 
									FROM trips 
									$sql_where $sql_where_alt 
									ORDER BY " . cd($dbcon, $sql_order_by) . " " . cd($dbcon, $sql_order_by_seq) . " LIMIT " . cd($dbcon, $page_offset) . ", " . cd($dbcon, $items_per_page));
if ($results) {
	if ($list_type == 'flex') {
		$sheet = '';
		while ($row = mysqli_fetch_assoc($results)) {
			$front_color = explode("|", $status_array[$row['trip_status']])[0];
			$back_color = explode("|", $status_array[$row['trip_status']])[1];
			$status_style = "style='color:$front_color;background:$back_color;'";
			$record_id = $row['key_trips'];
			$sheet .= "
			<section>
				<div>
					<h2><a href='trips_view.php?tripsid=" . $row['key_trips'] . "' target='overlay-iframe' onclick='overlayOpen();'>" . "<span>Trip #</span> " . $row['key_trips'] . "</a></h2>
					<p>" . date("M d, Y - h:ia", strtotime($row['pickup_datetime'])) . "</p>
					<p> $ " . round($row['total_trip_amount'], 2) . "</p>
				</div>
				<div>
					<h4><a href='rates_zones_view.php?rates_zonesid=" . $row['key_rates_zones'] . "' target='overlay-iframe' onclick='overlayOpen();'>" . $row['zone_from'] . "</h4>
					<h4>" . $row['zone_to'] . "</a></h4>
					<p>" . $row['airline'] . " " . $row['flight_number'] . "</p>
				</div>
				<div>
					<h3><a href='customer_passengers_view.php?customer_passengersid=" . $row['key_customer_passengers'] . "' target='overlay-iframe' onclick='overlayOpen();'>" . $row['passenger_name'] . "</a> <span>(" . $row['total_passengers'] . ")</span></h3>
					<p>" . $row['reference_number'] . "</p>
					<p><a href='customer_contacts_view.php?contactsid=" . $row['key_contacts'] . "' target='overlay-iframe' onclick='overlayOpen();'>" . $row['reserved_by'] . "</p>
				</div>
				<div>
					<h3><a href='drivers_view.php?driversid=" . $row['key_drivers'] . "' target='overlay-iframe' onclick='overlayOpen();'>" . $row['driver_name'] . "</a></h3>
					<p><a href='vehicles_view.php?vehiclesid=" . $row['key_vehicles'] . "' target='overlay-iframe' onclick='overlayOpen();'>" . $row['vehicle'] . "</a></p>
				</div>
				<div>
					<p><a class='status-button' " . $status_style . " href='trips_dispatch.php?tripsid=" . $row['key_trips'] . "' target='overlay-iframe' onclick='overlayOpen();'>" . $row['trip_status'] . "</a></p>
					<p><a href='trips_save.php?tripsid=" . $row['key_trips'] . "' target='overlay-iframe' onclick='overlayOpen();'>Edit trip</a></p>
				</div>
			</section>";
		}
		$listing_html = '<div id="sheet">' . $sheet . '</div>';
	} else if ($list_type == 'table') {
		$table_rows = '';
		while ($row = mysqli_fetch_assoc($results)) {
			$key_trips = $row['key_trips'];
			$front_color = explode("|", $status_array[$row['trip_status']])[0];
			$back_color = explode("|", $status_array[$row['trip_status']])[1];
			$status_style = "style='color:$front_color;background:$back_color;'";
			$table_rows .= "
			<tr>
			<td class='center'><a href='trips_view.php?tripsid=" . $row['key_trips'] . "' target='overlay-iframe' onclick='overlayOpen();'>" . $row['key_trips'] . "</a></td>
			<td class='center'>" . date("M d, Y - h:ia", strtotime($row['pickup_datetime'])) . "</td>
			<td><a href='rates_zones_view.php?rates_zonesid=" . $row['key_rates_zones'] . "' target='overlay-iframe' onclick='overlayOpen();'>" . $row['zone_from'] . " > " . $row['zone_to'] . "</a></td>
			<td><a href='https://www.google.com/search?q=" . $row['airline'] . " " . $row['flight_number'] . "' target='_blank'>" . $row['airline'] . ' ' . $row['flight_number'] . "</a></td>
			<td class='right'>" . $row['reference_number'] . "</td>
			<td><a href='customer_passengers_view.php?customer_passengersid=" . $row['key_customer_passengers'] . "' target='overlay-iframe' onclick='overlayOpen();'>" . $row['passenger_name'] . "</a></td>
			<td class='center'>" . $row['total_passengers'] . "</td>
			<td><a href='customer_contacts_view.php?customer_contactsid=" . $row['key_customer_contacts'] . "' target='overlay-iframe' onclick='overlayOpen();'>" . $row['reserved_by'] . "</a></td>
			<td><a href='drivers_view.php?driversid=" . $row['key_drivers'] . "' target='overlay-iframe' onclick='overlayOpen();'>" . $row['driver_name'] . "</a></td>
			<td><a href='vehicles_view.php?vehiclesid=" . $row['key_vehicles'] . "' target='overlay-iframe' onclick='overlayOpen();'>" . $row['vehicle'] . "</a></td>
			<td class='right'>" . $row['total_trip_amount'] . "</td>
			<td class='status-button' " . $status_style . "><a " . $status_style . " href='trips_trip_status_update.php?tripsid=" . $row['key_trips'] . "' target='overlay-iframe' onclick='overlayOpen();'>" . $row['trip_status'] . "</a></td>
			<td class='record-menus'>
				<a href='#' class='toggle' onclick='record_menu(\"menu$key_trips\", this);return false;'>ooo</a>
				<ul id='menu$key_trips'>
				<li><a href='trips_save.php?tripsid=$key_trips' target='overlay-iframe' onclick='overlayOpen();hide_record_menus();'>Edit</a></li>
				<li><a href='trips_save.php?tripsid=$key_trips&duplicate=1' target='overlay-iframe' onclick='overlayOpen();hide_record_menus();'>Duplicate</a></li>
				<li><a href='https://www.google.com/maps/dir/" . $row['routing_from'] . "/" . $row['routing_to'] . "' target='_blank' onclick='hide_record_menus();'>Direction</a></li>
				<li><a href='trips_quote.php?tripsid=$key_trips' target='overlay-iframe' onclick='overlayOpen();hide_record_menus();'>Quote</a></li>
				<li><a href='trips_confirmation.php?tripsid=$key_trips' target='overlay-iframe' onclick='overlayOpen();hide_record_menus();'>Confirmation</a></li>
				<li><a href='trips_dispatch.php?tripsid=$key_trips' target='overlay-iframe' onclick='overlayOpen();hide_record_menus();'>Dispatch</a></li>
				<li><a href='trips_invoice.php?tripsid=$key_trips' target='overlay-iframe' onclick='overlayOpen();hide_record_menus();'>Invoice</a></li>
				</ul>
			</td>
			</tr>";
		}
		$listing_html = "
		<table class='listing-table'>
			<tr>
				<th><a href='$url" . $query_symbol . "sort_by=key_trips&sort_seq=$sql_order_by_seq'>Trip #</a>" . (($sql_order_by == 'key_trips') ? $order_icon : '') . "</th>
				<th><a href='$url" . $query_symbol . "sort_by=pickup_datetime&sort_seq=$sql_order_by_seq'>Date Time</a>" . (($sql_order_by == 'pickup_datetime') ? $order_icon : '') . "</th>
				<th><a href='$url" . $query_symbol . "sort_by=zone_from&sort_seq=$sql_order_by_seq'>Zone</a>" . (($sql_order_by == 'zone_from') ? $order_icon : '') . "</th>
				<th><a href='$url" . $query_symbol . "sort_by=airline&sort_seq=$sql_order_by_seq'>Flight</a>" . (($sql_order_by == 'airline') ? $order_icon : '') . "</th>
				<th><a href='$url" . $query_symbol . "sort_by=reference_number&sort_seq=$sql_order_by_seq'>Ref&nbsp;#</a>" . (($sql_order_by == 'reference_number') ? $order_icon : '') . "</th>
				<th><a href='$url" . $query_symbol . "sort_by=passenger_name&sort_seq=$sql_order_by_seq'>Passenger</a>" . (($sql_order_by == 'passenger_name') ? $order_icon : '') . "</th>
				<th><a href='$url" . $query_symbol . "sort_by=total_passengers&sort_seq=$sql_order_by_seq'>#</a>" . (($sql_order_by == 'total_passengers') ? $order_icon : '') . "</th>
				<th><a href='$url" . $query_symbol . "sort_by=reserved_by&sort_seq=$sql_order_by_seq'>Reserved&nbsp;By</a>" . (($sql_order_by == 'reserved_by') ? $order_icon : '') . "</th>
				<th><a href='$url" . $query_symbol . "sort_by=driver_name&sort_seq=$sql_order_by_seq'>Driver</a>" . (($sql_order_by == 'driver_name') ? $order_icon : '') . "</th>
				<th><a href='$url" . $query_symbol . "sort_by=vehicle&sort_seq=$sql_order_by_seq'>Vehicle</a>" . (($sql_order_by == 'vehicle') ? $order_icon : '') . "</th>
				<th><a href='$url" . $query_symbol . "sort_by=total_trip_amount&sort_seq=$sql_order_by_seq'>Charges</a>" . (($sql_order_by == 'total_trip_amount') ? $order_icon : '') . "</th>
				<th><a href='$url" . $query_symbol . "sort_by=trip_status&sort_seq=$sql_order_by_seq'>Status</a>" . (($sql_order_by == 'trip_status') ? $order_icon : '') . "</th>
				<th class='icon-cell'></th>
			</tr>
			$table_rows
		</table>";		
	}
	// ----------------- PAGER
	if ($total_items > $page_offset) {
		$prev_page_offset = $page_offset - $items_per_page;
		$next_page_offset = $page_offset + $items_per_page;
		$pager = '';
		if ($prev_page_offset >= 0) $pager = "<td class='pager-prev'><a href=$url" . $query_symbol . "page=$prev_page_offset> ⯇ </a></td>";
		$pager .= "<td class='pager-info'>" . ($page_offset + 1) . "-" . ($next_page_offset < $total_items ? $next_page_offset : $total_items) . " (" . $total_items . ")</td>";
		if ($next_page_offset < $total_items) $pager .= "<td class='pager-next'><a href=$url" . $query_symbol . "page=$next_page_offset> ⯈ </a></td>";
		$pager = "<table id='pager'><tr>$pager</tr></table>";
		$listing_html .= $pager;
	}
	if (mysqli_num_rows($results) == 0) $message = "<div class='failure-result'>No record found</div>";
} else {
	print mysqli_error($dbcon);
	die('Unable to get records, please contact your system administrator.');
}
?>
<!DOCTYPE html>
<html>
<head>
	<title>TRIPS</title>
	<?php include('php/_head.php'); ?>
</head>
<body id='page-listing' class='page_listing page_trips_listing'>
	<?php include('php/_header.php'); ?>
	<section id='sub-menu'>
		<div class='left-block'><img src="images/icons/nav_trips.png"> trips</div>
		<div class='right-block'>
			&#9998;<a href='trips_sheet.php' target='_blank'>Trip Sheet</a>
			&nbsp;
			&#9998;<a href='trips_save.php' target='overlay-iframe' onclick='overlayOpen();'>New</a>
		</div>
	</section>

	<?php if (isset($message)) print $message; ?>

	<main>
		<section id='listing-forms'>
			<form id='dates_form' method='get'>
				<input name='date_from' type='date' value='<?php if (isset($date_from)) { print $date_from; } else { print date('Y-m-d'); } ?>'> to 
				<input name='date_to' type='date' value='<?php if (isset($date_to)) { print $date_to; } else { print date('Y-m-d'); } ?>'> 
				<?php
				if (isset($key_customer_passengers)) print "<input name='customer_passengersid' type='hidden' value='$key_customer_passengers'>";
				if (isset($key_customer_contacts)) print "<input name='customer_contactsid' type='hidden' value='$key_customer_contacts'>";
				if (isset($key_drivers)) print "<input name='driversid' type='hidden' value='$key_drivers'>";
				if (isset($key_vehicles)) print "<input name='vehiclesid' type='hidden' value='$key_vehicles'>";
				if (isset($key_rates_zones)) print "<input name='rates_zonesid' type='hidden' value='$key_rates_zones'>";
				?>
				<input type='submit' value='Get'>
			</form>
			<form id='search_form' method='get'>
				<input name='search' type='text' <?php if (isset($search)) print "value='$search' autofocus"; ?> required> 
				<?php
				if (isset($key_customer_passengers)) print "<input name='customer_passengersid' type='hidden' value='$key_customer_passengers'>";
				if (isset($key_customer_contacts)) print "<input name='customer_contactsid' type='hidden' value='$key_customer_contacts'>";
				if (isset($key_drivers)) print "<input name='driversid' type='hidden' value='$key_drivers'>";
				if (isset($key_vehicles)) print "<input name='vehiclesid' type='hidden' value='$key_vehicles'>";
				if (isset($key_rates_zones)) print "<input name='rates_zonesid' type='hidden' value='$key_rates_zones'>";
				?>
				<input type='submit' value='Search'>
			</form>
			<form id='items_per_page_form' method='post'>
				<input type='hidden' name='forward_url' value='<?php print $url; ?>'>
				<input type='hidden' name='forward_url' value='<?php print $url; ?>'>
				<select name='items_per_page' onchange="document.forms['items_per_page_form'].submit();">
					<?php
					print "
					<option" . (($items_per_page == '10') ? " selected='selected'" : '') .  ">10</option>
					<option" . (($items_per_page == '20') ? " selected='selected'" : '') .  ">20</option>
					<option" . (($items_per_page == '30') ? " selected='selected'" : '') .  ">30</option>
					<option" . (($items_per_page == '40') ? " selected='selected'" : '') .  ">40</option>
					<option" . (($items_per_page == '50') ? " selected='selected'" : '') .  ">50</option>
					<option" . (($items_per_page == '200') ? " selected='selected'" : '') .  ">200</option>
					";
					?>
				</select> per page &nbsp; &nbsp; 
				<input type='button' value='Reset' onclick="window.location='<?php print $reset_url; ?>'">
			</form>
		</section>
		<?php 
			if (isset($listing_html)) print $listing_html;
		?>
	</main>
	<?php include('php/_footer.php'); ?>
</body>
</html>
