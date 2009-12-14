<?php

include 'page/block/top.php';

$rs_question = $db->select
('
    SELECT `id`, `date`, `label`
    FROM `question`
    WHERE `id` = ' . $_GET['id'] . '
');

$rs_answer = $db->select
('
    SELECT a.id, a.label, j.question_id
    FROM `answer` AS a
    JOIN `question_answer` AS j ON j.answer_id = a.id
    WHERE j.question_id = ' . $_GET['id'] . '
', 0, 8);

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


