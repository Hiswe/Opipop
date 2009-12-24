<?php

include 'page/block/top.php';

$rs_question = $db->select
('
    SELECT `id`, `date`, `label`
    FROM `question`
    WHERE `date` > ' . (time() - POLL_DURATION) . '
    ORDER BY `date` DESC
', 0, 8);

if ($rs_question['total'] != 0)
{
    $idList = array();
    foreach ($rs_question['data'] as $item)
    {
        $idList[] = $item['id'];
    }

    $rs_answer = $db->select
    ('
        SELECT a.id, a.label, j.question_id
        FROM `answer` AS a
        JOIN `question_answer` AS j ON j.answer_id = a.id
        WHERE j.question_id IN (' . implode(',', $idList) . ')
    ');

    foreach ($rs_question['data'] as $question)
    {
        $tpl->assignLoopVar('question', array
        (
            'date'  => date('d-m-Y', $question['date']),
            'label' => $question['label'],
            'id'    => $question['id'],
        ));

        foreach ($rs_answer['data'] as $answer)
        {
            if ($answer['question_id'] == $question['id'])
            {
                $tpl->assignLoopVar('question.answer', array
                (
                    'label' => $answer['label'],
                ));
            }
        }
    }
}

