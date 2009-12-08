<?php

if (isOk($_GET['u']) && isOk($_GET['k']))
{
    if (isOk($_SESSION['user'][$_GET['u']]))
    {
        $tpl->assignSection('confirm_ok');
    }
    else
    {
        $result = $db->select
        ('
            SELECT `valided`,`login`,`email`,`register_date`
            FROM `user`
            WHERE `id`="' . $_GET['u'] . '" AND `key`="' . $_GET['k'] . '"
        ');

        if ($result['total'] != 0)
        {
            $user = $result['data'][0];

            if ($user['valided'] == 0)
            {
                $db->update('UPDATE `user` SET `valided`=1 WHERE `id`="' . $_GET['u'] . '"');
            }

            $_SESSION['user'][$_GET['u']] = array
            (
                'login'         => $user['login'],
                'email'         => $user['email'],
                'register_date' => $user['register_date'],
            );

            $tpl->assignSection('confirm_ok');
        }
        else
        {
            $tpl->assignSection('confirm_error');
        }
    }
}
else
{
	$tpl->assignSection('confirm_wait');
}

