<?php

	require_once '../../inc/conf.default.php';
	require_once '../../inc/conf.local.php';
    require_once '../../inc/setup.php';

    header('Content-Type: application/json; charset=utf-8');
    header("Cache-Control: no-cache");

	$id = $db->insert('INSERT INTO `question` (`date`, `label`) VALUES
    (
        "' . time() . '",
        "' . $_POST['label'] . '"
    )');

    echo json_encode(array(
        'id' => $id,
        'date' => time(),
        'label' => $_POST['label'],
    ));;

