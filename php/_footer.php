	
	<div id="overlay">
		<div id="overlay-div">
			<div id="div-close-link"><a href="#" onclick="closeOverlay();">X</a></div>
			<iframe id="overlay-iframe" name="overlay-iframe"></iframe>
		</div>
	</div>
	<div id="overlay2">
		<div id="overlay-div2">
			<div id="div-close-link2"><a href="#" onclick="closeOverlay2('notfromiframe');">X</a></div>
			<iframe id="overlay-iframe2" name="overlay-iframe2"></iframe>
		</div>
	</div>
	<div id="overlay3">
		<div id="overlay-div3">
			<div id="div-close-link3"><a href="#" onclick="closeOverlay3('notfromiframe');">X</a></div>
			<iframe id="overlay-iframe3" name="overlay-iframe3"></iframe>
		</div>
	</div>

	<?php
		if (isset($focus_field) && !empty($focus_field)) {
			print "
			<script>
				let element = document.getElementById('$focus_field');
				if (element) {
					element.focus()
				}
			</script>";
		}
	?>
