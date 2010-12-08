<?php

class Block_Question_Active extends Block
{
    protected $template = 'lib/view/question/active.tpl';

    private $page = 0;

    public function setPage($page)
    {
        $this->page = $page;
    }

    public function configure()
    {
        // Init category
        $category = new Model_Category(Conf::get('MAIN_CATEGORY'));
        if ($category->getTotalQuestions() == 0)
        {
            return;
        }

        // Get logged user if there is one
        $user = Model_User::getLoggedUser();

        // Get questions
        $questions = $category->getQuestions($this->page);

        // Loop through all questions
        foreach ($questions as $question)
        {
            Globals::$tpl->assignLoopVar('question', array
            (
                'id'               => $question->getId(),
                'label'            => $question->getLabel(),
                'image'            => $question->getImageURL('medium'),
                'label_urlencoded' => urlencode($question->getLabel()),
                'guid'             => Tool::makeGuid($question->getLabel()),
                'time'             => Tool::timeWarp($question->getEndDate()),
            ));

            // Get answers
            $answers = $question->getAnswers();

            if($user)
            {
                // User's guess concerning his friends
                $userGuessesAboutFriends = $user->getGuessesAboutFriends($question);
            }

            $friendsVotedId = array();

            if($user)
            {
                $userVote  = $user->getAnswer($question);
                $userGuess = $user->getGuess($question);
            }

            // Loop through all answers
            foreach ($answers as $answer)
            {
                $answerIsEmpty = true;

                Globals::$tpl->assignLoopVar('question.answer', array
                (
                    'id'    => $answer->getId(),
                    'label' => $answer->getLabel(),
                ));

                if ($user && $userVote && $answer->getId() == $userVote->getId())
                {
                    Globals::$tpl->assignLoopVar('question.answer.user', array
                    (
                        'class' => 'vote',
                        'label' => 'Mon opinion',
                        'id'    => $user->getId(),
                        'login' => $user->getLogin(),
                        'image' => $user->getAvatarURL('small'),
                    ));
                    $answerIsEmpty = false;
                }

                if ($user && $userGuess && $answer->getId() == $userGuess->getAnswer()->getId())
                {
                    Globals::$tpl->assignLoopVar('question.answer.user', array
                    (
                        'class' => 'guess',
                        'label' => 'Mon pronostic',
                        'id'    => $user->getId(),
                        'login' => $user->getLogin(),
                        'image' => 'media/layout/icon24x24/map_mini.png',
                    ));
                    $answerIsEmpty = false;
                }

                if ($user)
                {
                    foreach ($user->getGuessesAboutFriends($question) as $guess)
                    {
                        if ($answer->getId() == $guess->getAnswer()->getId())
                        {
                            Globals::$tpl->assignLoopVar('question.answer.friend', array
                            (
                                'class'  => 'friend',
                                'userId' => $user->getId(),
                                'id'     => $guess->getUser()->getId(),
                                'login'  => $guess->getUser()->getLogin(),
                                'avatar' => $guess->getUser()->getAvatarURL('small'),
                            ));
                            $answerIsEmpty    = false;
                            $friendsVotedId[] = $guess->getUser()->getId();
                        }
                    }
                }

                if ($answerIsEmpty)
                {
                    Globals::$tpl->assignLoopVar('question.answer.message', array
                    (
                        'label' => 'Vide ...'
                    ));
                }
            }

            $pendingIsEmpty = true;

            if ($user && !$userVote)
            {
                Globals::$tpl->assignLoopVar('question.pendingUser', array
                (
                    'class'  => 'vote',
                    'label'  => 'Mon vote',
                    'id'     => $user->getId(),
                    'login'  => $user->getLogin(),
                    'avatar' => $user->getAvatarURL('small'),
                ));
                $pendingIsEmpty = false;
            }

            if ($user && !$userGuess)
            {
                Globals::$tpl->assignLoopVar('question.pendingUser', array
                (
                    'class'  => 'guess',
                    'label'  => 'Mon opinion',
                    'id'     => $user->getId(),
                    'login'  => $user->getLogin(),
                    'avatar' => $user->getAvatarURL('small'),
                ));
                $pendingIsEmpty = false;
            }

            if($user)
            {
                // Construct unvoted friends list
                foreach ($user->getFriends() as $friend)
                {
                    if (!in_array($friend->getId(), $friendsVotedId))
                    {
                        Globals::$tpl->assignLoopVar('question.pendingFriend', array
                        (
                            'class'  => 'friend',
                            'userId' => $user->getId(),
                            'id'     => $friend->getId(),
                            'login'  => $friend->getLogin(),
                            'avatar' => $friend->getAvatarURL('small'),
                        ));
                        $pendingIsEmpty = false;
                    }
                }
            }

            if ($pendingIsEmpty)
            {
                Globals::$tpl->assignLoopVar('question.message', array
                (
                    'label' => 'Vide ...'
                ));
            }
        }
    }
}

