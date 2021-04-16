<?php
	chdir('../');
	require_once('config.inc.php');
	if(!isset($_SESSION['user']) || !$_SESSION['user']) {
		header('HTTP/1.0 403 Forbidden');
		die('{"error": "Please log in."}');
	}
	if(isset($_POST['barter'], $_POST['location_id'], $_POST['input_id'], $_POST['input_qty'], $_POST['output_id'], $_POST['output_qty'], $_POST['num'], $_POST['parley']) && intval($_POST['location_id']) && intval($_POST['input_id']) && intval($_POST['output_id']) && intval($_POST['num'])) {
		if($_POST['output_id'] == 104) {
			die('{"error": "This cannot be a result item."}');
		}
		if($_POST['input_id'] == 55) {
			die('{"error": "This cannot be a barter input item."}');
		}
		if($_POST['input_id'] != 104 && !intval($_POST['input_qty'])) {
			die('{"error": "Please specify input quantity."}');
		}
		if($_POST['output_id'] != 55 && !intval($_POST['output_qty'])) {
			die('{"error": "Please specify output quantity."}');
		}
		if(intval($_POST['barter'])) {
			$db->setQuery('UPDATE `trades` SET `location_id`=%d, `input_id`=%d, `input_qty`=%d, `output_id`=%d, `output_qty`=%d, `num`=%d, `parley`=%d WHERE `user_id`=%d AND `id`=%d');
			$db->runQuery($_POST['location_id'], $_POST['input_id'], $_POST['input_qty'], $_POST['output_id'], $_POST['output_qty'], $_POST['num'], $_POST['parley'], $_SESSION['user'], $_POST['barter']);
		} else {
			if(intval($_POST['trade_insert_position']) == -1) {
				$db->setQuery('SELECT MAX(`pos`) FROM `trades` WHERE `user_id`=%d');
				$db->runQuery($_SESSION['user']);
				$pos = intval($db->getResultSingle()) + 1;
			} else {
				$pos = intval($_POST['trade_insert_position']);
				$db->setQuery('UPDATE `trades` SET `pos`=`pos`+1 WHERE `pos` >= %d AND `user_id`=%d');
				$db->runQuery($pos, $_SESSION['user']);
			}
			$db->setQuery('INSERT INTO `trades` (`user_id`,`location_id`,`input_id`,`input_qty`,`output_id`,`output_qty`,`pos`,`num`,`parley`) VALUES (%d,%d,%d,%d,%d,%d,%d,%d,%d)');
			$db->runQuery($_SESSION['user'], $_POST['location_id'], $_POST['input_id'], $_POST['input_qty'], $_POST['output_id'], $_POST['output_qty'], $pos, $_POST['num'], $_POST['parley']);
			$_POST['barter'] = $db->getLastId();
		}
		$db->setQuery('SELECT * FROM `trades` WHERE `user_id`=%d AND `id`=%d');
		$db->runQuery($_SESSION['user'], $_POST['barter']);
		$trade = $db->getResult();
		$return = new stdClass();
		require_once('templates/barter.php');
		ob_start();
		barter($trade);
		$return->html = ob_get_clean();
		$return->pos = $trade->pos;
		die(json_encode($return));
	} else {
		die('{"error": "Please specify all required fields."}');
	}