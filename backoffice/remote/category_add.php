<?php

    require_once '../../inc/conf.default.php';
    require_once '../../inc/conf.local.php';
    require_once '../../inc/setup.php';

    header('Content-Type: application/json; charset=utf-8');
    header("Cache-Control: no-cache");

    $db->update('UPDATE `category` SET `position` = `position` + 1');

    $id = $db->insert('INSERT INTO `category` (`status`, `position`, `label`) VALUES
    (
        "0",
        "0",
        "' . $_POST['label'] . '"
    )');

    echo json_encode(array(
        'id' => $id,
        'label' => $_POST['label'],
    ));;

