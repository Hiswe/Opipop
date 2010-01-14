<?php

include 'page/block/top.php';

// Select the requested question
$rs_question = $db->select
('
    SELECT `id`, `date`, `label`
    FROM `question`
    WHERE `id` = ' . $_GET['id'] . '
');

// If there is one
if ($rs_question['total'] != 0)
{
    $question = $rs_question['data'][0];
    $user_idList = array();
    $user_voted_idList = array();

    // If some user are logged
    if (count($_SESSION['user']) != 0)
    {
        // List all users ids
        foreach($_SESSION['user'] as $id => $data)
        {
            $user_idList[] = $id;
        }

        // Select users results
        $rs_result = $db->select
        ('
            SELECT `user_id`, `answer_id`
            FROM `user_result`
            WHERE `question_id`=' . $question['id'] . ' AND `user_id` IN (' . implode(',', $user_idList) . ')
        ');

        // Select users prognostic
        $rs_prognostic = $db->select
        ('
            SELECT `user_id`, `answer_id`
            FROM `user_prognostic`
            WHERE `question_id`=' . $question['id'] . ' AND `user_id` IN (' . implode(',', $user_idList) . ')
        ');
    }

    // Select all answers releted to this question
    $rs_answer = $db->select
    ('
        SELECT a.id, a.label, j.question_id
        FROM `answer` AS a
        JOIN `question_answer` AS j ON j.answer_id = a.id
        WHERE j.question_id = ' . $_GET['id'] . '
    ');

    // Count results for each answers related to this questions
    $rs_progress = $db->select
    ('
        SELECT `answer_id`, COUNT(`user_id`) AS `total`
        FROM `user_result`
        WHERE `question_id`=' . $question['id'] . '
        GROUP BY `answer_id`
    ');

    // Compute totals
    $progressTotal = 0;
    $progressAnswer = array();
    foreach ($rs_progress['data'] as $progress)
    {
        $progressTotal += $progress['total'];
        $progressAnswer[$progress['answer_id']] = $progress['total'];
    }

    // Assign question infos
    $tpl->assignVar(array
    (
        'question_date'  => date('d-m-Y', $question['date']),
        'question_label' => $question['label'],
        'question_id'    => $question['id'],
    ));

    // Loop through all answers
    foreach ($rs_answer['data'] as $answer)
    {
        // Compute percent
        $progress = (isset($progressAnswer[$answer['id']])) ? $progressAnswer[$answer['id']] : 0;

        // Assign answer's infos
        $tpl->assignLoopVar('answer', array
        (
            'label'           => $answer['label'],
            'id'              => $answer['id'],
            'progress'        => $progress,
            'percentFormated' => ($progressTotal == 0) ? 0 : number_format(($progress / $progressTotal) * 100, 1, ',', ' '),
            'percent'         => ($progressTotal == 0) ? 0 : ($progress / $progressTotal) * 100,
        ));

        // If some users are logged
        if (count($_SESSION['user']) != 0)
        {
            // Loop through all users results
            foreach ($rs_result['data'] as $result)
            {
                // If the result is about this answer
                if ($result['answer_id'] == $answer['id'])
                {
                    // Assing user's infos
                    $tpl->assignLoopVar('answer.user', array
                    (
                        'login' => $_SESSION['user'][$result['user_id']]['login'],
                        'id'    => $result['user_id'],
                        'class' => 'voted',
                    ));
                    // Remembed this user has allready voted
                    $user_voted_idList[$result['user_id']] = true;
                }
            }
            // Loop through all users prognostics
            foreach ($rs_prognostic['data'] as $result)
            {
                // If the result is about this answer
                if ($result['answer_id'] == $answer['id'])
                {
                    // Assing user's infos
                    $tpl->assignLoopVar('answer.user', array
                    (
                        'login' => $_SESSION['user'][$result['user_id']]['login'],
                        'id'    => $result['user_id'],
                        'class' => 'guessed',
                    ));
                }
            }
        }
    }

    // If this question is out of date
    if ($question['date'] < time() - POLL_DURATION)
    {
        $tpl->assignSection('inactive');
    }
    // If it's not out of date
    else if (count($_SESSION['user']) != 0)
    {
        // Init some variables for javascripts
        $poll_parameters = array();
        $poll_parameters['question_id'] = $question['id'];
        $poll_parameters['user'] = array();
        $poll_parameters['mode'] = 'vote';

        // Pass all users results to javascripts
        foreach ($rs_result['data'] as $result)
        {
            $poll_parameters['user'][$result['user_id']] = $result['answer_id'];
        }

        // Loop through all logged users
        foreach($user_idList as $id)
        {
            // If he did not vote
            if (!array_key_exists($id, $user_voted_idList))
            {
                // Assing user's infos
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

