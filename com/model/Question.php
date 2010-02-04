<?php

class Question
{
    protected $data;
    protected $answers;

	public function Question($id, $data = array())
	{
		if (preg_match('/^(\d+)$/', $id) != 0)
		{
			$this->data = $data;
            $this->data['id'] = $id;
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
            WHERE q.id=' . $this->data['id'] . ' AND q.status=1 AND c.status=1
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
            WHERE j.question_id = ' . $this->data['id'] . '
            GROUP BY a.id
		');
		foreach ($rs['data'] as $answer)
		{
			$this->answers[] = new Answer($answer['id'], array
			(
				'label' => $answer['label'],
				'question_id' => $this->data['id'],
			));
		}
    }

    public function getId()
    {
        return $this->data['id'];
    }

    public function getLabel()
    {
		if (!isset($this->data['label']))
		{
			$this->fetchData();
		}
        return $this->data['label'];
    }

    public function getStartDate()
    {
		if (!isset($this->data['date']))
		{
			$this->fetchData();
		}
        return $this->data['date'];
    }

    public function getEndDate()
    {
		if (!isset($this->data['date']))
		{
			$this->fetchData();
		}
        return $this->data['date'] + QUESTION_DURATION;
    }

    public function isActive()
    {
		if (!isset($this->data['date']))
		{
			$this->fetchData();
		}
        return ($this->data['date'] > time() - QUESTION_DURATION);
    }

	public function getAnswers()
	{
		if (!isset($this->answers))
		{
			$this->fetchAnswers();
		}
		return $this->answers;
	}

    static public function getTotalQuestions()
    {
        $rs = DB::select('
            SELECT COUNT(*) AS `total`
            FROM `question`
            WHERE `date` < ' . (time() - QUESTION_DURATION) . '
        ');
        return $rs['data'][0]['total'];
    }
}

