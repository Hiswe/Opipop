<?php

class Remote_Login extends Remote
{
    public $AJAXONLY = false;

    private $block;

    public function configureView()
    {
        if ($this->block)
        {
            $this->block->assignTemplate();
        }
    }

    public function configureData()
    {
        $this->block = new Block_Login();
        $this->block->configure();
    }
}

