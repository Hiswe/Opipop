
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
        if (!($user = Model_User::getLoggedUser()))
        {
            return;
        }

        $this->tpl->assignVar(array
        (
            'user_login'  => $user->getLogin(),
            'user_avatar' => $user->getAvatarUri('medium'),
            'user_vote'   => $user->getAnswer($this->question)->getLabel(),
            'user_guess'  => $user->getGuess($this->question)->getAnswer()->getLabel(),
        ));
    }
}

