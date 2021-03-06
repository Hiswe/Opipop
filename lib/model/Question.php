<?php

class Model_Question
{
    protected $data;
    protected $stats;
    protected $answers;

    public function Model_Question($id, $data = array())
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
            SELECT q.id, q.date, q.label, q.didyouknow
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

    private function fetchStats()
    {
        $rs = DB::select
        ('
            SELECT
                COUNT(r.question_id) AS total,
                SUM(u.male=1) AS total_male
            FROM `user_result` AS `r`
            JOIN `user` AS `u` ON r.user_id=u.id
            WHERE r.question_id="' . $this->data['id'] . '"
            GROUP BY r.question_id
        ');
        $this->stats = array
        (
            'total'          => 0,
            'total_male'     => 0,
        );
        if ($rs['total'] != 0)
        {
            $this->stats = $rs['data'][0];
        }
        return $this->stats;
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
            $this->answers[] = new Model_Answer($answer['id'], array
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

    public function getDidyouknow()
    {
        if (!isset($this->data['didyouknow']))
        {
            $this->fetchData();
        }
        return $this->data['didyouknow'];
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
        return $this->data['date'] + Conf::get('QUESTION_DURATION');
    }

    public function isActive()
    {
        if (!isset($this->data['date']))
        {
            $this->fetchData();
        }
        return ($this->data['date'] > time() - Conf::get('QUESTION_DURATION'));
    }

    public function getAnswers()
    {
        if (!isset($this->answers))
        {
            $this->fetchAnswers();
        }
        return $this->answers;
    }

    public function getTotal()
    {
        if (!isset($this->stats))
        {
            $this->fetchStats();
        }
        return $this->stats['total'];
    }

    public function getTotalMale()
    {
        if (!isset($this->stats))
        {
            $this->fetchStats();
        }
        return $this->stats['total_male'];
    }

    public function getTotalFemale()
    {
        if (!isset($this->stats))
        {
            $this->fetchStats();
        }
        return $this->stats['total'] - $this->stats['total_male'];
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

    public function getImageURL($type)
    {
        switch ($type)
        {
            case 'medium':
                $size = Conf::get('QUESTION_MEDIUM_SIZE');
                break;
        }
        if (file_exists(Conf::get('MEDIA_DIR'). 'question/' . $size . '/' . $this->data['id'] . '.jpg'))
        {
            return Conf::get('MEDIA_PATH') . 'question/' . $size . '/' . $this->data['id'] . '.jpg';
        }
        return Conf::get('MEDIA_PATH') . 'question/' . $size . '/0.jpg';
    }

    static public function getTotalQuestions()
    {
        $rs = DB::select('
            SELECT COUNT(*) AS `total`
            FROM `question`
            WHERE `date` < ' . (time() - Conf::get('QUESTION_DURATION')) . '
            AND `category_id`="' . Conf::get('MAIN_CATEGORY') . '"
        ');
        return $rs['data'][0]['total'];
    }

    static public function getRandomQuestion()
    {
        $rs = DB::select
        ('
            SELECT q.id, q.date, q.label, q.didyouknow
            FROM `question` AS `q`
            JOIN `category` AS `c` ON c.id=q.category_id
            WHERE q.status=1 AND c.status=1
            AND q.category_id="' . Conf::get('MAIN_CATEGORY') . '"
            ORDER BY RAND()
        ');
        if ($rs['total'] == 0)
        {
            // TODO : Error 500
        }
        return new Model_Question($rs['data'][0]['id'], $rs['data'][0]);
    }
}

