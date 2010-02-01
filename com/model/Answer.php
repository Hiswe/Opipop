<?php

class Answer
{
	public function Answer()
	{
	}

	static function getAnswersForQuestions($questionList)
	{
        $rs = DB::select
        ('
            SELECT a.id, a.label, j.question_id
            FROM `answer` AS a
            JOIN `question_answer_feeling` AS j ON j.answer_id = a.id
            WHERE j.question_id IN (' . implode(',', $questionList) . ')
        ');
		return $rs['data'];
	}
}

