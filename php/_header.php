
	<a id='nav-toggle' href='#' onclick='menu_toggle();return false;'><img id='nav_image' src='images/icons/nav_toggle_up.png'></a>

	<header>
		<?php 
			$permission_items = $_SESSION["permission_items"];
			
			if (in_array("customer_passenger_listing", $permission_items)) 
				print "<a href='customer_passenger_listing.php' title='Passengers'><img src='images/icons/hed_passengers.png'></a>";
			if (in_array("trip_listing", $permission_items)) 
				print "<a href='trip_listing.php' title='Trips'><img src='images/icons/hed_trips.png'></a>";
			if (in_array("trip_conclude_listing", $permission_items)) 
				print "<a href='trip_conclude_listing.php' title='Conclude'><img src='images/icons/hed_conclude.png'></a>";
			if (in_array("trip_payroll_settlement_listing", $permission_items)) 
				print "<a href='trip_payroll_settlement_listing.php' title='Settle'><img src='images/icons/hed_settle.png'></a>";
			if (in_array("customer_invoice_listing", $permission_items)) 
				print "<a href='customer_invoice_listing.php' title='Invoices'><img src='images/icons/hed_bill.png'></a>";
			if (in_array("driver_listing", $permission_items)) 
				print "<a href='driver_listing.php' title='Drivers'><img src='images/icons/hed_drivers.png'></a>";
			if (in_array("vehicle_listing", $permission_items)) 
				print "<a href='vehicle_listing.php' title='Vehicles'><img src='images/icons/hed_vehicles.png'></a>";
			if (in_array("rate_zone_listing", $permission_items)) 
				print "<a href='rate_zone_listing.php' title='Zone Rates'><img src='images/icons/hed_rates_zones.png'></a>";
		?>
	</header>

	<nav>
		<ul>
			<?php
			if (in_array("trip_listing", $permission_items)) 
				print "<li><a href='trip_listing.php'><img src='images/icons/nav_trips.png'> Trips</a></li>";
			if (in_array("customer_passenger_listing", $permission_items)) 
				print "<li><a href='customer_passenger_listing.php'><img src='images/icons/nav_passengers.png'> Customer Passengers</a></li>";
			if (in_array("customer_contact_listing", $permission_items)) 
				print "<li><a href='customer_contact_listing.php'><img src='images/icons/nav_contacts.png'> Customer Contacts</a></li>";
			if (in_array("customer_company_listing", $permission_items)) 
				print "<li><a href='customer_company_listing.php'><img src='images/icons/nav_companies.png'> Customer Companies</a></li>";
			if (in_array("customer_billing_contact_listing", $permission_items)) 
				print "<li><a href='customer_billing_contact_listing.php'><img src='images/icons/nav_billing_contacts.png'> Customer Billing Contacts</a></li>";
			if (in_array("customer_rate_package_listing", $permission_items)) 
				print "<li><a href='customer_rate_package_listing.php'><img src='images/icons/nav_rate_packages.png'> Rate Packages</a></li>";
			if (in_array("trip_conclude_listing", $permission_items)) 
				print "<li><a href='trip_conclude_listing.php'><img src='images/icons/nav_conclude.png'> Conclude</a></li>";
			if (in_array("trip_payroll_settlement_listing", $permission_items)) 
				print "<li><a href='trip_payroll_settlement_listing.php'><img src='images/icons/nav_settle.png'> Settle</a></li>";
			if (in_array("customer_invoice_listing", $permission_items)) 
				print "<li><a href='customer_invoice_listing.php'><img src='images/icons/nav_bill.png'> Invoices</a></li>";
			if (in_array("driver_listing", $permission_items)) 
				print "<li><a href='driver_listing.php'><img src='images/icons/nav_drivers.png'> Drivers</a></li>";
			if (in_array("driver_payroll_listing", $permission_items)) 
				print "<li><a href='driver_payroll_listing.php'><img src='images/icons/nav_drivers_payroll.png'> Driver Payroll</a></li>";
			if (in_array("vehicle_listing", $permission_items)) 
				print "<li><a href='vehicle_listing.php'><img src='images/icons/nav_vehicles.png'> Vehicles</a></li>";
			if (in_array("rate_zone_listing", $permission_items)) 
				print "<li><a href='rate_zone_listing.php'><img src='images/icons/nav_zone_rates.png'> Zone Rates</a></li>";
			if (in_array("staff_listing", $permission_items)) 
				print "<li><a href='staff_listing.php'><img src='images/icons/nav_staff.png'> Staff</a></li>";
			if (in_array("staff_payroll_listing", $permission_items)) 
				print "<!-- <li><a href='staff_payroll_listing.php'><img src='images/icons/nav_staff_payroll.png'> Staff Payroll</a></li> -->";
			if (in_array("landmark_listing", $permission_items)) 
				print "<li><a href='landmark_listing.php'><img src='images/icons/nav_landmarks.png'> Landmarks</a></li>";
			if (in_array("settings", $permission_items)) 
				print "<li><a href='settings.php'><img src='images/icons/nav_settings.png'> Settings</a></li>";
			?>
		 </ul>
		 <hr>
		 <a href='logout.php'>Logout</a>
	</nav>
	
