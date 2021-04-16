<?php
	function handle_post() {
		if($_SESSION['user'] != 1) {
			header('Location: /');
			exit;
		}
		if(isset($_POST['username']) && $_POST['username']) {
			global $db;
			$db->setQuery('SELECT COUNT(*) FROM `users` WHERE `username`="%s"');
			$db->runQuery($_POST['username']);
			if($db->getResultSingle()) {
				global $errors;
				$errors[] = 'That user already exists.';
			} else {
				global $messages;
				$db->setQuery('INSERT INTO `users` (`username`,`password`) VALUES ("%s","12345")');
				$db->runQuery($_POST['username']);
				$messages[] = 'User added.';
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
		<h2>Add User</h2>
	</div>
<?php
	}
	function body_content() {
?>
<form action="/add-user" method="post">
	<div>
		<dl>
			<dt><label for="username">Username:</label></dt>
			<dd><input type="text" name="username" id="username" required="required" /></dd>
		</dl>
		<button type="submit">Insert</button>
	</div>
</form>
<?php
	}