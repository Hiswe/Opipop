<?php

class Page_Homepage extends Page
{
    public function configureView()
    {
        $this->tpl->assignTemplate('lib/view/header.tpl');
        $this->tpl->assignTemplate('lib/view/top.tpl');
        $this->tpl->assignTemplate('lib/view/homepage.tpl');
        $this->tpl->assignTemplate('lib/view/footer.tpl');
    }

    public function configureData()
    {
        // Configure top block
        $top = new Block_Top($this->tpl);
        $top->configure();

        // Init category
        $category = new Model_Category(Conf::get('MAIN_CATEGORY'));
        if ($category->getTotalQuestions() == 0)
        {
            return;
        }

        // Get logged user if there is one
        $user = Model_User::getLoggedUser();

        // Get questions
        $questions = $category->getQuestions($this->getPage());

        // Loop through all questions
        foreach ($questions as $question)
        {
            $this->tpl->assignLoopVar('question', array
            (
                'id'               => $question->getId(),
                'label'            => $question->getLabel(),
                'image'            => $question->getImageUri('medium'),
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
                $this->tpl->assignLoopVar('question.answer', array
                (
                    'id'    => $answer->getId(),
                    'label' => $answer->getLabel(),
                ));

                if ($user && $userVote && $answer->getId() == $userVote->getId())
                {
                    $this->tpl->assignLoopVar('question.answer.user', array
                    (
                        'class'  => 'vote',
                        'label'  => 'Mon vote',
                        'id'     => $user->getId(),
                        'login'  => $user->getLogin(),
                        'avatar' => $user->getAvatarUri('small'),
                    ));
                }

                if ($user && $userGuess && $answer->getId() == $userGuess->getAnswer()->getId())
                {
                    $this->tpl->assignLoopVar('question.answer.user', array
                    (
                        'class'  => 'guess',
                        'label'  => 'Mon opinion',
                        'id'     => $user->getId(),
                        'login'  => $user->getLogin(),
                        'avatar' => $user->getAvatarUri('small'),
                    ));
                }

                if ($user)
                {
                    foreach ($user->getGuessesAboutFriends($question) as $guess)
                    {
                        if ($answer->getId() == $guess->getAnswer()->getId())
                        {
                            $this->tpl->assignLoopVar('question.answer.friend', array
                            (
                                'class'  => 'friend',
                                'userId' => $user->getId(),
                                'id'     => $guess->getUser()->getId(),
                                'login'  => $guess->getUser()->getLogin(),
                                'avatar' => $guess->getUser()->getAvatarUri('small'),
                            ));
                            $friendsVotedId[] = $guess->getUser()->getId();
                        }
                    }
                }
            }

            if ($user && !$userVote)
            {
                $this->tpl->assignLoopVar('question.pendingUser', array
                (
                    'class'  => 'vote',
                    'label'  => 'Mon vote',
                    'id'     => $user->getId(),
                    'login'  => $user->getLogin(),
                    'avatar' => $user->getAvatarUri('small'),
                ));
            }

            if ($user && !$userGuess)
            {
                $this->tpl->assignLoopVar('question.pendingUser', array
                (
                    'class'  => 'guess',
                    'label'  => 'Mon opinion',
                    'id'     => $user->getId(),
                    'login'  => $user->getLogin(),
                    'avatar' => $user->getAvatarUri('small'),
                ));
            }

            if($user)
            {
                // Construct unvoted friends list
                foreach ($user->getFriends() as $friend)
                {
                    if (!in_array($friend->getId(), $friendsVotedId))
                    {
                        $this->tpl->assignLoopVar('question.pendingFriend', array
                        (
                            'class'  => 'friend',
                            'userId' => $user->getId(),
                            'id'     => $friend->getId(),
                            'login'  => $friend->getLogin(),
                            'avatar' => $friend->getAvatarUri('small'),
                        ));
                    }
                }
            }
        }
    }
}

