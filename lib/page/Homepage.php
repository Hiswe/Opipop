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
            if (isset($user))
            {
                $userAnswer = $user->getAnswer($question);
                $userGuess  = $user->getGuess($question);
                if (!$userAnswer)
                {
                    $block  = new Block_Question_Active_Vote();
                    $class  = 'active';
                }
                else if (!$userGuess)
                {
                    $block  = new Block_Question_Active_Guess();
                    $class  = 'active';
                }
                else
                {
                    $block  = new Block_Question_Active_Wait();
                    $class  = 'inactive';
                }
            }
            else
            {
                $block = new Block_Question_Active_Idle();
                $class  = 'active';
            }
            $block->setQuestion($question);
            $block->configure();
            $this->tpl->assignLoopVar('question', array
            (
                'class'            => $class,
                'content'          => $block->render(),
                'id'               => $question->getId(),
                'label'            => $question->getLabel(),
                'label_urlencoded' => urlencode($question->getLabel()),
                'guid'             => Tool::makeGuid($question->getLabel()),
                'time'             => 'ends ' . Tool::timeWarp($question->getEndDate()),
            ));
        }
    }
}

