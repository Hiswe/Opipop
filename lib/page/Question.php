<?php

class Page_Question extends Page
{
    public function configureView()
    {
        $this->tpl->assignTemplate('lib/view/header.tpl');
        $this->tpl->assignTemplate('lib/view/top.tpl');
        $this->tpl->assignTemplate('lib/view/question.tpl');
        $this->tpl->assignTemplate('lib/view/footer.tpl');
    }

    public function configureData()
    {
        // Configure top block
        $top = new Block_Top($this->tpl);
        $top->configure();

        // Get question
        $question = new Model_Question($this->getParameter('id'));

        // If a user is logged
        if (Tool::isOk($_SESSION['user']))
        {
            $user                    = new Model_User($_SESSION['user']['id']);
            $userAnswer              = $user->getAnswer($question);
            $userGuess               = $user->getGuess($question);
            //$userGuessesAboutFriends = $user->getGuessesAboutFriends($question);
        }

        // Assign question infos
        $this->tpl->assignVar(array
        (
            'question_id'               => $question->getId(),
            'question_label'            => $question->getLabel(),
            'question_guid'             => Tool::makeGuid($question->getLabel()),
            'question_end_time'         => Tool::timeWarp($question->getEndDate()),
            'question_label_urlencoded' => urlencode($question->getLabel()),
            'question_start_date'       => date('d/m/Y', $question->getStartDate()),
            'question_end_date'         => date('d/m/Y', $question->getEndDate()),
        ));

        // If a user is logged and did not vote
        if (Tool::isOk($_SESSION['user']) && $userAnswer === false)
        {
            // Select all user's friends
            $friends = $user->getFriends();

            // Assign friends infos
            foreach ($friends as $friend)
            {
                $this->tpl->assignLoopVar('friend', array
                (
                    'id'     => $friend->getId(),
                    'login'  => $friend->getLogin(),
                    'avatar' => $friend->getAvatarUri('small'),
                ));
            }

            // Assing user's infos
            $this->tpl->assignLoopVar('user', array
            (
                'id'     => $user->getId(),
                'login'  => $user->getLogin(),
                'avatar' => $user->getAvatarUri('small'),
            ));
        }

        // Get answers
        $answers = $question->getAnswers();
        $colors  = Conf::get('GRAPH_COLORS');
        $data    = array();

        foreach ($answers as $key => $answer)
        {
            // Assign answer's infos
            $this->tpl->assignLoopVar('answer', array
            (
                'label'           => $answer->getLabel(),
                'id'              => $answer->getId(),
                'key'             => $key,
                'percentFormated' => number_format($answer->getPercent(), 1, ',', ' '),
                'percent'         => round($answer->getPercent()),
            ));

            // Assign answer's details
            $this->tpl->assignLoopVar('details', array
            (
                'label'                 => $answer->getLabel(),
                'percentMaleFormated'   => number_format($answer->getPercentMale(), 1, ',', ' '),
                'percentMale'           => round($answer->getPercentMale()),
                'percentFemaleFormated' => number_format($answer->getPercentFemale(), 1, ',', ' '),
                'percentFemale'         => round($answer->getPercentFemale()),
            ));

            // If a user is logged and voted
            if (Tool::isOk($_SESSION['user']))
            {
                // If the user answered and the result is about this answer
                if ($userAnswer && $userAnswer->getId() == $answer->getId())
                {
                    // Assing user's infos
                    $this->tpl->assignLoopVar('answer.user', array
                    (
                        'id'     => $user->getId(),
                        'login'  => $user->getLogin(),
                        'avatar' => $user->getAvatarUri('small'),
                        'class'  => 'vote',
                    ));
                }

                // If the user guessed and the result is about this answer
                if ($userGuess && $userGuess->getId() == $answer->getId())
                {
                    // Assing user's infos
                    $this->tpl->assignLoopVar('answer.user', array
                    (
                        'id'     => $user->getId(),
                        'login'  => $user->getLogin(),
                        'avatar' => $user->getAvatarUri('small'),
                        'class'  => 'guess',
                    ));
                }

                // If the user guessed for his friends
                // Loop through all guesses
                // TODO : what I guessed for my friend, what my friend answered, what they guessed for me
                /* if ($userGuessesAboutFriends)
                {
                    foreach ($userGuessesAboutFriends as $guess)
                    {
                        // If the result is about this answer
                        if ($guess->getId() == $answer->getId())
                        {
                            // Assing friend's infos
                            $this->tpl->assignLoopVar('answer.friend', array
                            (
                                'id'     => $guess->getUser()->getId(),
                                'login'  => $guess->getUser()->getLogin(),
                                'avatar' => $guess->getUser()->getAvatarUri('small'),
                                'guid'   => Tool::makeGuid($guess->getUser()->getLogin()),
                                'class'  => 'friend',
                            ));
                        }
                    }
                }*/
            }
        }

        foreach (array_reverse($answers) as $key => $answer)
        {
            $data[] = array
            (
                'value' => $answer->getPercent() / 100,
                'color' => $colors[$key],
            );
        }

        $this->tpl->assignVar('question_data', json_encode($data));
    }
}


