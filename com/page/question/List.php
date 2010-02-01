<?php

include 'com/block/Top.php';
include 'com/model/Category.php';
include 'com/model/Answer.php';
include 'com/model/Pagination.php';

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

        // Select all possible answer related to those questions
        $questionsIds = array();
        foreach ($questions as $question)
        {
            $questionIds[] = $question['id'];
        }
        $answers = Answer::getAnswersForQuestions($questionIds);

        // Loop through all questions
        foreach ($questions as $question)
        {
            // Compute time
            if ($this->getParameter('archive'))
            {
                $time =  'ended ' . Tool::timeWarp(date($question['date'] + QUESTION_DURATION));
            }
            else
            {
                $time =  'ends ' . Tool::timeWarp($question['date'] + QUESTION_DURATION);
            }

            // Assign question infos
            $this->tpl->assignLoopVar('question', array
            (
                'id'    => $question['id'],
                'label' => $question['label'],
                'guid'  => Tool::makeGuid($question['label']),
                'date'  => date('d-m-Y', $question['date']),
                'time'  => $time,
            ));

            // Assign answers infos
            foreach ($answers as $answer)
            {
                if ($answer['question_id'] == $question['id'])
                {
                    $this->tpl->assignLoopVar('question.answer', array
                    (
                        'label' => $answer['label'],
                    ));
                }
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

