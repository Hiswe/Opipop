
<?php

class Block_Question_Active_Wait extends Block
{
    protected $_TEMPLATE = 'lib/view/question/active/wait.tpl';
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

        $userAnswer = $user->getAnswer($this->question);
        $userGuess  = $user->getGuess($this->question);

        foreach ($this->question->getAnswers() as $answer)
        {
            $this->tpl->assignLoopVar('answer', array
            (
                'label' => $answer->getLabel(),
            ));

            if ($userAnswer && $userAnswer->getId() == $answer->getId())
            {
                $this->tpl->assignLoopVar('answer.user', array
                (
                    'class'  => 'vote',
                    'login'  => $user->getLogin(),
                    'avatar' => $user->getAvatarUri('small'),
                ));
            }
            if ($userGuess && $userGuess->getId() == $answer->getId())
            {
                $this->tpl->assignLoopVar('answer.user', array
                (
                    'class'  => 'guess',
                    'login'  => $user->getLogin(),
                    'avatar' => $user->getAvatarUri('small'),
                ));
            }
        }
    }
}

