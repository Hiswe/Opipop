<?php

class Page_Question_List extends Page
{
	public function configureView()
	{
		$this->tpl->assignTemplate ('com/view/header.tpl');
		$this->tpl->assignTemplate ('com/view/top.tpl');
		$this->tpl->assignTemplate ('com/view/question_list.tpl');
		$this->tpl->assignTemplate ('com/view/pagination.tpl');
		$this->tpl->assignTemplate ('com/view/footer.tpl');
	}

	public function configureData()
	{
        // Configure top block
		$top = new Block_Top($this->tpl);
		$top->configure();

        // Init category
        $category = new Category($this->getParameter('guid'));
        $category->setIsArchive($this->getParameter('archive'));
        if ($category->getTotalQuestions() == 0)
        {
            return;
        }

        // Get questions
        $questions = $category->getQuestions($this->getPage());

        // Loop through all questions
        foreach ($questions as $question)
        {
            // Compute time
            if ($this->getParameter('archive'))
            {
                $timePrefix =  'ended ';
            }
            else
            {
                $timePrefix = 'ends ';
            }

            // Assign question infos
            $this->tpl->assignLoopVar('question', array
            (
                'id'    => $question->getId(),
                'label' => $question->getLabel(),
                'guid'  => Tool::makeGuid($question->getLabel()),
                'date'  => date('d-m-Y', $question->getStartDate()),
                'time'  => $timePrefix . Tool::timeWarp($question->getStartDate()),
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

        // Pagination setup
        if ($this->getParameter('archive'))
        {
            $pagination = new Pagination();
            $pagination->setPage($this->getPage());
            $pagination->setItemPerPage(QUESTION_PER_PAGE);
            $pagination->setTotalItem($category->getTotalQuestions());
            $pagination->setLink('category/' . $this->getParameter('guid') . '/archives');
            $pagination->compute($this->tpl);
        }
	}
}

