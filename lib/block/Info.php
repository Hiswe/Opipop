<?php

class Block_Info extends Block
{
    protected $_TEMPLATE = '';

    private $info = null;

    public function setInfo($info)
    {
        $this->info = $info;
    }

    public function configure()
    {
        $this->_TEMPLATE = 'lib/view/info/' . $this->info . '.tpl';
    }
}


