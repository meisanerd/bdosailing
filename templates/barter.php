<?php
	function barter($trade, $locations = false, $items = false) {
		global $db;
		if(!$locations) {
			$db->setQuery('SELECT `id`,`name` FROM `trade_locations` WHERE `id`=%d');
			$db->runQuery($trade->location_id);
			$locations = $db->getResultsSingleIndexed();
		}
		$location = $locations[$trade->location_id];
		if(!$items) {
			$db->setQuery('SELECT * FROM `trade_items` WHERE `id`=%d OR `id`=%d ORDER BY `level` ASC, `name` ASC');
			$db->runQuery($trade->input_id, $trade->output_id);
			$items = $db->getResultsIndexed();
		}
		$input_item = $items[$trade->input_id];
		$input = $input_item->name;
		if($input_item->level) {
			$input = '[Level ' . $input_item->level . '] ' . $input;
		}
		$output_item = $items[$trade->output_id];
		$output = $output_item->name;
		if($output_item->level) {
			$output = '[Level ' . $output_item->level . '] ' . $output;
		}
?>
<div data-id="<?=$trade->id?>" data-num="<?=$trade->num?>" data-parley="<?=$trade->parley?>" id="trade_<?=$trade->id?>" class="trade">
	<div class="sort_block">
		<button class="sort_up">Up</button>
		<button class="sort_down">Down</button>
	</div>
	<div class="data">
		<div class="location" data-id="<?=$trade->location_id?>"><strong><span class="name"><?=$location?></span></strong> (<?=$trade->num?> trade<?=$trade->num==1?'':'s'?>)</div>
		<div class="input" data-id="<?=$trade->input_id?>" data-weight="<?=$input_item->weight?>" data-qty="<?=$trade->input_qty?>"><span class="qty"><?=$trade->input_qty?> (<?=$trade->input_qty*$trade->num?>)</span> <span class="name"><?=$input?></span></div>
		<div class="output" data-id="<?=$trade->output_id?>" data-weight="<?=$output_item->weight?>" data-qty="<?=$trade->output_qty?>"><span class="qty"><?=$trade->output_qty?> (<?=$trade->output_qty*$trade->num?>)</span> <span class="name"><?=$output?></span></div>
		<div>
			Parley: <span class="remaining_parley"></span>
			Weight: <span class="remaining_weight"></span>
		</div>
	</div>
	<div style="clear: both"></div>
</div>
<?php
	}
	function barter_dialog($trade = false) {
		global $db;
		$db->setQuery('SELECT `id`,`name` FROM `trade_locations` ORDER BY `name` ASC');
		$db->runQuery();
		$locations = $db->getResultsSingleIndexed();
		$db->setQuery('SELECT * FROM `trade_items` ORDER BY `level` ASC, `name` ASC');
		$db->runQuery();
		$trade_items = $db->getResultsIndexed();
?>
	<div id="trade_top_container">
		<h2><?=$trade?'Edit':'Add'?> Barter</h2>
	</div>
	<div id="trade_contents">
		<dl>
			<dt><label for="trade_location">Location:</label></dt>
			<dd><select id="trade_location">
				<option value="">Select...</option>
<?php foreach($locations as $id => $name) { ?>
				<option value="<?=$id?>"<?=$trade&&$trade->location_id==$id?' selected="selected"':''?>><?=$name?></option>
<?php } ?>
			</select></dd>
			<dt><label for="trade_num">Number of trades:</label></dt>
			<dd><input type="number" id="trade_num" value="<?=$trade?intval($trade->num):1?>" /></dd>
		</dl>
		<div id="suggestions"></div>
		<fieldset>
			<legend>Per Trade</legend>
			<dl>
				<dt><label for="trade_input">Barter Item:</label></dt>
				<dd><select id="trade_input">
					<option value="">Select...</option>
					<option value="104"<?=$trade&&$trade->input_id==104?' selected="selected"':''?>>Load Trade Items</option>
<?php
		$lastlevel = -1;
		foreach($trade_items as $id => $item) {
			if($item->id == 55 || $item->id == 104) continue;
			if($item->level != $lastlevel) {
				if($lastlevel != -1) {
?>
					</optgroup>
<?php
				}
				$lastlevel = $item->level;
?>
					<optgroup label="<?=$lastlevel?'Level ' . $lastlevel:'Misc'?>">
<?php
			}
?>
						<option value="<?=$id?>"<?=$trade&&$trade->input_id==$id?' selected="selected"':''?>><?=$item->name?></option>
<?php } ?>
					</optgroup>
				</select></dd>
				<dt><label for="trade_input_qty">Barter Quantity:</label></dt>
				<dd><input type="number" id="trade_input_qty" value="<?=$trade?intval($trade->input_qty):1?>" /></dd>
				<dt><label for="trade_output">Result Item:</label></dt>
				<dd><select id="trade_output">
					<option value="">Select...</option>
					<option value="55"<?=$trade&&$trade->output_id==55?' selected="selected"':''?>>Offload Trade Items</option>
<?php
		$lastlevel = -1;
		foreach($trade_items as $id => $item) {
			if($item->id == 55 || $item->id == 104) continue;
			if($item->level != $lastlevel) {
				if($lastlevel != -1) {
?>
					</optgroup>
<?php
				}
				$lastlevel = $item->level;
?>
					<optgroup label="<?=$lastlevel?'Level ' . $lastlevel:'Misc'?>">
<?php
			}
?>
						<option value="<?=$id?>"<?=$trade&&$trade->output_id==$id?' selected="selected"':''?>><?=$item->name?></option>
<?php } ?>
					</optgroup>
				</select></dd>
				<dt><label for="trade_output_qty">Result Quantity:</label></dt>
				<dd><input type="number" id="trade_output_qty" value="<?=$trade?intval($trade->output_qty):1?>" /></dd>
				<dt><label for="trade_parley">Parley:</label></dt>
				<dd><input type="number" id="trade_parley" value="<?=$trade?intval($trade->parley):0?>" /></dd>
			</dl>
		</fieldset>
<?php if(!$trade) { ?>
		<div id="trade_insert_contents">
			<dl>
				<dt><label for="trade_insert_position">Insert At:</label></dt>
				<dd id="trade_insert_select"><select id="trade_insert_position">
					<option value="0">Top</option>
					<option value="-1" selected="selected">Bottom</option>
				</select></dd>
			</dl>
		</div>
<?php } ?>
		<div style="text-align: center; margin-top: 1em;">
			<button id="trade_save">Save</button>
			<button id="trade_save_close">Save and Close</button>
			<button id="trade_close">Close</button>
		</div>
<?php if($trade) { ?>
		<div style="text-align: center; margin-top: 1em;" class="edit_trade">
			<button id="trade_complete">Complete</button>
			<button id="trade_cancel">Delete</button>
		</div>
<?php } ?>
	</div>
<?php
	}
	function barter_loads_dialog() {
		global $db;
		$db->setQuery('SELECT `id`,`name` FROM `trade_locations` ORDER BY `name` ASC');
		$db->runQuery();
		$locations = $db->getResultsSingleIndexed();
?>
	<div id="trade_top_container">
		<h2>Add Barter Item Loads</h2>
	</div>
	<div id="trade_contents">
		<dl>
			<dt><label for="trade_location">Location:</label></dt>
			<dd><select id="trade_location">
				<option value="">Select...</option>
<?php foreach($locations as $id => $name) { ?>
				<option value="<?=$id?>"<?=$trade&&$trade->location_id==$id?' selected="selected"':''?>><?=$name?></option>
<?php } ?>
			</select></dd>
			<dt><label for="trade_insert_position">Insert At:</label></dt>
			<dd id="trade_insert_select"><select id="trade_insert_position">
				<option value="0" selected="selected">Top</option>
				<option value="-1">Bottom</option>
			</select></dd>
		</dl>
		<fieldset>
			<legend>Missing Items To Load</legend>
			<div id="missing_loads_list"></div>
			<input type="hidden" id="trade_input" value="104" />
			<input type="hidden" id="trade_input_qty" value="1" />
			<input type="hidden" id="trade_num" value="1" />
			<input type="hidden" id="trade_parley" value="0" />
			<input type="hidden" id="trade_output" value="" />
			<input type="hidden" id="trade_output_qty" value="" />
		</fieldset>
		<div style="text-align: center; margin-top: 1em;">
			<button id="trade_save_close">Add and Close</button>
			<button id="trade_close">Close</button>
		</div>
	</div>
<?php
	}
	function barter_unloads_dialog() {
		global $db;
		$db->setQuery('SELECT `id`,`name` FROM `trade_locations` ORDER BY `name` ASC');
		$db->runQuery();
		$locations = $db->getResultsSingleIndexed();
?>
	<div id="trade_top_container">
		<h2>Add Barter Item Unloads</h2>
	</div>
	<div id="trade_contents">
		<dl>
			<dt><label for="trade_location">Location:</label></dt>
			<dd><select id="trade_location">
				<option value="">Select...</option>
<?php foreach($locations as $id => $name) { ?>
				<option value="<?=$id?>"<?=$trade&&$trade->location_id==$id?' selected="selected"':''?>><?=$name?></option>
<?php } ?>
			</select></dd>
			<dt><label for="trade_insert_position">Insert At:</label></dt>
			<dd id="trade_insert_select"><select id="trade_insert_position">
				<option value="0" selected="selected">Top</option>
				<option value="-1">Bottom</option>
			</select></dd>
		</dl>
		<fieldset>
			<legend>Missing Items To Unload</legend>
			<div id="missing_unloads_list"></div>
			<input type="hidden" id="trade_input" value="" />
			<input type="hidden" id="trade_input_qty" value="" />
			<input type="hidden" id="trade_num" value="1" />
			<input type="hidden" id="trade_parley" value="0" />
			<input type="hidden" id="trade_output" value="55" />
			<input type="hidden" id="trade_output_qty" value="1" />
		</fieldset>
		<div style="text-align: center; margin-top: 1em;">
			<button id="trade_save_close">Add and Close</button>
			<button id="trade_close">Close</button>
		</div>
	</div>
<?php
	}
	function suggestions($location_id = false, $input_id = false, $output_id = false) {
		global $db;
		$suggestions = array();
		if($location_id) {
			$db->setQuery('SELECT * FROM `trade_location_item_map` WHERE `location_id`=%d');
			$db->runQuery($location_id);
			$suggestions = array_merge($suggestions, $db->getResults());
		}
		if($input_id) {
			$db->setQuery('SELECT * FROM `trade_location_item_map` WHERE `input_id`=%d');
			$db->runQuery($input_id);
			$suggestions = array_merge($suggestions, $db->getResults());
		}
		if($output_id) {
			$db->setQuery('SELECT * FROM `trade_location_item_map` WHERE `output_id`=%d');
			$db->runQuery($output_id);
			$suggestions = array_merge($suggestions, $db->getResults());
		}
		if(count($suggestions)) {
			$db->setQuery('SELECT `id`,`name` FROM `trade_locations` ORDER BY `name` ASC');
			$db->runQuery();
			$locations = $db->getResultsSingleIndexed();
			$db->setQuery('SELECT * FROM `trade_items` ORDER BY `level` ASC, `name` ASC');
			$db->runQuery();
			$trade_items = $db->getResultsIndexed();
?>
	<fieldset>
		<legend>Suggestions</legend>
		<div class="suggestions">
<?php
			foreach($suggestions as $suggestion) {
				$input = $trade_items[$suggestion->input_id]->name;
				if($trade_items[$suggestion->input_id]->level) {
					$input = '[Level ' . $trade_items[$suggestion->input_id]->level . '] ' . $input;
				}
				$output = $trade_items[$suggestion->output_id]->name;
				if($trade_items[$suggestion->output_id]->level) {
					$output = '[Level ' . $trade_items[$suggestion->output_id]->level . '] ' . $output;
				}
?>
			<div class="suggestion" data-location="<?=$suggestion->location_id?>" data-input="<?=$suggestion->input_id?>" data-output="<?=$suggestion->output_id?>">
				<?=$locations[$suggestion->location_id]?>: <?=$input?> for <?=$output?>
			</div>
<?php } ?>
		</div>
	</fieldset>
<?php
		}
	}