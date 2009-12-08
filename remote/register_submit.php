<?php

	require_once '../inc/conf.default.php';
	require_once '../inc/conf.local.php';
    require_once '../inc/setup.php';

    $key = md5(rand(0, 1000) + microtime());

    $id = $db->insert('INSERT INTO `user` (`login`, `email`, `password`, `key`, `register_date`) VALUES
    (
        "' . $_POST['login'] . '",
        "' . $_POST['email'] . '",
        "' . md5($_POST['password']) . '",
        "' . $key . '",
		"' . time() . '"
    )');


    echo $key . chr(13) . $ROO_PATH . 'login/confirm?u=' . $id . '&k=' . $key;

