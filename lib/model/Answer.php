<?php

class Model_Answer
{
    protected $data;
    protected $stats;

    public function Model_Answer($id, $data = array())
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
            SELECT `label`
            FROM `answer`
            WHERE `id`=' . $this->data['id'] . '
        ');
        if ($rs['total'] == 0)
        {
            // TODO : Error 500
        }
        $this->data = $rs['data'][0];
    }

    private function fetchStats()
    {
        // TODO : check if !$this->stats here and not in each method that uses fetchStats
        if (!$this->data['question_id'])
        {
            // TODO : Error 500
        }
        $rs = DB::select
        ('
            SELECT
                COUNT(r.question_id) AS total,
                SUM(if(r.answer_id="' . $this->data['id'] . '", 1, 0)) AS total_matching,
                SUM(if(r.answer_id="' . $this->data['id'] . '" AND u.male, 1, 0)) AS total_male
            FROM `user_result` AS `r`
            JOIN `user` AS `u` ON r.user_id=u.id
            WHERE r.question_id="' . $this->data['question_id'] . '"
            GROUP BY r.question_id
        ');
        $this->stats = array
        (
            'total'          => 0,
            'total_matching' => 0,
            'total_male'     => 0,
        );
        if ($rs['total'] != 0)
        {
            $this->stats = $rs['data'][0];
        }
        return $this->stats;
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

    public function getPercent()
    {
        if (!isset($this->stats))
        {
            $this->fetchStats();
        }
        if ($this->stats['total'] == 0)
        {
            return 0;
        }
        return ($this->stats['total_matching'] / $this->stats['total']) * 100;
    }

    public function getPercentMale()
    {
        if (!isset($this->stats))
        {
            $this->fetchStats();
        }
        if ($this->stats['total'] == 0)
        {
            return 0;
        }
        return ($this->stats['total_male'] / $this->stats['total']) * 100;
    }

    public function getPercentFemale()
    {
        if (!isset($this->stats))
        {
            $this->fetchStats();
        }
        if ($this->stats['total'] == 0)
        {
            return 0;
        }
        return (($this->stats['total'] - $this->stats['total_male']) / $this->stats['total']) * 100;
    }
}

