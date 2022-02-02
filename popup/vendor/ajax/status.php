<?php
	include('../class/db.php');
	include('../class/status.php');
	$Status = new Status($Config->get('streaming/url'), 1, $Config->get('streaming/version'));
	$type = isset($_GET['type']) ? $_GET['type'] : '';
	$cloc = $Status->init('locutor');

	if(isset($_SERVER['REQUEST_METHOD']) && $_SERVER['REQUEST_METHOD'] == 'GET' && $type != ''){
		switch($type){

			case 'locutor':
				echo $Status->init('locutor');
			break;

			case 'programa':
				echo $Status->init('programa');
			break;

			case 'ouvintes':
				echo $Status->init('ouvintes');
			break;

			case 'unicos':
				echo $Status->init('unicos');
			break;
		}
	}