<?php

include 'page/block/top.php';

if (!is_array($_SESSION['user']) || count($_SESSION['user']) == 0)
{
	// TODO : Error no user logged
	exit();
}

foreach ($_SESSION['user'] as $id => $info)
{
    if (strtolower($info['login']) == strtolower($_GET['login']))
    {
        $userId = $id;
        break;
    }
}

if (!isset($userId))
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

