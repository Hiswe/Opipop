
<?php

class Block_Question_Active_Vote extends Block
{
    protected $_TEMPLATE = 'lib/view/question/active/vote.tpl';
    protected $question  = null;

    public function setQuestion($question)
    {
        $this->question = $question;
    }

    public function configure()
    {
        // If a user is logged
        if (Tool::isOk($_SESSION['user']))
        {
            $user = new Model_User($_SESSION['user']['id']);
        }
        else
        {
            return;
        }

        $this->tpl->assignVar(array
        (
            'question_id' => $this->question->getId(),
        ));

        foreach ($this->question->getAnswers() as $answer)
        {
            $this->tpl->assignLoopVar('answer', array
            (
                'id'    => $answer->getId(),
                'label' => $answer->getLabel(),
            ));
        }
    }
}


