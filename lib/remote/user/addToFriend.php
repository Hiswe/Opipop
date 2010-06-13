<?php

    if (!($user = Model_User::getLoggedUser()))
    {
        $_SESSION['warning'] = 'You need to be logged to add users to your friends';
		echo 'register';
        exit();
    }

    $userId   = $user->getId();
    $friendId = $_POST['friendId'];

    if ($userId == $friendId)
    {
        $_SESSION['warning'] = 'You are allready friend with this persone';
		echo 'reload';
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

	echo json_encode(array
	(
		'friendId' => $friendId,
		'userId'   => $userId,
		'action'   => $_POST['action'],
	));

