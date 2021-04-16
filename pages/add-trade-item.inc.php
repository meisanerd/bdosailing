<?php
	function handle_post() {
		if(!$_SESSION['admin']) {
			header('Location: /');
			exit;
		}
		if(isset($_POST['item'],$_POST['level'],$_POST['weight'],$_POST['record_trade']) && $_POST['item']) {
			global $db;
			$db->setQuery('SELECT COUNT(*) FROM `trade_items` WHERE `name`="%s"');
			$db->runQuery($_POST['item']);
			if($db->getResultSingle()) {
				global $errors;
				$errors[] = 'That item already exists.';
			} else {
				global $messages;
				$db->setQuery('INSERT INTO `trade_items` (`name`,`level`,`weight`,`record_trade`) VALUES ("%s",%d,%f,%d)');
				$db->runQuery($_POST['item'],$_POST['level'],$_POST['weight'],$_POST['record_trade']);
				$messages[] = 'Item added.';
			}
		}
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
<?php
	}
	function header_content() {
?>
	<div id="header">
		<h2>Add Trade Item</h2>
	</div>
<?php
	}
	function body_content() {
?>
<form action="/add-trade-item" method="post">
	<div>
		<dl>
			<dt><label for="item">Name:</label></dt>
			<dd><input type="text" name="item" id="item" required="required" /></dd>
			<dt><label for="level">Level:</label></dt>
			<dd><select name="level" id="level" required="required" />
				<option value="">Select...</option>
				<option value="0">Misc</option>
				<option value="1">Level 1 - White</option>
				<option value="2">Level 2 - Green</option>
				<option value="3">Level 3 - Blue</option>
				<option value="4">Level 4 - Yellow</option>
				<option value="5">Level 5 - Orange</option>
			</select></dd>
			<dt><label for="weight">Weight:</label></dt>
			<dd><input type="text" name="weight" id="weight" required="required" /></dd>
			<dt><label for="record_trade">Record Trade for Suggestions:</label></dt>
			<dd><select name="record_trade" id="record_trade" required="required" />
				<option value="1">Yes</option>
				<option value="0">No</option>
			</select></dd>
		</dl>
		<button type="submit">Insert</button>
	</div>
</form>
<?php
	}
