<?php
	chdir('../');
	require_once('config.inc.php');
	if(!isset($_SESSION['user']) || !$_SESSION['user']) {
		header('HTTP/1.0 403 Forbidden');
		die('Please log in.');
	}
	require_once('templates/barter.php');
	$location = isset($_POST['location'])?intval($_POST['location']):false;
	$input = isset($_POST['input'])?intval($_POST['input']):false;
	$output = isset($_POST['output'])?intval($_POST['output']):false;
	if($location || $input || $output) {
		suggestions($location, $input, $output);
	}