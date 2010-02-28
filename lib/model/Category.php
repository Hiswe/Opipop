<?php

class Model_Category
{
    protected $data;
    protected $questions;
    protected $isArchive = false;

    public function Model_Category($id, $data = array())
    {
        if (preg_match('/^(\d+)$/', $id) == 0)
        {
            $this->fetchData($id);
        }
        else
        {
            $this->data = $data;
            $this->data['id'] = $id;
        }
    }

    private function fetchData($guid = false)
    {
        if (!$this->data['id'] && $guid)
        {
            $where =  'WHERE `guid`="' . $guid . '"';
        }
        else
        {
            $where =  'WHERE `id`="' . $this->data['id'] . '"';
        }
        $rs = DB::select('
            SELECT `id`, `label`
            FROM `category`
            ' . $where . '
            AND `status`=1
        ');
        if ($rs['total'] == 0)
        {
            // TODO : Error 500
        }
        $this->data = $rs['data'][0];
    }

    private function fetchQuestions()
    {
        if ($this->isArchive)
        {
            $where = 'q.date < ' . (time() - QUESTION_DURATION);
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
            AND c.id="' . $this->data['id'] . '"
            AND q.status=1
            AND c.status=1
            ORDER BY q.date DESC
        ');
        foreach ($rs['data'] as $question)
        {
            $this->questions[] = new Model_Question($question['id'], array
            (
                'label' => $question['label'],
                'date' => $question['date'],
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

    public function setIsArchive($bool)
    {
        $this->isArchive = $bool;
    }

    public function getTotalQuestions()
    {
        if (!isset($this->questions))
        {
            $this->fetchQuestions();
        }
        return count($this->questions);
    }

    public function getQuestions($page = false)
    {
        if (!isset($this->questions))
        {
            $this->fetchQuestions();
        }
        $from = ((!$page) ? 0 : $page - 1) * QUESTION_PER_PAGE;
        $max = ($page === false) ? 0 : QUESTION_PER_PAGE;
        return array_slice($this->questions, $from, $max);
    }
}

