<?php
	function style_content() {
?>
#filters {
	flex: 1;
}
#trade_items {
	flex: 1;
	overflow: auto;
}
#filters input, #filters select {
	width: 100%;
	padding: 0.25em;
	margin-top: 0.25em;
	box-sizing: border-box;
}
.trade_item {
	padding: 5px;
	border-bottom: 1px solid #444547;
}
.color_block {
	float: left;
	width: 40px;
	height: 40px;
	margin-right: 5px;
	border: 1px solid #444547;
	text-align: center;
	color: #000000;
	line-height: 40px;
}
.data {
	float: left;
}
.data .notes {
	display: none;
}
.level_1 .color_block {
	background: #FFFFFF;
}
.level_2 .color_block {
	background: #00FF00;
}
.level_3 .color_block {
	background: #3C99DC;
}
.level_4 .color_block {
	background: #BBBB00;
}
.level_5 .color_block {
	background: #996600;
}
#trade_item_dialog {
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
	overflow: auto;
	padding: 1em;
}
#item_name {
	text-align: center;
}
#item_notes {
	width: 100%;
	box-sizing: border-box;
}
#trade_item_dialog button {
	font-size: 16px;
	margin: 0 0.25em;
}
.count_buttons {
	margin-bottom: 1em;
}
.count_buttons button {
	width: 30px;
	height: 30px;
}
.count_buttons div {
	display: inline-block;
}
<?php
	}
	function header_content() {
?>
	<div id="filters">
		<div>
			<select id="level">
				<option value="0">All</option>
				<option value="1">Level 1 - White</option>
				<option value="2">Level 2 - Green</option>
				<option value="3">Level 3 - Blue</option>
				<option value="4">Level 4 - Yellow</option>
				<option value="5">Level 5 - Orange</option>
			</select>
		</div>
		<div>
			<input type="text" id="name" />
		</div>
	</div>
<?php
	}
	function body_content() {
		global $db;
?>
<div id="trade_items">
<?php
	$db->setQuery('SELECT * FROM `trade_items` WHERE `level` > 0 ORDER BY `level` ASC, `name` ASC');
	$db->runQuery();
	$trade_items = $db->getResults();
	$db->setQuery('SELECT * FROM `user_trade_items` WHERE `user_id`=%d');
	$db->runQuery($_SESSION['user']);
	$user_trade_items = $db->getResultsIndexed('trade_item_id');
	foreach($trade_items as $trade_item) {
		if(!isset($user_trade_items[$trade_item->id])) {
			$user_trade_items[$trade_item->id] = new stdClass();
			$user_trade_items[$trade_item->id]->num = 0;
			$user_trade_items[$trade_item->id]->notes = '';
		}
?>
	<div id="trade_item_<?=$trade_item->id?>" class="trade_item level_<?=$trade_item->level?>">
		<div class="color_block"><?=$trade_item->level?></div>
		<div class="data">
			<div class="name"><?=$trade_item->name?></div>
			<small class="count"><?=intval($user_trade_items[$trade_item->id]->num)?></small>
			<div class="notes"><?=$user_trade_items[$trade_item->id]->notes?></div>
		</div>
		<div style="clear: both"></div>
	</div>
<?php } ?>
</div>
<div id="trade_item_dialog">
	<div id="trade_top_container">
		<h2 id="item_name"></h2>
	</div>
	<div id="trade_contents">
		<div style="text-align: center" class="count_buttons">
			<button id="item_count_decrease">-</button>
			<div id="item_count"></div>
			<button id="item_count_increase">+</button>
		</div>
		<textarea id="item_notes" rows="4" cols="40"></textarea>
		<div style="text-align: center; margin-top: 1em;">
			<button id="trade_item_save">Save</button>
			<button id="trade_item_save_close">Save and Close</button>
			<button id="trade_item_close">Close</button>
		</div>
	</div>
</div>
<?php
	}