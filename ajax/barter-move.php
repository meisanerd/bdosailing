<?php
	chdir('../');
	require_once('config.inc.php');
	if(!isset($_SESSION['user']) || !$_SESSION['user']) {
		header('HTTP/1.0 403 Forbidden');
		die('Please log in.');
	}
	if(isset($_POST['barter'], $_POST['direction']) && intval($_POST['barter']) && $_POST['direction']) {
		$db->setQuery('SELECT `pos` FROM `trades` WHERE `user_id`=%d AND `id`=%d');
		$db->runQuery($_SESSION['user'], $_POST['barter']);
		$pos = $db->getResultSingle();
		if($pos !== false) {
			switch($_POST['direction']) {
				case 'up':
					$db->setQuery('SELECT `pos` FROM `trades` WHERE `user_id`=%d AND `pos` < %d ORDER BY `pos` DESC LIMIT 1');
					$db->runQuery($_SESSION['user'], $pos);
					$newpos = $db->getResultSingle();
					if($newpos !== false) {
						$db->setQuery('UPDATE `trades` SET `pos`=%d WHERE `user_id`=%d AND `pos`=%d');
						$db->runQuery($pos, $_SESSION['user'], $newpos);
						$db->setQuery('UPDATE `trades` SET `pos`=%d WHERE `user_id`=%d AND `id`=%d');
						$db->runQuery($newpos, $_SESSION['user'], $_POST['barter']);
						die('1');
					}
					die('Cannot move further up.');
					break;
				case 'down':
					$db->setQuery('SELECT `pos` FROM `trades` WHERE `user_id`=%d AND `pos` > %d ORDER BY `pos` ASC LIMIT 1');
					$db->runQuery($_SESSION['user'], $pos);
					$newpos = $db->getResultSingle();
					if($newpos !== false) {
						$db->setQuery('UPDATE `trades` SET `pos`=%d WHERE `user_id`=%d AND `pos`=%d');
						$db->runQuery($pos, $_SESSION['user'], $newpos);
						$db->setQuery('UPDATE `trades` SET `pos`=%d WHERE `user_id`=%d AND `id`=%d');
						$db->runQuery($newpos, $_SESSION['user'], $_POST['barter']);
						die('1');
					}
					die('Cannot move further down.');
					break;
			}
			die('Invalid direction');
		}
		die('Invalid barter.');
	} else {
		die('Please specify all required fields.');
	}