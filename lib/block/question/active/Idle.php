
<?php

class Block_Question_Active_Idle extends Block
{
    protected $_TEMPLATE = 'lib/view/question/active/idle.tpl';
    protected $question  = null;

    public function setQuestion($question)
    {
        $this->question = $question;
    }

    public function configure()
    {
        foreach ($this->question->getAnswers() as $answer)
        {
            $this->tpl->assignLoopVar('answer', array
            (
                'label' => $answer->getLabel(),
            ));
        }
    }
}


