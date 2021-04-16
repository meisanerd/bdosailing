<?php
	function handle_post() {
		if(isset($_POST['user'],$_POST['password']) && $_POST['user'] && $_POST['password']) {
			global $db;
			$db->setQuery('SELECT * FROM `users` WHERE `username`="%s"');
			$db->runQuery($_POST['user']);
			$user = $db->getResult();
			if($user && password_verify($_POST['password'], $user->password)) {
				global $page;
				$_SESSION['user'] = $user->id;
				$_SESSION['admin'] = $user->admin;
				header('Location: /' . ($page=='login'?'':$page));
				exit;
			} else {
				global $errors;
				$errors[] = 'Credentials are incorrect.';
			}
		}
	}
	function body_content() {
		global $page;
?>
<form action="/<?=$page=='login'?'':$page?>" method="post">
	<dl>
		<dt><label for="user">Username:</label></dt>
		<dd><input type="text" name="user" id="user" value="<?=isset($_POST['user'])?htmlspecialchars($_POST['user']):''?>" required="required" /></dd>
		<dt><label for="password">Password:</label></dt>
		<dd><input type="password" name="password" id="password" required="required" /></dd>
	</dl>
	<button type="submit">Log In</button>
</form>
<?php
	}