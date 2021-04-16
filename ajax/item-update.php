<?php
	chdir('../');
	require_once('config.inc.php');
	if(!isset($_SESSION['user']) || !$_SESSION['user']) {
		header('HTTP/1.0 403 Forbidden');
		die('{"error": "Please log in."}');
	}
	if(isset($_POST['item'], $_POST['num'], $_POST['notes']) && intval($_POST['item'])) {
		$db->setQuery('INSERT INTO `user_trade_items` (`user_id`,`trade_item_id`,`num`,`notes`) VALUES (%1$d, %2$d, %3$d, "%4$s") ON DUPLICATE KEY UPDATE `num`=%3$d, `notes`="%4$s"');
		$db->runQuery($_SESSION['user'], $_POST['item'], $_POST['num'], $_POST['notes']);
		$db->setQuery('SELECT `num`,`notes` FROM `user_trade_items` WHERE `user_id`=%d AND `trade_item_id`=%d');
		$db->runQuery($_SESSION['user'], $_POST['item']);
		die(json_encode($db->getResult()));
	} else {
		die('{"error": "Please specify all required fields."}');
	}