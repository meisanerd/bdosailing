<?php
	chdir('../');
	require_once('config.inc.php');
	if(!isset($_SESSION['user']) || !$_SESSION['user']) {
		header('HTTP/1.0 403 Forbidden');
		die('Please log in.');
	}
	if(isset($_POST['parley']) && intval($_POST['parley'])) {
		$db->setQuery('UPDATE `users` SET `parley`=%d WHERE `id`=%d');
		$db->runQuery($_POST['parley'], $_SESSION['user']);
		die('1');
	} else {
		die('Please specify all required fields.');
	}