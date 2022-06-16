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
				$directory_file = str_replace(".php", "", basename($directory_files[$i]));
				$first_part = explode("_", $directory_file)[0];
				if ($first_part != $heading) {
					$heading = $first_part;
					$permission_items_html .= "
						<div class='clear'></div>
						<h2>
							<div>". strtoupper($heading) . "</div>
							<div>
								<input type='button' value='Select all' onclick='checkBoxes(\"check\", \"$first_part\");'> 
								<input type='button' value='Un-select all' onclick='checkBoxes(\"\", \"$first_part\");'>
							</div>
						</h2>
						";
				}
				if (in_array($directory_file, $permission_items_array)) {
					$checked = 'checked';
				} else {
					$checked = '';
				}
				$permission_items_html .= "<div class='checkbox'><input type='checkbox' id='$directory_file' name='$directory_file' $checked> <label for='$directory_file'> $directory_file</label></div>";
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
			$message = "
				<div class='success-result'>Permissions saved successfully.</div>
				<br>
				<input type='button' value='Close' onclick='parent.closeOverlay2();'>
				";
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
    <title>STAFF - PERMISSIONS</title>
    <style>
    body {
        font-family: arial;
        font-size: 14px;
    }
    h2 {
        display: flex;
        justify-content: space-between;
        background-color: #DDD;
        text-align: center;
        padding: 5px 20px 5px 20px;
        margin: 10px 0 10px 0;
    }
    .checkbox {
        float: left;
        width: 350px;
    }
    .clear {
        clear: both;
    }
    #save_submit {
        position: fixed;
        z-index: 1000;
        right: 30px;
        bottom: 30px;
        width: auto;
        background-color: LightSeaGreen;
        color: white;
        padding: 10px;
        cursor: pointer;
    }
    </style>
    <script>
    function checkBoxes(option, first_part) {
        let boxes = document.querySelectorAll("input[type='checkbox']");
        for (i = 0; i < boxes.length; i++) {
            let checkbox_first_part = boxes[i].id;
            checkbox_first_part = checkbox_first_part.split("_")[0];
            if (checkbox_first_part == first_part) {
                if (option == "check") {
                    boxes[i].checked = true;
                } else {
                    boxes[i].checked = false;
                }
            }
        }
    }
    </script>
</head>
<body>
    <h1>Permissions: <?php print $first_name . ' ' . $last_name; ?></h1>
    <?php if (isset($message)) print $message; ?>
    <main>
        <?php if (isset($show_form) && $show_form) { ?>
        <form method='post'>
            <div>
                <?php print $permission_items_html; ?>
            </div>
            <input id='save_submit' name='save_submit' type='submit' value='Save'>
        </form>
        <div class='clear'><br></div>
        <?php } ?>
    </main>
</body>
</html>