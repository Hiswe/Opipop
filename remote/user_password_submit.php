<?php

	require_once '../inc/conf.default.php';
	require_once '../inc/conf.local.php';
    require_once '../inc/setup.php';

    if (!$_SESSION['user'][$_POST['id']])
    {
        exit();
    }

    $rs = $db->select('SELECT `id` FROM `user` WHERE `password`="' . md5($_POST['old_password']) . '"');

    if ($rs['total'] == 0)
    {
        echo '0';
    }
    else
    {
        echo '1';

        $db->update('UPDATE `user` SET
            `password`="' . md5($_POST['new_password']) . '"
            WHERE `id`="' . $_POST['id'] . '"');
    }

