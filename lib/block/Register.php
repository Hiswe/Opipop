<?php

class Block_Register extends Block
{
    protected $_TEMPLATE = 'lib/view/register.tpl';

    public function configure()
    {
        // If some user are connected
        if ($user = Model_User::getLoggedUser())
        {
            $this->tpl->assignSection('noLogin');
        }
        else
        {
            $this->tpl->assignSection('login');
        }
    }
}

