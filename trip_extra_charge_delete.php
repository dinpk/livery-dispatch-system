<?php 
include('php/_code.php');
$show_record = true;
if (isset($_GET['tripextrachargeid'])) {
	$record_id = trim($_GET['tripextrachargeid']);
	if (!is_numeric($record_id)) die('Invalid record id.');
	if (isset($_GET['delete'])) {
		$results = mysqli_query($dbcon, "DELETE FROM trip_extra_charges WHERE key_trip_extra_charges = $record_id");
		if ($results) {
			$message = "<script>parent.location.reload(false);</script>";
		} else {
			$message = "<div class='failure-result'>Could not delete record</div>";
		}
	} else {
		$results = mysqli_query($dbcon, "SELECT * FROM trip_extra_charges WHERE key_trip_extra_charges = $record_id");
		if ($row = mysqli_fetch_assoc($results)) {
			$category = $row['category'];
			$amount = $row['amount'];
			$notes = $row['notes'];
		} else {
			$message = "<div class='failure-result'>Record not found</div>";
		}
	}
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>TRIP - EXTRA CHARGES</title>
    <?php include('php/_head.php'); ?>
</head>
<body id='page-delete' class='foreign'>
    <?php if (isset($message)) print $message; ?>
    <?php if ($show_record) { ?>
    <main>
        <div class='center'>
            <p class='red'><b>Do you really want to delete this record?</b></p>
            <p>
                <br>
                <a class='button-big' href='<?php print $_SERVER['REQUEST_URI']; ?>&delete=1'>Delete</a> &nbsp
                <a class='button-big' href='#' onclick='parent.location.reload(false);'>Cancel</a><br>
            </p>
            <br>
            <hr><br>
        </div>
        <table class='record-table'>
            <tr>
                <td class='label-cell'>CATEGORY</td>
                <td class='value-cell'><?php if (isset($category)) print $category; ?></td>
            </tr>
            <tr>
                <td class='label-cell'>AMOUNT</td>
                <td class='value-cell'><?php if (isset($amount)) print $amount; ?></td>
            </tr>
            <tr>
                <td class='label-cell'>NOTES</td>
                <td class='value-cell'><?php if (isset($notes)) print $notes; ?></td>
            </tr>
        </table>
    </main>
    <?php } // show_record ?>
    <?php include('php/_footer.php'); ?>
</body>
</html>