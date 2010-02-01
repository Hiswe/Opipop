<?php

    if (!isOk($_POST['id']) || !isOk($_SESSION['user']) || $_SESSION['user']['id'] != $_POST['id'] || !isOk($_POST['old_password']) || !isOk($_POST['new_password']))
    {
		header('Location: ' . ROOT_PATH);
        exit();
    }

    $rs = $db->select('SELECT `id` FROM `user` WHERE `password`="' . md5($_POST['old_password']) . '"');

    if ($rs['total'] == 0)
    {
		$_SESSION['feedback'] = 'Your current password is not correct !';
    }
    else
    {
		$_SESSION['feedback'] = 'Password changed';

        $db->update('UPDATE `user` SET
            `password`="' . md5($_POST['new_password']) . '"
            WHERE `id`="' . $_POST['id'] . '"');
    }

	header('Location: ' . ROOT_PATH . $_POST['login']);

