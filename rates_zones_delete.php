<?php 
include('php/_code.php');
$show_record = true;
if (isset($_GET['rates_zonesid'])) {
	$record_id = trim($_GET['rates_zonesid']);
	if (!is_numeric($record_id)) die('Invalid record id.');
	if (isset($_GET['delete'])) {
		$results = mysqli_query($dbcon, "DELETE FROM rates_zones WHERE key_rates_zones = $record_id");
		if ($results) {
			$message = "<script>parent.location.reload(false);</script>";
			$show_record = false;
		} else {
			$message = "<div class='failure-result'>Could not delete record</div>";
		}
	} else {
		$results = mysqli_query($dbcon, "SELECT * FROM rates_zones WHERE key_rates_zones = $record_id");
		if ($row = mysqli_fetch_assoc($results)) {
			$from_city = $row['from_city'];
			$from_state = $row['from_state'];
			$from_zip_code = $row['from_zip_code'];
			$to_city = $row['to_city'];
			$to_state = $row['to_state'];
			$to_zip_code = $row['to_zip_code'];
			$rate = $row['rate'];
			$tolls = $row['tolls'];
			$miles = $row['miles'];
			$active_status = $row['active_status'];
		} else {
			$message = "<div class='failure-result'>Record not found</div>";
		}
	}
}
?>
<!DOCTYPE html>
<html>
<head>
 <title>RATES ZONES</title>
 <?php include('php/_head.php'); ?>
</head>
<body id='page-delete' class='page_delete page_rates_zones_delete'>

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
         <br><hr><br>
     </div>

     <table class='record-table'>
         <tr>
         <td class='label-cell'>From city</td>
         <td class='value-cell'><?php if (isset($from_city)) print $from_city; ?></td>
         </tr>

         <tr>
         <td class='label-cell'>From state</td>
         <td class='value-cell'><?php if (isset($from_state)) print $from_state; ?></td>
         </tr>

         <tr>
         <td class='label-cell'>From zip code</td>
         <td class='value-cell'><?php if (isset($from_zip_code)) print $from_zip_code; ?></td>
         </tr>

         <tr>
         <td class='label-cell'>To city</td>
         <td class='value-cell'><?php if (isset($to_city)) print $to_city; ?></td>
         </tr>

         <tr>
         <td class='label-cell'>To state</td>
         <td class='value-cell'><?php if (isset($to_state)) print $to_state; ?></td>
         </tr>

         <tr>
         <td class='label-cell'>To zip code</td>
         <td class='value-cell'><?php if (isset($to_zip_code)) print $to_zip_code; ?></td>
         </tr>

         <tr>
         <td class='label-cell'>Rate</td>
         <td class='value-cell'><?php if (isset($rate)) print $rate; ?></td>
         </tr>

         <tr>
         <td class='label-cell'>Tolls</td>
         <td class='value-cell'><?php if (isset($tolls)) print $tolls; ?></td>
         </tr>

         <tr>
         <td class='label-cell'>Miles</td>
         <td class='value-cell'><?php if (isset($miles)) print $miles; ?></td>
         </tr>

         <tr>
         <td class='label-cell'>Status</td>
         <td class='value-cell'><?php if (isset($active_status)) print $active_status; ?></td>
         </tr>

     </table>

 </main>

 <?php } // show_record ?>


 <?php include('php/_footer.php'); ?>
</body>
</html>
