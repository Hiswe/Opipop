<?php

    $forbidenLogins = array('remote', 'login', 'logout', 'register', 'category', 'poll', 'users', 'infos');

    if (in_array($_POST['login'], $forbidenLogins))
    {
        echo '0';
    }
    else
    {
        // Look if this login exists
        $rs = DB::select
        ('
            SELECT `id`
            FROM `user`
            WHERE `login`="' . $_POST['login'] . '" AND `valided`=1
        ');

		echo ($rs['total'] != 0) ? 0 : 1;
    }

