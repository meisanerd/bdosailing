<?php
	function handle_post() {
		if(isset($_POST['weight']) && intval($_POST['weight'])) {
			global $db, $messages;;
			$default_parley = isset($_POST['default_parley'])?$_POST['default_parley']:0;
			$show_suggestions = isset($_POST['show_suggestions'])?$_POST['show_suggestions']:1;
			$db->setQuery('UPDATE `users` SET `weight`=%f, `default_parley`=%d, `show_suggestions`=%d WHERE `id`=%d');
			$db->runQuery($_POST['weight'], $default_parley, $show_suggestions, $_SESSION['user']);
			$messages[] = 'User settings have been saved.';
			if(isset($_POST['password'],$_POST['password1'],$_POST['password2']) && $_POST['password1']) {
				if($_POST['password1'] == $_POST['password2']) {
					$db->setQuery('SELECT `password` FROM `users` WHERE `id`=%d');
					$db->runQuery($_SESSION['user']);
					if(password_verify($_POST['password'], $db->getResultSingle())) {
						$algo = PASSWORD_DEFAULT;
						if(defined('PASSWORD_ARGON2I') && $algo == PASSWORD_BCRYPT) {
							$algo = PASSWORD_ARGON2I;
						}
						$password = password_hash($_POST['password1'], $algo);
						$db->setQuery('UPDATE `users` SET `password`="%s" WHERE `id`=%d');
						$db->runQuery($password, $_SESSION['user']);
						$messages[] = 'Password has been successfully updated.';
					} else {
						global $errors;
						$errors[] = 'Current password was incorrect, password has not been updated.';
					}
				} else {
					global $errors;
					$errors[] = 'Passwords do not match, password has not been updated.';
				}
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
		<h2>Your Profile</h2>
	</div>
<?php
	}
	function body_content() {
		global $db;
		$db->setQuery('SELECT * FROM `users` WHERE `id`=%d');
		$db->runQuery($_SESSION['user']);
		$user = $db->getResult();
?>
<form action="/user" method="post">
	<div>
		<dl>
			<dt>Username:</dt>
			<dd><?=$user->username?></dd>
			<dt><label for="weight">Available Boat Weight:</label></dt>
			<dd><input type="number" name="weight" id="weight" value="<?=$user->weight?>" required="required" /></dd>
			<dt><label for="default_parley">Default Parley:</label></dt>
			<dd><input type="number" name="default_parley" id="default_parley" value="<?=$user->default_parley?>" required="required" /></dd>
			<dt><label for="show_suggestions">Show Barter Suggestions:</label></dt>
			<dd><select name="show_suggestions" id="show_suggestions">
				<option value="1"<?=$user->show_suggestions?' selected="selected"':''?>>Yes</option>
				<option value="0"<?=$user->show_suggestions?'':' selected="selected"'?>>No</option>
			</select></dd>
		</dl>
		<fieldset>
			<legend>Password Change</legend>
			<small>Only fill in if changing your password</small>
			<dl>
				<dt><label for="password">Current Password:</label></dt>
				<dd><input type="password" name="password" id="password" /></dd>
				<dt><label for="password1">New Password:</label></dt>
				<dd><input type="password" name="password1" id="password1" /></dd>
				<dt><label for="password2">New Password Again:</label></dt>
				<dd><input type="password" name="password2" id="password2" /></dd>
			</dl>
		</fieldset>
		<div style="text-align: center; margin-top: 1em;">
			<button type="submit">Update</button>
		</div>
	</div>
</form>
<?php
	}
