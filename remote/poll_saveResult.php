<?php

	require_once '../inc/conf.default.php';
	require_once '../inc/conf.local.php';
    require_once '../inc/setup.php';

    // If the question specified is out of date or does not exists exit
    $rs_question = $db->select('SELECT `date` FROM `question` WHERE `id`="' . $_POST['question_id'] . '"');
    if ($rs_question['total'] == 0 || $rs_question['data'][0]['date'] < time() - POLL_DURATION)
    {
        exit();
    }

    foreach($_POST['user'] as $user_id => $data)
    {
		// If the user specified is not logged exit
		if (!isOk($_SESSION['user']) || $_SESSION['user']['id'] != $user_id)
		{
			continue;
		}

		foreach ($data as $type => $value)
		{
			switch ($type)
			{
				case 'vote':
					$table = 'user_result';
					$answer_id = $value;
					break;
				case 'guess':
					$table = 'user_prognostic';
					$answer_id = $value;
					break;
			}

			// Select user's results if there is some
			$rs = $db->select('SELECT `answer_id` FROM `' . $table . '` WHERE `question_id`="' . $_POST['question_id'] . '" AND `user_id`="' . $user_id . '"');

			// If the user did not vote for this question
			if ($rs['total'] == 0)
			{
				echo $answer_id;
				// If he voted for an answer
				if ($answer_id != 0)
				{
					// Remember his answer
					$db->insert('INSERT INTO `' . $table . '` (`question_id`, `answer_id`, `user_id`, `date`) VALUES
					(
						"' . $_POST['question_id'] . '",
						"' . $answer_id . '",
						"' . $user_id . '",
						"' . time() . '"
					)');
				}
			}
			// Else if the user voted blank
			else if ($answer_id == 0)
			{
				// Remove his answer
				$db->delete('DELETE FROM `' . $table . '` WHERE `question_id`=' . $_POST['question_id'] . ' AND `user_id`=' . $user_id);
			}
			// Else if he already voted but changed his minde
			// WE DO NOT ALLOW THIS
			//else if ($answer_id != $rs['data'][0]['answer_id'])
			//{
				// Change his answer
				//$db->update('UPDATE `' . $table . '`
					//SET `answer_id` = ' . $answer_id . '
					//WHERE `question_id`=' . $_POST['question_id'] . ' AND `user_id`=' . $user_id);
			//}
		}
    }

