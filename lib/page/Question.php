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
            'question_image'            => $question->getImageUri('medium'),
        ));

        // Get answers
        $answers = $question->getAnswers();

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
        }

        $colors = Conf::get('GRAPH_COLORS');
        $data   = array();

        foreach (array_reverse($answers) as $key => $answer)
        {
            $data[] = array
            (
                'value' => $answer->getPercent() / 100,
                'color' => $colors[$key],
            );
        }

        $this->tpl->assignVar('question_data', json_encode($data));

        // If a user is logged
        if ($user = Model_User::getLoggedUser())
        {
            // User's vote and guess
            $answer = $user->getAnswer($question);
            $guess  = $user->getGuess($question);
            $this->tpl->assignVar(array
            (
                'user_vote'  => ($answer) ? $answer->getLabel() : '',
                'user_guess' => ($guess) ? $guess->getAnswer()->getLabel() : '',
            ));

            // User's guess concerning his friends
            $userGuessesAboutFriends = $user->getGuessesAboutFriends($question);
            foreach ($userGuessesAboutFriends as $guess)
            {
                // Assing friend's infos
                $this->tpl->assignLoopVar('userGuessesAboutFriends', array
                (
                    'label'  => $guess->getAnswer()->getLabel(),
                    'login'  => $guess->getUser()->getLogin(),
                    'avatar' => $guess->getUser()->getAvatarUri('small'),
                    'guid'   => Tool::makeGuid($guess->getUser()->getLogin()),
                ));
            }

            // User's friends votes and guess concerning me
            $friends = $user->getFriends();
            foreach ($friends as $friend)
            {
                $answer = $friend->getAnswer($question);
                if ($answer)
                {
                    $this->tpl->assignLoopVar('userFriendsVotes', array
                    (
                        'label'  => $answer->getLabel(),
                        'login'  => $friend->getLogin(),
                        'avatar' => $friend->getAvatarUri('small'),
                        'guid'   => Tool::makeGuid($friend->getLogin()),
                    ));
                }

                $guess = $friend->getGuessAboutFriend($question, $user);
                if ($guess)
                {
                    $this->tpl->assignLoopVar('userFriendsGuessAboutMe', array
                    (
                        'label'  => $guess->getAnswer()->getLabel(),
                        'login'  => $friend->getLogin(),
                        'avatar' => $friend->getAvatarUri('small'),
                        'guid'   => Tool::makeGuid($friend->getLogin()),
                    ));
                }
            }
        }
    }
}


