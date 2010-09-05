<?php

class Remote_User_Edit extends Remote
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
        $this->block = new Block_User_Edit();
        $this->block->setUser(new Model_User($_GET['userId']));
        $this->block->configure();
    }
}

