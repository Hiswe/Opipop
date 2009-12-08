<?php

	require_once '../inc/conf.default.php';
	require_once '../inc/conf.local.php';
    require_once '../inc/setup.php';

    $rs = $db->select('SELECT `id` FROM `user` WHERE `login`="' . $_POST['login'] . '" AND `password`="' . md5($_POST['password']) . '" AND `valided`=1');

    if ($rs['total'] == 0)
    {
        echo '0';
    }
    else
    {
		$_SESSION['user'] = $rs['data']['0']['id'];

        echo '1';
    }

