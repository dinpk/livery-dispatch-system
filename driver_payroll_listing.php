<?php 
include('php/_code.php'); 
$base_file_name = 'driver_payroll_listing';
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
$sql_where = ' WHERE driver_payroll.key_drivers = drivers.key_drivers';
$sql_order_by = 'end_date';
$sql_order_by_seq = 'desc';
$order_icon = '&nbsp;▲';
$page_offset = '0';
$items_per_page = '50';
$total_items = '0';
$sql_where_alt = '';
$reset_url = $base_file_name . '.php';
if (isset($_GET['driverid']) && is_numeric($_GET['driverid'])) {
	$key_drivers = $_GET['driverid'];
	$sql_where_alt = ' AND driver_payroll.key_drivers = ' . $_GET['driverid'];
	$reset_url = "$base_file_name.php?driverid=$key_drivers";
}
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
		$sql_where = "WHERE (end_date BETWEEN '$date_from' AND '$date_to') AND driver_payroll.key_drivers = drivers.key_drivers";
	}
}
if (isset($_GET['search'])) {
	$search = trim($_GET['search']);
	if (empty($search)) {
		$message = "<div class='failure-result'>Provide a search term</div>";
	} else {
		$sql_where = "WHERE key_driver_payroll = $search AND driver_payroll.key_drivers = drivers.key_drivers";
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
$count_results = mysqli_query($dbcon, "SELECT count(*) AS total_items FROM driver_payroll, drivers $sql_where $sql_where_alt ");
if ($count_results && $count_row = mysqli_fetch_assoc($count_results)) $total_items = $count_row['total_items'];
$page_offset = (isset($_GET['page']) && is_numeric($_GET['page']) ? $_GET['page'] : '0');
$results = mysqli_query($dbcon, "SELECT key_driver_payroll, start_date, end_date, due_date, amount, amount_paid, first_name, last_name 
				FROM driver_payroll, drivers 
				$sql_where $sql_where_alt 
				ORDER BY " . cd($dbcon, $sql_order_by) . " " . cd($dbcon, $sql_order_by_seq) . " LIMIT " . cd($dbcon, $page_offset) . ", " . cd($dbcon, $items_per_page));
if ($results) {
	$table_rows = '';
	while ($row = mysqli_fetch_assoc($results)) {
		$record_id = $row['key_driver_payroll'];
		$total_amount = $row['amount'];
		$paid_amount = $row['amount_paid'];
		$balance = round($total_amount - $paid_amount, 2);
		if ($paid_amount < $total_amount) {
			$balance = "<span class='red'>$balance</span>";
		} else if ($paid_amount > $total_amount) {
			$balance = "<span class='blue'>$balance</span>";
		} else {
			$balance = "<span class='green'>$balance</span>";
		}
		$table_rows = $table_rows . "
		<tr>
		<td class='center'>" . $row['key_driver_payroll'] . "</td>
		<td class='center'><h3>" . $row['first_name'] . " " . $row['last_name'] . "</h3></td>
		<td class='center'>" . date("F d, Y", strtotime($row['start_date'])) . "</td>
		<td class='center'>" . date("F d, Y", strtotime($row['end_date'])) . "</td>
		<td class='center'>" . date("F d, Y", strtotime($row['due_date'])) . "</td>
		<td class='right'>" . $total_amount . "</td>
		<td class='right'>" . $paid_amount . "</td>
		<td class='right'><h4>" . $balance . "</h4></td>
		<td class='record-icons'>
			<a href='driver_payroll_save.php?driverpayrollid=$record_id' target='overlay-iframe' onclick='overlayOpen();'>✎</a> 
			<a href='driver_payroll_print.php?driverpayrollid=$record_id' target='_blank'>☷</a> 
		</td>
		</tr>";
	}
	$listing_html = "
		<table class='listing-table'>
		<tr class='bg-black'>
		<th><a href='$url" . $query_symbol . "sort_by=key_driver_payroll&sort_seq=$sql_order_by_seq'>Payroll&nbsp;#</a>" . (($sql_order_by == 'key_driver_payroll') ? $order_icon : '') . "</th>
		<th><a href='$url" . $query_symbol . "sort_by=first_name&sort_seq=$sql_order_by_seq'>Driver</a>" . (($sql_order_by == 'first_name') ? $order_icon : '') . "</th>
		<th><a href='$url" . $query_symbol . "sort_by=start_date&sort_seq=$sql_order_by_seq'>Start&nbsp;Date</a>" . (($sql_order_by == 'start_date') ? $order_icon : '') . "</th>
		<th><a href='$url" . $query_symbol . "sort_by=end_date&sort_seq=$sql_order_by_seq'>End&nbsp;Date</a>" . (($sql_order_by == 'end_date') ? $order_icon : '') . "</th>
		<th><a href='$url" . $query_symbol . "sort_by=due_date&sort_seq=$sql_order_by_seq'>Due&nbsp;Date</a>" . (($sql_order_by == 'due_date') ? $order_icon : '') . "</th>
		<th><a href='$url" . $query_symbol . "sort_by=amount&sort_seq=$sql_order_by_seq'>Amount</a>" . (($sql_order_by == 'amount') ? $order_icon : '') . "</th>
		<th><a href='$url" . $query_symbol . "sort_by=amount_paid&sort_seq=$sql_order_by_seq'>Paid</a>" . (($sql_order_by == 'amount_paid') ? $order_icon : '') . "</th>
		<th><a href='$url" . $query_symbol . "sort_by=amount_paid&sort_seq=$sql_order_by_seq'>Balance</a>" . (($sql_order_by == 'amount_paid') ? $order_icon : '') . "</th>
		<th class='icon-cell'></th>
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
    <title>DRIVER PAYROLL</title>
    <?php include('php/_head.php'); ?>
</head>
<body id='page-listing'>
    <?php include('php/_header.php'); ?>
    <section id='sub-menu'>
        <div class='left-block'><img src="images/icons/nav_drivers_payroll.png"> driver payroll</div>
        <div class='right-block'>
            ☢ <a href='driver_payroll_create.php' target='overlay-iframe' onclick='overlayOpen();'>Create Payrolls</a>
            &nbsp;
            ☷ <a href='driver_payroll_print.php' target='_blank'>Print</a>
        </div>
    </section>
    <div class='page-image' style='background-image:url(images/page-driver-payroll.jpg);'></div>
    <?php if (isset($message)) print $message; ?>
    <main>
        <section id='listing-forms'>
            <form id='dates_form' method='get'>
                Ending between
                <input name='date_from' type='date'
                    value='<?php if (isset($date_from)) { print $date_from; } else { print date('Y-m-d'); } ?>'> and
                <input name='date_to' type='date'
                    value='<?php if (isset($date_to)) { print $date_to; } else { print date('Y-m-d'); } ?>'>
                <?php
				if (isset($key_drivers)) print "<input name='driverid' type='hidden' value='$key_drivers'>";
				?>
                <input type='submit' value='Get'>
            </form>
            <form id='search_form' method='get'>
                <input name='search' type='text' placeholder='Payroll #'
                    <?php if (isset($search)) print "value='$search' autofocus"; ?> required>
                <?php
				if (isset($key_drivers)) print "<input name='driverid' type='hidden' value='$key_drivers'>";
				?>
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