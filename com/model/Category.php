<?php

class Category
{
    protected $id;
    protected $questions;
    protected $isArchive = false;

	public function Category($id)
	{
		if (is_string($id))
		{
            $rs = DB::select('
                SELECT `id`
                FROM `category`
                WHERE `guid`="' . $id . '"
            ');
            if ($rs['total'] != 0)
            {
                $this->id = $rs['data'][0]['id'];
            }
            else
            {
                // TODO : Error 500
            }
		}
		else
		{
            $this->id = $id;
		}
	}

    private function fetchQuestions()
    {
        if ($this->isArchive)
        {
            $where = 'q.date < ' . (time() - QUESTION_DURATION - 3600);
        }
        else
        {
            $where = 'q.date > ' . (time() - QUESTION_DURATION);
        }
        // TODO : retrun an array of question
        $rs = DB::select
        ('
            SELECT q.id, q.date, q.label
            FROM `question` AS `q`
            JOIN `category` AS `c` ON c.id=q.category_id
            WHERE ' . $where . '
            AND c.id="' . $this->id . '"
            AND q.status=1
            AND c.status=1
            ORDER BY q.date DESC
        ');
		foreach ($rs['data'] as $question)
		{
			$this->questions[] = new Question($question['id'], array
			(
				'label' => $question['label'],
				'date' => $question['date'],
			));
		}
    }

    public function getId()
    {
        return $this->id;
    }

    public function setIsArchive($bool)
    {
        $this->isArchive = $bool;
    }

    public function getTotalQuestions()
    {
        if (!$this->questions)
        {
            $this->fetchQuestions();
        }
        return count($this->questions);
    }

    public function getQuestions($page = false)
    {
        if (!$this->questions)
        {
            $this->fetchQuestions();
        }
        $from = ((!$page) ? 0 : $page - 1) * QUESTION_PER_PAGE;
        $max = ($page === false) ? 0 : QUESTION_PER_PAGE;

		return array_slice($this->questions, $from, $max);
    }
}

