<?php 
include('php/_code.php');
$show_record = true;
if (isset($_GET['driverid'])) {
	$record_id = trim($_GET['driverid']);
	if (!is_numeric($record_id)) die('Invalid record id.');
	if (isset($_GET['delete'])) {
		$results = mysqli_query($dbcon, "DELETE FROM drivers WHERE key_drivers = $record_id");
		if ($results) {
			$message = "<div class='success-result'>Deleted successfully</div>
			<div class='center'><br><br><input type='button' value='Close' onclick='parent.location.reload(false);'></div>";
			$show_record = false;
		} else {
			$message = "<div class='failure-result'>Could not delete record</div>";
		}
	} else {
		$results = mysqli_query($dbcon, "SELECT username, first_name, last_name, contract_type FROM drivers WHERE key_drivers = $record_id");
		if ($row = mysqli_fetch_assoc($results)) {
			$username = $row['username'];
			$first_name = $row['first_name'];
			$last_name = $row['last_name'];
			$contract_type = $row['contract_type'];
		} else {
			$message = "<div class='failure-result'>Record not found</div>";
		}
	}
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>DRIVERS</title>
    <?php include('php/_head.php'); ?>
</head>
<body id='page-delete'>
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
                <td class='label-cell'>User name</td>
                <td class='value-cell'><?php if (isset($username)) print $username; ?></td>
            </tr>
            <tr>
                <td class='label-cell'>First name</td>
                <td class='value-cell'><?php if (isset($first_name)) print $first_name; ?></td>
            </tr>
            <tr>
                <td class='label-cell'>Last name</td>
                <td class='value-cell'><?php if (isset($last_name)) print $last_name; ?></td>
            </tr>
            <tr>
                <td class='label-cell'>Contract type</td>
                <td class='value-cell'><?php if (isset($contract_type)) print $contract_type; ?></td>
            </tr>
        </table>
    </main>
    <?php } // show_record ?>
    <?php include('php/_footer.php'); ?>
</body>
</html>