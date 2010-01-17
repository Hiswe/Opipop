<?php

	require_once '../inc/conf.default.php';
	require_once '../inc/conf.local.php';
    require_once '../inc/setup.php';

    if (!$_SESSION['user'][$_POST['id']])
    {
        exit();
    }

    $db->update('UPDATE `user` SET
        `zip`="' . $_POST['zip'] . '",
        `male`="' . $_POST['gender'] . '"
        WHERE `id`="' . $_POST['id'] . '"');

