<?php 
include('php/_code.php'); 
// parent id passed
if (isset($_GET['customerpassengerid'])) {
	$parent_id = trim($_GET['customerpassengerid']);
	if (!is_numeric($parent_id)) die('Parent table id is invalid');
	
	$results = mysqli_query($dbcon, "SELECT first_name, last_name FROM customer_passengers WHERE key_customer_passengers = $parent_id");
	if ($row = mysqli_fetch_assoc($results)) {
		$parent_record_label = "Address Book — " . $row['first_name'] . " " . $row['last_name'];
	} else {
		die('Parent id does not exist');
	}
} else {
	die('Parent id is not set');
}
$base_file_name = 'customer_address_book_listing';
$url = $_SERVER['REQUEST_URI'];
// remove query string
if (strpos($url, '?sort_by')) $url = substr($url, 0, strpos($url, '?sort_by'));
if (strpos($url, '&sort_by')) $url = substr($url, 0, strpos($url, '&sort_by'));
if (strpos($url, '?page')) $url = substr($url, 0, strpos($url, '?page'));
if (strpos($url, '&page')) $url = substr($url, 0, strpos($url, '&page'));
$query_symbol = '?';
if (strpos($url, '?')) $query_symbol = '&';
$sql_where = "WHERE key_customer_passengers = $parent_id";
$sql_order_by = 'entry_date_time';
$sql_order_by_seq = 'desc';
$order_icon = '▲';
$page_offset = '0';
$items_per_page = '15';
$total_items = '0';
if (isset($_POST['items_per_page'])) {
	$items_per_page = $_POST['items_per_page'];
	setcookie($base_file_name . '_items_per_page', $items_per_page, time() + (86400 * 30 * 12), '/');
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
		$sql_where = "WHERE key_customer_passengers = $parent_id AND  (entry_date_time BETWEEN '$period_from' AND '$period_to') ";
	}
}
if (isset($_GET['search'])) {
	$search = trim($_GET['search']);
	if (empty($search)) {
		$message = "<div class='failure-result'>Provide a search term</div>";
	} else {
		$sql_where = "WHERE key_customer_passengers = $parent_id AND  MATCH(title,category,city,zip_code) AGAINST('" . cd($dbcon, $search) . "')";
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
$order_icon = ($sql_order_by_seq == 'asc') ? '▼' : '▲';
$count_results = mysqli_query($dbcon, "SELECT count(*) AS total_items FROM customer_address_book $sql_where ");
if ($count_results && $count_row = mysqli_fetch_assoc($count_results)) $total_items = $count_row['total_items'];
$page_offset = (isset($_GET['page']) && is_numeric($_GET['page']) ? $_GET['page'] : '0');
$results = mysqli_query($dbcon, "SELECT key_customer_address_book, title, category, city, state  FROM customer_address_book $sql_where ORDER BY " . cd($dbcon, $sql_order_by) . " " . cd($dbcon, $sql_order_by_seq) . " LIMIT " . cd($dbcon, $page_offset) . ", " . cd($dbcon, $items_per_page));
if ($results) {
	$table_rows = '';
	while ($row = mysqli_fetch_assoc($results)) {
		$record_id = $row['key_customer_address_book'];
		$table_rows .= "
		<tr>
		<td>" . $row['title'] . "</td>
		<td>" . $row['category'] . "</td>
		<td>" . $row['city'] . "</td>
		<td>" . $row['state'] . "</td>
		<td class='record-icons'>
		<small>
		<a href='customer_address_book_save.php?customer_address_bookid=$record_id&customerpassengerid=$parent_id' target='overlay-iframe' onclick='overlayOpen();'>✎</a> 
		<a href='customer_address_book_view.php?customer_address_bookid=$record_id' target='overlay-iframe' onclick='overlayOpen();'>☷</a> 
		</small>
		</td>
		</tr>
		";
	}
	$listing_html = "
		<table class='listing-table'>
		<tr>
		<th><a href='$url" . $query_symbol . "sort_by=title&sort_seq=$sql_order_by_seq'>TITLE</a> " . (($sql_order_by == 'title') ? $order_icon : '') . "</th>
		<th><a href='$url" . $query_symbol . "sort_by=category&sort_seq=$sql_order_by_seq'>CATEGORY</a> " . (($sql_order_by == 'category') ? $order_icon : '') . "</th>
		<th><a href='$url" . $query_symbol . "sort_by=city&sort_seq=$sql_order_by_seq'>CITY</a> " . (($sql_order_by == 'city') ? $order_icon : '') . "</th>
		<th><a href='$url" . $query_symbol . "sort_by=state&sort_seq=$sql_order_by_seq'>STATE</a> " . (($sql_order_by == 'state') ? $order_icon : '') . "</th>
		<th></th>
		</tr>
		$table_rows
		</table>
		";
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
    <title>CUSTOMER ADDRESS BOOK</title>
    <?php include('php/_head.php'); ?>
</head>
<body id='page-listing' class='foreign'>
    <section id='sub-menu'>
        <div class='left-block'><?php if (isset($parent_record_label)) print $parent_record_label; ?></div>
        <div class='right-block'>
            ✢ <a href='customer_address_book_save.php?customerpassengerid=<?php print $parent_id; ?>'
                target='overlay-iframe' onclick='overlayOpen();'> New Address</a>
        </div>
    </section>
    <?php if (isset($message)) print $message; ?>
    <main>
        <section id='listing-forms'>
            <form id='dates_form' method='get'>
                <input type='hidden' name='customerpassengerid' value='<?php print $parent_id; ?>'>
                <input name='date_from' type='date'
                    value='<?php if (isset($date_from)) { print $date_from; } else { print date('Y-m-d'); } ?>'> to
                <input name='date_to' type='date'
                    value='<?php if (isset($date_to)) { print $date_to; } else { print date('Y-m-d'); } ?>'>
                <input type='submit' value='Get'>
            </form>
            <form id='search_form' method='get'>
                <input type='hidden' name='customerpassengerid' value='<?php print $parent_id; ?>'>
                <input name='search' type='text' <?php if (isset($search)) print "value='$search' autofocus"; ?>
                    required>
                <input type='submit' value='Search'>
            </form>
            <form id='items_per_page_form' method='post'>
                <input type='hidden' name='forward_url' value='<?php print $url; ?>'>
                <select name='items_per_page' onchange="document.forms['items_per_page_form'].submit();">
                    <?php
					print "
						<option" . (($items_per_page == '5') ? " selected='selected'" : '') .  ">5</option>
						<option" . (($items_per_page == '10') ? " selected='selected'" : '') .  ">10</option>
						<option" . (($items_per_page == '30') ? " selected='selected'" : '') .  ">30</option>
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