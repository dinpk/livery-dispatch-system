<?php 
include('php/_code.php');
$show_record = true;
if (isset($_GET['vehicleid'])) {
	$record_id = trim($_GET['vehicleid']);
	if (!is_numeric($record_id)) die('Invalid record id.');
	if (isset($_GET['delete'])) {
		$results = mysqli_query($dbcon, "DELETE FROM vehicles WHERE key_vehicles = $record_id");
		if ($results) {
			$message = "<div class='success-result'>Deleted successfully</div>
			<div class='center'><br><br><input type='button' value='Close' onclick='parent.location.reload(false);'></div>";
			$show_record = false;
		} else {
			$message = "<div class='failure-result'>Could not delete record</div>";
		}
	} else {
		$results = mysqli_query($dbcon, "SELECT * FROM vehicles WHERE key_vehicles = $record_id");
		if ($row = mysqli_fetch_assoc($results)) {
			$fleet_number = $row['fleet_number'];
			$vehicle_type = $row['vehicle_type'];
			$tag = $row['tag'];
			$vin_number = $row['vin_number'];
			$year_made = $row['year_made'];
			$model = $row['model'];
			$max_seats = $row['max_seats'];
			$color = $row['color'];

		} else {
			$message = "<div class='failure-result'>Record not found</div>";
		}
	}
}
?>
<!DOCTYPE html>
<html>

<head>
    <title>VEHICLE - DELETE</title>
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
                <td class='label-cell'>Fleet #</td>
                <td class='value-cell'><?php if (isset($fleet_number)) print $fleet_number; ?></td>
            </tr>
            <tr>
                <td class='label-cell'>Vehicle type</td>
                <td class='value-cell'><?php if (isset($vehicle_type)) print $vehicle_type; ?></td>
            </tr>
            <tr>
                <td class='label-cell'>Tag</td>
                <td class='value-cell'><?php if (isset($tag)) print $tag; ?></td>
            </tr>
            <tr>
                <td class='label-cell'>Vin #</td>
                <td class='value-cell'><?php if (isset($vin_number)) print $vin_number; ?></td>
            </tr>
            <tr>
                <td class='label-cell'>Year</td>
                <td class='value-cell'><?php if (isset($year_made)) print $year_made; ?></td>
            </tr>
            <tr>
                <td class='label-cell'>Model</td>
                <td class='value-cell'><?php if (isset($model)) print $model; ?></td>
            </tr>
            <tr>
                <td class='label-cell'>Max seats</td>
                <td class='value-cell'><?php if (isset($max_seats)) print $max_seats; ?></td>
            </tr>
            <tr>
                <td class='label-cell'>Color</td>
                <td class='value-cell'><?php if (isset($color)) print $color; ?></td>
            </tr>

        </table>
    </main>
    <?php } // show_record ?>
    <?php include('php/_footer.php'); ?>
</body>
</html>