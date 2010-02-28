<?php

    header('Content-Type: application/json; charset=utf-8');
    header("Cache-Control: no-cache");

    DB::update('
        UPDATE `category`
        SET `position` = `position` + 1
    ');

    $id = DB::insert('INSERT INTO `category` (`status`, `position`, `label`) VALUES
    (
        "0",
        "0",
        "' . $_POST['label'] . '"
    )');

    echo json_encode(array(
        'id' => $id,
        'label' => $_POST['label'],
    ));;

