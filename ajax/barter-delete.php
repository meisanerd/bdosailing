<?php
	chdir('../');
	require_once('config.inc.php');
	if(!isset($_SESSION['user']) || !$_SESSION['user']) {
		header('HTTP/1.0 403 Forbidden');
		die('{"error":"Please log in."}');
	}
	if(isset($_POST['barter'], $_POST['complete']) && intval($_POST['barter'])) {
		if(intval($_POST['complete'])) {
			$db->setQuery('SELECT * FROM `trades` WHERE `user_id`=%d AND `id`=%d');
			$db->runQuery($_SESSION['user'],$_POST['barter']);
			$trade = $db->getResult();
			$weight = 0;
			$record_trade = true;
			$db->setQuery('SELECT `level`, `weight`, `record_trade` FROM `trade_items` WHERE `id`=%d');
			$db->runQuery($trade->input_id);
			$item = $db->getResult();
			if($item->level) {
				$db->setQuery('UPDATE `user_trade_items` SET `num`=`num`-%d WHERE `user_id`=%d AND `trade_item_id`=%d');
				$db->runQuery($trade->input_qty * $trade->num, $_SESSION['user'], $trade->input_id);
			}
			if(!$item->record_trade) {
				$record_trade = false;
			}
			$weight += $trade->input_qty * $trade->num * $item->weight;
			$db->setQuery('SELECT `level`, `weight`, `record_trade` FROM `trade_items` WHERE `id`=%d');
			$db->runQuery($trade->output_id);
			$item = $db->getResult();
			if($item->level) {
				$db->setQuery('INSERT INTO `user_trade_items` (`user_id`,`trade_item_id`,`num`) VALUES (%1$d, %2$d, %3$d) ON DUPLICATE KEY UPDATE `num`=`num`+%3$d');
				$db->runQuery($_SESSION['user'], $trade->output_id, $trade->output_qty * $trade->num);
			}
			if(!$item->record_trade) {
				$record_trade = false;
			}
			$weight -= $trade->output_qty * $trade->num * $item->weight;
			$db->setQuery('UPDATE `users` SET `parley`=`parley`-%d, `current_weight`=`current_weight`+%d WHERE `id`=%d');
			$db->runQuery($trade->num * $trade->parley, $weight, $_SESSION['user']);
			if($record_trade) {
				$db->setQuery('INSERT INTO `trade_location_item_map` (`location_id`, `input_id`, `output_id`) VALUES (%d, %d, %d)');
				$db->runQuery($trade->location_id, $trade->input_id, $trade->output_id);
			}
		}
		$db->setQuery('DELETE FROM `trades` WHERE `user_id`=%d AND `id`=%d');
		$db->runQuery($_SESSION['user'], $_POST['barter']);
		$db->setQuery('SELECT `id` FROM `trades` WHERE `user_id`=%d ORDER BY `pos` ASC');
		$db->runQuery($_SESSION['user']);
		$postrades = $db->getResultsSingle();
		$db->setQuery('UPDATE `trades` SET `pos`=%d WHERE `id`=%d AND `user_id`=%d');
		$x = 0;
		foreach($postrades as $postrade) {
			$db->runQuery($x++, $postrade, $_SESSION['user']);
		}
		$db->setQuery('SELECT `parley`,`current_weight` FROM `users` WHERE `id`=%d');
		$db->runQuery($_SESSION['user']);
		die(json_encode($db->getResult()));
	} else {
		die('{"error":"Please specify all required fields."}');
	}