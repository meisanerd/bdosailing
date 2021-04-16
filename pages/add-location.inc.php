<?php
	function handle_post() {
		if(!$_SESSION['admin']) {
			header('Location: /');
			exit;
		}
		if(isset($_POST['location']) && $_POST['location']) {
			global $db;
			$db->setQuery('SELECT COUNT(*) FROM `trade_locations` WHERE `name`="%s"');
			$db->runQuery($_POST['location']);
			if($db->getResultSingle()) {
				global $errors;
				$errors[] = 'That location already exists.';
			} else {
				global $messages;
				$db->setQuery('INSERT INTO `trade_locations` (`name`) VALUES ("%s")');
				$db->runQuery($_POST['location']);
				$messages[] = 'Location added.';
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
		<h2>Add Location</h2>
	</div>
<?php
	}
	function body_content() {
?>
<form action="/add-location" method="post">
	<div>
		<dl>
			<dt><label for="location">Name:</label></dt>
			<dd><input type="text" name="location" id="location" required="required" /></dd>
		</dl>
		<button type="submit">Insert</button>
	</div>
</form>
<?php
	}
