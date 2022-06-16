<?php 
include('php/_code.php');
if (isset($_GET['customer_address_bookid'])) {
	$record_id = trim($_GET['customer_address_bookid']);
	if (!is_numeric($record_id)) die('Invalid record id.');
	$results = mysqli_query($dbcon, "SELECT * FROM customer_address_book WHERE key_customer_address_book = $record_id");
	if ($row = mysqli_fetch_assoc($results)) {
		$title = $row['title'];
		$category = $row['category'];
		$address1 = $row['address1'];
		$address2 = $row['address2'];
		$city = $row['city'];
		$state = $row['state'];
		$zip_code = $row['zip_code'];
		$image_url = $row['image_url'];
		$notes = $row['notes'];
	} else {
		$message = "<div class='failure-result'>Record not found</div>";
	}
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>CUSTOMER ADDRESS BOOK</title>
    <?php include('php/_head.php'); ?>
</head>
<body id='page-view' class='foreign'>
    <?php if (isset($message)) print $message; ?>
    <main>
        <table class='record-table'>
            <tr>
                <td class='label-cell'>TITLE</td>
                <td class='value-cell'><?php if (isset($title)) print $title; ?></td>
            </tr>
            <tr>
                <td class='label-cell'>CATEGORY</td>
                <td class='value-cell'><?php if (isset($category)) print $category; ?></td>
            </tr>
            <tr>
                <td class='label-cell'>ADDRESS1</td>
                <td class='value-cell'><?php if (isset($address1)) print $address1; ?></td>
            </tr>
            <tr>
                <td class='label-cell'>ADDRESS2</td>
                <td class='value-cell'><?php if (isset($address2)) print $address2; ?></td>
            </tr>
            <tr>
                <td class='label-cell'>CITY</td>
                <td class='value-cell'><?php if (isset($city)) print $city; ?></td>
            </tr>
            <tr>
                <td class='label-cell'>STATE</td>
                <td class='value-cell'><?php if (isset($state)) print $state; ?></td>
            </tr>
            <tr>
                <td class='label-cell'>ZIP CODE</td>
                <td class='value-cell'><?php if (isset($zip_code)) print $zip_code; ?></td>
            </tr>
            <tr>
                <td class='label-cell'>IMAGE URL</td>
                <td class='image-cell'><?php if (isset($image_url)) print "<img src='$image_url'>"; ?></td>
            </tr>
            <tr>
                <td class='label-cell'>NOTES</td>
                <td class='value-cell'><?php if (isset($notes)) print $notes; ?></td>
            </tr>
        </table>
    </main>
    <?php include('php/_footer.php'); ?>
</body>
</html>