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

        // Loop through all questions
        foreach ($questions as $key => $question)
        {
            // Assign question infos
            $this->tpl->assignLoopVar('question', array
            (
                'key'   => $key,
                'id'    => $question->getId(),
                'label' => $question->getLabel(),
                'guid'  => Tool::makeGuid($question->getLabel()),
                'date'  => date('d-m-Y', $question->getStartDate()),
                'time'  => 'ends ' . Tool::timeWarp($question->getEndDate()),
            ));

            // Get question's answers
            $answers = $question->getAnswers();

            // Assign answers infos
            foreach ($answers as $answer)
            {
                $this->tpl->assignLoopVar('question.answer', array
                (
                    'label' => $answer->getLabel(),
                ));
            }
        }
	}
}

