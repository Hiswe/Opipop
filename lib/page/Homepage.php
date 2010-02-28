<?php

class Page_Homepage extends Page
{
    public function configureView()
    {
        $this->tpl->assignTemplate('lib/view/header.tpl');
        $this->tpl->assignTemplate('lib/view/top.tpl');
        $this->tpl->assignTemplate('lib/view/question_active_list.tpl');
        $this->tpl->assignTemplate('lib/view/footer.tpl');
    }

    public function configureData()
    {
        // Configure top block
        $top = new Block_Top($this->tpl);
        $top->configure();

        // Init category
        $category = new Model_Category(MAIN_CATEGORY);
        if ($category->getTotalQuestions() == 0)
        {
            return;
        }

        // Get questions
        $questions = $category->getQuestions($this->getPage());

        // If a user is logged
        if (Tool::isOk($_SESSION['user']))
        {
            $user = new Model_User($_SESSION['user']['id']);
            $this->tpl->assignVar(array
            (
                'user_login' => $user->getLogin(),
                'user_id'    => $user->getId(),
            ));
        }

        // Loop through all questions
        foreach ($questions as $question)
        {
            // Assign question infos
            $this->tpl->assignLoopVar('question', array
            (
                'id'               => $question->getId(),
                'label'            => $question->getLabel(),
                'label_urlencoded' => urlencode($question->getLabel()),
                'guid'             => Tool::makeGuid($question->getLabel()),
                'date'             => date('d-m-Y', $question->getStartDate()),
                'time'             => 'ends ' . Tool::timeWarp($question->getEndDate()),
            ));

            if (isset($user))
            {
                $userAnswer = $user->getAnswer($question);
                $userGuess  = $user->getGuess($question);
            }

            // Get question's answers
            $answers = $question->getAnswers();

            // If the user already voted and guessed
            if (isset($user) && $userAnswer != false && $userGuess != false)
            {
                foreach ($answers as $answer)
                {
                    $this->tpl->assignLoopVar('question.answer', array
                    (
                        'label' => $answer->getLabel(),
                        'id'    => $answer->getId(),
                    ));

                    if ($userAnswer->getId() == $answer->getId())
                    {
                        $this->tpl->assignLoopVar('question.answer.user', array
                        (
                            'id'     => $user->getId(),
                            'login'  => $user->getLogin(),
                            'avatar' => $user->getAvatarUri('small'),
                            'class'  => 'vote',
                        ));
                    }

                    if ($userGuess->getId() == $answer->getId())
                    {
                        $this->tpl->assignLoopVar('question.answer.user', array
                        (
                            'id'     => $user->getId(),
                            'login'  => $user->getLogin(),
                            'avatar' => $user->getAvatarUri('small'),
                            'class'  => 'guess',
                        ));
                    }
                }
            }
            else
            {
                $this->tpl->assignLoopVar('question.active', array());

                foreach ($answers as $answer)
                {
                    $this->tpl->assignLoopVar('question.answer', array
                    (
                        'label' => $answer->getLabel(),
                        'id'    => $answer->getId(),
                    ));
                }

                if (!isset($userAnswer) || $userAnswer == false)
                {
                    foreach ($answers as $answer)
                    {
                        $this->tpl->assignLoopVar('question.vote', array
                        (
                            'label' => $answer->getLabel(),
                            'id'    => $answer->getId(),
                        ));
                    }
                }
                if (!isset($userGuess) || $userGuess == false)
                {
                    foreach ($answers as $answer)
                    {
                        $this->tpl->assignLoopVar('question.guess', array
                        (
                            'label' => $answer->getLabel(),
                            'id'    => $answer->getId(),
                        ));
                    }
                }
            }
        }
    }
}

