<?php 
include('php/_code.php');
$show_form = true;
$directory_files = glob("*.php");

if (isset($_GET['staffid'])) {
	$record_id = trim($_GET['staffid']);
	if (!is_numeric($record_id)) exit;
	if (!isset($_POST['save_submit'])) {
		$results = mysqli_query($dbcon, "SELECT first_name, last_name, permission_items FROM staff WHERE key_staff = $record_id");
		if ($row = mysqli_fetch_assoc($results)) {
			$first_name = $row['first_name'];
			$last_name = $row['last_name'];
			$permission_items_array = json_decode($row['permission_items']);
			$permission_items_html = '';

			$heading = '';
			for ($i = 0; $i < sizeof($directory_files); $i++) {
				$directory_file = basename($directory_files[$i]);
				$directory_file = str_replace(".php", "", $directory_file);
				
				$first_part = explode("_", $directory_file)[0];
				if ($first_part != $heading) {
					$heading = $first_part;
					$permission_items_html .= "<h2>". strtoupper($heading) . "</h2>";
				}

				if (in_array($directory_file, $permission_items_array)) {
					$checked = 'checked';
				} else {
					$checked = '';
				}
				$permission_items_html .= "<input type='checkbox' name='$directory_file' $checked> $directory_file<br>";
			}
		} else {
			$message = "<div class='failure-result'>Record not found</div>";
		}
	}
}

if (isset($_POST['save_submit'])) {
	
	$error = 0;

	$checked_items_array = array();
	for ($i = 0; $i < sizeof($directory_files); $i++) {
		$base_name = basename($directory_files[$i]);
		$base_name = str_replace(".php", "", $base_name);
		if (array_key_exists($base_name, $_POST)) {
			$checked_items_array[] = $base_name;
		}
	}

	$permissions_data = json_encode($checked_items_array);



	if (isset($record_id)) {
		$results = mysqli_query($dbcon, "UPDATE staff SET permission_items = '$permissions_data' WHERE key_staff = $record_id");
		if ($results) {
			$message = "<div class='success-result'>Permissions saved successfully.</div>";
			$show_form = false;
		} else {
			die('Unable to update, please contact your system administrator.');
		}
	}

}
?>
<!DOCTYPE html>
<html>

<head>
    <title>STAFF PERMISSIONS</title>
    <script>
    function checkBoxes(option) {
        var boxes = document.querySelectorAll("input[type='checkbox']");
        if (option == "check") {
            for (i = 0; i < boxes.length; i++) {
                boxes[i].checked = true;
            }
        } else {
            for (i = 0; i < boxes.length; i++) {
                boxes[i].checked = false;
            }
        }
    }
    </script>
</head>

<body>
    <h2>Permissions: <?php print $first_name . ' ' . $last_name; ?></h2>
    <?php if (isset($message)) print $message; ?>

    <main>


		<?php if (isset($show_form) && $show_form) { ?>
        <form method='post'>

            <p>
                <input type="button" value="Select all" onclick="checkBoxes('check');"> <input type="button"
                    value="Un-select all" onclick="checkBoxes('');">
            </p>
            <hr>

            <div>
                <?php print $permission_items_html; ?>
            </div>
            <hr>
            <p>
                <input id='save_submit' name='save_submit' type='submit' value='Save'>
            </p>

        </form>
		<?php } ?>

    </main>

</body>

</html>