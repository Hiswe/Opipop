<?php

class Remote_Question_Map extends Remote
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
        $this->block = new Block_Question_Map();
        $this->bock->setQuestion(new Model_Question($_GET['questionId']));
        $this->block->configure();
    }
}

