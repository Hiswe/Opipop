<?php

    header('Content-Type: application/json; charset=utf-8');
    header("Cache-Control: no-cache");

    $id = DB::insert('INSERT INTO `question` (`date`, `label`, `category_id`) VALUES
    (
        "' . time() . '",
        "' . $_POST['label'] . '",
        "' . $_POST['category_id'] . '"
    )');

    echo json_encode(array(
        'id' => $id,
        'date' => time(),
        'label' => $_POST['label'],
    ));;

