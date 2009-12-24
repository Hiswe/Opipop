<?php

	require_once '../inc/conf.default.php';
	require_once '../inc/conf.local.php';
    require_once '../inc/setup.php';

    if (!isset($_SESSION['user'][$_POST['user_id']]))
    {
        exit();
    }

    $rs_question = $db->select('SELECT `date` FROM `question` WHERE `id`="' . $_POST['question_id'] . '"');
    if ($rs_question['total'] == 0 || $rs_question['data'][0]['date'] < time() - POLL_DURATION)
    {
        exit();
    }

    $rs = $db->select('SELECT `answer_id` FROM `user_result` WHERE `question_id`="' . $_POST['question_id'] . '" AND `user_id`="' . $_POST['user_id'] . '"');

    if ($rs['total'] == 0)
    {
        if ($_POST['answer_id'] != 0)
        {
            $db->insert('INSERT INTO `user_result` (`question_id`, `answer_id`, `user_id`, `date`) VALUES
            (
                "' . $_POST['question_id'] . '",
                "' . $_POST['answer_id'] . '",
                "' . $_POST['user_id'] . '",
                "' . time() . '"
            ) ');
        }
    }
    else if ($_POST['answer_id'] == 0)
    {
        $db->delete('DELETE FROM `user_result` WHERE `question_id`=' . $_POST['question_id'] . ' AND `user_id`=' . $_POST['user_id']);
    }
    else if ($_POST['answer_id'] != $rs['data'][0]['answer_id'])
    {
        $db->update('UPDATE `user_result`
            SET `answer_id` = ' . $_POST['answer_id'] . '
            WHERE `question_id`=' . $_POST['question_id'] . ' AND `user_id`=' . $_POST['user_id']);
    }

