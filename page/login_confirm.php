<?php

// If we have a key and a user id in the query params
if (isOk($_GET['u']) && isOk($_GET['k']))
{
    // If the user is already logged
    if (isOk($_SESSION['user'][$_GET['u']]))
    {
        $tpl->assignSection('confirm_ok');
    }
    else
    {
        // Select user's infos
        $result = $db->select
        ('
            SELECT `valided`,`login`,`email`,`register_date`
            FROM `user`
            WHERE `id`="' . $_GET['u'] . '" AND `key`="' . $_GET['k'] . '"
        ');

        // If the user exists and has the good key
        if ($result['total'] != 0)
        {
            $user = $result['data'][0];

            // Validate his registration
            if ($user['valided'] == 0)
            {
                $db->update('UPDATE `user` SET `valided`=1 WHERE `id`="' . $_GET['u'] . '"');
            }

            // Log the user
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

