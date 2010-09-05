<?php

class Remote_Register extends Remote
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
        $this->block = new Block_Register();
        $this->block->configure();
    }
}

