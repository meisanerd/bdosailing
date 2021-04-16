<?php
	chdir('../');
	require_once('config.inc.php');
	if(!isset($_SESSION['user']) || !$_SESSION['user']) {
		header('HTTP/1.0 403 Forbidden');
		die('Please log in.');
	}
	require_once('templates/barter.php');
	if(isset($_POST['mode']) && $_POST['mode'] == 'add_loads') {
		barter_loads_dialog();
	} else if(isset($_POST['mode']) && $_POST['mode'] == 'add_unloads') {
		barter_unloads_dialog();
	} else if(isset($_POST['barter']) && intval($_POST['barter'])) {
		$db->setQuery('SELECT * FROM `trades` WHERE `user_id`=%d AND `id`=%d');
		$db->runQuery($_SESSION['user'], $_POST['barter']);
		$trade = $db->getResult();
		barter_dialog($trade);
	} else {
		barter_dialog();
	}