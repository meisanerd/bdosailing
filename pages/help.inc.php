<?php
	function style_content() {
?>
#header {
	flex: 1;
}
h3 {
	margin-bottom: 0;
}
<?php
	}
	function header_content() {
?>
	<div id="header">
		<h2>Help</h2>
	</div>
<?php
	}
	function body_content() {
?>
<div style="padding: 1em">
	<h3>Barter Routes</h3>
	<p><strong>This page allows you to plan out your barter route and number of trades.</strong></p>
	<h4>Setting Up</h4>
	<ol>
		<li>Click on the Add Barter button</li>
		<li>Select the location, enter the number of trades you are going to be doing.</li>
		<li>Select the possible trade from the suggestions if it exists, or enter in the Per Trade details.  Load Trade Items and Unload Trade Items are special "items" indicating you are loading or unloading the item from storage.</li>
		<li>Save and Close. Repeat until all the trades you wish to do are in place.</li>
		<li>For convenience, you can load and unload all missing items by clicking "Actions", then "Add Missing Loads" or "Add Missing Unloads".</li>
		<li>Scroll the list looking for items highlighted in red.  These are instances where you will either be overweight or run out of parley.</li>
		<li>Sort items, or load/unload trade items to fix the overweight issue.</li>
	</ol>
	<h4>Running</h4>
	<ol>
		<li>When you complete the first barter, click on "Mark First Complete", or click on the barter and click "Complete".  This will update the "Trade Items" page by decreasing the "Barter Item", and increasing the "Result Item" by their respective quantities multipled by the number of trades.</li>
		<li>When all barters are complete, or if you click on the barter refresh in game, click on "Actions", then "Reset Barters" to set your ship weight and parley back to max.</li>
	</ol>
	<h3>Trade Items</h3>
	<p><strong>This page lists all of the trade items and shows you how many you currently have in stock.</strong></p>
	<div>
		You can use the top to filter by level and item name.<br />
		Click on an item to set the number of those you have in storage, as well as notes.
	</div>
	<h3>Ship Building Materials</h3>
	<p><strong>This page tracks all of the materials you have and need for building a boat.</strong></p>
	<div>
		Check off the box beside the boats you are saving materials for.<br />
		Enter in the number of each material you have and hit save.<br />
		You can use the summary button at the bottom to see an overview of all of the materials you need, and how many you have.<br />
		Material requirements are a worst-case scenario, it is assuming you are only getting 1 of the materials per process.
	</div>
	<h3>Profile</h3>
	<p><strong>This page allows you to change profile settings.</strong></p>
	<div>
		The boat weight is used on the Barter Routes page.<br />
		The value to be entered is the available weight of your boat when there are no trade items on board, but do have all of the parts (cannon, sails, etc) and sailors on board.
	</div>
</div>
<?php }