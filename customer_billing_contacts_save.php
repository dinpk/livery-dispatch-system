<?php 
include('php/_code.php');
$show_form = true;
$focus_field = 'contact_name';
// id passed for update
if (isset($_GET['customer_billing_contactsid'])) {
	$record_id = trim($_GET['customer_billing_contactsid']);
	if (!is_numeric($record_id)) exit;
	if (!isset($_POST['save_submit'])) {
		$results = mysqli_query($dbcon, "SELECT * FROM customer_billing_contacts WHERE key_customer_billing_contacts = $record_id");
		if ($row = mysqli_fetch_assoc($results)) {
			$contact_name = $row['contact_name'];
			$card_type = $row['card_type'];
			$card_number = $row['card_number'];
			$card_expiration = $row['card_expiration'];
			$card_security_code = $row['card_security_code'];
			$name_on_card = $row['name_on_card'];
			$address1 = $row['address1'];
			$address2 = $row['address2'];
			$city = $row['city'];
			$state = $row['state'];
			$zip_code = $row['zip_code'];
			$confirmation_email = $row['confirmation_email'];
			$phone = $row['phone'];
			$notes = $row['notes'];
			$active_status = $row['active_status'];
		} else {
			$message = "<div class='failure-result'>Record not found</div>";
			$show_form = false;
		}
	}
}
// 'Save' button clicked
if (isset($_POST['save_submit'])) {
	$error = 0;
	$active_status = trim($_POST['active_status']);
	if (strlen($active_status) > 10) {
		$msg_active_status = "<div class='message-error'>Provide a valid value of length 0-10</div>";
		$focus_field = 'active_status';
		$error = 1;
	}
	$notes = trim($_POST['notes']);
	if (strlen($notes) > 2000) {
		$msg_notes = "<div class='message-error'>Provide a valid value of length 0-2000</div>";
		$focus_field = 'notes';
		$error = 1;
	}
	$phone = trim($_POST['phone']);
	if (strlen($phone) > 30) {
		$msg_phone = "<div class='message-error'>Provide a valid value of length 0-30</div>";
		$focus_field = 'phone';
		$error = 1;
	}
	$confirmation_email = trim($_POST['confirmation_email']);
	if (strlen($confirmation_email) > 100) {
		$msg_confirmation_email = "<div class='message-error'>Provide a valid value of length 0-100</div>";
		$focus_field = 'confirmation_email';
		$error = 1;
	}
	$zip_code = trim($_POST['zip_code']);
	if (strlen($zip_code) > 30) {
		$msg_zip_code = "<div class='message-error'>Provide a valid value of length 0-30</div>";
		$focus_field = 'zip_code';
		$error = 1;
	}
	$state = trim($_POST['state']);
	if (strlen($state) > 100) {
		$msg_state = "<div class='message-error'>Provide a valid value of length 0-100</div>";
		$focus_field = 'state';
		$error = 1;
	}
	$city = trim($_POST['city']);
	if (strlen($city) > 100) {
		$msg_city = "<div class='message-error'>Provide a valid value of length 0-100</div>";
		$focus_field = 'city';
		$error = 1;
	}
	$address2 = trim($_POST['address2']);
	if (strlen($address2) > 100) {
		$msg_address2 = "<div class='message-error'>Provide a valid value of length 0-100</div>";
		$focus_field = 'address2';
		$error = 1;
	}
	$address1 = trim($_POST['address1']);
	if (strlen($address1) > 100) {
		$msg_address1 = "<div class='message-error'>Provide a valid value of length 0-100</div>";
		$focus_field = 'address1';
		$error = 1;
	}
	$name_on_card = trim($_POST['name_on_card']);
	if (strlen($name_on_card) < 3 || strlen($name_on_card) > 100) {
		$msg_name_on_card = "<div class='message-error'>Provide a valid value of length 3-100</div>";
		$focus_field = 'name_on_card';
		$error = 1;
	}
	$card_security_code = trim($_POST['card_security_code']);
	if (strlen($card_security_code) > 20) {
		$msg_card_security_code = "<div class='message-error'>Provide a valid value of length 0-20</div>";
		$focus_field = 'card_security_code';
		$error = 1;
	}
	$card_expiration = trim($_POST['card_expiration']);
	if (strlen($card_expiration) > 10) {
		$msg_card_expiration = "<div class='message-error'>Provide a valid value of length 0-10</div>";
		$focus_field = 'card_expiration';
		$error = 1;
	}
	$card_number = trim($_POST['card_number']);
	if (strlen($card_number) > 100) {
		$msg_card_number = "<div class='message-error'>Provide a valid value of length 0-100</div>";
		$focus_field = 'card_number';
		$error = 1;
	}
	$card_type = trim($_POST['card_type']);
	if (strlen($card_type) < 3 || strlen($card_type) > 50) {
		$msg_card_type = "<div class='message-error'>Provide a valid value of length 3-50</div>";
		$focus_field = 'card_type';
		$error = 1;
	}
	$contact_name = trim($_POST['contact_name']);
	if (strlen($contact_name) < 3 || strlen($contact_name) > 100) {
		$msg_contact_name = "<div class='message-error'>Provide a valid value of length 3-100</div>";
		$focus_field = 'contact_name';
		$error = 1;
	}
	// no validation error
	if ($error == 0) {
		if (isset($record_id) && $error != 1) { // update
			$results = mysqli_query($dbcon, "UPDATE customer_billing_contacts SET 
			contact_name = '" . sd($dbcon, $contact_name) . "',
			card_type = '" . sd($dbcon, $card_type) . "',
			card_number = '" . sd($dbcon, $card_number) . "',
			card_expiration = '" . sd($dbcon, $card_expiration) . "',
			card_security_code = '" . sd($dbcon, $card_security_code) . "',
			name_on_card = '" . sd($dbcon, $name_on_card) . "',
			address1 = '" . sd($dbcon, $address1) . "',
			address2 = '" . sd($dbcon, $address2) . "',
			city = '" . sd($dbcon, $city) . "',
			state = '" . sd($dbcon, $state) . "',
			zip_code = '" . sd($dbcon, $zip_code) . "',
			confirmation_email = '" . sd($dbcon, $confirmation_email) . "',
			phone = '" . sd($dbcon, $phone) . "',
			notes = '" . sd($dbcon, $notes) . "',
			active_status = '" . sd($dbcon, $active_status) . "'
				WHERE key_customer_billing_contacts = $record_id");
			if ($results) {
				$message = "<script>parent.location.reload(false);</script>";
			} else {
				//print mysqli_error($dbcon);
				die('Unable to update, please contact your system administrator.');
			}
		} else if ($error != 1) { // insert
			$results = mysqli_query($dbcon, "INSERT INTO customer_billing_contacts (
			contact_name,
			card_type,
			card_number,
			card_expiration,
			card_security_code,
			name_on_card,
			address1,
			address2,
			city,
			state,
			zip_code,
			confirmation_email,
			phone,
			notes,
			active_status
			) 
			VALUES (
			'" . sd($dbcon, $contact_name) . "',
			'" . sd($dbcon, $card_type) . "',
			'" . sd($dbcon, $card_number) . "',
			'" . sd($dbcon, $card_expiration) . "',
			'" . sd($dbcon, $card_security_code) . "',
			'" . sd($dbcon, $name_on_card) . "',
			'" . sd($dbcon, $address1) . "',
			'" . sd($dbcon, $address2) . "',
			'" . sd($dbcon, $city) . "',
			'" . sd($dbcon, $state) . "',
			'" . sd($dbcon, $zip_code) . "',
			'" . sd($dbcon, $confirmation_email) . "',
			'" . sd($dbcon, $phone) . "',
			'" . sd($dbcon, $notes) . "',
			'" . sd($dbcon, $active_status) . "'
			)");
			if ($results) {
				$message = "<script>parent.location.reload(false);</script>";
			} else {
				if (strpos(mysqli_error($dbcon), "Duplicate") > -1) {
					$message = "<div class='failure-result'>" . mysqli_error($dbcon) . "</div>";
					$error = 1;
				} else {
					die('Unable to add, please contact your system administrator.');
				}
			}
		}	
	}
	if ($error == 0) $show_form = false;
}
?>
<!DOCTYPE html>
<html>

<head>
    <title>CUSTOMER BILLING CONTACTS</title>
    <?php include('php/_head.php'); ?>
</head>

<body id='page-save' class='page_save page_customer_billing_contacts_save'>

    <section id='sub-menu'>
        <div class='left-block'>customer billing contacts</div>
        <div class='right-block'>

        </div>
    </section>

    <?php if (isset($message)) print $message; ?>

    <main>

        <?php if (isset($show_form) && $show_form) { ?>
        <form method='post'>
            <fieldset>


                <div>
                    <label for='contact_name'>Contact name</label> <span class='red'> *</span>
                    <?php if(isset($msg_contact_name)) print $msg_contact_name; ?>
                    <input id='contact_name' name='contact_name' type='text'
                        value='<?php if (isset($contact_name)) {print $contact_name;} else { print '';} ?>'
                        required><br>
                </div>

                <div>
                    <label for='card_type'>Card type</label> <span class='red'> *</span><br>
                    <?php if(isset($msg_card_type)) print $msg_card_type; ?>
                    <select id='card_type' name='card_type' required>
                        <?php 
						$options = '';
						
						$results = mysqli_query($dbcon, 'SELECT payment_card_type FROM settings_payment_card_type_values');
						while ($row = mysqli_fetch_assoc($results)) {
							$selection = '';
							if ($row['payment_card_type'] == $card_type) $selection = "selected='selected'";
								$options .= "<option $selection>" . $row['payment_card_type'] . "</option>";
						}
						print $options; 
						?>
                    </select>
                </div>

                <div>
                    <label for='card_number'>Card #</label> <span class='red'> *</span>
                    <?php if(isset($msg_card_number)) print $msg_card_number; ?>
                    <input id='card_number' name='card_number' type='text'
                        value='<?php if (isset($card_number)) {print $card_number;} else { print '';} ?>' required><br>
                </div>

                <div>
                    <label for='card_expiration'>Expiration</label>
                    <?php if(isset($msg_card_expiration)) print $msg_card_expiration; ?>
                    <input id='card_expiration' name='card_expiration' type='text'
                        value='<?php if (isset($card_expiration)) {print $card_expiration;} else { print '';} ?>'><br>
                </div>

                <div>
                    <label for='card_security_code'>Security code</label>
                    <?php if(isset($msg_card_security_code)) print $msg_card_security_code; ?>
                    <input id='card_security_code' name='card_security_code' type='text'
                        value='<?php if (isset($card_security_code)) {print $card_security_code;} else { print '';} ?>'><br>
                </div>

                <div>
                    <label for='name_on_card'>Name on card</label> <span class='red'> *</span>
                    <?php if(isset($msg_name_on_card)) print $msg_name_on_card; ?>
                    <input id='name_on_card' name='name_on_card' type='text'
                        value='<?php if (isset($name_on_card)) {print $name_on_card;} else { print '';} ?>'
                        required><br>
                </div>

            </fieldset>

            <fieldset>

                <div>
                    <label for='confirmation_email'>Confirmation email</label>
                    <?php if(isset($msg_confirmation_email)) print $msg_confirmation_email; ?>
                    <input id='confirmation_email' name='confirmation_email' type='email'
                        value='<?php if (isset($confirmation_email)) {print $confirmation_email;} else { print '';} ?>'><br>
                </div>

                <div>
                    <label for='phone'>Phone</label>
                    <?php if(isset($msg_phone)) print $msg_phone; ?>
                    <input id='phone' name='phone' type='tel'
                        value='<?php if (isset($phone)) {print $phone;} else { print '';} ?>'><br>
                </div>

                <div>
                    <label for='address1'>Address 1</label>
                    <?php if(isset($msg_address1)) print $msg_address1; ?>
                    <input id='address1' name='address1' type='text'
                        value='<?php if (isset($address1)) {print $address1;} else { print '';} ?>'><br>
                </div>

                <div>
                    <label for='address2'>Address 2</label>
                    <?php if(isset($msg_address2)) print $msg_address2; ?>
                    <input id='address2' name='address2' type='text'
                        value='<?php if (isset($address2)) {print $address2;} else { print '';} ?>'><br>
                </div>

                <div>
                    <label for='city'>City</label>
                    <?php if(isset($msg_city)) print $msg_city; ?>
                    <input id='city' name='city' type='text'
                        value='<?php if (isset($city)) {print $city;} else { print '';} ?>'><br>
                </div>

                <div>
                    <label for='state'>State</label><br>
                    <?php if(isset($msg_state)) print $msg_state; ?>
                    <input id='state' name='state' list='list_state'
                        value='<?php if (isset($state)) {print $state;} ?>'><br>
                    <datalist id='list_state'>
                        <?php 
						$options = '';
						
						$results = mysqli_query($dbcon, 'SELECT state FROM values_state');
						while ($row = mysqli_fetch_assoc($results)) {
							$options .= "<option value='" . $row['state'] . "'>";
						}
						print $options; 
						?>
                    </datalist>
                </div>

                <div>
                    <label for='zip_code'>Zip code</label>
                    <?php if(isset($msg_zip_code)) print $msg_zip_code; ?>
                    <input id='zip_code' name='zip_code' type='text'
                        value='<?php if (isset($zip_code)) {print $zip_code;} else { print '';} ?>'><br>
                </div>

                <div>
                    <label for='notes'>Notes</label>
                    <?php if(isset($msg_notes)) print $msg_notes; ?>
                    <textarea id='notes' name='notes'><?php if (isset($notes)) print $notes; ?></textarea><br>
                </div>

                <div>
                    <?php if(isset($msg_active_status)) print $msg_active_status; ?>
                    <input <?php if (!isset($active_status) || $active_status=='on') {print "checked='checked'";} ?>
                        type='checkbox' id='active_status' name='active_status'> <label
                        for='active_status'>Status</label><br>
                </div>

            </fieldset>

            <input id='save_submit' name='save_submit' type='submit' value='Save'>


        </form>
        <?php } ?>

    </main>
    <?php include('php/_footer.php'); ?>

</body>

</html>