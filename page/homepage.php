<?php

include 'page/block/top.php';

// Select all previous question accoring to this page'n number
$rs_question = $db->select
('
    SELECT `id`, `date`, `label`
    FROM `question`
    WHERE `date` > ' . (time() - POLL_DURATION) . '
    ORDER BY `date` DESC
', 0, 8);

// If there is some
if ($rs_question['total'] != 0)
{
    // List all questions ids
    $idList = array();
    foreach ($rs_question['data'] as $item)
    {
        $idList[] = $item['id'];
    }

    // Select all possible answer related to those questions
    $rs_answer = $db->select
    ('
        SELECT a.id, a.label, j.question_id
        FROM `answer` AS a
        JOIN `question_answer` AS j ON j.answer_id = a.id
        WHERE j.question_id IN (' . implode(',', $idList) . ')
    ');

    // Loop through all questions
    foreach ($rs_question['data'] as $question)
    {
        // Assign question infos
        $tpl->assignLoopVar('question', array
        (
            'date'  => date('d-m-Y', $question['date']),
            'label' => $question['label'],
            'id'    => $question['id'],
        ));

        // Assign answers infos
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
else
{
    // Error !
}

