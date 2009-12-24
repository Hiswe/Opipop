<?php

include 'page/block/top.php';


$rs_question = $db->select
('
    SELECT `id`, `date`, `label`
    FROM `question`
    WHERE `id` = ' . $_GET['id'] . '
');

if ($rs_question['total'] != 0)
{
    $question = $rs_question['data'][0];

    $user_idList = array();
    $user_voted_idList = array();
    if (count($_SESSION['user']) != 0)
    {
        foreach($_SESSION['user'] as $id => $data)
        {
            $user_idList[] = $id;
        }
        $rs_result = $db->select
        ('
            SELECT `user_id`, `answer_id`
            FROM `user_result`
            WHERE `question_id`=' . $question['id'] . ' AND `user_id` IN (' . implode(',', $user_idList) . ')
        ', 0, 8);
    }

    $rs_answer = $db->select
    ('
        SELECT a.id, a.label, j.question_id
        FROM `answer` AS a
        JOIN `question_answer` AS j ON j.answer_id = a.id
        WHERE j.question_id = ' . $_GET['id'] . '
    ', 0, 8);

    $tpl->assignVar(array
    (
        'question_date'  => date('d-m-Y', $question['date']),
        'question_label' => $question['label'],
        'question_id'    => $question['id'],
    ));

    foreach ($rs_answer['data'] as $answer)
    {
        if ($answer['question_id'] == $question['id'])
        {
            $tpl->assignLoopVar('answer', array
            (
                'label' => $answer['label'],
                'id'    => $answer['id'],
            ));

            if (count($_SESSION['user']) != 0)
            {
                foreach ($rs_result['data'] as $result)
                {
                    if ($result['answer_id'] == $answer['id'])
                    {
                        $tpl->assignLoopVar('answer.user', array
                        (
                            'login' => $_SESSION['user'][$result['user_id']]['login'],
                            'id'    => $result['user_id'],
                        ));
                        $user_voted_idList[$result['user_id']] = true;
                    }
                }
            }
        }
    }

    if ($question['date'] < time() - POLL_DURATION)
    {
        $tpl->assignSection('inactive');
    }
    else if (count($_SESSION['user']) != 0)
    {
        $poll_parameters = array();
        $poll_parameters['question_id'] = $question['id'];
        $poll_parameters['user'] = array();

        foreach ($rs_result['data'] as $result)
        {
            $poll_parameters['user'][$result['user_id']] = $result['answer_id'];
        }
        foreach($user_idList as $id)
        {
            if (!array_key_exists($id, $user_voted_idList))
            {
                $tpl->assignLoopVar('user', array
                (
                    'login' => $_SESSION['user'][$id]['login'],
                    'id'    => $id,
                ));
            }
        }

        $tpl->assignVar('poll_parameters', json_encode($poll_parameters));
        $tpl->assignSection('active');
    }
}

