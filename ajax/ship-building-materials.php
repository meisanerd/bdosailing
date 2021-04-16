<?php
	chdir('../');
	require_once('config.inc.php');
	if(!isset($_SESSION['user']) || !$_SESSION['user']) {
		header('HTTP/1.0 403 Forbidden');
		die('{"error":"Please log in."}');
	}
	if(isset($_POST['params'])) {
		$params = new stdClass();
		foreach($_POST['params'] as $param) {
			$params->{$param["name"]} = intval($param["value"]);
		}
		$db->setQuery('INSERT INTO `ship_building_materials` (`user_id`,`materials`) VALUES (%1$d, "%2$s") ON DUPLICATE KEY UPDATE `materials`="%2$s"');
		$db->runQuery($_SESSION['user'], json_encode($params));
		die('{"success":"1"}');
	} else {
		die('{"error":"Please specify all required fields."}');
	}