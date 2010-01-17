<?php

include 'page/block/top.php';

foreach ($_SESSION['user'] as $id => $info)
{
    if ($info['login'] == $_GET['login'])
    {
        $userId = $id;
        break;
    }
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

