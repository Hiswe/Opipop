<?php

class Page_Question extends Page
{
	public function configureView()
	{
		$this->tpl->assignTemplate ('com/view/header.tpl');
		$this->tpl->assignTemplate ('com/view/top.tpl');
		$this->tpl->assignTemplate ('com/view/question.tpl');
		$this->tpl->assignTemplate ('com/view/footer.tpl');
	}

	public function configureData()
	{
        // Configure top block
		$top = new Block_Top($this->tpl);
		$top->configure();

        // Get question
        $question = new Question($this->getParameter('id'));

        // If a user is logged
        if (Tool::isOk($_SESSION['user']))
        {
            $user = new User($_SESSION['user']['id']);
            $userAnswer = $user->getAnswer($question->getId());
            if ($userAnswer !== false)
            {
                $userGuess             = $user->getGuess($question->getId());
                $userGuessesForFriends = $user->getGuessesForFriends($question->getId());
            }
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

        if (!$question->isActive())
        {
            $this->tpl->assignSection('inactive');
        }
        else
        {
            $this->tpl->assignSection('active');

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
        }

        // Get answers
        $answers = $question->getAnswers();

        foreach ($answers as $answer)
        {
            if ($question->isActive())
            {
                // Assign answer's infos
                $this->tpl->assignLoopVar('answer', array
                (
                    'label' => $answer['label'],
                    'id'    => $answer['id'],
                ));
            }

            if (!$question->isActive())
            {
                // Assign answer's infos
                $this->tpl->assignLoopVar('answer', array
                (
                    'label'           => $answer->getLabel(),
                    'id'              => $answer->getId(),
                    'percentFormated' => number_format($answer->getPercent($question->getId()), 1, ',', ' '),
                    'percent'         => round($answer->getPercent()),
                    'percent_male'    => round($answer->getPercentMale()),
                    'percent_female'  => round($answer->getPercentFemale()),
                ));

            }

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
                        'class'  => 'voted',
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
                        'class'  => 'guessed',
                    ));
                }

                // If the user guessed for his friends
                if ($userGuessesForFriends)
                {
                    // Loop through all guesses
                    foreach ($userGuessesForFriends as $guess)
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
        }
	}
}


