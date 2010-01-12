<?php

	require_once '../../inc/conf.default.php';
	require_once '../../inc/conf.local.php';
    require_once '../../inc/setup.php';

    header('Content-Type: application/json; charset=utf-8');
    header("Cache-Control: no-cache");

    set_time_limit(20);
    ini_set("memory_limit",'16M');

	$rs = $db->select('SELECT `id`, `status`, `label` FROM question ORDER BY `date` DESC');

	echo json_encode($rs['data']);

