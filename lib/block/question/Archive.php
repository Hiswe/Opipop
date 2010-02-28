<?php

class Block_Question_Archive extends Block
{
    protected $page = 0;

    public function setPage($page)
    {
        $this->page = $page;
    }

    public function configure()
    {
        // Init category
        $category = new Model_Category(MAIN_CATEGORY);
        $category->setIsArchive(true);
        if ($category->getTotalQuestions() == 0)
        {
            exit();
        }

        // Get questions
        $questions = $category->getQuestions($this->page);

        if ($this->isAjax() && $category->getTotalQuestions() <= $this->page * QUESTION_PER_PAGE)
        {
            header('X-JSON: (removeMorePollButton())');
        }

        // Loop through all questions
        foreach ($questions as $key => $question)
        {
            // Get question's answers
            $answers = $question->getAnswers();

            $data = array();
            foreach ($answers as $answer)
            {
                $data[] = $answer->getPercent() + 1; // TODO : remove the +1
            }

            // Assign question infos
            $this->tpl->assignLoopVar('question', array
            (
                'id'    => $question->getId(),
                'label' => $question->getLabel(),
                'guid'  => Tool::makeGuid($question->getLabel()),
                'data'  => json_encode(array_reverse($data)),
            ));

            // Assign answers infos
            foreach ($answers as $key => $answer)
            {
                $this->tpl->assignLoopVar('question.answer', array
                (
                    'percentFormated' => number_format($answer->getPercent(), 1, ',', ' '),
                    'label'           => $answer->getLabel(),
                    'key'             => $key,
                ));
            }
        }
    }
}

