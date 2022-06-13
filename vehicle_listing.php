<?php 
include('php/_code.php'); 
$base_file_name = 'vehicles_listing';
$url = $_SERVER['REQUEST_URI'];
// remove query string
if (strpos($url, '?sort_by')) $url = substr($url, 0, strpos($url, '?sort_by'));
if (strpos($url, '&sort_by')) $url = substr($url, 0, strpos($url, '&sort_by'));
if (strpos($url, '?page')) $url = substr($url, 0, strpos($url, '?page'));
if (strpos($url, '&page')) $url = substr($url, 0, strpos($url, '&page'));
if (isset($_GET['sort_by']) && isset($_GET['sort_seq']) && (sizeof($_GET) == 2)) {
	$query_symbol = '?';
} else if (sizeof($_GET) > 1) {
	$query_symbol = '&';
} else {
	$query_symbol = '?';
}
$sql_where = '';
$sql_order_by = 'entry_date_time';
$sql_order_by_seq = 'desc';
$order_icon = '&nbsp;▲';
$page_offset = '0';
$items_per_page = '50';
$total_items = '0';
if (isset($_POST['items_per_page'])) {
	$items_per_page = $_POST['items_per_page'];
	setcookie($base_file_name . '_items_per_page', $items_per_page, time() + (86400 * 30 * 12), '/');
	header('location: ' . $_POST['forward_url']); // to reload with new items_per_page
} else if (isset($_COOKIE[$base_file_name . '_items_per_page'])) {
	$items_per_page = $_COOKIE[$base_file_name . '_items_per_page'];
}
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
		$sql_where = "WHERE (entry_date_time BETWEEN '" . cd($dbcon, $period_from) . "' AND '" . cd($dbcon, $period_to) . "') ";
	}
}
if (isset($_GET['search'])) {
	$search = trim($_GET['search']);
	if (empty($search)) {
		$message = "<div class='failure-result'>Provide a search term</div>";
	} else {
		$sql_where = "WHERE MATCH(fleet_number, vehicle_type, tag, vin_number, year_made, make, model, color, notes) AGAINST('" . cd($dbcon, $search) . "')";
	}
}
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
$count_results = mysqli_query($dbcon, "SELECT count(*) AS total_items FROM vehicles $sql_where ");
if ($count_results && $count_row = mysqli_fetch_assoc($count_results)) $total_items = $count_row['total_items'];
$page_offset = (isset($_GET['page']) && is_numeric($_GET['page']) ? $_GET['page'] : '0');
$results = mysqli_query($dbcon, "SELECT key_vehicles, fleet_number, vehicle_type, tag, year_made, make, model, max_seats, image_url, active_status FROM vehicles $sql_where ORDER BY " . cd($dbcon, $sql_order_by) . " " . cd($dbcon, $sql_order_by_seq) . " LIMIT " . cd($dbcon, $page_offset) . ", " . cd($dbcon, $items_per_page));
if ($results) {
	$table_rows = '';
	while ($row = mysqli_fetch_assoc($results)) {
		$record_id = $row['key_vehicles'];
		$image_url = $row['image_url'];
		if (!empty($image_url)) {
			$image_url = "<a href='$image_url' target='_blank'><img src='$image_url' valign='middle'></a>";
		} else {
			$image_url = "<img src='images/icons/lis_vehicles.png' valign='middle'>";
		}
		$table_rows = $table_rows . "
		<tr>
		<td>" . $row['make'] . "</td>
		<td>" . $row['model'] . "</td>
		<td class='center'>" . $row['fleet_number'] . "</td>
		<td>" . $row['vehicle_type'] . "</td>
		<td class='center'>$image_url</td>
		<td class='center'>" . $row['tag'] . "</td>
		<td class='center'>" . $row['year_made'] . "</td>
		<td class='center'>" . $row['max_seats'] . "</td>
		<td class='center'>" . (($row['active_status'] == "on") ? "&#10003;" : "") . "</td>
		<td class='record-menus'>
			<a href='#' class='toggle' onclick='record_menu(\"menu$record_id\", this);return false;'>ooo</a>
			<ul id='menu$record_id'>
			<li><a href='vehicle_save.php?vehiclesid=$record_id' target='overlay-iframe' onclick='overlayOpen();hide_record_menus();'>Edit</a></li>
			<li><a href='vehicle_view.php?vehiclesid=$record_id' target='overlay-iframe' onclick='overlayOpen();hide_record_menus();'>View</a></li>
			<li><a href='vehicle_maintenance_listing.php?vehiclesid=$record_id' target='_blank' onclick='hide_record_menus();'>Maintenance</a></li>
			<li><a href='trip_listing.php?vehiclesid=$record_id' target='_blank' onclick='hide_record_menus();'>Trips</a></li>
			</ul>
		</td>
		</tr>
			";
	}
	$listing_html = "
		<table class='listing-table'>
		<tr>
		<th><a href='$url" . $query_symbol . "sort_by=make&sort_seq=$sql_order_by_seq'>Make</a>" . (($sql_order_by == 'make') ? $order_icon : '') . "</th>
		<th><a href='$url" . $query_symbol . "sort_by=model&sort_seq=$sql_order_by_seq'>Model</a>" . (($sql_order_by == 'model') ? $order_icon : '') . "</th>
		<th><a href='$url" . $query_symbol . "sort_by=fleet_number&sort_seq=$sql_order_by_seq'>Fleet&nbsp;#</a>" . (($sql_order_by == 'fleet_number') ? $order_icon : '') . "</th>
		<th><a href='$url" . $query_symbol . "sort_by=vehicle_type&sort_seq=$sql_order_by_seq'>Vehicle&nbsp;Type</a>" . (($sql_order_by == 'vehicle_type') ? $order_icon : '') . "</th>
		<th><a href='$url" . $query_symbol . "sort_by=image_url&sort_seq=$sql_order_by_seq'>Image</a>" . (($sql_order_by == 'image_url') ? $order_icon : '') . "</th>
		<th><a href='$url" . $query_symbol . "sort_by=tag&sort_seq=$sql_order_by_seq'>Tag</a>" . (($sql_order_by == 'tag') ? $order_icon : '') . "</th>
		<th><a href='$url" . $query_symbol . "sort_by=year_made&sort_seq=$sql_order_by_seq'>Year</a>" . (($sql_order_by == 'year_made') ? $order_icon : '') . "</th>
		<th><a href='$url" . $query_symbol . "sort_by=max_seats&sort_seq=$sql_order_by_seq'>Max&nbsp;Seats</a>" . (($sql_order_by == 'max_seats') ? $order_icon : '') . "</th>
		<th><a href='$url" . $query_symbol . "sort_by=active_status&sort_seq=$sql_order_by_seq'>Status</a>" . (($sql_order_by == 'active_status') ? $order_icon : '') . "</th>
		<th class='icon-cell'></th>
		</tr>
		$table_rows
		</table>";
	if ($total_items > $page_offset) {
		$prev_page_offset = $page_offset - $items_per_page;
		$next_page_offset = $page_offset + $items_per_page;
		$pager = '';
		if ($prev_page_offset >= 0) $pager = "<td class='pager-prev'><a href=$url" . $query_symbol . "page=$prev_page_offset> ◄ </a></td></td>";
		$pager .= "<td class='pager-info'>" . ($page_offset + 1) . "-" . ($next_page_offset < $total_items ? $next_page_offset : $total_items) . " (" . $total_items . ")</td>";
		if ($next_page_offset < $total_items) $pager .= "<td class='pager-next'><a href=$url" . $query_symbol . "page=$next_page_offset> ► </a></td>";
		$pager = "<table id='pager'><tr>$pager</tr></table>";
		$listing_html .= $pager;
	}
	if (mysqli_num_rows($results) == 0) {
		$message = "<div class='failure-result'>No record found</div>";
	}
} else {
	//print mysqli_error($dbcon);
	die('Unable to get records, please contact your system administrator.');
}
?>
<!DOCTYPE html>
<html>
<head>
	<title>VEHICLES</title>
	<?php include('php/_head.php'); ?>
</head>
<body id='page-listing' class='page_listing page_vehicles_listing'>
	<?php include('php/_header.php'); ?>
	<section id='sub-menu'>
		<div class='left-block'><img src="images/icons/nav_vehicles.png"> vehicles</div>
		<div class='right-block'>
			✢ <a href='vehicle_save.php' target='overlay-iframe' onclick='overlayOpen();'>New Vehicle</a>
		</div>
	</section>

	<div class='page-image' style='background-image:url(images/page-vehicles.jpg);'></div>

	<?php if (isset($message)) print $message; ?>

	<main>
		<section id='listing-forms'>
			<form id='dates_form' method='get'>
					<input name='date_from' type='date' value='<?php if (isset($date_from)) { print $date_from; } else { print date('Y-m-d'); } ?>'> to 
					<input name='date_to' type='date' value='<?php if (isset($date_to)) { print $date_to; } else { print date('Y-m-d'); } ?>'> 
					<input type='submit' value='Get'>
			</form>
			<form id='search_form' method='get'>
					<input name='search' type='text' <?php if (isset($search)) print "value='$search' autofocus"; ?> required> 
					<input type='submit' value='Search'>
			</form>
			<form id='items_per_page_form' method='post'>
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
				<input type='button' value='Reset' onclick="window.location='<?php print $base_file_name . ".php"; ?>'">
			</form>
		</section>
		<?php 
			if (isset($listing_html)) print $listing_html;
		?>
	</main>
	<?php include('php/_footer.php'); ?>
</body>
</html>
