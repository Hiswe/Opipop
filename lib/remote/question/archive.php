<?php

class Remote_Question_Archive extends Remote
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
        $this->block = new Block_Question_Archive();
        $this->block->setPage($_POST['page']);
        $this->block->configure();
    }
}

