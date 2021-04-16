<?php
	function style_content() {
?>
#menu_button {
	display: none;
}
#home_menu a {
	padding: 0.5em;
	display: block;
	text-align: center;
	border-bottom: 1px solid #444547;
	text-decoration: none;
}
<?php
	}
	function header_content() {
?>
	<div id="header">
		<h2>BDO Barter Route Planner</h2>
	</div>
<?php
	}
	function body_content() {
?>
<div id="home_menu">
	<a href="/barter-routes">Barter Routes</a>
	<a href="/trade-items">Trade Items</a>
	<a href="/ship-building-materials">Ship Building Materials</a>
<?php if($_SESSION['admin']) { ?>
	<a href="/add-trade-item">Add Trade Item</a>
	<a href="/add-location">Add Location</a>
<?php } ?>
	<a href="/user">Your Profile</a>
	<a href="/?logout=true">Log Out</a>
</div>
<?php }