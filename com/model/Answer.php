<?php

class Answer
{
    protected $id;
    protected $data;
    protected $stats;

	public function Answer($id, $data = array())
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
            SELECT `label`
            FROM `answer`
            WHERE `id`=' . $this->id . '
        ');
		if ($rs['total'] == 0)
		{
            // TODO : Error 500
		}
		$this->data = $rs['data'][0];
    }

	private function fetchStats()
	{
		if (!$this->data['question_id'])
		{
			// TODO : Error 500
		}
		$rs = DB::select
		('
			SELECT
				COUNT(r.question_id) AS total,
				SUM(if(r.answer_id="' . $this->id . '", 1, 0)) AS total_matching,
				SUM(u.male) AS total_male
			FROM `user_result` AS `r`
			JOIN `user` AS `u` ON r.user_id=u.id
			WHERE r.question_id="' . $this->data['question_id'] . '"
			GROUP BY r.question_id
		');
		$this->stats = $rs['data'][0];
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

    public function getPercent()
    {
		if (!$this->stats)
		{
			$this->fetchStats();
		}
		return ($this->stats['total_matching'] / $this->stats['total']) * 100;
    }

    public function getPercentMale()
    {
		if (!$this->stats)
		{
			$this->fetchStats();
		}
		return ($this->stats['total_male'] / $this->stats['total']) * 100;
    }

    public function getPercentFemale()
    {
		if (!$this->stats)
		{
			$this->fetchStats();
		}
		return (($this->stats['total'] - $this->stats['total_male']) / $this->stats['total']) * 100;
    }
}

