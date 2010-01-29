<?php

include 'page/block/top.php';

// Select the requested question
$rs_question = $db->select
('
    SELECT q.id, q.date, q.label
    FROM `question` AS `q`
    JOIN `category` AS `c` ON c.id=q.category_id
    WHERE q.id=' . $_GET['id'] . ' AND q.status=1 AND c.status=1
');

// If there is one
if ($rs_question['total'] != 0)
{
    $question = $rs_question['data'][0];
    $progressTotal = 0;
    $progressAnswer = array();

    // If a user is logged
    if (isOk($_SESSION['user']))
    {
        // List all users ids
        $userId = $_SESSION['user']['id'];

        // Select users results
        $rs_result = $db->select
        ('
            SELECT `user_id`, `answer_id`
            FROM `user_result`
            WHERE `question_id`=' . $question['id'] . ' AND `user_id`="' . $userId . '"
        ');

        // Select users prognostic
        $rs_prognostic = $db->select
        ('
            SELECT `user_id`, `answer_id`
            FROM `user_prognostic`
            WHERE `question_id`=' . $question['id'] . ' AND `user_id`="' . $userId . '"
        ');
    }

    // Select all answers releted to this question
    $rs_answer = $db->select
    ('
        SELECT a.id, a.label
        FROM `answer` AS `a`
        JOIN `question_answer_feeling` AS j ON j.answer_id = a.id
        WHERE j.question_id = ' . $_GET['id'] . '
        GROUP BY a.id
    ');

    // Assign question infos
    $tpl->assignVar(array
    (
        'question_start_date'       => date('d/m/Y', $question['date']),
        'question_end_date'         => date('d/m/Y', $question['date'] + POLL_DURATION),
        'question_end_time'         => timeWarp($question['date'] + POLL_DURATION),
        'question_guid'             => makeGuid($question['label']),
        'question_label'            => $question['label'],
        'question_label_urlencoded' => urlencode($question['label']),
        'question_id'               => $question['id'],
    ));

    // If this question is not out of date
    if ($question['date'] > time() - POLL_DURATION)
    {
        $tpl->assignSection('active');

        // If a users is logged
        if (isOk($_SESSION['user']))
        {
            // Init some variables for javascripts
            $poll_parameters = array();
            $poll_parameters['question_id'] = $question['id'];
            $poll_parameters['user'] = array();

            // Pass all users results to javascripts
            foreach ($rs_result['data'] as $result)
            {
                $poll_parameters['user'][$result['user_id']] = $result['answer_id'];
            }

            // If the user did not vote
            if ($rs_result['total'] == 0)
            {
                // Assing user's infos
                $tpl->assignLoopVar('user', array
                (
                    'id'     => $_SESSION['user']['id'],
                    'login'  => $_SESSION['user']['login'],
                    'avatar' => (file_exists(ROOT_DIR . 'media/avatar/' . AVATAR_SMALL_SIZE . '/' . $userId . '.jpg')) ? AVATAR_SMALL_SIZE . '/' . $userId . '.jpg' : AVATAR_SMALL_SIZE . '/0.jpg',
                ));
            }

            $tpl->assignVar('poll_parameters', json_encode($poll_parameters));
        }
    }
    else
    {
        $tpl->assignSection('inactive');

        // Stats about answers
        $rs_stats = $db->select
        ('
            SELECT a.id, COUNT(u.id) AS total_answer, SUM(u.male) AS total_male
            FROM `answer` AS `a`
            JOIN `question_answer_feeling` AS j ON j.answer_id = a.id
            JOIN `user_result` AS `r` ON j.question_id=r.question_id AND j.answer_id=r.answer_id
            JOIN `user` AS `u` ON r.user_id=u.id
            WHERE j.question_id = ' . $_GET['id'] . '
            GROUP BY a.id
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
        foreach ($rs_progress['data'] as $progress)
        {
            $progressTotal += $progress['total'];
            $progressAnswer[$progress['answer_id']] = $progress['total'];
        }
    }

    // Loop through all answers
    foreach ($rs_answer['data'] as $answer)
    {
        $progress    = 0;
        $totalAnswer = 0;
        $totalMale   = 0;
        $totalFemale = 0;

        // If this question is out of date
        if ($question['date'] <= time() - POLL_DURATION)
        {
            $progress = (isset($progressAnswer[$answer['id']])) ? $progressAnswer[$answer['id']] : 0;
            foreach ($rs_stats['data'] as $stats)
            {
                if ($stats['id'] == $answer['id'])
                {
                    $totalAnswer = $stats['total_answer'];
                    $totalMale   = $stats['total_male'];
                    $totalFemale = $stats['total_answer'] - $stats['total_male'];
                    break;
                }
            }
        }

        // Assign answer's infos
        $tpl->assignLoopVar('answer', array
        (
            'label'           => $answer['label'],
            'id'              => $answer['id'],
            'percentFormated' => ($progressTotal == 0) ? 0 : number_format(($progress / $progressTotal) * 100, 1, ',', ' '),
            'percent'         => ($progressTotal == 0) ? 0 : round(($progress / $progressTotal) * 100),
            'percent_male'    => ($totalAnswer == 0) ? 0 : round(($totalMale / $totalAnswer) * 100),
            'percent_female'  => ($totalAnswer == 0) ? 0 : round(($totalFemale / $totalAnswer) * 100),
        ));

        // If a users is logged
        if (isOk($_SESSION['user']))
        {
            // Loop through user's results
            foreach ($rs_result['data'] as $result)
            {
                // If the result is about this answer
                if ($result['answer_id'] == $answer['id'])
                {
                    // Assing user's infos
                    $tpl->assignLoopVar('answer.user', array
                    (
                        'id'     => $_SESSION['user']['id'],
                        'login'  => $_SESSION['user']['login'],
                        'avatar' => (file_exists(ROOT_DIR . 'media/avatar/' . AVATAR_SMALL_SIZE . '/' . $userId . '.jpg')) ? AVATAR_SMALL_SIZE . '/' . $userId . '.jpg' : AVATAR_SMALL_SIZE . '/0.jpg',
                        'class'  => 'voted',
                    ));
                    // Remembed this user has allready voted
                }
            }
            // Loop through user's prognostics
            foreach ($rs_prognostic['data'] as $result)
            {
                // If the result is about this answer
                if ($result['answer_id'] == $answer['id'])
                {
                    // Assing user's infos
                    $tpl->assignLoopVar('answer.user', array
                    (
                        'id'     => $_SESSION['user']['id'],
                        'login'  => $_SESSION['user']['login'],
                        'guid'   => makeGuid($_SESSION['user']['login']),
                        'avatar' => (file_exists(ROOT_DIR . 'media/avatar/' . AVATAR_SMALL_SIZE . '/' . $userId . '.jpg')) ? AVATAR_SMALL_SIZE . '/' . $userId . '.jpg' : AVATAR_SMALL_SIZE . '/0.jpg',
                        'class'  => 'guessed',
                    ));
                }
            }
        }
    }
}
else
{
    // TODO : Error no poll found
}

