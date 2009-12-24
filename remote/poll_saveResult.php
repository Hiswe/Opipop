<?php

	require_once '../inc/conf.default.php';
	require_once '../inc/conf.local.php';
    require_once '../inc/setup.php';

    // If the user specified is not logged exit
    if (!isset($_SESSION['user'][$_POST['user_id']]))
    {
        exit();
    }

    // If the question specified is out of date or does not exists exit
    $rs_question = $db->select('SELECT `date` FROM `question` WHERE `id`="' . $_POST['question_id'] . '"');
    if ($rs_question['total'] == 0 || $rs_question['data'][0]['date'] < time() - POLL_DURATION)
    {
        exit();
    }

    // Select user's results if there is some
    $rs = $db->select('SELECT `answer_id` FROM `user_result` WHERE `question_id`="' . $_POST['question_id'] . '" AND `user_id`="' . $_POST['user_id'] . '"');

    // If the user did not vote for this question
    if ($rs['total'] == 0)
    {
        // If he voted for an answer
        if ($_POST['answer_id'] != 0)
        {
            // Remember his answer
            $db->insert('INSERT INTO `user_result` (`question_id`, `answer_id`, `user_id`, `date`) VALUES
            (
                "' . $_POST['question_id'] . '",
                "' . $_POST['answer_id'] . '",
                "' . $_POST['user_id'] . '",
                "' . time() . '"
            ) ');
        }
    }
    // Else if the user voted blank
    else if ($_POST['answer_id'] == 0)
    {
        // Remove his answer
        $db->delete('DELETE FROM `user_result` WHERE `question_id`=' . $_POST['question_id'] . ' AND `user_id`=' . $_POST['user_id']);
    }
    // Else if he already voted but changed his minde
    else if ($_POST['answer_id'] != $rs['data'][0]['answer_id'])
    {
        // Change his answer
        $db->update('UPDATE `user_result`
            SET `answer_id` = ' . $_POST['answer_id'] . '
            WHERE `question_id`=' . $_POST['question_id'] . ' AND `user_id`=' . $_POST['user_id']);
    }

