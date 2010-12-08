<?php

class Block_Help extends Block
{
    protected $template = '';

    private $info = null;

    public function setInfo($info)
    {
        $this->info = $info;
    }

    public function configure()
    {
        switch ($this->info)
        {
            case 'user_friends':
                $this->template = 'lib/view/help/user/friends.tpl';
                break;

            case 'user_info':
                $this->template = 'lib/view/help/user/info.tpl';
                break;

            case 'question_archive':
                $this->template = 'lib/view/help/question/archive.tpl';
                break;

            case 'question_active':
                $this->template = 'lib/view/help/question/active.tpl';
                break;
        }
    }
}


