<?php

    $forbidenLogins = array('remote', 'login', 'logout', 'register', 'category', 'poll', 'users', 'infos');

    // If the login is not allowed exit
    if (in_array($_POST['login'], $forbidenLogins))
    {
        echo '0';
        exit();
    }

    // Look if this login exists
    $rs = DB::select
    ('
        SELECT `id`
        FROM `user`
        WHERE `login`="' . $_POST['login'] . '" AND `valided`=1
    ');

	// If this user is not already registered
	// TODO : check if the email is not allready taken
    if ($rs['total'] == 0)
    {
		// Encrypte password
		$key = md5(rand(0, 1000) + microtime());

		// Insert user's infos in the base
		$id = DB::insert('INSERT INTO `user` (`login`, `zip`, `gender`, `email`, `password`, `key`, `register_date`) VALUES
		(
			"' . $_POST['login'] . '",
			"' . $_POST['zip'] . '",
			"' . $_POST['gender'] . '",
			"' . $_POST['email'] . '",
			"' . md5($_POST['password']) . '",
			"' . $key . '",
			"' . time() . '"
		)');

		// TODO : register informations should be sent by email
		echo $key . chr(13) . $ROO_PATH . 'login/confirm?u=' . $id . '&k=' . $key;
	}

