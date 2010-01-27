<?php

	require_once '../inc/conf.default.php';
	require_once '../inc/conf.local.php';
    require_once '../inc/setup.php';

	if (!isOk($_SESSION['user']))
    {
        exit();
    }

	foreach($_SESSION['user'] as $id => $data)
	{
		$userId = $id;
		break;
	}

	$friendId = $_POST['friendId'];

	if ($userId == $friendId)
	{
		exit();
	}

	if ($_POST['action'] == 'add')
	{
		$rs_friend = $db->select('
			SELECT `valided`
			FROM `friend`
			WHERE (`user_id_1`="' . $friendId . '" AND `user_id_2`="' . $userId . '")
			OR (`user_id_1`="' . $userId . '" AND `user_id_2`="' . $friendId . '")
		');

		if ($rs_friend['total'] == 0)
		{
			$db->insert('INSERT INTO `friend` (`user_id_1`, `user_id_2`, `date`) VALUES
			(
				"' . $userId . '",
				"' . $friendId . '",
				"' . time() . '"
			)');
		}
	}
	else if ($_POST['action'] == 'accept')
	{
		$db->update('UPDATE `friend` SET `valided`="1" WHERE `user_id_1`="' . $friendId . '" AND `user_id_2`="' . $userId . '"');
	}
	else
	{
		$db->delete('DELETE FROM `friend`
			WHERE (`user_id_1`="' . $friendId . '" AND `user_id_2`="' . $userId . '")
			OR (`user_id_1`="' . $userId . '" AND `user_id_2`="' . $friendId . '")
		');
	}

