<?php

class Remote_Register_CheckEmail extends Remote
{
    public $AJAXONLY = true;

    public function configureData()
    {
        // Look if this login exists
        $rs = DB::select
        ('
            SELECT `id`
            FROM `user`
            WHERE `email`="' . $_POST['email'] . '" AND `valided`=1
        ');

        echo ($rs['total'] != 0) ? 0 : 1;
    }
}


