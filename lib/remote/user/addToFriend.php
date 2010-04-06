<?php

    if (!Tool::isOk($_SESSION['user']))
    {
        exit();
    }

    $userId   = $_SESSION['user']['id'];
    $friendId = $_POST['friendId'];

    if ($userId == $friendId)
    {
        exit();
    }

    if ($_POST['action'] == 'add')
    {
        $rs_friend = DB::select('
            SELECT `valided`
            FROM `friend`
            WHERE (`user_id_1`="' . $friendId . '" AND `user_id_2`="' . $userId . '")
            OR (`user_id_1`="' . $userId . '" AND `user_id_2`="' . $friendId . '")
        ');

        if ($rs_friend['total'] == 0)
        {
            DB::insert('INSERT INTO `friend` (`user_id_1`, `user_id_2`, `date`) VALUES
            (
                "' . $userId . '",
                "' . $friendId . '",
                "' . time() . '"
            )');
        }
    }
    else if ($_POST['action'] == 'accept')
    {
        DB::update('UPDATE `friend` SET `valided`="1" WHERE `user_id_1`="' . $friendId . '" AND `user_id_2`="' . $userId . '"');
    }
    else
    {
        DB::delete('DELETE FROM `friend`
            WHERE (`user_id_1`="' . $friendId . '" AND `user_id_2`="' . $userId . '")
            OR (`user_id_1`="' . $userId . '" AND `user_id_2`="' . $friendId . '")
        ');
    }

