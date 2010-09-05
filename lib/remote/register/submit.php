<?php

class Remote_Register_Submit extends Remote
{
    public $AJAXONLY = true;

    public function configureData()
    {
        // Look if this login exists
        $rs = DB::select
        ('
            SELECT `id`
            FROM `user`
            WHERE `login`="' . $_POST['login'] . '" AND `valided`=1
        ');

        // If this user is not already registered
        // TODO : check if the email is not allready taken
        if ($rs['total'] == 0)
        {
            // Encrypte password
            $key = md5(rand(0, 1000) + microtime());

            // Insert user's infos in the base
            $id = DB::insert('INSERT INTO `user` (`login`, `zip`, `male`, `email`, `password`, `key`, `register_date`) VALUES
            (
                "' . $_POST['login'] . '",
                "' . $_POST['zip'] . '",
                "' . $_POST['gender'] . '",
                "' . $_POST['email'] . '",
                "' . md5($_POST['password']) . '",
                "' . $key . '",
                "' . time() . '"
            )');

            // TODO : register informations should be sent by email
            echo $key . chr(13) . Conf::get('ROO_PATH') . $_POST['login'] . '/confirm?u=' . $id . '&k=' . $key;
        }
    }
}

