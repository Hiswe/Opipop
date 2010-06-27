<?php

class Block_Question_Archive extends Block
{
    protected $_TEMPLATE = 'lib/view/question/archive.tpl';
    protected $page = 0;

    public function setPage($page)
    {
        $this->page = $page;
    }

    public function configure()
    {
        if (!$this->isAjax())
        {
            $this->tpl->assignSection('question_archive_navigation');
        }

        // Init category
        $category = new Model_Category(Conf::get('MAIN_CATEGORY'));
        $category->setIsArchive(true);
        if ($category->getTotalQuestions() == 0)
        {
            exit();
        }

        // Get questions
        $questions = $category->getQuestions($this->page);

        if ($this->isAjax() && $category->getTotalQuestions() <= $this->page * Conf::get('QUESTION_PER_PAGE'))
        {
            //header('X-JSON: (Question.setEndReached())');
            return;
        }

        $colors = Conf::get('GRAPH_COLORS');

        // Loop through all questions
        foreach ($questions as $key => $question)
        {
            // Get question's answers
            $answers = $question->getAnswers();

            $data = array();
            foreach (array_reverse($answers) as $key => $answer)
            {
                $data[] = array
                (
                    'value' => $answer->getPercent() / 100,
                    'color' => $colors[$key],
                );
            }

            // Assign question infos
            $this->tpl->assignLoopVar('question_archive', array
            (
                'id'    => $question->getId(),
                'label' => $question->getLabel(),
                'guid'  => Tool::makeGuid($question->getLabel()),
                'data'  => json_encode($data),
                'time'  => Tool::timeWarp($question->getEndDate()),
            ));

            // Assign answers infos
            foreach ($answers as $key => $answer)
            {
                $this->tpl->assignLoopVar('question_archive.answer', array
                (
                    'percentFormated' => number_format($answer->getPercent(), 1, ',', ' '),
                    'label'           => $answer->getLabel(),
                    'key'             => $key,
                ));
            }
        }
    }
}

