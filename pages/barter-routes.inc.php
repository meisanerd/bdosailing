<?php
	function handle_post() {
		if(isset($_POST['reset_barters']) && intval($_POST['reset_barters'])) {
			global $db;
			$db->setQuery('DELETE FROM `trades` WHERE `user_id`=%d');
			$db->runQuery($_SESSION['user']);
			$db->setQuery('UPDATE `users` SET `parley`=1000000, `current_weight`=`weight` WHERE `id`=%d');
			$db->runQuery($_SESSION['user']);
		}
	}
	function style_content() {
?>
#complete_button {
	flex: none;
	width: 60px;
}
#complete {
	height: 50px;
}
#parley_container {
	flex: 1;
}
#parley_container span {
	width: 60px;
	display: inline-block;
}
#parley_container input {
	width: 100px;
	padding: 0.25em;
	margin-top: 0.25em;
}
#trades {
	flex: 1;
	overflow: auto;
}
.trade {
	padding: 5px;
	border-bottom: 1px solid #444547;
}
.trade.overweight, .trade.noparley {
	background: #AA0000;
}
.sort_block {
	float: left;
	width: 50px;
	height: 70px;
	margin-right: 5px;
	border: 1px solid #444547;
	text-align: center;
	line-height: 35px;
}
.sort_block button {
	width: 45px;
	height: 25px;
}
#bottom_container {
	flex: none;
	display: flex;
	height: 33px;
	background: #735B39;
	color: #FFEDD2;
}
#bottom_container .noflex {
	flex: none;
}
#bottom_container .spacer {
	flex: 1;
}
#bottom_container button, #action_dialog button {
	padding: 5px;
	margin: 3px;
}
#trades .data .id, #trades .data .num, #trades .data .parley, #trades .data .weight {
	display: none;
}
#trade_dialog {
	position: fixed;
	top: 0;
	left: 0;
	width: 100%;
	height: 100%;
	background: #1D1D1F;
	display: none;
	flex-direction: column;
}
#trade_top_container {
	flex: none;
	display: flex;
	flex-direction: row;
	padding: 0 0.5em;
	height: 60px;
	background: #735B39;
	color: #FFEDD2;
}
#trade_contents {
	flex: 1;
	min-height: 0;
	overflow: auto;
	padding: 1em;
}
#trade_contents input, #trade_contents select {
	width: 250px;
	box-sizing: border-box;
}
#trade_contents .suggestion {
	padding: 0.5em;
	display: block;
	text-align: center;
	border-bottom: 1px solid #444547;
	text-decoration: none;
}
#trade_contents .suggestions {
	max-height: 150px;
	overflow: auto;
}
#trade_contents .suggestion:last-child {
	border-bottom: none;
}
#trade_dialog button {
	font-size: 16px;
	margin: 0 0.25em;
}
#action_dialog {
	position: fixed;
	bottom: 33px;
	right: 0;
	background: #735B39;
	color: #FFEDD2;
	display: none;
	padding: 5px;
	border-bottom: 1px solid #444547;
	text-align: center;
}
#action_dialog button {
	width: 100%;
}
<?php
	}
	function header_content() {
		global $db;
		$db->setQuery('SELECT `parley`,`current_weight`,`weight` FROM `users` WHERE `id`=%d');
		$db->runQuery($_SESSION['user']);
		$userdata = $db->getResult();
		if(!intval($userdata->weight)) {
			global $errors;
			$errors[] = 'Please set your Available Boat Weight in your <a href="/user">Profile</a>.';
		}
?>
	<div id="parley_container">
		<div><span>Parley:</span> <input type="text" id="parley" value="<?=$userdata->parley?>" /></div>
		<div><span>Weight:</span> <input type="text" id="weight" value="<?=$userdata->current_weight?>" /></div>
	</div>
	<div id="complete_button">
		<button id="complete">Mark First Complete</button>
	</div>
<?php
	}
	function body_content() {
		global $db;
		require_once('templates/barter.php');
?>
<div id="trades">
<?php
		$db->setQuery('SELECT * FROM `trades` WHERE `user_id`=%d ORDER BY `pos` ASC, `id` ASC');
		$db->runQuery($_SESSION['user']);
		$trades = $db->getResults();
		$db->setQuery('SELECT `id`,`name` FROM `trade_locations`');
		$db->runQuery();
		$locations = $db->getResultsSingleIndexed();
		$db->setQuery('SELECT * FROM `trade_items`');
		$db->runQuery();
		$trade_items = $db->getResultsIndexed();
		foreach($trades as $trade) {
			barter($trade, $locations, $trade_items);
		}
?>
</div>
<div id="action_dialog">
	<button id="add_loads">Add Missing Loads</button><br />
	<button id="add_unloads">Add Missing Unloads</button>
	<form action="/barter-routes" method="post" class="noflex">
		<button type="submit" name="reset_barters" id="reset_barters" value="1">Reset Barters</button>
	</div>
</div>
<div id="bottom_container">
	<div class="noflex">
		<button id="add_trade" data-id="0">Add Barter</button>
	</div>
	<div class="spacer"></div>
	<div class="noflex">
		<button id="action_dialog_button">Actions</button>
	</div>
</div>
<div id="trade_dialog"></div>
<?php
	}