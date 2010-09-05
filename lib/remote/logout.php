<?php

class Remote_Logout extends Remote
{
    public $AJAXONLY = false;

    public function configureData()
    {
        // Logout user
        Model_User::logout();

        // Go back to home or to where I was
        if (substr($_SERVER['HTTP_REFERER'], 0, strlen(Conf::get('ROOT_PATH'))) == Conf::get('ROOT_PATH'))
        {
            header('Location: ' . $_SERVER['HTTP_REFERER']);
        }
        else
        {
            header('Location: ' . Conf::get('ROOT_PATH'));
        }
    }

}

