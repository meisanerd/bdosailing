<?php
	require_once('config.inc.php');
	$page = isset($_REQUEST['page'])?str_replace(array('..','/','\\'),'',$_REQUEST['page']):'home';
	if(isset($_REQUEST['logout'])) {
		unset($_SESSION['user']);
	}
	if((!isset($_SESSION['user']) || !$_SESSION['user']) && $page != 'signup') {
		require_once('pages/login.inc.php');
	} else if(file_exists('pages/' . $page . '.inc.php')) {
		require_once('pages/' . $page . '.inc.php');
	} else {
		header('Location: /');
		exit;
	}
	if(!function_exists('style_content')) {
		function style_content() {
		}
	}
	if(!function_exists('header_content')) {
		function header_content() {
		}
	}
	if(!function_exists('body_content')) {
		function body_content() {
		}
	}
	if(function_exists('handle_post')) {
		handle_post();
	}
?>
<!DOCTYPE html>
<html>
<head>
	<title>BDO Barter Planner</title>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<style type="text/css">
		html, body {
			margin: 0;
			padding: 0;
			width: 100%;
			height: 100%;
		}
		body {
			font-size: 16px;
			display: flex;
			flex-direction: column;
			background: #1D1D1F;
			color: #C9BDA5;
		}
		a {
			color: #D4B67A;
		}
		input, button, select, textarea {
			background: #222327;
			color: #A1978B;
			border: 1px solid #444245;
		}
		#errors, #messages {
			flex: none;
		}
		#errors div, #messages div {
			background: #FF9999;
			color: #000000;
			padding: 1em;
		}
		#errors a, #messages a {
			color: #000000;
		}
		#messages div {
			background: #CCFFCC;
		}
		#top_container, #menu_top_container {
			flex: none;
			display: flex;
			flex-direction: row;
			padding: 0 0.5em;
			height: 60px;
			background: #735B39;
			color: #FFEDD2;
		}
		#top_container button, #menu_top_container button {
			margin-top: 4px;
		}
		#menu_button, #menu_close_button {
			flex: none;
			width: 70px;
		}
		#main_menu, #menu_close {
			display: block;
			float: right;
			width: 50px;
			height: 50px;
		}
		#menu_dialog {
			position: fixed;
			top: 0;
			left: 0;
			width: 100%;
			height: 100%;
			background: #1D1D1F;
			display: none;
			flex-direction: column;
		}
		#menu_links {
			flex: 1;
			overflow: auto;
			padding: 1em;
		}
		#menu_links a {
			padding: 0.5em;
			display: block;
			text-align: center;
			border-bottom: 1px solid #444547;
			text-decoration: none;
		}
<?php style_content(); ?>
	</style>
	<script type="text/javascript" src="js/jquery-3.5.1.min.js"></script>
	<script type="text/javascript">
		$(document).ready(function() {
			$("#main_menu").click(function(e) {
				e.preventDefault();
				$("#menu_dialog").show().css("display","flex");
			});
			$("#menu_close").click(function(e) {
				e.preventDefault();
				$("#menu_dialog").hide();
			});
			$(document).ajaxError(function(event, response) {
				if(response.status == 403) {
					alert("You must log in again");
					window.location.reload();
				}
			});
		});
<?php
	if(file_exists('js/pages/' . $page . '.js')) {
		readfile('js/pages/' . $page . '.js');
	}
?>
	</script>
</head>
<body>
<?php if(isset($_SESSION['user']) && $_SESSION['user']) { ?>
	<div id="top_container">
<?php header_content(); ?>
		<div id="menu_button">
			<button id="main_menu">Menu</button>
		</div>
	</div>
<?php
	}
	if(count($errors)) {
?>
	<div id="errors"><div><?=implode('</div><div>', $errors)?></div></div>
<?php
	}
	if(count($messages)) {
?>
	<div id="messages"><div><?=implode('</div><div>', $messages)?></div></div>
<?php
	}
	body_content();
	if(isset($_SESSION['user']) && $_SESSION['user']) {
?>
<div id="menu_dialog">
	<div id="menu_top_container">
		<div style="flex: 1;">
			<h2>Menu</h2>
		</div>
		<div id="menu_close_button">
			<button id="menu_close">Close</button>
		</div>
	</div>
	<div id="menu_links">
		<div><a href="/">Home</a></div>
		<div><a href="/barter-routes">Barter Routes</a></div>
		<div><a href="/trade-items">Trade Items</a></div>
		<div><a href="/ship-building-materials">Ship Building Materials</a></div>
<?php if($_SESSION['admin']) { ?>
		<div><a href="/add-trade-item">Add Trade Item</a></div>
		<div><a href="/add-location">Add Location</a></div>
<?php } ?>
		<div><a href="/user">Your Profile</a></div>
		<div><a href="/help">Help</a></div>
		<div><a href="/?logout=true">Log Out</a></div>
	</div>
</div>
<?php } ?>
</body>
</html>