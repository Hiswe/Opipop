<?php

    if (!Tool::isOk($_POST['id']) || !($user = Model_User::getLoggedUser()) || $user->getId() != $_POST['id'] || !Tool::isOk($_POST['old_password']) || !Tool::isOk($_POST['new_password']))
    {
        header('Location: ' . Conf::get('ROOT_PATH'));
        exit();
    }

    $rs = DB::select('SELECT `id` FROM `user` WHERE `password`="' . md5($_POST['old_password']) . '"');

    if ($rs['total'] == 0)
    {
        $_SESSION['feedback'] = 'Your current password is not correct !';
    }
    else
    {
        $_SESSION['feedback'] = 'Password changed';

        DB::update('UPDATE `user` SET
            `password`="' . md5($_POST['new_password']) . '"
            WHERE `id`="' . $_POST['id'] . '"');
    }

    header('Location: ' . Conf::get('ROOT_PATH'). $_POST['login']);

