<?php

class Block_Register extends Block
{
    protected $template = 'lib/view/register.tpl';

    public function configure()
    {
        // If some user are connected
        if ($user = Model_User::getLoggedUser())
        {
            Globals::$tpl->assignSection('noLogin');
        }
        else
        {
            Globals::$tpl->assignSection('login');
        }
    }
}

