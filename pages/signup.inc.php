<?php
	function handle_post() {
		if(isset($_POST['username'],$_POST['password1'],$_POST['password2']) && $_POST['username']) {
			global $db;
			$db->setQuery('SELECT * FROM `users` WHERE `username`="%s"');
			$db->runQuery($_POST['username']);
			$user = $db->getResult();
			if($user && $user->password=='12345') {
				if($_POST['password1'] == $_POST['password2']) {
					$username = $user->username;
					if($_POST['changeusername']) {
						$db->setQuery('SELECT COUNT(*) FROM `users` WHERE `username`="%s" AND `id` != %d');
						$db->runQuery($_POST['changeusername'], $user->id);
						if($db->getResultSingle()) {
							global $errors;
							$errors[] = 'That username is already in use.';
							return;
						}
						$username = $_POST['changeusername'];
					}
					global $messages;
					$algo = PASSWORD_DEFAULT;
					if(defined('PASSWORD_ARGON2I') && $algo == PASSWORD_BCRYPT) {
						$algo = PASSWORD_ARGON2I;
					}
					$password = password_hash($_POST['password1'], $algo);
					$db->setQuery('UPDATE `users` SET `username`="%s", `password`="%s" WHERE `id`=%d');
					$db->runQuery($username, $password, $user->id);
					$messages[] = 'You have been successfully registered. Click <a href="/">here</a> to log in.';
				} else {
					global $errors;
					$errors[] = 'Passwords do not match.';
				}
			} else {
				global $errors;
				$errors[] = 'Username does not exist or is not allowed to register.';
			}
		}
	}
	function body_content() {
?>
<form action="/signup" method="post">
	<div>
		<dl>
			<dt><label for="username">Username:</label></dt>
			<dd><input type="text" name="username" id="username" value="<?=isset($_POST['username'])?htmlspecialchars($_POST['username']):''?>" required="required" /></dd>
			<dt><label for="changeusername">New Username (If you want to change it):</label></dt>
			<dd><input type="text" name="changeusername" id="changeusername" value="<?=isset($_POST['changeusername'])?htmlspecialchars($_POST['changeusername']):''?>" /></dd>
			<dt><label for="password1">Password:</label></dt>
			<dd><input type="password" name="password1" id="password1" required="required" /></dd>
			<dt><label for="password2">Password Again:</label></dt>
			<dd><input type="password" name="password2" id="password2" required="required" /></dd>
		</dl>
		<button type="submit">Register</button>
	</div>
</form>
<?php
	}