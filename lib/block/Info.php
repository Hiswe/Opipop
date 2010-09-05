<?php

class Block_Info extends Block
{
    protected $template = '';

    private $info = null;

    public function setInfo($info)
    {
        $this->info = $info;
    }

    public function configure()
    {
        $this->TEMPLATE = 'lib/view/info/' . $this->info . '.tpl';
    }
}


