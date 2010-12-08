<?php

class Remote_Help extends Remote
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
        $this->block = new Block_Help();
        $this->block->setInfo($_GET['info']);
        $this->block->configure();
    }
}

