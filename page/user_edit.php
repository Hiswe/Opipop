<?php

include 'page/block/top.php';

if (!isOk($_SESSION['user']))
{
	// TODO : Error no user logged
	exit();
}

if (strtolower($_SESSION['user']['login']) == strtolower($_GET['login']))
{
	$userId = $_SESSION['user']['id'];
}
else
{
	// TODO : Error this user is not logged
	exit();
}

$tpl->assignSection('private');

if (file_exists(ROOT_DIR . 'media/avatar/' . AVATAR_LARGE_SIZE . '/' . $userId . '.jpg'))
{
	$tpl->assignVar('avatar', AVATAR_LARGE_SIZE . '/' . $userId . '.jpg');
}
else
{
	$tpl->assignVar('avatar', AVATAR_LARGE_SIZE . '/0.jpg');
}

$rs = $db->select('SELECT `male`, `zip` FROM `user` WHERE `id`="' . $userId . '"');

if ($rs['total'] != 0)
{
    $user = $rs['data'][0];

    $tpl->assignVar(array
    (
        'user_id'    => $userId,
        'user_login' => $_GET['login'],
        'user_male'  => $user['male'],
        'user_zip'   => $user['zip'],

        'user_edit_zip_' . $user['zip']     => ' selected="selected"',
        'user_edit_gender_' . $user['male'] => ' selected="selected"',
    ));
}

