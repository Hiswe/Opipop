<?php

include 'page/block/top.php';

// Retrieve user's id
$rs_user = $db->select('
	SELECT `id`
	FROM `user`
	WHERE `login`="' . $_GET['login'] . '"
');

if ($rs_user['total'] != 0)
{
	$profileId = $rs_user['data'][0]['id'];

    $tpl->assignVar(array
    (
        'user_login' => $_GET['login'],
        'user_id' => $profileId,
    ));

    if (file_exists(ROOT_DIR . 'media/avatar/' . AVATAR_LARGE_SIZE . '/' . $profileId . '.jpg'))
    {
        $tpl->assignVar('avatar', AVATAR_LARGE_SIZE . '/' . $profileId . '.jpg');
    }
    else
    {
        $tpl->assignVar('avatar', AVATAR_LARGE_SIZE . '/0.jpg');
    }

    // If someone is logged
	if (isOk($_SESSION['user']))
	{
        $userId = $_SESSION['user']['id'];

        // If I'm on my profile
        if ($profileId == $userId)
        {
            $tpl->assignSection('private');

            // Select all my pending friend requests
            $rs_request = $db->select('
                SELECT u.id, u.login
                FROM `friend` AS `f`
                JOIN `user` AS `u` ON u.id=f.user_id_1
                WHERE f.valided=0 AND f.user_id_2="' . $userId . '"
            ');
            if ($rs_request['total'] != 0)
            {
                foreach ($rs_request['data'] as $friend)
                {
                    $tpl->assignLoopVar('request', array
                    (
                        'id'     => $friend['id'],
                        'login'  => $friend['login'],
                        'avatar' => (file_exists(ROOT_DIR . 'media/avatar/' . AVATAR_SMALL_SIZE . '/' . $friend['id'] . '.jpg')) ? AVATAR_SMALL_SIZE . '/' . $friend['id'] . '.jpg' : AVATAR_SMALL_SIZE . '/0.jpg',
                    ));
                }
                $tpl->assignSection('friendPendingRequest');
            }
        }
        else
        {
            $tpl->assignSection('friendRequest');

            // Look if we are friends
            $rs_friendRequest = $db->select('
                SELECT `valided`
                FROM `friend`
                WHERE (`user_id_1`="' . $userId . '" AND `user_id_2`="' . $profileId . '")
                OR (`user_id_1`="' . $profileId . '" AND `user_id_2`="' . $userId . '")
            ');

            if ($rs_friendRequest['total'] == 0)
            {
                $friendMessage = 'Add to friends';
                $friendAction  = 'add';
            }
            else
            {
                if ($rs_friendRequest['data'][0]['valided'] == 1)
                {
                    $friendMessage = 'Remove from friends';
                    $friendAction  = 'remove';
                }
                else
                {
                    $friendMessage = 'Cancel friend request';
                    $friendAction  = 'cancel';
                }
            }

            $tpl->assignVar(array
            (
                'friendRequest_message' => $friendMessage,
                'friendRequest_action'  => $friendAction,
            ));
        }
	}

    // Select all user's friends
    $rs_friend = $db->select('
        SELECT u.login, u.id
        FROM `friend` AS `f`
        JOIN `user` AS `u` ON u.id=f.user_id_1 OR u.id=f.user_id_2
        WHERE f.valided="1" AND (f.user_id_1="' . $profileId . '" OR f.user_id_2="' . $profileId . '")
    ');
    foreach ($rs_friend['data'] as $friend)
    {
        if ($friend['id'] != $profileId)
        {
            $tpl->assignLoopVar('friend', array
            (
                'id'     => $friend['id'],
                'login'  => $friend['login'],
                'avatar' => (file_exists(ROOT_DIR . 'media/avatar/' . AVATAR_SMALL_SIZE . '/' . $friend['id'] . '.jpg')) ? AVATAR_SMALL_SIZE . '/' . $friend['id'] . '.jpg' : AVATAR_SMALL_SIZE . '/0.jpg',
            ));
            $friendIds[] = $friend['id'];
        }
    }

	// Count user's total votes
	$rs_result_total = $db->select('
		SELECT COUNT(user_id) AS `total`
		FROM `user_result`
		WHERE `user_id`="' . $profileId . '"
		GROUP BY `user_id`
	');

	// If user already voted
	if ($rs_result_total['total'] != 0)
	{
		$user_totalVote = $rs_result_total['data'][0]['total'];
		$tpl->assignVar(array
		(
			'user_totalVote' => $rs_result_total['data'][0]['total'],
		));

		// Select all user's results for past questions
		$rs_user_result = $db->select('
			SELECT r.question_id AS `question_id`, r.answer_id AS `answer_id`
			FROM `user_result` AS `r`
			JOIN `question` AS `q` ON q.id=r.question_id
			WHERE r.user_id="' . $profileId . '" AND q.date < ' . (time() - POLL_DURATION - 3600) . '
		');

        // Count total questions
        $rs_totalQuestion = $db->select('SELECT COUNT(*) AS `total` FROM `question` WHERE `date` < ' . (time() - POLL_DURATION - 3600) . '');
        $totalQuestion = $rs_totalQuestion['data'][0]['total'];




        // Get stats on user votes according to global votes
        $rs_result = $db->select('
            SELECT
                rg.question_id,
                COUNT(rg.answer_id) AS `total_vote`,
                SUM(IF(rg.answer_id=ru.answer_id, 1, 0)) AS `total_according_votes`,
                SUM(IF(rg.answer_id!=ru.answer_id, 1, 0)) AS `total_disaccording_votes`
            FROM `user_result` AS `rg`
            JOIN `user_result` AS `ru` ON ru.user_id="' . $profileId . '" AND rg.question_id=ru.question_id
            JOIN `question` AS `q` ON q.id=rg.question_id
            WHERE q.date < ' . (time() - POLL_DURATION - 3600) . '
            GROUP BY rg.question_id
            ORDER BY rg.question_id
        ');

		// Count user's popular votes
		$totalAccordingVote = 0;
        $totalVote = $rs_result['total'];
		foreach ($rs_result['data'] as $item)
		{
			if ($item['total_according_votes'] >= $item['total_disaccording_votes'])
			{
				$totalAccordingVote ++;
			}
		}
		$tpl->assignVar(array
		(
			'user_global_distance' => round((($totalVote - $totalAccordingVote) / $totalVote) * $totalQuestion),
		));

        // Get stats on user votes according to his friends votes
        $rs_friend_result = $db->select('
            SELECT
                rg.question_id,
                COUNT(rg.answer_id) AS `total_vote`,
                SUM(IF(rg.answer_id=ru.answer_id, 1, 0)) AS `total_according_votes`,
                SUM(IF(rg.answer_id!=ru.answer_id, 1, 0)) AS `total_disaccording_votes`
            FROM `user_result` AS `rg`
            JOIN `user_result` AS `ru` ON ru.user_id="' . $profileId . '" AND rg.question_id=ru.question_id
            JOIN `question` AS `q` ON q.id=rg.question_id
            WHERE q.date < ' . (time() - POLL_DURATION - 3600) . '
            AND rg.user_id IN (' . implode(',', $friendIds) . ')
            GROUP BY rg.question_id
            ORDER BY rg.question_id
        ');

		// Count user's popular votes
		$friend_totalAccordingVote = 0;
        $friend_totalVote = $rs_friend_result['total'];
		foreach ($rs_friend_result['data'] as $item)
		{
			if ($item['total_according_votes'] >= $item['total_disaccording_votes'])
			{
				$friend_totalAccordingVote ++;
			}
		}
		$tpl->assignVar(array
		(
			'user_friend_distance' => round((($friend_totalVote - $friend_totalAccordingVote) / $friend_totalVote) * $totalQuestion),
		));

        // Get stats on user guesses according to global votes
        $rs_guess = $db->select('
            SELECT
                rg.question_id,
                COUNT(rg.answer_id) AS `total_vote`,
                SUM(IF(rg.answer_id=gu.answer_id, 1, 0)) AS `total_according_guesses`,
                SUM(IF(rg.answer_id!=gu.answer_id, 1, 0)) AS `total_disaccording_guesses`
            FROM `user_result` AS `rg`
            JOIN `user_guess` AS `gu` ON gu.user_id="' . $profileId . '" AND rg.question_id=gu.question_id
            JOIN `question` AS `q` ON q.id=rg.question_id
            WHERE q.date < ' . (time() - POLL_DURATION - 3600) . '
            GROUP BY rg.question_id
            ORDER BY rg.question_id
        ');

		// Count user's good and bad guess
		$totalPredictionLost = 0;
		$totalPredictionWon = 0;
		foreach ($rs_guess['data'] as $item)
		{
			if ($item['total_according_guesses'] >= $item['total_disaccording_guesses'])
			{
				$totalPredictionWon ++;
			}
			else
			{
				$totalPredictionLost ++;
			}
		}
		$tpl->assignVar(array
		(
			'user_totalPredictionWon' => $totalPredictionWon,
			'user_totalPredictionLost' => $totalPredictionLost,
			'user_predictionAccuracy' => round(($totalPredictionWon / $rs_guess['total']) * 100),
		));

        // Count user's good guess about his friends for past questions
        $rs_user_guess_friend = $db->select('
            SELECT
                u.id AS `id`,
                u.login AS `login`,
                SUM(IF(p.answer_id=r.answer_id, 1, 0)) AS `total_good`,
                COUNT(p.question_id) AS `total_question`
            FROM `user_guess_friend` AS `p`
            JOIN `user_result` AS `r` ON p.question_id=r.question_id AND r.user_id IN (' . implode(',', $friendIds) . ')
            JOIN `question` AS `q` ON q.id=p.question_id
            JOIN `user` AS `u` ON p.friend_id=u.id
            WHERE p.user_id="' . $profileId . '"
            AND q.date < ' . (time() - POLL_DURATION - 3600) . '
            AND `friend_id` IN (' . implode(',', $friendIds) . ')
            GROUP BY p.friend_id
        ');
        foreach ($rs_user_guess_friend['data'] as $guess)
        {
            $tpl->assignLoopVar('friendPredictionAccuracy', array
            (
                'id'      => $guess['id'],
                'login'   => $guess['login'],
                'percent' => round(($guess['total_good'] / $guess['total_question']) * 100),
            ));
        }

		// Compute user's feelings
		$rs_user_feeling = $db->select('
			SELECT f.id, COUNT(f.id) AS total
			FROM `user_result` AS `r`
			JOIN `question_answer_feeling` AS `j` ON j.question_id=r.question_id AND j.answer_id=r.answer_id
			JOIN `feeling` AS `f` ON f.id=j.feeling_id
			WHERE r.user_id="' . $profileId . '" AND f.id!="1"
			GROUP BY f.id
		');

		// Init values
		$feelings = array('personality', 'surroundings', 'knowledge', 'experience', 'thoughts');
		$user_feelings = array('1' => 0, '2' => 0, '3' => 0, '4' => 0, '5' => 0, '6' => 0);

		// Count user feelings
		$totalPoint = 0;
		$max = 0;
		$values = array();
		foreach ($rs_user_feeling['data'] as $item)
		{
			$user_feelings[$item['id']] = $item['total'];
			$max = ($max < $item['total']) ? $item['total'] : $max;
			$totalPoint ++;
		}
		foreach ($feelings as $id => $label)
		{
			$tpl->assignLoopVar('feeling', array
			(
				'label'   => $label,
				'percent' => round(($user_feelings[$id + 1] / $max) * 100),
			));
			$values[] = number_format(($user_feelings[$id + 1] / $max) * 5 + 1, 2);
		}

		include 'inc/pChart.1.27d/pChart/pData.class';
		include 'inc/pChart.1.27d/pChart/pChart.class';
		include 'inc/pChart.1.27d/pChart/pCache.class';

		error_reporting(0);

		// Dataset definition
		$DataSet = new pData;
		$DataSet->AddPoint($feelings, 'Label');
		$DataSet->AddPoint($values, 'Serie1');
		$DataSet->AddSerie('Serie1');
		$DataSet->SetAbsciseLabelSerie('Label');
		$DataSet->SetSerieName('Personality', 'Serie1');

		// Init cahce
		$Cache = new pCache(ROOT_DIR . 'media/chart/');
		if (!$Cache->isInCache('personality', $DataSet->GetData()))
		{
			// Initialise the graph
			$Chart = new pChart(400, 400);
			$Chart->setFontProperties('inc/pChart.1.27d/Fonts/tahoma.ttf',10);
			$Chart->setGraphArea(50, 50, 350, 350);
			$Chart->setColorPalette(0, 120, 120, 230);

			// Draw the radar graph
			$Chart->drawRadarAxis($DataSet->GetData(),$DataSet->GetDataDescription(),TRUE,20,120,120,120,230,230,230);
			$Chart->drawFilledRadar($DataSet->GetData(),$DataSet->GetDataDescription(),50,20);

			// Cache the graph
			$Cache->WriteToCache('personality', $DataSet->GetData(), $Chart);
		}
		$tpl->assignVar('personality_chart', $Cache->GetFromCache('personality', $DataSet->GetData(), true));

		error_reporting(E_ALL);
	}
	else
	{
		$tpl->assignVar(array
		(
			'user_totalVote'           => 0,
			'user_totalPredictionWon'  => 0,
			'user_totalPredictionLost' => 0,
			'user_predictionAccuracy'  => 0,
			'user_global_distance'     => 0,
			'user_firend_distance'     => 0,
		));
	}
}
else
{
	// TODO : error, user does not exists
}

