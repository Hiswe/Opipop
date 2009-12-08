<?php

	require_once '../inc/conf.default.php';
	require_once '../inc/conf.local.php';
    require_once '../inc/setup.php';

    $rs = $db->select
	('
		SELECT `id`,`login`,`email`,`register_date`
		FROM `user`
		WHERE `login`="' . $_POST['login'] . '" AND `password`="' . md5($_POST['password']) . '" AND `valided`=1
	');

    if ($rs['total'] == 0)
    {
        echo '0';
    }
    else
    {
		$user = $rs['data'][0];
		$_SESSION['user'][$user['id']] = array
		(
			'login'         => $user['login'],
			'email'         => $user['email'],
			'register_date' => $user['register_date'],
		);

        echo '1';
    }

