<?php
	function format_id($string) {
		return strtolower(preg_replace('/[^0-9A-Za-z]/','',$string));
	}
	function style_content() {
?>
#header {
	flex: 1;
}
form {
	flex: 1;
	overflow: auto;
}
form div {
	padding: 5px;
}
.item {
	border-bottom: 1px solid #444547;
	padding: 10px;
}
.item.done {
	background: #006600;
}
.parts {
	margin: 5px 0 0 30px;
	padding: 0;
	border-top: 1px solid #444547;
}
#making_dialog {
	position: fixed;
	top: 0;
	left: 0;
	width: 100%;
	height: 100%;
	background: #1D1D1F;
	display: none;
	flex-direction: column;
}
#making_top_container {
	flex: none;
	display: flex;
	flex-direction: row;
	padding: 0 0.5em;
	height: 60px;
	background: #735B39;
	color: #FFEDD2;
}
#making_contents {
	flex: 1;
	overflow: auto;
	padding: 1em;
}
#item_name {
	text-align: center;
}
#making_dialog button {
	font-size: 16px;
	margin: 0 0.25em;
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
#summary_dialog {
	position: fixed;
	top: 0;
	left: 0;
	width: 100%;
	height: 100%;
	background: #1D1D1F;
	display: none;
	flex-direction: column;
	overflow: auto;
}
#summary_top_container {
	flex: none;
	display: flex;
	flex-direction: row;
	padding: 0 0.5em;
	height: 60px;
	background: #735B39;
	color: #FFEDD2;
}
#summary_contents {
	flex: 1;
	overflow: auto;
	padding: 1em;
}
#summary_items div {
	padding: 0.25em 0;
}
#summary_dialog button {
	font-size: 16px;
	margin: 0 0.25em;
}
<?php
	}
	function header_content() {
?>
	<div id="header">
		<h2>Ship Building Materials</h2>
	</div>
<?php
	}
	function parts_display($id, $parts, $materials, $level = 0) {
		foreach($parts as $item) {
			$partid = format_id($item['name']);
			$itemid = $id . '_' . $partid;
			$making = isset($item['making'])?htmlspecialchars(json_encode($item['making'])):'';
			$done = false;
			if(isset($item['enhancement'])) {
				if($materials && isset($materials->{$itemid.'_enhancement'}) && $materials->{$itemid.'_enhancement'} == $item['enhancement']) {
					$done = true;
				}
			} else if($materials && isset($materials->{$itemid}) && $materials->{$itemid} == $item['qty']) {
				$done = true;
			}
?>
			<div class="item<?=$done?' done':''?>">
				<label class="itemdata itemdatalevel_<?=$level?> <?=$partid?>" data-partid="<?=$partid?>" data-qty="<?=$item['qty']?>"><span class="name"><?=$item['name']?></span><?=$making?' (<a href="#" class="making" data-steps="' . $making . '">How To Make</a>)':''?>
					<br /><span><input type="number" name="<?=$itemid?>" value="<?=$materials&&isset($materials->{$itemid})?$materials->{$itemid}:0?>" class="haveqty" /> / <?=$item['qty']?></span>
<?php if(isset($item['enhancement'])) { ?>
					<br /><span><input type="number" name="<?=$itemid?>_enhancement" value="<?=$materials&&isset($materials->{$itemid.'_enhancement'})?$materials->{$itemid.'_enhancement'}:0?>" class="haveenhancement" /> / +<?=$item['enhancement']?> Enhancement</span>
<?php } ?>
				</label>
<?php if(isset($item['parts']) && count($item['parts'])) { ?>
				<div class="parts"><?php parts_display($itemid, $item['parts'], $materials, $level+1); ?></div>
<?php } ?>
			</div>
<?php
		}
	}
	function body_content() {
		$boats = array(
			'Epheria Frigate' => array(
				'link' => 'https://grumpygreen.cricket/bdo-epheria-frigate-guide/',
				'parts' => array(
					array(
						'name' => 'Standardized Timber Square',
						'qty' => 1000,
						'making' => array(
							'Chop 10x Log -> 1x Usable Scantling',
							'Chop 10x Usable Scantling -> 1x'
						),
						'parts' => array(
							array(
								'name' => 'Usable Scantling',
								'qty' => 10000,
								'parts' => array(
									array(
										'name' => 'Log',
										'qty' => 100000
									)
								)
							)
						)
					),
					array(
						'name' => 'Jade Coral Ingot',
						'qty' => 800,
						'making' => array(
							'Heat 5x Titanium Ore -> 1x Melted Titanium Shard',
							'Heat 15x Melted Titanium Shard and 5x [Prairie Green Coral, Golden Sun Coral, Breezy White Coral, Twilight Red Coral, OR Daybreak Blue Coral] -> 1x'
						),
						'parts' => array(
							array(
								'name' => 'Titanium Ore',
								'qty' => 60000
							)
						)
					),
					array(
						'name' => 'Pine Coated Plywood',
						'qty' => 1600
					),
					array(
						'name' => 'Enhanced Flax Fabric',
						'qty' => 450
					),
					array(
						'name' => 'Design: Epheria Frigate',
						'qty' => 25
					)
				)
			),
			'Epheria Frigate (Upgrade)' => array(
				'link' => 'https://grumpygreen.cricket/bdo-bartali-sailboat-upgrade-guide-how-to-recipe-materials/',
				'parts' => array(
					array(
						'name' => 'Standardized Timber Square',
						'qty' => 1000,
						'making' => array(
							'Chop 10x Log -> 1x Usable Scantling',
							'Chop 10x Usable Scantling -> 1x'
						),
						'parts' => array(
							array(
								'name' => 'Usable Scantling',
								'qty' => 10000,
								'parts' => array(
									array(
										'name' => 'Log',
										'qty' => 100000
									)
								)
							)
						)
					),
					array(
						'name' => 'Jade Coral Ingot',
						'qty' => 800,
						'making' => array(
							'Heat 5x Titanium Ore -> 1x Melted Titanium Shard',
							'Heat 15x Melted Titanium Shard and 5x [Prairie Green Coral, Golden Sun Coral, Breezy White Coral, Twilight Red Coral, OR Daybreak Blue Coral] -> 1x'
						),
						'parts' => array(
							array(
								'name' => 'Titanium Ore',
								'qty' => 60000
							)
						)
					),
					array(
						'name' => 'Pine Coated Plywood',
						'qty' => 1000,
						'making' => array(
							'Chop 5x Pine Timber -> 1x Pine Plank',
							'Chop 10x Pine Plank -> 1x Pine Plywood',
							'Heat 50x Coconut and 5x Pine Plywood -> 1x'
						),
						'parts' => array(
							array(
								'name' => 'Coconut',
								'qty' => 50000
							),
							array(
								'name' => 'Pine Timber',
								'qty' => 250000
							)
						)
					),
					array(
						'name' => 'Enhanced Flax Fabric',
						'qty' => 450,
						'making' => array(
							'Heat 5x Flax -> 1x Flax Thread',
							'Grind 10x Flax Thread -> 1x Flax Fabric',
							'Grind 5x Shining Powder and 5x Flax Fabric -> 1x'
						),
						'parts' => array(
							array(
								'name' => 'Flax',
								'qty' => 112500
							),
							array(
								'name' => 'Shining Powder',
								'qty' => 2250
							)
						)
					),
					array(
						'name' => 'Hard Pillar',
						'qty' => 100,
						'making' => array(
							'Alchemy Tool 1x Sugar, 1x Silver Azalea, 1x Purified Water, and 1x Wild Herb -> 1x Pure Powder Reagent',
							'Alchemy Tool 1x Pure Powder Reagent, 4x Fir Sap, 3x Bloody Tree Knot, and 3x Trace of the Earth -> 1x Plywood Hardener',
							'Heat 10x Plywood Hardener and 10x Log -> 1x'
						),
						'parts' => array(
							array(
								'name' => 'Plywood Hardener',
								'qty' => 1000,
								'parts' => array(
									array(
										'name' => 'Pure Powder Reagent',
										'qty' => 1000,
										'parts' => array(
											array(
												'name' => 'Sugar',
												'qty' => 1000
											),
											array(
												'name' => 'Silver Azalea',
												'qty' => 1000
											),
											array(
												'name' => 'Purified Water',
												'qty' => 1000
											),
											array(
												'name' => 'Wild Herb',
												'qty' => 1000
											)
										)
									),
									array(
										'name' => 'Fir Sap',
										'qty' => 4000
									),
									array(
										'name' => 'Bloody Tree Knot',
										'qty' => 3000
									),
									array(
										'name' => 'Trace of the Earth',
										'qty' => 3000
									)
								)
							),
							array(
								'name' => 'Log',
								'qty' => 1000
							)
						)
					),
					array(
						'name' => 'Ship Upgrade Permit: Epheria Frigate',
						'qty' => 1
					),
					array(
						'name' => 'Bartali Sailboat: Old Prow',
						'qty' => 1,
						'enhancement' => 10
					),
					array(
						'name' => 'Bartali Sailboat: Old Plating',
						'qty' => 1,
						'enhancement' => 10
					),
					array(
						'name' => 'Bartali Sailboat: Old Cannon',
						'qty' => 1,
						'enhancement' => 10
					),
					array(
						'name' => 'Bartali Sailboat: Old Wind Sail',
						'qty' => 1,
						'enhancement' => 10
					)
				)
			),
			'Epheria Sailboat (Upgrade)' => array(
				'link' => 'https://grumpygreen.cricket/bdo-bartali-sailboat-upgrade-guide-how-to-recipe-materials/',
				'parts' => array(
					array(
						'name' => 'Standardized Timber Square',
						'qty' => 800,
						'making' => array(
							'Chop 10x Log -> 1x Usable Scantling',
							'Chop 10x Usable Scantling -> 1x'
						),
						'parts' => array(
							array(
								'name' => 'Usable Scantling',
								'qty' => 8000,
								'parts' => array(
									array(
										'name' => 'Log',
										'qty' => 80000
									)
								)
							)
						)
					),
					array(
						'name' => 'Steel',
						'qty' => 600,
						'making' => array(
							'Heat 5x Iron Ore -> 1x Melted Iron Shard',
							'Heat 5x Melted Iron Shard and 5x Coal -> 1x'
						),
						'parts' => array(
							array(
								'name' => 'Melted Iron Shard',
								'qty' => 3000,
								'parts' => array(
									array(
										'name' => 'Iron Ore',
										'qty' => 15000
									)
								)
							),
							array(
								'name' => 'Coal',
								'qty' => 3000
							)
						)
					),
					array(
						'name' => 'Pine Plywood',
						'qty' => 1500,
						'making' => array(
							'Chop 5x Pine Timber -> 1x Pine Plank',
							'Chop 10x Pine Plank -> 1x Pine Plywood'
						),
						'parts' => array(
							array(
								'name' => 'Pine Plank',
								'qty' => 15000,
								'parts' => array(
									array(
										'name' => 'Pine Timber',
										'qty' => 75000
									)
								)
							)
						)
					),
					array(
						'name' => 'Flax Fabric',
						'qty' => 300,
						'making' => array(
							'Heat 5x Flax -> 1x Flax Thread',
							'Grind 10x Flax Thread -> 1x Flax Fabric'
						),
						'parts' => array(
							array(
								'name' => 'Flax Thread',
								'qty' => 3000,
								'parts' => array(
									array(
										'name' => 'Flax',
										'qty' => 15000
									)
								)
							)
						)
					),
					array(
						'name' => 'Hard Pillar',
						'qty' => 100,
						'making' => array(
							'Alchemy Tool 1x Sugar, 1x Silver Azalea, 1x Purified Water, and 1x Wild Herb -> 1x Pure Powder Reagent',
							'Alchemy Tool 1x Pure Powder Reagent, 4x Fir Sap, 3x Bloody Tree Knot, and 3x Trace of the Earth -> 1x Plywood Hardener',
							'Heat 10x Plywood Hardener and 10x Log -> 1x'
						),
						'parts' => array(
							array(
								'name' => 'Plywood Hardener',
								'qty' => 1000,
								'parts' => array(
									array(
										'name' => 'Pure Powder Reagent',
										'qty' => 1000,
										'parts' => array(
											array(
												'name' => 'Sugar',
												'qty' => 1000
											),
											array(
												'name' => 'Silver Azalea',
												'qty' => 1000
											),
											array(
												'name' => 'Purified Water',
												'qty' => 1000
											),
											array(
												'name' => 'Wild Herb',
												'qty' => 1000
											)
										)
									),
									array(
										'name' => 'Fir Sap',
										'qty' => 4000
									),
									array(
										'name' => 'Bloody Tree Knot',
										'qty' => 3000
									),
									array(
										'name' => 'Trace of the Earth',
										'qty' => 3000
									)
								)
							),
							array(
								'name' => 'Log',
								'qty' => 1000
							)
						)
					),
					array(
						'name' => 'Ship Upgrade Permit: Epheria Sailboat',
						'qty' => 1
					),
					array(
						'name' => 'Bartali Sailboat: Old Prow',
						'qty' => 1,
						'enhancement' => 10
					),
					array(
						'name' => 'Bartali Sailboat: Old Plating',
						'qty' => 1,
						'enhancement' => 10
					),
					array(
						'name' => 'Bartali Sailboat: Old Cannon',
						'qty' => 1,
						'enhancement' => 10
					),
					array(
						'name' => 'Bartali Sailboat: Old Wind Sail',
						'qty' => 1,
						'enhancement' => 10
					)
				)
			),
			'Improved Epheria Frigate' => array(
				'link' => 'https://grumpygreen.cricket/bdo-epheria-frigate-upgrade-galleass-or-improved-design-materials-quest/',
				'parts' => array(
					array(
						'name' => 'Standardized Timber Square',
						'qty' => 250
					),
					array(
						'name' => 'Steel',
						'qty' => 200
					),
					array(
						'name' => 'Pine Plywood',
						'qty' => 500
					),
					array(
						'name' => 'Flax Fabric',
						'qty' => 100
					),
					array(
						'name' => 'Hard Pillar',
						'qty' => 30
					),
					array(
						'name' => 'Ultimate Weapon Reform Stone',
						'qty' => 10
					),
					array(
						'name' => 'Epheria: Old Prow',
						'qty' => 1,
					),
					array(
						'name' => 'Epheria: Old Plating',
						'qty' => 1,
					),
					array(
						'name' => 'Epheria: Old Cannon',
						'qty' => 1,
					),
					array(
						'name' => 'Epheria: Old Wind Sail',
						'qty' => 1,
					)
				)
			),
			'Galleass' => array(
				'link' => 'https://grumpygreen.cricket/bdo-epheria-frigate-upgrade-galleass-or-improved-design-materials-quest/',
				'parts' => array(
					array(
						'name' => 'Graphite Ingot for Upgrade',
						'qty' => 100,
						'parts' => array(
							array(
								'name' => 'Zinc Ingot',
								'qty' => 10000
							),
							array(
								'name' => 'Sea Monster\'s Ooze',
								'qty' => 100
							)
						)
					),
					array(
						'name' => 'Timber for Upgrade',
						'qty' => 100,
						'parts' => array(
							array(
								'name' => 'Old Tree Bark',
								'qty' => 10000
							),
							array(
								'name' => 'Red Tree Lump',
								'qty' => 10000
							),
							array(
								'name' => 'Sea Monster\'s Ooze',
								'qty' => 100
							)
						)
					),
					array(
						'name' => 'Adhesive for Upgrade',
						'qty' => 100,
						'parts' => array(
							array(
								'name' => 'White Cedar Sap',
								'qty' => 10000
							),
							array(
								'name' => 'Acacia Sap',
								'qty' => 10000
							),
							array(
								'name' => 'Elder Tree Sap',
								'qty' => 10000
							),
							array(
								'name' => 'Sea Monster\'s Ooze',
								'qty' => 100
							)
						)
					),
					array(
						'name' => 'Ship Upgrade Permit: Epheria Galleass',
						'qty' => 1
					),
					array(
						'name' => 'Island Tree Coated Plywood',
						'qty' => 100
					),
					array(
						'name' => 'Tide-Dyed Standardized Timber Square',
						'qty' => 6
					),
					array(
						'name' => 'Cobalt Ingot',
						'qty' => 2
					),
					array(
						'name' => 'Moon Scale Plywood',
						'qty' => 10
					),
					array(
						'name' => 'Epheria: Old Prow',
						'qty' => 1,
						'enhancement' => 10
					),
					array(
						'name' => 'Epheria: Old Plating',
						'qty' => 1,
						'enhancement' => 10
					),
					array(
						'name' => 'Epheria: Old Cannon',
						'qty' => 1,
						'enhancement' => 10
					),
					array(
						'name' => 'Epheria: Old Wind Sail',
						'qty' => 1,
						'enhancement' => 10
					)
				)
			),
			'Improved Epheria Sailboat' => array(
				'link' => 'https://grumpygreen.cricket/bdo-epheria-sailboat-upgrade-design-materials-quest/',
				'parts' => array(
					array(
						'name' => 'Standardized Timber Square',
						'qty' => 250,
						'making' => array(
							'Chop 10x Log -> 1x Usable Scantling',
							'Chop 10x Usable Scantling -> 1x'
						),
						'parts' => array(
							array(
								'name' => 'Usable Scantling',
								'qty' => 2500,
								'parts' => array(
									array(
										'name' => 'Log',
										'qty' => 25000
									)
								)
							)
						)
					),
					array(
						'name' => 'Steel',
						'qty' => 200,
						'making' => array(
							'Heat 5x Iron Ore -> 1x Melted Iron Shard',
							'Heat 5x Melted Iron Shard and 5x Coal -> 1x'
						),
						'parts' => array(
							array(
								'name' => 'Melted Iron Shard',
								'qty' => 1000,
								'parts' => array(
									array(
										'name' => 'Iron Ore',
										'qty' => 5000
									)
								)
							),
							array(
								'name' => 'Coal',
								'qty' => 1000
							)
						)
					),
					array(
						'name' => 'Pine Plywood',
						'qty' => 500,
						'making' => array(
							'Chop 5x Pine Timber -> 1x Pine Plank',
							'Chop 10x Pine Plank -> 1x Pine Plywood'
						),
						'parts' => array(
							array(
								'name' => 'Pine Plank',
								'qty' => 5000,
								'parts' => array(
									array(
										'name' => 'Pine Timber',
										'qty' => 25000
									)
								)
							)
						)
					),
					array(
						'name' => 'Flax Fabric',
						'qty' => 100,
						'making' => array(
							'Heat 5x Flax -> 1x Flax Thread',
							'Grind 10x Flax Thread -> 1x Flax Fabric'
						),
						'parts' => array(
							array(
								'name' => 'Flax Thread',
								'qty' => 1000,
								'parts' => array(
									array(
										'name' => 'Flax',
										'qty' => 5000
									)
								)
							)
						)
					),
					array(
						'name' => 'Hard Pillar',
						'qty' => 30,
						'making' => array(
							'Alchemy Tool 1x Sugar, 1x Silver Azalea, 1x Purified Water, and 1x Wild Herb -> 1x Pure Powder Reagent',
							'Alchemy Tool 1x Pure Powder Reagent, 4x Fir Sap, 3x Bloody Tree Knot, and 3x Trace of the Earth -> 1x Plywood Hardener',
							'Heat 10x Plywood Hardener and 10x Log -> 1x'
						),
						'parts' => array(
							array(
								'name' => 'Plywood Hardener',
								'qty' => 300,
								'parts' => array(
									array(
										'name' => 'Pure Powder Reagent',
										'qty' => 300,
										'parts' => array(
											array(
												'name' => 'Sugar',
												'qty' => 300
											),
											array(
												'name' => 'Silver Azalea',
												'qty' => 300
											),
											array(
												'name' => 'Purified Water',
												'qty' => 300
											),
											array(
												'name' => 'Wild Herb',
												'qty' => 300
											)
										)
									),
									array(
										'name' => 'Fir Sap',
										'qty' => 400
									),
									array(
										'name' => 'Bloody Tree Knot',
										'qty' => 300
									),
									array(
										'name' => 'Trace of the Earth',
										'qty' => 300
									)
								)
							),
							array(
								'name' => 'Log',
								'qty' => 300
							)
						)
					),
					array(
						'name' => 'Ultimate Armor Reform Stone',
						'qty' => 10
					),
					array(
						'name' => 'Epheria: Old Prow',
						'qty' => 1,
					),
					array(
						'name' => 'Epheria: Old Plating',
						'qty' => 1,
					),
					array(
						'name' => 'Epheria: Old Cannon',
						'qty' => 1,
					),
					array(
						'name' => 'Epheria: Old Wind Sail',
						'qty' => 1,
					)
				)
			),
			'Caravel' => array(
				'link' => 'https://grumpygreen.cricket/bdo-epheria-caravel/',
				'parts' => array(
					array(
						'name' => 'Graphite Ingot for Upgrade',
						'qty' => 100,
						'parts' => array(
							array(
								'name' => 'Zinc Ingot',
								'qty' => 10000
							),
							array(
								'name' => 'Sea Monster\'s Ooze',
								'qty' => 100
							)
						)
					),
					array(
						'name' => 'Timber for Upgrade',
						'qty' => 100,
						'parts' => array(
							array(
								'name' => 'Old Tree Bark',
								'qty' => 10000
							),
							array(
								'name' => 'Red Tree Lump',
								'qty' => 10000
							),
							array(
								'name' => 'Sea Monster\'s Ooze',
								'qty' => 100
							)
						)
					),
					array(
						'name' => 'Adhesive for Upgrade',
						'qty' => 100,
						'parts' => array(
							array(
								'name' => 'White Cedar Sap',
								'qty' => 10000
							),
							array(
								'name' => 'Acacia Sap',
								'qty' => 10000
							),
							array(
								'name' => 'Elder Tree Sap',
								'qty' => 10000
							),
							array(
								'name' => 'Sea Monster\'s Ooze',
								'qty' => 100
							)
						)
					),
					array(
						'name' => 'Ship Upgrade Permit: Epheria Caravel',
						'qty' => 1
					),
					array(
						'name' => 'Island Tree Coated Plywood',
						'qty' => 100
					),
					array(
						'name' => 'Rock Salt Ingot',
						'qty' => 100
					),
					array(
						'name' => 'Deep Sea Memory Filled Glue',
						'qty' => 4
					),
					array(
						'name' => 'Seaweed Stalk',
						'qty' => 6
					),
					array(
						'name' => 'Epheria: Old Prow',
						'qty' => 1,
						'enhancement' => 10
					),
					array(
						'name' => 'Epheria: Old Plating',
						'qty' => 1,
						'enhancement' => 10
					),
					array(
						'name' => 'Epheria: Old Cannon',
						'qty' => 1,
						'enhancement' => 10
					),
					array(
						'name' => 'Epheria: Old Wind Sail',
						'qty' => 1,
						'enhancement' => 10
					)
				)
			),
			'Volante' => array(
				'link' => 'https://grumpygreen.cricket/bdo-epheria-galleass-upgrade-carrack/',
				'parts' => array(
					array(
						'name' => 'Moon Vein Flax Fabric',
						'qty' => 210
					),
					array(
						'name' => 'Deep Tide-Dyed Standardized Timber Square',
						'qty' => 144
					),
					array(
						'name' => 'Brilliant Rock Salt Ingot',
						'qty' => 30
					),
					array(
						'name' => 'Tear of the Ocean',
						'qty' => 42
					),
					array(
						'name' => 'Brilliant Pearl Shard',
						'qty' => 30
					),
					array(
						'name' => 'Epheria Galleass: Black Dragon Prow',
						'qty' => 1,
						'enhancement' => 10,
						'parts' => array(
							array(
								'name' => 'Epheria Galleass: White Horn Prow',
								'qty' => 1,
								'enhancement' => 10
							),
							array(
								'name' => 'Ruddy Manganese Nodule',
								'qty' => 50
							),
							array(
								'name' => 'Enhanced Island Tree Coated Plywood',
								'qty' => 300
							),
							array(
								'name' => 'Seaweed Stalk',
								'qty' => 125
							),
							array(
								'name' => 'Great Ocean Dark Iron',
								'qty' => 150
							)
						)
					),
					array(
						'name' => 'Epheria Galleass: Blue-Grade Upgraded Plating',
						'qty' => 1,
						'enhancement' => 10,
						'parts' => array(
							array(
								'name' => 'Epheria Galleass: Green-Grade Upgraded Plating',
								'qty' => 1,
								'enhancement' => 10
							),
							array(
								'name' => 'Pure Pearl Crystal',
								'qty' => 45
							),
							array(
								'name' => 'Cox Pirate\'s Artifact (Parley Beginner)',
								'qty' => 60
							),
							array(
								'name' => 'Cox Pirate\'s Artifact (Combat)',
								'qty' => 125
							),
							array(
								'name' => 'Moon Scale Plywood',
								'qty' => 300
							)
						)
					),
					array(
						'name' => 'Epheria Galleass: Mayna Cannon',
						'qty' => 1,
						'enhancement' => 10,
						'parts' => array(
							array(
								'name' => 'Epheria Galleass: Verisha Cannon',
								'qty' => 1,
								'enhancement' => 10
							),
							array(
								'name' => 'Tide-Dyed Standardized Timber Square',
								'qty' => 180
							),
							array(
								'name' => 'Cox Pirate\'s Artifact (Combat)',
								'qty' => 125
							),
							array(
								'name' => 'Moon Scale Plywood',
								'qty' => 300
							),
							array(
								'name' => 'Bright Reef Piece',
								'qty' => 180
							)
						)
					),
					array(
						'name' => 'Epheria Galleass: Stratus Wind Sail',
						'qty' => 1,
						'enhancement' => 10,
						'parts' => array(
							array(
								'name' => 'Epheria Galleass: White Wind Sail',
								'qty' => 1,
								'enhancement' => 10
							),
							array(
								'name' => 'Ruddy Manganese Nodule',
								'qty' => 50
							),
							array(
								'name' => 'Cox Pirate\'s Artifact (Parley Expert)',
								'qty' => 30
							),
							array(
								'name' => 'Seaweed Stalk',
								'qty' => 125
							),
							array(
								'name' => 'Luminous Cobalt Ingot',
								'qty' => 30
							)
						)
					)
				)
			),
			'Valor' => array(
				'link' => 'https://grumpygreen.cricket/bdo-epheria-galleass-upgrade-carrack/',
				'parts' => array(
					array(
						'name' => 'Moon Vein Flax Fabric',
						'qty' => 180
					),
					array(
						'name' => 'Deep Tide-Dyed Standardized Timber Square',
						'qty' => 170
					),
					array(
						'name' => 'Brilliant Rock Salt Ingot',
						'qty' => 30
					),
					array(
						'name' => 'Tear of the Ocean',
						'qty' => 42
					),
					array(
						'name' => 'Brilliant Pearl Shard',
						'qty' => 30
					),
					array(
						'name' => 'Epheria Galleass: Black Dragon Prow',
						'qty' => 1,
						'enhancement' => 10,
						'parts' => array(
							array(
								'name' => 'Epheria Galleass: White Horn Prow',
								'qty' => 1,
								'enhancement' => 10
							),
							array(
								'name' => 'Ruddy Manganese Nodule',
								'qty' => 50
							),
							array(
								'name' => 'Enhanced Island Tree Coated Plywood',
								'qty' => 300
							),
							array(
								'name' => 'Seaweed Stalk',
								'qty' => 125
							),
							array(
								'name' => 'Great Ocean Dark Iron',
								'qty' => 150
							)
						)
					),
					array(
						'name' => 'Epheria Galleass: Blue-Grade Upgraded Plating',
						'qty' => 1,
						'enhancement' => 10,
						'parts' => array(
							array(
								'name' => 'Epheria Galleass: Green-Grade Upgraded Plating',
								'qty' => 1,
								'enhancement' => 10
							),
							array(
								'name' => 'Pure Pearl Crystal',
								'qty' => 45
							),
							array(
								'name' => 'Cox Pirate\'s Artifact (Parley Beginner)',
								'qty' => 60
							),
							array(
								'name' => 'Cox Pirate\'s Artifact (Combat)',
								'qty' => 125
							),
							array(
								'name' => 'Moon Scale Plywood',
								'qty' => 300
							)
						)
					),
					array(
						'name' => 'Epheria Galleass: Mayna Cannon',
						'qty' => 1,
						'enhancement' => 10,
						'parts' => array(
							array(
								'name' => 'Epheria Galleass: Verisha Cannon',
								'qty' => 1,
								'enhancement' => 10
							),
							array(
								'name' => 'Tide-Dyed Standardized Timber Square',
								'qty' => 180
							),
							array(
								'name' => 'Cox Pirate\'s Artifact (Combat)',
								'qty' => 125
							),
							array(
								'name' => 'Moon Scale Plywood',
								'qty' => 300
							),
							array(
								'name' => 'Bright Reef Piece',
								'qty' => 180
							)
						)
					),
					array(
						'name' => 'Epheria Galleass: Stratus Wind Sail',
						'qty' => 1,
						'enhancement' => 10,
						'parts' => array(
							array(
								'name' => 'Epheria Galleass: White Wind Sail',
								'qty' => 1,
								'enhancement' => 10
							),
							array(
								'name' => 'Ruddy Manganese Nodule',
								'qty' => 50
							),
							array(
								'name' => 'Cox Pirate\'s Artifact (Parley Expert)',
								'qty' => 30
							),
							array(
								'name' => 'Seaweed Stalk',
								'qty' => 125
							),
							array(
								'name' => 'Luminous Cobalt Ingot',
								'qty' => 30
							)
						)
					)
				)
			),
			'Advance' => array(
				'link' => 'https://grumpygreen.cricket/bdo-epheria-caravel-upgrade/',
				'parts' => array(
					array(
						'name' => 'Moon Vein Flax Fabric',
						'qty' => 180
					),
					array(
						'name' => 'Deep Tide-Dyed Standardized Timber Square',
						'qty' => 144
					),
					array(
						'name' => 'Brilliant Rock Salt Ingot',
						'qty' => 35
					),
					array(
						'name' => 'Tear of the Ocean',
						'qty' => 42
					),
					array(
						'name' => 'Brilliant Pearl Shard',
						'qty' => 35
					),
					array(
						'name' => 'Epheria Caravel: Black Dragon Prow',
						'qty' => 1,
						'enhancement' => 10,
						'parts' => array(
							array(
								'name' => 'Epheria Caravel: Brass Prow',
								'qty' => 1,
								'enhancement' => 10
							),
							array(
								'name' => 'Ruddy Manganese Nodule',
								'qty' => 50
							),
							array(
								'name' => 'Enhanced Island Tree Coated Plywood',
								'qty' => 300
							),
							array(
								'name' => 'Seaweed Stalk',
								'qty' => 125
							),
							array(
								'name' => 'Great Ocean Dark Iron',
								'qty' => 150
							)
						)
					),
					array(
						'name' => 'Epheria Caravel: Blue-Grade Upgraded Plating',
						'qty' => 1,
						'enhancement' => 10,
						'parts' => array(
							array(
								'name' => 'Epheria Caravel: Green-Grade Upgraded Plating',
								'qty' => 1,
								'enhancement' => 10
							),
							array(
								'name' => 'Pure Pearl Crystal',
								'qty' => 45
							),
							array(
								'name' => 'Cox Pirate\'s Artifact (Parley Beginner)',
								'qty' => 60
							),
							array(
								'name' => 'Cox Pirate\'s Artifact (Combat)',
								'qty' => 60
							),
							array(
								'name' => 'Moon Scale Plywood',
								'qty' => 200
							)
						)
					),
					array(
						'name' => 'Epheria Caravel: Mayna Cannon',
						'qty' => 1,
						'enhancement' => 10,
						'parts' => array(
							array(
								'name' => 'Epheria Caravel: Verisha Cannon',
								'qty' => 1,
								'enhancement' => 10
							),
							array(
								'name' => 'Tide-Dyed Standardized Timber Square',
								'qty' => 180
							),
							array(
								'name' => 'Cox Pirate\'s Artifact (Combat)',
								'qty' => 60
							),
							array(
								'name' => 'Moon Scale Plywood',
								'qty' => 200
							),
							array(
								'name' => 'Bright Reef Piece',
								'qty' => 180
							)
						)
					),
					array(
						'name' => 'Epheria Caravel: Stratus Wind Sail',
						'qty' => 1,
						'enhancement' => 10,
						'parts' => array(
							array(
								'name' => 'Epheria Caravel: White Wind Sail',
								'qty' => 1,
								'enhancement' => 10
							),
							array(
								'name' => 'Ruddy Manganese Nodule',
								'qty' => 40
							),
							array(
								'name' => 'Cox Pirate\'s Artifact (Parley Expert)',
								'qty' => 30
							),
							array(
								'name' => 'Seaweed Stalk',
								'qty' => 80
							),
							array(
								'name' => 'Luminous Cobalt Ingot',
								'qty' => 30
							)
						)
					)
				)
			)
		);
		global $db;
		$db->setQuery('SELECT `materials` FROM `ship_building_materials` WHERE `user_id`=%d');
		$db->runQuery($_SESSION['user']);
		$materials = $db->getResultSingle();
		if($materials) {
			$materials = json_decode($materials);
		}
?>
<form action="/ship-building-materials" method="post" id="ship-building-materials">
	<div>
<?php
		foreach($boats as $boatname => $boat) {
			$boatid = format_id($boatname);
?>
		<fieldset>
			<legend><label><?=$boatname?> <input type="checkbox" name="<?=$boatid?>" value="1" class="build"<?=$materials&&isset($materials->{$boatid})?' checked="checked"':''?> /></legend>
			<div class="item"><a href="<?=$boat['link']?>" target="_blank"><?=$boat['link']?></a></div>
<?php
			parts_display($boatid, $boat['parts'], $materials);
?>
		</fieldset>
<?php } ?>
	</div>
</form>
<div id="bottom_container">
	<div class="noflex">
		<button id="summary">Summary</button>
	</div>
	<div class="spacer"></div>
	<div class="noflex">
		<button id="save">Save</button>
	</div>
</div>
<div id="making_dialog">
	<div id="making_top_container">
		<h2 id="item_name"></h2>
	</div>
	<div id="making_contents">
		<div id="making_steps"></div>
		<div style="text-align: center; margin-top: 1em;">
			<button id="making_close">Close</button>
		</div>
	</div>
</div>
<div id="summary_dialog">
	<div id="summary_top_container">
		<h2>Needed Parts</h2>
	</div>
	<div id="summary_contents">
		<div id="summary_items"></div>
		<div style="text-align: center; margin-top: 1em;">
			<button id="summary_update">Update</button>
			<button id="summary_close">Close</button>
		</div></div>
</div>
<?php
	}