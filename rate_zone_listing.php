<?php 
include('php/_code.php'); 
$base_file_name = 'rate_zone_listing';
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
	$search_from = trim($_GET['search_from']);
	$search_to = trim($_GET['search_to']);
	$from_sql = '';
	$to_sql = '';
	$reverse_sql = '';
	if (!empty($search_from)) {
		$from_sql = "from_city = '" . cd($dbcon, $search_from) . "'";
	}
	if (!empty($search_to)) {
		$to_sql = " AND to_city = '" . cd($dbcon, $search_to) . "'";
	}
	if (isset($_GET['search_reverse']) && !empty($search_from) && !empty($search_to)) {
		$reverse_sql = " OR to_city = '" . cd($dbcon, $search_from) . "' AND from_city = '" . cd($dbcon, $search_to) . "'";
	}
	
	if (!empty($search_from)) {
		$sql_where = "WHERE $from_sql $to_sql $reverse_sql";
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
$count_results = mysqli_query($dbcon, "SELECT count(*) AS total_items FROM rates_zones $sql_where ");
if ($count_results && $count_row = mysqli_fetch_assoc($count_results)) $total_items = $count_row['total_items'];
$page_offset = (isset($_GET['page']) && is_numeric($_GET['page']) ? $_GET['page'] : '0');
$results = mysqli_query($dbcon, "SELECT key_rates_zones, from_city, from_state, to_city, to_state, rate, tolls, active_status FROM rates_zones $sql_where ORDER BY " . cd($dbcon, $sql_order_by) . " " . cd($dbcon, $sql_order_by_seq) . " LIMIT " . cd($dbcon, $page_offset) . ", " . cd($dbcon, $items_per_page));
if ($results) {
	$table_rows = '';
	while ($row = mysqli_fetch_assoc($results)) {
		$record_id = $row['key_rates_zones'];
		$table_rows .= "
		<tr>
		<td>" . $row['from_city'] . "</td>
		<td>" . $row['from_state'] . "</td>
		<td>⮕</td>
		<td>" . $row['to_city'] . "</td>
		<td>" . $row['to_state'] . "</td>
		<td class='right'>" . $row['rate'] . "</td>
		<td class='right'>" . $row['tolls'] . "</td>
		<td class='center'>" . (($row['active_status'] == "on") ? "&#10003;" : "") . "</td>
		<td class='record-menus'>
		<a href='#' class='toggle' onclick='record_menu(\"menu$record_id\", this);return false;'>ooo</a>
		<ul id='menu$record_id'>
		<li><a href='rate_zone_save.php?ratezoneid=$record_id' target='overlay-iframe' onclick='overlayOpen();hide_record_menus();'>Edit</a></li>
		<li><a href='rate_zone_view.php?ratezoneid=$record_id' target='overlay-iframe' onclick='overlayOpen();hide_record_menus();'>View</a></li>
		<li><a href='rate_zone_delete.php?ratezoneid=$record_id' target='overlay-iframe' onclick='overlayOpen();hide_record_menus();'>Delete</a></li>
		<li><a href='trip_listing.php?ratezoneid=$record_id' target='_blank' onclick='hide_record_menus();'>Trips</a></li>
		</ul>
		</td>
		</tr>
		";
	}
	$listing_html = "
		<table class='listing-table'>
		<tr>
		<th><a href='$url" . $query_symbol . "sort_by=from_city&sort_seq=$sql_order_by_seq'>From&nbsp;City</a>" . (($sql_order_by == 'from_city') ? $order_icon : '') . "</th>
		<th><a href='$url" . $query_symbol . "sort_by=from_state&sort_seq=$sql_order_by_seq'>From&nbsp;State</a>" . (($sql_order_by == 'from_state') ? $order_icon : '') . "</th>
		<th></th>
		<th><a href='$url" . $query_symbol . "sort_by=to_city&sort_seq=$sql_order_by_seq'>To&nbsp;City</a>" . (($sql_order_by == 'to_city') ? $order_icon : '') . "</th>
		<th><a href='$url" . $query_symbol . "sort_by=to_state&sort_seq=$sql_order_by_seq'>To&nbsp;State</a>" . (($sql_order_by == 'to_state') ? $order_icon : '') . "</th>
		<th><a href='$url" . $query_symbol . "sort_by=rate&sort_seq=$sql_order_by_seq'>Rate</a>" . (($sql_order_by == 'rate') ? $order_icon : '') . "</th>
		<th><a href='$url" . $query_symbol . "sort_by=tolls&sort_seq=$sql_order_by_seq'>Tolls</a>" . (($sql_order_by == 'tolls') ? $order_icon : '') . "</th>
		<th><a href='$url" . $query_symbol . "sort_by=active_status&sort_seq=$sql_order_by_seq'>Status</a>" . (($sql_order_by == 'active_status') ? $order_icon : '') . "</th>
		<th class='icon-cell'></th>
		</tr>
		$table_rows
		</table>
		";

	$pager = pager($url . $query_symbol, $total_items, $page_offset, $items_per_page);
	
	if (mysqli_num_rows($results) == 0) {
		$message = "<div class='failure-result'>No record found</div>";
	}
	
	
	
} else {
	// print mysqli_error($dbcon);
	die('Unable to get records, please contact your system administrator.');
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>ZONE RATES</title>
    <?php include('php/_head.php'); ?>
</head>
<body id='page-listing'>
    <?php include('php/_header.php'); ?>
    <section id='sub-menu'>
        <div class='left-block'><img src="images/icons/nav_zone_rates.png"> zone rates</div>
        <div class='right-block'>
            ✢ <a href='rate_zone_save.php' target='overlay-iframe' onclick='overlayOpen();'>New Zone Rate</a>
        </div>
    </section>
    <div class='page-image' style='background-image:url(images/page-zone-rates.jpg);'></div>
    <?php if (isset($message)) print $message; ?>
    <main>
        <section id='listing-forms'>
            <form id='dates_form' method='get'>
                <input name='date_from' type='date'
                    value='<?php if (isset($date_from)) { print $date_from; } else { print date('Y-m-d'); } ?>'> to
                <input name='date_to' type='date'
                    value='<?php if (isset($date_to)) { print $date_to; } else { print date('Y-m-d'); } ?>'>
                <input type='submit' value='Get'>
            </form>
            <form id='search_form' method='get'>
                <input name='search_from' type='text'
                    <?php if (isset($search_from)) print "value='$search_from' autofocus"; ?> placeholder='From'
                    required>
                <input name='search_to' type='text' <?php if (isset($search_to)) print "value='$search_to' "; ?>
                    placeholder='To'>
                <input type='checkbox' name='search_reverse' title='Show reverse'
                    <?php if (isset($_GET['search_reverse'])) print "checked"; ?>>
                <input type='submit' name='search' value='Search'>
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
		if (isset($pager)) print $pager;
		?>
    </main>
    <?php include('php/_footer.php'); ?>
</body>
</html>
