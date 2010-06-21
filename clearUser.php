<?php

    include 'conf/default.php';
    include 'conf/local.php';
    include 'lib/Conf.php';
    Conf::register($conf);

    // AUTOLOADER
    function __autoload($className)
    {
        include Conf::get('ROOT_DIR') . 'lib/' . str_replace('_', '/', $className) . '.php';
    }

    $totalAffectedRows = 0;

    $rs = DB::select('
        SELECT `id` FROM `user` WHERE `login`= "' . $_GET['login'] . '"
    ');

    if ($rs['total'] > 0)
    {
        $id = $rs['data'][0]['id'];

        $affectedRows = DB::delete('
            DELETE FROM `user_result`
            WHERE user_id = "' . $id . '"
        ');
        $totalAffectedRows += ($affectedRows > 0) ? $affectedRows : 0;

        $affectedRows = DB::delete('
            DELETE FROM `user_guess`
            WHERE user_id = "' . $id . '"
        ');
        $totalAffectedRows += ($affectedRows > 0) ? $affectedRows : 0;

        $affectedRows = DB::delete('
            DELETE FROM `user_guess_friend`
            WHERE user_id = "' . $id . '"
        ');
        $totalAffectedRows += ($affectedRows > 0) ? $affectedRows : 0;

        echo '<h4>' . $totalAffectedRows . ' rows deleted</h4>';
    }
    else
    {
        echo '<h4>user not found</h4>';
    }

