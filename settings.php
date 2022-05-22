<?php 
include('php/_code.php');
?>
<!DOCTYPE html>
<html>
<head>
	<title>Settings</title>
	<?php include('php/_head.php'); ?>
</head>
<body id='page-settings'>
	<?php include('php/_header.php'); ?>
	<section id='sub-menu'>
		<div class='left-block'><img src="images/icons/nav_settings.png"> SETTINGS</div>
		<div class='right-block'></div>
	</section>

	<main>
		<section>
			<a href='settings_ad_source_values_listing.php'>
				<div><img src="images/icons/set_ad_source.png"></div>
				<h3>Ad Sources</h3>
				<p>How did the customer hear about us. Values are used in passenger profiles.</p>
			</a>
		</section>
		<section>
			<a href='settings_airline_values_listing.php'>
				<div><img src="images/icons/set_airlines.png"></div>
				<h3>Airlines</h3>
				<p>Used in passenger reservations along with flight numbers for tracking their arrival or departure.</p>
			</a>
		</section>
		<section>
			<a href='settings_dispatch_area_values_listing.php'>
				<div><img src="images/icons/set_dispatch_area.png"></div>
				<h3>Dispatch Areas</h3>
				<p>A dispatch area is where a different set of dispatchers and drivers operate. Values used in passenger trips.</p>
			</a>
		</section>
		<section>
			<a href='settings_extra_charges_values_listing.php'>
				<div><img src="images/icons/set_extra_charges.png"></div>
				<h3>Extra Charges</h3>
				<p>Additional charges to a trip like baby seat, newspaper or other items and services.</p>
			</a>
		</section>
		<section>
			<a href='settings_insurance_company_values_listing.php'>
				<div><img src="images/icons/set_insurance_companies.png"></div>
				<h3>Insurance Companies</h3>
				<p>Insurance providers for the fleet of the business. Values are used in vehicle profiles.</p>
			</a>
		</section>
		<section>
			<a href='settings_landmark_values_listing.php'>
				<div><img src="images/icons/set_landmarks.png"></div>
				<h3>Landmarks</h3>
				<p>Categories of the places visted frequently. Values are used in landmark profiles along with their addresses.</p>
			</a>
		</section>
		<section>
			<a href='settings_offtime_type_values_listing.php'>
				<div><img src="images/icons/set_off_time_types.png"></div>
				<h3>Off-time Types</h3>
				<p>Values that show if the trip was not during the regular hours i.e. early in the morning or late in the night.</p>
			</a>
		</section>
		<section>
			<a href='settings_payment_card_type_values_listing.php'>
				<div><img src="images/icons/set_payment_cards.png"></div>
				<h3>Payment Card Types</h3>
				<p>Such as credit cards or debit cards by different providers like Visa and Master etc. Values are used in passenger profiles.</p>
			</a>
		</section>
		<section>
			<a href='settings_payment_method_values_listing.php'>
				<div><img src="images/icons/set_payment_methods.png"></div>
				<h3>Payment Methods</h3>
				<p>Different methods of payment such as cash, check and credit card etc. Values are used in invoice or payroll payments.</p>
			</a>
		</section>
		<section>
			<a href='settings_state_values_listing.php'>
				<div><img src="images/icons/set_states.png"></div>
				<h3>States/Provinces</h3>
				<p>Values of different provinces and states used in the addresses of customers, staff, drivers and landmarks etc..</p>
			</a>
		</section>
		<section>
			<a href='settings_country_values_listing.php'>
				<div><img src="images/icons/set_countries.png"></div>
				<h3>Countries</h3>
				<p>Values of different countries  used in the addresses of customers, staff, drivers and landmarks etc.</p>
			</a>
		</section>
		<section>
			<a href='settings_toll_type_values_listing.php'>
				<div><img src="images/icons/set_toll_types.png"></div>
				<h3>Toll Types</h3>
				<p>How the toll amount was paid. Values like cash and ez-pass etc.</p>
			</a>
		</section>
		<section>
			<a href='settings_trips_save.php?settings_tripsid=1'  target='overlay-iframe' onclick='overlayOpen();'>
				<div><img src="images/icons/set_trip_values.png"></div>
				<h3>Trip Values</h3>
				<p>Values such as gas surcharge, admin fee etc.</p>
			</a>
		</section>
		<section>
			<a href='settings_trip_status_values_listing.php'>
				<div><img src="images/icons/set_trip_statuses.png"></div>
				<h3>Trip Statuses</h3>
				<p>What status the trip is currently in. Values such as dispatched, in-progress, completed are used during the trip.</p>
			</a>
		</section>
		<section>
			<a href='settings_trip_type_values_listing.php'>
				<div><img src="images/icons/set_trip_types.png"></div>
				<h3>Trip Types</h3>
				<p>What type of event this trip has reserved for such as corporate, wedding, game, movie, dinner etc.</p>
			</a>
		</section>
		<section>
			<a href='settings_vehicle_make_values_listing.php'>
				<div><img src="images/icons/set_vehicle_makes.png"></div>
				<h3>Vehicle Makes</h3>
				<p>List of vehicle manufacturers used in the industry. Values are used in vehicle profiles.</p>
			</a>
		</section>
		<section>
			<a href='settings_vehicle_model_values_listing.php'>
				<div><img src="images/icons/set_vehicle_models.png"></div>
				<h3>Vehicle Models</h3>
				<p>Different models of vehicles representing their categories or classes. Values are used in vehicle profiles.</p>
			</a>
		</section>
		<section>
			<a href='settings_vehicle_type_values_listing.php'>
				<div><img src="images/icons/set_vehicle_types.png"></div>
				<h3>Vehicle Types</h3>
				<p>Categories of the fleet of vehicles that the company has to offer. For example, sedan, stretch-limo, van, bus etc.</p>
			</a>
		</section>
		<section>
			<a href='settings_workshop_name_values_listing.php'>
				<div><img src="images/icons/set_workshops.png"></div>
				<h3>Workshops</h3>
				<p>Garages where the vehicles of the business are repared. Values are used in vehicle maintenance records.</p>
			</a>
		</section>
		<section>
			<a href='settings_staff_designation_values_listing.php'>
				<div><img src="images/icons/set_workshops.png"></div>
				<h3>Designations</h3>
				<p>Designations of staff such as management, dispatch, billing, tech support, etc.</p>
			</a>
		</section>
		<section>
			<a href='settings_company_save.php?settings_companyid=1' target='overlay-iframe' onclick='overlayOpen();'>
				<div><img src="images/icons/set_company.png"></div>
				<h3>Company</h3>
				<p>Profile of the company running this business. Information appears in company correspondence.</p>
			</a>
		</section>
		<section>
			<a href='settings_email_configuration_save.php?settings_email_configurationid=1' target='overlay-iframe' onclick='overlayOpen();'>
				<div><img src="images/icons/set_email_configuration.png"></div>
				<h3>Email Configuration</h3>
				<p>Settings of email account the business is using for the official correspondence.</p>
			</a>
		</section>
	</main>
	<?php include('php/_footer.php'); ?>
</body>
</html>
