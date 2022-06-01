
	// ----------------------------- SLIDER MENU
	var menu_hidden = 1;
	function menu_toggle() {
		if (menu_hidden == 1) {
			menu_hidden = 0;
			document.getElementsByTagName('nav')[0].style.bottom='50px';
			setTimeout(function(){ document.getElementById('nav_image').src = 'images/icons/nav_toggle_down.png'; }, 200);
			
		} else {
			menu_hidden = 1;
			document.getElementsByTagName('nav')[0].style.bottom='-100%';
			setTimeout(function(){ document.getElementById('nav_image').src = 'images/icons/nav_toggle_up.png'; }, 200);
		}
	}

	var record_menu_toggle = 1;
	function record_menu(menuid, toggle) {
		// hide any open menu
		var record_menus = document.querySelectorAll(".listing-table .record-menus ul");
		for (i = 0; i < record_menus.length; i++) record_menus[i].style.display = "none";
		var toggles = document.querySelectorAll(".listing-table .toggle");
		for (i = 0; i < toggles.length; i++) toggles[i].style.fontWeight = "400";
		// show passed menu
		if (record_menu_toggle == 1) {
			document.getElementById(menuid).style.display = "block";
			toggle.style.fontWeight = "900";
			record_menu_toggle = 0;
		} else {
			document.getElementById(menuid).style.display = "none";
			record_menu_toggle = 1;
		}
	}

	function hide_record_menus() { // called from menu-link's onclick
		var record_menus = document.querySelectorAll(".listing-table .record-menus ul");
		for (i = 0; i < record_menus.length; i++) record_menus[i].style.display = "none";
		var toggles = document.querySelectorAll(".listing-table .toggle");
		for (i = 0; i < toggles.length; i++) toggles[i].style.fontWeight = "400";
		record_menu_toggle = 1; // after a menu-link is clicked, this is reset to open next menu on a single click
	}


	// ----------------------------- OVERLAY
	function overlayOpen() {
		document.getElementById("overlay").style.display="block";
	}
		
	function closeOverlay() {
		document.getElementById('overlay').style.display='none';
		document.getElementById('overlay-iframe').src='';
	}

	function overlayOpen2() {
		document.getElementById("overlay2").style.display="block";
	}

	function closeOverlay2(param) {
		if (param == 'fromiframe') {
			parent.document.getElementById('overlay2').style.display='none';
			parent.document.getElementById('overlay-iframe2').src='';
		} else { // click on X, which is in main document
			document.getElementById('overlay2').style.display='none';
			document.getElementById('overlay-iframe2').src='';
		}
	}

	function overlayOpen3() {
		document.getElementById("overlay3").style.display="block";
	}

	function closeOverlay3(param) {
		if (param == 'fromiframe') {
			parent.document.getElementById('overlay3').style.display='none';
			parent.document.getElementById('overlay-iframe3').src='';
		} else { // click on X, which is in main document
			document.getElementById('overlay3').style.display='none';
			document.getElementById('overlay-iframe3').src='';
		}
	}


// ----------------------------- UNSELECT KEY VALUE
function unselectKeyValue(key_element, value_element) {
	document.getElementById(key_element).value = '0';
	document.getElementById(value_element).value = '';
}


function calc() {

	let rate_type = document.getElementById("rate_type").value;
	let hourly_regular_rate = parseFloat(document.getElementById("hourly_regular_rate").value);
	let regular_hours = parseFloat(document.getElementById("regular_hours").value);
	let regular_minutes = parseFloat(document.getElementById("regular_minutes").value);
	if (regular_minutes > 0) regular_hours += 1;
	let hourly_regular_amount = hourly_regular_rate * regular_hours;
	document.getElementById("hourly_regular_amount").value = hourly_regular_amount.toFixed(2);
	let hourly_wait_rate = parseFloat(document.getElementById("hourly_wait_rate").value);
	let wait_hours = parseFloat(document.getElementById("wait_hours").value);
	let wait_minutes = parseFloat(document.getElementById("wait_minutes").value);
	if (wait_minutes > 0) wait_hours += 1;
	let hourly_wait_amount = hourly_wait_rate * wait_hours;
	document.getElementById("hourly_wait_amount").value = hourly_wait_amount.toFixed(2);
	let hourly_overtime_rate = parseFloat(document.getElementById("hourly_overtime_rate").value);
	let overtime_hours = parseFloat(document.getElementById("overtime_hours").value);
	let overtime_minutes = parseFloat(document.getElementById("overtime_minutes").value);
	if (overtime_minutes > 0) overtime_hours += 1;
	let hourly_overtime_amount = hourly_overtime_rate * overtime_hours;
	document.getElementById("hourly_overtime_amount").value = hourly_overtime_amount.toFixed(2);

	let hourly_total_amount = hourly_regular_amount + hourly_wait_amount + hourly_overtime_amount;

	let zone_rate = parseFloat(document.getElementById("zone_rate").value);

	let base_amount = 0;
	if (rate_type == "Zone") {
		base_amount = zone_rate;
	} else if (rate_type == "Hourly") {
		base_amount = hourly_total_amount;
	}

	document.getElementById("base_amount").value = base_amount.toFixed(2);
	let offtime_type = parseFloat(document.getElementById("offtime_type").value);
	let offtime_amount = parseFloat(document.getElementById("offtime_amount").value);
	let extra_stops = parseFloat(document.getElementById("extra_stops").value);
	let extra_stops_amount = parseFloat(document.getElementById("extra_stops_amount").value);
	let toll_type = parseFloat(document.getElementById("toll_type").value);
	let tolls_amount = parseFloat(document.getElementById("tolls_amount").value);
	let parking_amount = parseFloat(document.getElementById("parking_amount").value);
	let gratuity_percent = parseFloat(document.getElementById("gratuity_percent").value);
	let gratuity_amount = gratuity_percent * base_amount / 100;
	document.getElementById("gratuity_amount").value = gratuity_amount.toFixed(2);

	let gas_surcharge_percent = parseFloat(document.getElementById("gas_surcharge_percent").value);
	let gas_surcharge_amount = gas_surcharge_percent * base_amount / 100;
	document.getElementById("gas_surcharge_amount").value = gas_surcharge_amount.toFixed(2);
	let admin_fee_percent = parseFloat(document.getElementById("admin_fee_percent").value);
	let admin_fee_amount = admin_fee_percent * base_amount / 100
	document.getElementById("admin_fee_amount").value = admin_fee_amount.toFixed(2);
	let discount_percent = parseFloat(document.getElementById("discount_percent").value);
	let discount_amount = discount_percent * base_amount / 100;
	document.getElementById("discount_amount").value = discount_amount.toFixed(2);
	let tax_percent = parseFloat(document.getElementById("tax_percent").value);
	let tax_amount = tax_percent * base_amount / 100;
	document.getElementById("tax_amount").value = tax_amount.toFixed(2);
  
  
	let trip_extra_charges = parseFloat(document.getElementById("trip_extra_charges").value);
	let total_trip_amount = (base_amount + offtime_amount + extra_stops_amount + tolls_amount + parking_amount + gratuity_amount + gas_surcharge_amount + admin_fee_amount + tax_amount + trip_extra_charges) - discount_amount;
	if (rate_type == "Flat") {
		document.getElementById("total_trip_amount").value = document.getElementById("flat_amount").value;
	} else {
		document.getElementById("total_trip_amount").value = total_trip_amount.toFixed(2);
	}
}