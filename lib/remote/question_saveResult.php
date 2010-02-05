<?php

    // If the question specified is out of date or does not exists exit
    $rs_question = DB::select('SELECT `date` FROM `question` WHERE `id`="' . $_POST['question_id'] . '"');
    if ($rs_question['total'] == 0 || $rs_question['data'][0]['date'] < time() - POLL_DURATION)
    {
        exit();
    }

    foreach($_POST['user'] as $user_id => $data)
    {
		// If the user specified is not logged exit
		if (!Tool::isOk($_SESSION['user']) || $_SESSION['user']['id'] != $user_id)
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
					$table = 'user_guess';
					$answer_id = $value;
					break;
                default:
                    continue;
			}

			// Select user's results if there is some
			$rs = DB::select('SELECT `answer_id` FROM `' . $table . '` WHERE `question_id`="' . $_POST['question_id'] . '" AND `user_id`="' . $user_id . '"');

			// If the user did not vote for this question
			if ($rs['total'] == 0)
			{
				// If he voted for an answer
				if ($answer_id != 0)
				{
					// Remember his answer
					DB::insert('INSERT INTO `' . $table . '` (`question_id`, `answer_id`, `user_id`, `date`) VALUES
					(
						"' . $_POST['question_id'] . '",
						"' . $answer_id . '",
						"' . $user_id . '",
						"' . time() . '"
					)');
				}
			}
			// Else if the user voted blank
			// WE DO NOT ALLOW THIS
			//else if ($answer_id == 0)
			//{
				//// Remove his answer
				//DB::delete('DELETE FROM `' . $table . '` WHERE `question_id`=' . $_POST['question_id'] . ' AND `user_id`=' . $user_id);
			//}
			// Else if he already voted but changed his minde
			// WE DO NOT ALLOW THIS
			//else if ($answer_id != $rs['data'][0]['answer_id'])
			//{
				// Change his answer
				//DB::update('UPDATE `' . $table . '`
					//SET `answer_id` = ' . $answer_id . '
					//WHERE `question_id`=' . $_POST['question_id'] . ' AND `user_id`=' . $user_id);
			//}
		}
    }

    // Dress friends id list
    $friendIds = array();
    foreach($_POST['friend'] as $friend_id => $data)
    {
        $friendIds[] = $friend_id;
    }

    // Look if there is prognostics for thoses friend from this user to this question
    $rs = DB::select('
        SELECT `friend_id` FROM `user_guess_friend`
        WHERE `question_id`="' . $_POST['question_id'] . '"
        AND `user_id`="' . $user_id .'"
        AND `friend_id` IN (' . implode(',', $friendIds) . ')
    ');

    // Establish the list of already guessed friends
    $freindRegistered = array();
    foreach ($rs as $item)
    {
        $freindRegistered[] = $item['friend_id'];
    }

    foreach($_POST['friend'] as $friend_id => $data)
    {
		foreach ($data as $type => $value)
		{
            switch ($type)
            {
                case 'guess':
                    $table = 'user_guess_friend';
                    $answer_id = $value;
                    break;
                default:
                    continue;
            }

            // If user did not already guess for this friend
            if (!in_array($friend_id, $freindRegistered))
            {
                // Remember his guess
                DB::insert('INSERT INTO `' . $table . '` (`question_id`, `answer_id`, `user_id`, `friend_id`, `date`) VALUES
                (
                    "' . $_POST['question_id'] . '",
                    "' . $answer_id . '",
                    "' . $user_id . '",
                    "' . $friend_id . '",
                    "' . time() . '"
                )');
            }
        }
    }

