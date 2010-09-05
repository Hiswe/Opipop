<?php

class Remote_Login_Submit extends Remote
{
    public $AJAXONLY = true;

    public function configureData()
    {
        // Select the user corresponding to the this login and password
        $rs = DB::select
        ('
            SELECT `id`,`login`, `key`
            FROM `user`
            WHERE `login`="' . $_POST['login'] . '" AND `password`="' . md5($_POST['password']) . '" AND `valided`=1
        ');

        // If there is none do nothing
        if ($rs['total'] == 0)
        {
            echo '0';
        }
        // Else log this user
        else
        {
            $user = $rs['data'][0];

            Model_User::login((int)$user['id']);

            echo '1';
        }
    }
}

