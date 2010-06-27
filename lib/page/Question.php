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
        //Configure top block
        $top = new Block_Top($this->tpl);
        $top->configure();

        // Get question
        $question = new Model_Question($this->getParameter('id'));

        // If a user is logged
        if ($user = Model_User::getLoggedUser())
        {
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
        if ($user && $userAnswer === false)
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
        $answers   = $question->getAnswers();
        $colors    = Conf::get('GRAPH_COLORS');
        $data      = array();
        $dataWomen = array();
        $dataMen   = array();

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

            /* TODO
            // If a user is logged and voted
            if ($user)
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
                if ($userGuessesAboutFriends)
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
                }
            }
            */
        }

        foreach (array_reverse($answers) as $key => $answer)
        {
            $data[] = array
            (
                'value' => $answer->getPercent() / 100,
                'color' => $colors[$key],
            );
        }

        // Percent MALE
        foreach ($answers as $key => $answer)
        {
            $dataMen[] = array
            (
                'value' => Tool::percent($answer->getTotalMale(), $question->getTotalMale()) / 100,
                'color' => $colors[$key],
            );
        }

        // Percent FEMALE
        foreach ($answers as $key => $answer)
        {
            $dataWomen[] = array
            (
                'value' => Tool::percent($answer->getTotalFemale(), $question->getTotalFemale()) / 100,
                'color' => $colors[$key],
            );
        }

        $this->tpl->assignVar('question_data', json_encode($data));
        $this->tpl->assignVar('question_women_data', json_encode($dataWomen));
        $this->tpl->assignVar('question_men_data', json_encode($dataMen));
    }
}


