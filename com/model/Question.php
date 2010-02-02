<?php

class Question
{
    protected $id;
    protected $data;
    protected $answers;

	public function Question($id, $data = array())
	{
		if (is_numeric($id))
		{
            $this->id = $id;
			$this->data = $data;
		}
		else
		{
            // TODO : Error 500
		}
	}

    private function fetchData()
    {
        $rs = DB::select
        ('
            SELECT q.id, q.date, q.label
            FROM `question` AS `q`
            JOIN `category` AS `c` ON c.id=q.category_id
            WHERE q.id=' . $this->id . ' AND q.status=1 AND c.status=1
        ');
		if ($rs['total'] == 0)
		{
            // TODO : Error 500
		}
		$this->data = $rs['data'][0];
    }

    private function fetchAnswers()
    {
		$rs = DB::select('
            SELECT a.id, a.label
            FROM `answer` AS `a`
            JOIN `question_answer_feeling` AS j ON j.answer_id = a.id
            WHERE j.question_id = ' . $this->id . '
            GROUP BY a.id
		');
		foreach ($rs['data'] as $answer)
		{
			$this->answers[] = new Answer($answer['id'], array
			(
				'label' => $answer['label'],
				'question_id' => $this->id,
			));
		}
    }

    public function getId()
    {
        return $this->id;
    }

    public function getLabel()
    {
		if (!$this->data)
		{
			$this->fetchData();
		}
        return $this->data['label'];
    }

    public function getStartDate()
    {
		if (!$this->data)
		{
			$this->fetchData();
		}
        return $this->data['date'];
    }

    public function getEndDate()
    {
		if (!$this->data)
		{
			$this->fetchData();
		}
        return $this->data['date'] + QUESTION_DURATION;
    }

    public function isActive()
    {
		if (!$this->data)
		{
			$this->fetchData();
		}
        return ($this->data['date'] > time() - QUESTION_DURATION);
    }

	public function getAnswers()
	{
		if (!$this->answers)
		{
			$this->fetchAnswers();
		}
		return $this->answers;
	}
}

