<?php

	require_once '../inc/conf.default.php';
	require_once '../inc/conf.local.php';
    require_once '../inc/setup.php';

    // Look if this login exists
    $rs = $db->select
    ('
        SELECT `id`
        FROM `user`
        WHERE `login`="' . $_POST['login'] . '" AND `valided`=1
    ');

    if ($rs['total'] != 0)
    {
        echo '0';
    }
    else
    {
        echo '1';
    }

