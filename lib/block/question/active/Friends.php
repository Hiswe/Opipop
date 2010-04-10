<?php

class Block_Question_Active_Friends extends Block
{
    protected $_TEMPLATE = 'lib/view/question/active/friends.tpl';
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

        // Select all user's friends
        $friends = $user->getFriends();
        $guesses = $user->getGuessesAboutFriends($this->question);
        $answers = $this->question->getAnswers();

        $unguessed = 0;

        foreach ($friends as $friend)
        {
            $guessId = false;
            foreach ($guesses as $guess)
            {
                if ($guess->getUser()->getId() == $friend->getId())
                {
                    $guessId = $guess->getId();
                    break;
                }
            }

            $this->tpl->assignLoopVar('friend', array
            (
                'id'     => $friend->getId(),
                'login'  => $friend->getLogin(),
                'avatar' => $friend->getAvatarUri('small'),
            ));

            foreach ($answers as $answer)
            {
                $this->tpl->assignLoopVar('friend.answer', array
                (
                    'questionId' => $this->question->getId(),
                    'friendId'   => $friend->getId(),
                    'id'         => $answer->getId(),
                    'label'      => $answer->getLabel(),
                    'checked'    => ($guessId == $answer->getId()) ? ' CHECKED' : '',
                    'disabled'   => ($guessId !== false) ? ' DISABLED' : '',
                ));
            }

            $unguessed += ($guessId === false) ? 1 : 0;
        }

        $this->tpl->assignVar(array
        (
            'question_id' => $this->question->getId(),
        ));

        if ($unguessed != 0)
        {
            $this->tpl->assignSection('save');
        }
    }
}

